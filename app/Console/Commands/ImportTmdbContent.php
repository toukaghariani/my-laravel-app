<?php

namespace App\Console\Commands;

use App\Models\Content;
use App\Models\Genre;
use App\Services\TmdbService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ImportTmdbContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:import {--window=day : The trending window to pull (day or week)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically pull and import trending titles from TMDB';

    /**
     * Execute the console command.
     */
    public function handle(TmdbService $tmdb)
    {
        // Rate Limiter: Prevent multiple imports within 10 minutes to respect limits / avoid db locks
        if (Cache::has('tmdb_last_import_time')) {
            $this->warn('TMDB auto-import ran recently. Skipping to respect rate limits.');
            return self::SUCCESS;
        }

        $this->info('Starting TMDB auto-import...');
        $window = $this->option('window');
        $data = $tmdb->trending($window);

        if (!$data || empty($data['results'])) {
            $this->error('Failed to fetch trending titles from TMDB.');
            return self::FAILURE;
        }

        $imported = 0;
        $skipped = 0;

        foreach ($data['results'] as $item) {
            $mediaType = $item['media_type'] ?? null;
            if (!in_array($mediaType, ['movie', 'tv'])) continue;

            // Check if already in DB
            if (Content::where('tmdb_id', $item['id'])->exists()) {
                $skipped++;
                continue;
            }

            // Normalise schema
            $normalised = $tmdb->normalise($item, $mediaType);
            $genreIds   = $normalised['genre_ids'] ?? [];
            unset($normalised['genre_ids']);

            $normalised['streaming_url'] = '';
            $normalised['is_premium']    = false; // Default auto-imported to free

            $content = Content::create($normalised);
            $this->syncTmdbGenres($tmdb, $content, $genreIds, $mediaType);
            
            $imported++;
            
            // Artificial delay (200ms) to ensure we don't bombard the DB or TMDB when syncing genres
            usleep(200000); 
        }

        // Lock for 10 minutes
        Cache::put('tmdb_last_import_time', now(), now()->addMinutes(10));

        $this->info("Import complete! Imported: {$imported} | Skipped (already existed): {$skipped}");
        return self::SUCCESS;
    }

    /**
     * Sync TMDB genre IDs to our local genres table, creating any missing genres.
     */
    private function syncTmdbGenres(TmdbService $tmdb, Content $content, array $tmdbGenreIds, string $type): void
    {
        if (empty($tmdbGenreIds)) return;

        // Fetch TMDB's genre name map
        $genreList = $type === 'movie'
            ? $tmdb->movieGenres()
            : $tmdb->tvGenres();

        $tmdbGenreMap = collect($genreList['genres'] ?? [])
            ->pluck('name', 'id')
            ->toArray();

        $localGenreIds = [];
        foreach ($tmdbGenreIds as $tgId) {
            $name = $tmdbGenreMap[$tgId] ?? null;
            if (!$name) continue;

            $genre = Genre::firstOrCreate(
                ['name' => $name],
            );
            $localGenreIds[] = $genre->id;
        }

        $content->genres()->sync($localGenreIds);
    }
}
