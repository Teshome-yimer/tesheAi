<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $baseUrl = rtrim(config('app.url'), '/');

        // Static public URLs
        $staticUrls = [
            ['loc' => $baseUrl . '/',            'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => $baseUrl . '/login',        'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => $baseUrl . '/register',     'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => $baseUrl . '/documents',    'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => $baseUrl . '/quizzes',      'priority' => '0.7', 'changefreq' => 'weekly'],
        ];

        // Dynamic: all published courses
        $courses = Course::where('is_published', true)
            ->select(['slug', 'updated_at'])
            ->get();

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($staticUrls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . htmlspecialchars($url['loc'], ENT_XML1, 'UTF-8') . "</loc>\n";
            $xml .= '    <changefreq>' . $url['changefreq'] . "</changefreq>\n";
            $xml .= '    <priority>' . $url['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        foreach ($courses as $course) {
            $loc      = $baseUrl . '/course/' . rawurlencode($course->slug);
            $lastmod  = $course->updated_at
                ? $course->updated_at->toAtomString()
                : now()->toAtomString();

            $xml .= "  <url>\n";
            $xml .= '    <loc>' . htmlspecialchars($loc, ENT_XML1, 'UTF-8') . "</loc>\n";
            $xml .= '    <lastmod>' . $lastmod . "</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'text/xml; charset=UTF-8',
        ]);
    }
}
