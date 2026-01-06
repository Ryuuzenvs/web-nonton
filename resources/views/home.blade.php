<link href="{{ asset('bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('all.min.css') }}" rel="stylesheet">
<link href="{{ asset('aniel.css') }}" rel="stylesheet">
<link href="{{ asset('anibt.css') }}" rel="stylesheet">
<script src="{{ asset('feather.min.js') }}"></script>

<style>
    body {
        background: #090a0f;
        overflow-x: hidden;
background:  url('{{ asset('bg.webp') }}') no-repeat fixed; /* Tambahkan ini */
        color: white;
background-size: cover;
    }

</style>


<div class="container mt-5">
<div class="highlight-section mb-5">
    <h4 class="mb-3"><i data-feather="zap" class="text-warning"></i> Rekomendasi Hari Ini</h4>
    <div class="d-flex flex-nowrap overflow-auto pb-3" style="gap: 15px; scrollbar-width: thin;">
        @foreach($highlights as $h)
            @if($h->highlight_video)
            <div class="card bg-dark text-white border-primary" style="min-width: 300px; max-width: 300px;">
                <div class="position-relative">
                    <video width="100%" height="170" style="object-fit: cover;" muted loop onmouseover="this.play()" onmouseout="this.pause()">
                        <source src="{{ asset('anime/' . $h->folder_name . '/' . $h->highlight_video . '#t=30') }}" type="video/mp4">
                    </video>
                    <div class="position-absolute bottom-0 start-0 p-2 w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                        <small class="d-block text-truncate">{{ $h->title ?? $h->folder_name }}</small>
                    </div>
                </div>
                <div class="card-body p-2 d-flex justify-content-between align-items-center">
    <span class="small text-info">Episode {{ $h->highlight_eps }}</span>
    
    <a href="{{ route('anime.watch', [$h->folder_name, $h->highlight_eps]) }}" class="btn btn-primary btn-sm">
    <i data-feather="play-circle"></i> Tonton
</a>
</div>
            </div>
            @endif
        @endforeach
    </div>
</div>
    <h2>Daftar Anime Lokal <a href="{{ route('anime.sync') }}" class="btn btn-success custom-btn-icon">
<i data-feather="refresh-cw" width="16" height="16"></i>
            <span class="btn-text">. Scan Folder Baru</span>
</a></h2>
    <form action="/" method="GET" class="mb-4">
        <input type="text" name="search" class="form-control" placeholder="Cari nama anime alias...">
    </form>

<div class="row">
    @foreach($animes as $a)
<div class="col-md-3 mb-3">
    <div class="card text-white anime-card-effect bg-transparent"> <div class="card-body">
            <h5>{{ $a->title ?? $a->folder_name }}</h5>
            <p class="small text-warning">{{ $a->title ? '' : $a->folder_name }}</p>
            <p>Total: {{ $a->max_eps }} Eps</p>
            <a href="{{ route('anime.detail', $a->folder_name) }}" class="btn btn-primary btn-sm custom-btn-icon">
    <i data-feather="play" width="14" height="14"></i><span class="btn-text">Buka</span> </a>
        </div>
    </div>
</div>
@endforeach
</div>
<script>
    // Inisialisasi Feather Icons
    feather.replace();
</script>
