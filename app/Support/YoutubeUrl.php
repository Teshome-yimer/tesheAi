<?php

namespace App\Support;

class YoutubeUrl
{
    public static function normalize(?string $url): ?string
    {
        if (!$url) return null;

        $url = trim($url);

        // Already embed
        if (str_contains($url, '/embed/')) return $url;

        // youtu.be/ID?si=xxx
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        // youtube.com/watch?v=ID
        if (preg_match('/[?&]v=([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        // youtube.com/shorts/ID
        if (preg_match('/shorts\/([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        return $url;
    }
}
