<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('bootstrap.min.css') }}" rel="stylesheet">
    <title>Episode {{ $anime->title }}</title>
</head>
<body class="bg-dark text-white p-5">
    <div class="container">
        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light mb-3">← Kembali</a>
        <h1>{{ $anime->title }}</h1>
        <p>Pilih Episode (1 - {{ $anime->max_eps }}):</p>
        
        <div class="row">
    @for ($i = 1; $i <= $anime->max_eps; $i++)
        <div class="col-md-2 mb-2">
           <a href="{{ route('watch', ['folder_name' => $anime->folder_name, 'eps' => $i]) }}" class="btn btn-primary w-100">
    Eps {{ $i }}
</a>
        </div>
    @endfor
</div>
    </div>
</body>
</html>
