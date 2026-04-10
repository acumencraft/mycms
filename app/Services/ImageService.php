<?php
namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    private ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function convertToWebP(
        string $path,
        string $disk = 'public',
        int $quality = 85,
        ?int $maxWidth = 1920
    ): string {
        if (!$path || !Storage::disk($disk)->exists($path)) {
            return $path;
        }

        if (Str::endsWith(strtolower($path), '.webp')) {
            return $path;
        }

        $fullPath = Storage::disk($disk)->path($path);
        $image = $this->manager->decode($fullPath);

        if ($maxWidth && $image->width() > $maxWidth) {
            $image->scaleDown(width: $maxWidth);
        }

        $newPath = preg_replace('/\.[^.]+$/', '.webp', $path);
        $newFullPath = Storage::disk($disk)->path($newPath);

        $image->encode(new WebpEncoder(quality: $quality))->save($newFullPath);

        if ($newPath !== $path) {
            Storage::disk($disk)->delete($path);
        }

        return $newPath;
    }
}
