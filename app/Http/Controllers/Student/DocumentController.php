<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::where('is_published', true);

        if ($request->filled('category')) {
            $category = $request->input('category');
            
            // የኮዲንግ፣ ዌብ፣ ሞባይል እና ሌሎችም ቃላት በእንግሊዘኛ እና በአማርኛ
            $keywords = match($category) {
                'coding' => [
                    // General Coding & Development (English)
                    'coding', 'code', 'programming', 'developer', 'development', 'software', 'engineer',
                    'fullstack', 'full stack', 'full-stack', 'backend', 'back-end', 'frontend', 'front-end',
                    'web', 'web development', 'website', 'mobile', 'mobile app', 'android', 'ios',
                    'php', 'laravel', 'livewire', 'alpine', 'javascript', 'js', 'typescript', 'ts',
                    'node', 'nodejs', 'express', 'react', 'reactjs', 'react native', 'vue', 'vuejs',
                    'nuxt', 'nextjs', 'angular', 'mern', 'mean', 'flutter', 'dart', 'html', 'css',
                    'scss', 'tailwind', 'bootstrap', 'sql', 'mysql', 'mongodb', 'postgresql', 'sqlite',
                    'database', 'db', 'java', 'c++', 'c#', 'c', 'python', 'django', 'flask', 'ruby',
                    'rails', 'go', 'golang', 'rust', 'swift', 'kotlin', 'git', 'github', 'gitlab',
                    'api', 'rest', 'graphql', 'json', 'xml', 'docker', 'linux', 'ubuntu', 'aws',
                    'firebase', 'supabase', 'jquery', 'wordpress', 'woocommerce', 'shopify', 'debugging',
                    'algorithm', 'data structure', 'app', 'script', 'terminal', 'bash', 'command',
                    'framework', 'library', 'oop', 'mvc', 'artisan', 'composer', 'npm', 'yarn', 'vite',
                    'webpack', 'server', 'hosting', 'domain', 'security', 'auth', 'jwt', 'session',
                    'cookie', 'migration', 'eloquent', 'query', 'controller', 'view', 'blade', 'api integration',
                    // ኮዲንግ፣ ዌብ እና ሞባይል (አማርኛ)
                    'ኮዲንግ', 'ኮድ', 'ፕሮግራሚንግ', 'ሶፍትዌር', 'ዲቨሎፐር', 'ፉልስታክ', 'ዌብ', 'ሞባይል',
                    'አፕሊኬሽን', 'አፕ', 'የድረገጽ ልማት', 'የሞባይል አፕ', 'ቴክኖሎጂ', 'ኮምፒዩተር', 'ዳታቤዝ',
                    'ስክሪፕት', 'የፕሮግራም ቋንቋ', 'ኢንጂነር'
                ],
                'graphics' => [
                    // English
                    'graphics', 'graphic', 'design', 'designer', 'photoshop', 'ps', 'illustrator', 'ai',
                    'indesign', 'xd', 'figma', 'sketch', 'canva', 'ui', 'ux', 'user interface', 'user experience',
                    'branding', 'logo', 'poster', 'flyer', 'banner', 'vector', 'raster', 'coreldraw', 'blender',
                    '3d', '4d', 'animation', 'typography', 'color', 'palette', 'art', 'drawing', 'sketchpad',
                    'visual', 'layout', 'wireframe', 'prototype', 'mockup', 'creative', 'template', 'photo editing',
                    'image', 'picture', 'icon', 'svg', 'png', 'jpg', 'jpeg', 'resolution', 'dpi', 'pixel',
                    'gradient', 'shadow', 'layer', 'mask', 'blend', 'brush', 'filter', 'effect', 'plugin',
                    'portfolio', 'business card', 'brochure', 'book cover', 'social media post', 'thumbnail',
                    'font', 'style guide', 'design system', 'interaction', 'motion', 'render', 'texture',
                    // አማርኛ
                    'ግራፊክስ', 'ዲዛይን', 'ፎቶሾፕ', 'ኢልስትሬተር', 'ፊግማ', 'ካንቫ', 'ሎጎ', 'ፖስተር', 'ባነር',
                    'ፎቶ', 'ስዕል', 'አርት', 'ቪዥዋል', 'ማስታወቂያ', 'የስራ ዕቅድ', 'ንድፍ', 'ብሌንደር', 'የዲዛይን ስራ'
                ],
                'video' => [
                    // English
                    'video', 'editing', 'editor', 'premiere', 'pro', 'after effects', 'ae', 'capcut', 'davinci',
                    'resolve', 'final cut', 'filmora', 'sony vegas', 'vfx', 'visual effects', 'cgi', 'color grading',
                    'audio', 'sound design', 'transition', 'effects', 'rendering', 'export', 'mp4', 'avi', 'mov',
                    'mkv', 'clip', 'footage', 'montage', 'cinematic', 'cinema', 'motion graphics', 'green screen',
                    'chroma key', 'youtube', 'content creation', 'production', 'post-production', 'camera', 'shooting',
                    'fps', 'resolution', '1080p', '4k', '8k', 'bitrate', 'codec', 'audio mixing', 'voiceover',
                    'subtitle', 'caption', 'intro', 'outro', 'teaser', 'trailer', 'reels', 'shorts', 'tiktok',
                    'streaming', 'obs', 'microphone', 'podcast', 'frequency', 'equalizer', 'compression', 'gain',
                    'timeline', 'keyframe', 'masking', 'tracking', 'stabilization', 'speed ramp', 'slow motion',
                    // አማርኛ
                    'ቪዲዮ', 'ኤዲቲንግ', 'ኤዲተር', 'ፕሪሚየር', 'ካፕካት', 'ዳቪንቺ', 'ፊልሞራ', 'ድምፅ', 'ሙዚቃ',
                    'የቪዲዮ ኤዲቲንግ', 'ዩቲዩብ', 'ካሜራ', 'ሬኮርድ', 'ሲኒማ', 'ሞንታጅ', 'የቪዲዮ ቅንብር'
                ],
                'freshman' => [
                    // English
                    'freshman', 'university', 'college', 'book', 'pdf', 'notes', 'study', 'education', 'first year',
                    'exam', 'quiz', 'assignment', 'lecture', 'syllabus', 'module', 'handout', 'mathematics', 'math',
                    'physics', 'chemistry', 'biology', 'economics', 'psychology', 'logic', 'critical thinking',
                    'civics', 'moral', 'english', 'communicative', 'global trends', 'entrepreneurship', 'anthropology',
                    'science', 'natural', 'social', 'amharic', 'ethiopian', 'history', 'geography', 'statistic',
                    'stats', 'accounting', 'management', 'business', 'law', 'ict', 'information technology',
                    'stream', 'department', 'campus', 'registrar', 'grade', 'gpa', 'cgpa', 'semester', 'class',
                    // አማርኛ
                    'ፍሬሽማን', 'ዩኒቨርሲቲ', 'ኮሌጅ', 'መጽሐፍ', 'ሞጁል', 'ማስታወሻ', 'ትምህርት', 'ፈተና', 'ጥያቄ',
                    'ሂሳብ', 'ፊዚክስ', 'ኬሚስትሪ', 'ባዮሎጂ', 'ኢኮኖሚክስ', 'ሳይኮሎጂ', 'ሎጂክ', 'ሲቪክስ', 'ታሪክ',
                    'ጂኦግራፊ', 'አንትሮፖሎጂ', 'ኢንተርፕረነርሺፕ', 'አማርኛ', 'እንግሊዝኛ', 'ህግ', 'አካውንቲንግ', 'ማኔጅመንት',
                    'መጀመሪያ ዓመት', 'ሰሚስተር', 'ማኑዋል', 'ማጣቀሻ', 'መጽሐፍት'
                ],
                default => [$category]
            };

            // ቃላቱን በ Title ወይም Description ውስጥ ፈልጎ ማምጣት
            $query->where(function($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('title', 'like', '%' . $keyword . '%')
                      ->orWhere('description', 'like', '%' . $keyword . '%');
                }
            });
        }

        $documents = $query->orderByDesc('created_at')->paginate(12)->withQueryString();

        return view('documents.index', compact('documents'));
    }

    public function read(Document $document)
    {
        abort_unless($document->is_published, 404);
        return view('documents.read', compact('document'));
    }

    public function view(Document $document)
    {
        abort_unless($document->is_published, 404);
        $disk = Storage::disk(config('filesystems.default'));

        if (!$disk->exists($document->file_path)) {
            abort(404, 'File not found');
        }

        return response()->stream(function () use ($disk, $document) {
            echo $disk->get($document->file_path);
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . str_replace('"', '', $document->title) . '.pdf"',
        ]);
    }

    public function download(Document $document)
    {
        abort_unless($document->is_published, 404);
        $disk = Storage::disk(config('filesystems.default'));

        if (!$disk->exists($document->file_path)) {
            abort(404, 'File not found');
        }

        $document->increment('download_count');

        return $disk->download(
            $document->file_path,
            str_replace('"', '', $document->title) . '.pdf'
        );
    }
}
