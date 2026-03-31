{{-- ============================================================
     WATCH PROGRESS TRACKER COMPONENT
     POSTs progress to backend every 30 seconds
     Backend TODO: POST /watch/progress → WatchController@saveProgress
     ============================================================ --}}

@push('scripts')
<script>
(function() {
    const MOVIE_ID = {{ $movieId ?? 1 }};
    const DURATION = {{ $duration ?? 7200 }};
    const video = document.getElementById('mainPlayer');
    let lastSaved = 0;

    function saveProgress() {
        if (!video || video.paused) return;
        const currentTime = Math.floor(video.currentTime);
        if (currentTime === lastSaved) return;
        lastSaved = currentTime;
        const progress = Math.round((currentTime / DURATION) * 100);

        // POST to backend every 30 seconds
        fetch('/watch/progress', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                movie_id: MOVIE_ID,
                current_time: currentTime,
                progress: progress,
                duration: DURATION
            })
        }).catch(function(err) {
            console.log('Progress save failed:', err);
        });

        console.log('Progress saved:', progress + '% — ' + currentTime + 's / ' + DURATION + 's');
    }

    // Save every 30 seconds
    setInterval(saveProgress, 30000);

    // Also save when user leaves the page
    window.addEventListener('beforeunload', saveProgress);

    // Save when video ends
    if (video) {
        video.addEventListener('ended', function() {
            saveProgress();
            console.log('Movie completed!');
        });
    }
})();
</script>
@endpush