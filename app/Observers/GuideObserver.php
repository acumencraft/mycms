<?php
namespace App\Observers;

use App\Models\Guide;
use App\Services\ImageService;

class GuideObserver
{
    public function __construct(
        private ImageService $imageService
    ) {}

    public function saved(Guide $guide): void
    {
        if ($guide->wasChanged('cover_image') && $guide->cover_image) {
            $webpPath = $this->imageService->convertToWebP(
                path: $guide->cover_image,
                disk: 'public',
                quality: 85,
                maxWidth: 1200
            );

            if ($webpPath !== $guide->cover_image) {
                $guide->updateQuietly(['cover_image' => $webpPath]);
            }
        }
    }
}
