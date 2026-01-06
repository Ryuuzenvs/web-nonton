<link href="{{ asset('bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('salju.css') }}" rel="stylesheet">
<style>
    body {
        background: radial-gradient(ellipse at bottom, #1b2735 0%, #090a0f 100%);
        overflow-x: hidden;
        min-height: 100vh;
        color: white;
    }

</style>

<div class="snow-container" id="snow"></div>

<script>
    // Kita render salju SEKALI saja saat page load
    const snowContainer = document.getElementById('snow');
    const snowflakeCount = 50; // Jumlah partikel, 50 sudah cukup indah & ringan untuk i3

    for (let i = 0; i < snowflakeCount; i++) {
        const div = document.createElement('div');
        div.classList.add('snowflake');
        
        // Randomize posisi dan ukuran di awal (Pre-calculation)
        const size = Math.random() * 4 + 2 + 'px';
        const left = Math.random() * 100 + '%';
        const duration = Math.random() * 10 + 5 + 's'; // Kecepatan jatuh beda-beda
        const delay = Math.random() * 10 + 's';
        const opacity = Math.random();

        div.style.width = size;
        div.style.height = size;
        div.style.left = left;
        div.style.animationDuration = duration;
        div.style.animationDelay = delay;
        div.style.opacity = opacity;

        snowContainer.appendChild(div);
    }
</script>
<div class="container mt-5">
    <h2>Daftar Anime Lokal</h2>
<div class="m-2">
<a href="{{ route('anime.sync') }}" class="btn btn-success">🔄 Scan Folder Baru</a>
</div>
    <form action="/" method="GET" class="mb-4">
        <input type="text" name="search" class="form-control" placeholder="Cari nama anime alias...">
    </form>

<div class="row">
    @foreach($animes as $a)
    <div class="col-md-3 mb-3">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <h5>{{ $a->title ?? $a->folder_name }}</h5>
                <p class="small text-warning">{{ $a->title ? '' : $a->folder_name }}</p>
                <p>Total: {{ $a->max_eps }} Eps</p>
                <a href="{{ route('anime.detail', $a->folder_name) }}" class="btn btn-primary btn-sm">Buka</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
