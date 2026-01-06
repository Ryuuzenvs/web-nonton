<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AnimeController extends Controller
{
    public function streamVideo($folder, $file)
{
    $path = public_path("anime/{$folder}/{$file}");

    if (!file_exists($path)) {
        abort(404);
    }

    $size = filesize($path);
    $length = $size;
    $start = 0;
    $end = $size - 1;

    $type = 'video/mp4';
    $headers = [
        'Content-Type' => $type,
        'Accept-Ranges' => 'bytes',
    ];

    if (request()->hasHeader('Range')) {
        $range = request()->header('Range');
        list(, $range) = explode('=', $range, 2);
        if (strpos($range, ',') !== false) {
            abort(416);
        }
        if ($range == '-') {
            $range = "0-$end";
        }
        $range = explode('-', $range);
        $start = (int)$range[0];
        $end = (isset($range[1]) && is_numeric($range[1])) ? (int)$range[1] : $size - 1;

        $length = $end - $start + 1;
        $headers['Content-Range'] = "bytes $start-$end/$size";
        $headers['Content-Length'] = $length;

        return response()->stream(function () use ($path, $start, $length) {
            $stream = fopen($path, 'rb');
            fseek($stream, $start);
            echo fread($stream, $length);
            fclose($stream);
        }, 206, $headers);
    }

    $headers['Content-Length'] = $size;
    return response()->file($path, $headers);
}
    public function index(Request $request)
    {
        // 1. Ambil semua anime dari database
        $allAnimes = Anime::all();

        // 2. Logic untuk Highlight (Ambil 5 random)
        $highlights = $allAnimes->shuffle()->take(5)->map(function ($anime) {
            // Scan folder untuk cari video mp4
            $files = glob(public_path("anime/{$anime->folder_name}/*.mp4"));

            if (count($files) > 0) {
                $randomFile = $files[array_rand($files)];
                $fileName = basename($randomFile);
                $anime->highlight_video = $fileName;

                // Ambil nomor episode dari nama file (preg_match)
                if (preg_match('/--(\d+)/', $fileName, $matches)) {
                    $anime->highlight_eps = (int)$matches[1];
                } else {
                    $anime->highlight_eps = 1;
                }
            } else {
                $anime->highlight_video = null;
            }
            return $anime;
        });

        // 3. Logic untuk Daftar Anime di bawah (Pencarian)
        $query = $request->input('search');
        $animes = Anime::when($query, function ($q) use ($query) {
            return $q->where('title', 'like', "%$query%")
                ->orWhere('folder_name', 'like', "%$query%");
        })->get();
         
        // Fitur Waifu Sambut Ver 1.3
    $waifuIndex = rand(1, 3); // Karena ada 3 gambar (1.png, 2.png, 3.png)
    
    $dialogs = [
        "Ohayou, Onii-chan! Sudah siap maraton anime hari ini?",
        "Okaerinasai! Mau lanjut nonton episode yang mana?",
        "Yahalloo~! Ada banyak anime seru yang nungguin kamu nih.",
        "Otsukare-sama! Istirahat dulu yuk sambil nonton.",
        "Konbanwa! Jangan nonton kemalaman ya, kesehatanmu penting!",
        "Mata aeta ne! Aku senang kamu mampir ke sini lagi.",
        "Nani miteru no? Semoga ketemu anime yang cocok ya!",
        "Ganbare! Aku akan selalu menemanimu di sini.",
        "Tadaima? Eh salah, maksudnya Okaeri! Hehe.",
        "Sa, ikou! Ayo mulai nontonnya sekarang!"
    ];
    $waifuDialog = $dialogs[array_rand($dialogs)];

return view('home', compact('highlights', 'animes', 'waifuIndex', 'waifuDialog'));
    }

    public function show($folder_name)
    {
        $anime = Anime::where('folder_name', $folder_name)->firstOrFail();
        return view('list_episode', compact('anime'));
    }

    public function watch($folder_name, $eps)
    {
        $anime = Anime::where('folder_name', $folder_name)->firstOrFail();

        // Logika suffix
        $suffix = ($eps == $anime->max_eps) ? '_End_360p' : '_360p';
        $eps_format = str_pad($eps, 2, '0', STR_PAD_LEFT);

        // Hasil: Otakudesu_SeirGenski--01_360p.mp4
        $video_file = $anime->file_pattern . $eps_format . $suffix . '.mp4';

        return view('watch', compact('anime', 'eps', 'video_file'));
    }

    public function sync()
    {
        $path = public_path('anime');
        $folders = File::directories($path);

        foreach ($folders as $folderPath) {
            $folderName = basename($folderPath);
            $exists = Anime::where('folder_name', $folderName)->exists();

            if (!$exists) {
                $files = File::files($folderPath);
                $mp4Count = 0;
                foreach ($files as $file) {
                    if ($file->getExtension() == 'mp4') {
                        $mp4Count++;
                    }
                }
                
                // Rumus Pattern
                $cleanName = (str_contains($folderName, '_360p')) ? substr($folderName, 0, -5) : $folderName;

                Anime::create([
                    'title' => null,
                    'folder_name' => $folderName,
                    'file_pattern' => $cleanName . '--',
                    'max_eps' => $mp4Count,
                ]);
            }
        }

        return redirect()->route('home')->with('success', 'Scan Selesai!');
    }
}
