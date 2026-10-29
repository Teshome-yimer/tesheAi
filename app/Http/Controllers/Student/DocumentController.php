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

        // ተጠቃሚው ካቴጎሪ መርጦ ከሆነ ፊልተር እናደርጋለን (ዳታቤዝ ሳንነካ በ title ወይም description keyword ፈልጎ ማምጣት ይቻላል)
        if ($request->filled('category')) {
            $category = $request->input('category');
            
            // የካቴጎሪ ማጣሪያ (በምርጫህ መሰረት ኪዎርድ ፈልጎ እንዲያመጣ ማድረግ ይቻላል)
            $query->where(function($q) use ($category) {
                $q->where('title', 'like', '%' . $category . '%')
                  ->orWhere('description', 'like', '%' . $category . '%');
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
