<?php
namespace App\Observers;

use App\Models\Publication;
use App\Services\ImageService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PublicationObserver
{
    public function __construct(
        private ImageService $imageService
    ) {}

    public function saved(Publication $publication): void
    {
        Cache::forget('home.publications');

        // cover_image შეიცვალა და არ არის WebP
        if ($publication->wasChanged('cover_image') && $publication->cover_image) {
            $webpPath = $this->imageService->convertToWebP(
                path: $publication->cover_image,
                disk: 'public',
                quality: 85,
                maxWidth: 1200
            );

            // path შეიცვალა — DB განვაახლოთ Observer-ის loop-ის გარეშე
            if ($webpPath !== $publication->cover_image) {
                $publication->withoutEvents(function () use ($publication, $webpPath) {
                    $publication->updateQuietly(['cover_image' => $webpPath]);
                });
            }
        }

        if ($publication->is_published) {
            $this->pingGoogle();
        }
    }

    public function deleted(Publication $publication): void
    {
        Cache::forget('home.publications');
    }

    private function pingGoogle(): void
    {
        $sitemapUrl = config('app.url') . '/sitemap.xml';
        Http::get("https://www.google.com/ping?sitemap={$sitemapUrl}");
    }
}
