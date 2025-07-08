<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImageDownloader
{
    public static function downloadImage(string $url, string $filename, string $disk = 'public'): string
    {
        try {
            $response = Http::timeout(30)->get($url);
            
            if ($response->successful()) {
                $path = "seeders/{$filename}";
                Storage::disk($disk)->put($path, $response->body());
                return $path;
            }
        } catch (\Exception $e) {
            // If download fails, return a default placeholder
            return "seeders/default-{$filename}";
        }
        
        return "seeders/default-{$filename}";
    }

    public static function getProductImageUrl(int $index): string
    {
        $imageUrls = [
            'https://picsum.photos/400/400?random=1',
            'https://picsum.photos/400/400?random=2',
            'https://picsum.photos/400/400?random=3',
            'https://picsum.photos/400/400?random=4',
            'https://picsum.photos/400/400?random=5',
            'https://picsum.photos/400/400?random=6',
            'https://picsum.photos/400/400?random=7',
            'https://picsum.photos/400/400?random=8',
            'https://picsum.photos/400/400?random=9',
            'https://picsum.photos/400/400?random=10',
        ];
        
        return $imageUrls[$index % count($imageUrls)];
    }

    public static function getCategoryImageUrl(int $index): string
    {
        $imageUrls = [
            'https://picsum.photos/600/400?random=11',
            'https://picsum.photos/600/400?random=12',
            'https://picsum.photos/600/400?random=13',
            'https://picsum.photos/600/400?random=14',
            'https://picsum.photos/600/400?random=15',
            'https://picsum.photos/600/400?random=16',
            'https://picsum.photos/600/400?random=17',
            'https://picsum.photos/600/400?random=18',
        ];
        
        return $imageUrls[$index % count($imageUrls)];
    }
} 