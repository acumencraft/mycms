<?php
namespace App\Observers;

use App\Models\DigitalProduct;
use App\Services\ImageService;

class DigitalProductObserver
{
    public function __construct(
        private ImageService $imageService
    ) {}

    public function saved(DigitalProduct $product): void
    {
        // Cover image
        if ($product->wasChanged('image') && $product->image) {
            $webpPath = $this->imageService->convertToWebP(
                path: $product->image,
                disk: 'public',
                quality: 85,
                maxWidth: 1200
            );
            if ($webpPath !== $product->image) {
                $product->updateQuietly(['image' => $webpPath]);
            }
        }

        // Gallery images
        if ($product->wasChanged('gallery_images') && $product->gallery_images) {
            $converted = [];
            foreach ($product->gallery_images as $img) {
                $webpPath = $this->imageService->convertToWebP(
                    path: $img,
                    disk: 'public',
                    quality: 85,
                    maxWidth: 1200
                );
                $converted[] = $webpPath;
            }
            $product->updateQuietly(['gallery_images' => $converted]);
        }
    }
}
