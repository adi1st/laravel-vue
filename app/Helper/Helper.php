<?php
namespace App\Helper;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Helper
{
    // File Management
    public static function upload_file($file, $dir)
    {
        if (! $file instanceof \Illuminate\Http\UploadedFile) {
            throw new \InvalidArgumentException('File harus berupa instance dari UploadedFile.');
        }
        $originalName = $file->getClientOriginalName();
        if (preg_match('/\.php$/i', $originalName) || preg_match('/[<>:"\/|?*\x00-\x1F]/', $originalName)) {
            throw new \Exception('Nama file atau ekstensi mengandung karakter yang tidak didukung');
        }
        $safeName = time() . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs($dir, $safeName);
        return $path;
    }
    public static function url_file($path)
    {
        return $path && Storage::exists($path) ? Storage::url($path) : null;
    }
    public static function delete_file($file)
    {
        $url  = Storage::url('/');
        $file = str_replace($url, '', $file);
        if (Storage::exists($file)) {
            Storage::delete($file);
        }
    }
}
