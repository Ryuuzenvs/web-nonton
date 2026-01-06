<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;

use App\Models\Anime;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function index(Request $request)
{
    $search = $request->query('search');

    // Pakai query builder supaya lebih fleksibel
    $animes = Anime::when($search, function ($query, $search) {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('folder_name', 'LIKE', "%{$search}%");
        });
    })->get();

    return view('home', compact('animes'));
}

   public function show($folder_name)
{
    // Cari data berdasarkan nama folder, bukan ID
    $anime = Anime::where('folder_name', $folder_name)->firstOrFail();
    return view('list_episode', compact('anime'));
}
public function watch($folder_name, $eps)
{
    $anime = Anime::where('folder_name', $folder_name)->firstOrFail();
    
    // Logika suffix berdasarkan list file kamu tadi
    $suffix = ($eps == $anime->max_eps) ? '_End_360p' : '_360p';
    $eps_format = str_pad($eps, 2, '0', STR_PAD_LEFT);
    
    // Hasil: Otakudesu_SeirGenski--01_360p.mp4
    $video_file = $anime->file_pattern . $eps_format . $suffix . '.mp4'; 
    
    return view('watch', compact('anime', 'eps', 'video_file'));
    }

    public function sync()
{
    $path = public_path('anime');
    
    // 1. Ambil semua folder di dalam public/anime
    $folders = File::directories($path);

    foreach ($folders as $folderPath) {
        $folderName = basename($folderPath);

        // 2. Cek apakah folder ini sudah ada di database
        $exists = Anime::where('folder_name', $folderName)->exists();

        if (!$exists) {
            // 3. Hitung jumlah file .mp4 (Max Eps)
            $files = File::files($folderPath);
            $mp4Count = 0;
            foreach ($files as $file) {
                if ($file->getExtension() == 'mp4') {
                    $mp4Count++;
                }
            }
$cleanName = substr($folderName, 0, -5); // Memotong '_360p'
$folderName = trim(basename($folderPath), '/');

            // 4. Masukkan ke Database
            Anime::create([
                'title' => null, // Kamu isi manual nanti
                'folder_name' => $folderName,
                'file_pattern' => $cleanName . '--', // Rumus: folder_name + --
                'max_eps' => $mp4Count,
            ]);
        }
    }

    return redirect()->route('home')->with('success', 'Scan Selesai!');
}

}
