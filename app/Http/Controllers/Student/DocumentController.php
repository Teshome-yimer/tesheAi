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
            
            // የየራሳቸው የተለዩ እና የማይተላለፉ ቃላት (Keywords)
            $keywords = match($category) {
                'coding' => [
                    'coding', 'code', 'programming', 'developer', 'development', 'software', 'engineer',
                    'fullstack', 'full stack', 'backend', 'frontend', 'web', 'mobile', 'android', 'ios',
                    'php', 'laravel', 'javascript', 'js', 'typescript', 'node', 'react', 'vue',
                    'flutter', 'dart', 'html', 'css', 'sql', 'mysql', 'mongodb', 'python', 'java',
                    'ኮዲንግ', 'ኮድ', 'ፕሮግራሚንግ', 'ሶፍትዌር', 'ዲቨሎፐር', 'ፉልስታክ', 'ዌብ', 'ሞባይል', 'አፕሊኬሽን', 'አፕ'
                ],
                'graphics' => [
                    'graphics', 'graphic', 'design', 'designer', 'photoshop', 'illustrator', 'figma',
                    'canva', 'ui', 'ux', 'branding', 'logo', 'poster', 'blender', '3d', 'vector',
                    'ግራፊክስ', 'ዲዛይን', 'ፎቶሾፕ', 'ኢልስትሬተር', 'ፊግማ', 'ካንቫ', 'ሎጎ', 'ፖስተር', 'ስዕል', 'ንድፍ'
                ],
                'video' => [
                    'video', 'editing', 'editor', 'premiere', 'after effects', 'capcut', 'davinci',
                    'filmora', 'vfx', 'color grading', 'cinematic', 'youtube', 'reels', 'shorts',
                    'ቪዲዮ', 'ኤዲቲንግ', 'ኤዲተር', 'ፕሪሚየር', 'ካፕካት', 'ዳቪንቺ', 'ዩቲዩብ', 'ሞንታጅ'
                ],
                'freshman' => [
                    'freshman', 'university', 'college', 'module', 'handout', 'semester',
                    'mathematics', 'physics', 'chemistry', 'biology', 'economics', 'psychology', 'logic',
                    'ፍሬሽማን', 'ዩኒቨርሲቲ', 'ኮሌጅ', 'ሞጁል', 'ማስታወሻ', 'ፈተና', 'ሂሳብ', 'ፊዚክስ', 'ኬሚስትሪ', 'ባዮሎጂ'
                ],
                default => [$category]
            };

            // እያንዳንዱ ካቴጎሪ የራሱን ቃላት ብቻ በጥብቅ እንዲፈልግ ማድረግ
            $query->where(function($q) use ($keywords) {
                foreach ($keywords as $index => $keyword) {
                    if ($index === 0) {
                        $q->where('title', 'like', '%' . $keyword . '%')
                          ->orWhere('description', 'like', '%' . $keyword . '%');
                    } else {
                        $q->orWhere('title', 'like', '%' . $keyword . '%')
                          ->orWhere('description', 'like', '%' . $keyword . '%');
                    }
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

    // Streams the PDF inline for the in-platform reader
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
