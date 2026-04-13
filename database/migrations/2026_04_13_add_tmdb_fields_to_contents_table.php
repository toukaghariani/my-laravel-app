<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->unsignedBigInteger('tmdb_id')->nullable()->unique()->after('id');
            $table->string('backdrop_url')->nullable()->after('thumbnail_url');
            $table->float('vote_average', 3, 1)->nullable()->after('is_premium');
            $table->integer('runtime')->nullable()->after('vote_average'); // minutes
            $table->string('streaming_url')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn(['tmdb_id', 'backdrop_url', 'vote_average', 'runtime']);
        });
    }
};
