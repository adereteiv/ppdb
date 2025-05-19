<span {{ $attributes->merge(['id' => 'countdown']) }}></span>
<script>
    let expiry = {{ $expiry }};
    const countdownElement = document.getElementById('countdown');
    const endTime = Date.now() + expiry * 1000;

    function updateTimer() {
        const now = Date.now();
        const diff = Math.max(0, Math.floor((endTime - now) / 1000));

        const minutes = Math.floor(diff / 60);
        const secs = diff % 60;
        countdownElement.textContent = `${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;

        if (diff > 0) {
            setTimeout(updateTimer, 1000);
        }
    }
    updateTimer();
</script>
