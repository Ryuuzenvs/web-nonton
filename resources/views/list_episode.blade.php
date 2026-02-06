<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('feather.min.js') }}"></script>
    <title>Episode {{ $anime->title ?? $anime->folder_name }}</title>
    <style>
        body {
            background: #090a0f url('{{ asset('bg.webp') }}') no-repeat center center fixed;
            background-size: cover;
            color: white;
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
        }
        .btn-episode {
            transition: all 0.3s;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .btn-episode:hover {
            transform: scale(1.1);
            background-color: #0d6efd;
            box-shadow: 0 0 15px rgba(13, 110, 253, 0.5);
        }
    </style>
</head>
<body class="p-5">
    <div class="container glass-card">
        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light mb-4">
            <i data-feather="arrow-left" style="width: 14px;"></i> Kembali ke Home
        </a>
        
        <h1 class="display-5 fw-bold">{{ $anime->title ?? $anime->folder_name }}</h1>
        <p class="text-warning">Total: {{ $anime->max_eps }} Episode tersedia</p>
        <hr class="border-secondary">

        <div class="row mt-4">
            @for ($i = 1; $i <= $anime->max_eps; $i++)
                <div class="col-6 col-md-2 col-lg-1 mb-3">
                    {{-- Perbaikan: Ganti 'watch' menjadi 'anime.watch' --}}
                    <a href="{{ route('anime.watch', ['folder_name' => $anime->folder_name, 'eps' => $i]) }}" 
                       class="btn btn-dark w-100 btn-episode">
                        {{ $i }}
                    </a>
                </div>
            @endfor
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>
