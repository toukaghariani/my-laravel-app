<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TmdbService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $imageBase;

    public function __construct()
    {
        $this->baseUrl   = config('services.tmdb.base_url');
        $this->apiKey    = config('services.tmdb.key');
        $this->imageBase = config('services.tmdb.image_base');
    }

    // ─── Core HTTP ─────────────────────────────────────────────

    /**
     * Make an authenticated GET request to the TMDB API.
     */
    protected function get(string $endpoint, array $params = []): ?array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept'        => 'application/json',
            ])->get($this->baseUrl . $endpoint, $params);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('TMDB API error', [
                'endpoint' => $endpoint,
                'status'   => $response->status(),
                'body'     => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('TMDB API exception', [
                'endpoint' => $endpoint,
                'message'  => $e->getMessage(),
            ]);
            return null;
        }
    }

    // ─── Search ────────────────────────────────────────────────

    /**
     * Search for movies by title.
     */
    public function searchMovies(string $query, int $page = 1): ?array
    {
        return $this->get('/search/movie', [
            'query'    => $query,
            'page'     => $page,
            'language' => 'en-US',
        ]);
    }

    /**
     * Search for TV shows by title.
     */
    public function searchTv(string $query, int $page = 1): ?array
    {
        return $this->get('/search/tv', [
            'query'    => $query,
            'page'     => $page,
            'language' => 'en-US',
        ]);
    }

    /**
     * Multi-search (movies + TV combined).
     */
    public function searchMulti(string $query, int $page = 1): ?array
    {
        return $this->get('/search/multi', [
            'query'    => $query,
            'page'     => $page,
            'language' => 'en-US',
        ]);
    }

    // ─── Details ───────────────────────────────────────────────

    /**
     * Get full details for a movie by TMDB ID.
     */
    public function getMovie(int $tmdbId): ?array
    {
        return $this->get("/movie/{$tmdbId}", [
            'language'            => 'en-US',
            'append_to_response' => 'credits,videos',
        ]);
    }

    /**
     * Get full details for a TV show by TMDB ID.
     */
    public function getTvShow(int $tmdbId): ?array
    {
        return $this->get("/tv/{$tmdbId}", [
            'language'            => 'en-US',
            'append_to_response' => 'credits,videos',
        ]);
    }

    // ─── Discovery / Trending ──────────────────────────────────

    /**
     * Get trending movies & TV for time window (day|week).
     */
    public function trending(string $window = 'week', int $page = 1): ?array
    {
        return $this->get("/trending/all/{$window}", [
            'page'     => $page,
            'language' => 'en-US',
        ]);
    }

    /**
     * Discover movies with optional genre filter.
     */
    public function discoverMovies(array $filters = [], int $page = 1): ?array
    {
        return $this->get('/discover/movie', array_merge([
            'page'     => $page,
            'language' => 'en-US',
            'sort_by'  => 'popularity.desc',
        ], $filters));
    }

    /**
     * Discover TV shows with optional genre filter.
     */
    public function discoverTv(array $filters = [], int $page = 1): ?array
    {
        return $this->get('/discover/tv', array_merge([
            'page'     => $page,
            'language' => 'en-US',
            'sort_by'  => 'popularity.desc',
        ], $filters));
    }

    // ─── Genres ────────────────────────────────────────────────

    /**
     * Get the official TMDB genre list for movies.
     */
    public function movieGenres(): ?array
    {
        return $this->get('/genre/movie/list', ['language' => 'en-US']);
    }

    /**
     * Get the official TMDB genre list for TV.
     */
    public function tvGenres(): ?array
    {
        return $this->get('/genre/tv/list', ['language' => 'en-US']);
    }

    // ─── Helpers ───────────────────────────────────────────────

    /**
     * Build a full image URL from a TMDB poster/backdrop path.
     */
    public function imageUrl(?string $path, string $size = 'w500'): ?string
    {
        if (!$path) return null;
        $base = rtrim(config('services.tmdb.image_base'), '/');
        // Replace the default size in the base URL if a different size is given
        $base = preg_replace('#/w\d+$#', "/{$size}", $base);
        return $base . $path;
    }

    /**
     * Normalise a TMDB result into an array matching our Content model columns.
     */
    public function normalise(array $item, string $type = 'movie'): array
    {
        $isMovie = ($type === 'movie');

        return [
            'tmdb_id'       => $item['id'],
            'title'         => $isMovie ? ($item['title'] ?? $item['name'] ?? '') : ($item['name'] ?? $item['title'] ?? ''),
            'description'   => $item['overview'] ?? null,
            'language'      => $item['original_language'] ?? 'en',
            'type'          => $isMovie ? 'movie' : 'series',
            'release_year'  => $this->extractYear($isMovie ? ($item['release_date'] ?? '') : ($item['first_air_date'] ?? '')),
            'thumbnail_url' => $this->imageUrl($item['poster_path'] ?? null),
            'backdrop_url'  => $this->imageUrl($item['backdrop_path'] ?? null, 'original'),
            'vote_average'  => $item['vote_average'] ?? null,
            'runtime'       => $item['runtime'] ?? ($item['episode_run_time'][0] ?? null),
            'genre_ids'     => $item['genre_ids'] ?? collect($item['genres'] ?? [])->pluck('id')->toArray(),
        ];
    }

    /**
     * Extract a 4-digit year from a date string.
     */
    protected function extractYear(?string $date): ?int
    {
        if (!$date) return null;
        $year = (int) substr($date, 0, 4);
        return $year > 0 ? $year : null;
    }
}
