<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::where('is_published', true)
            ->orderByDesc('created_at')
            ->paginate(12);
        return view('documents.index', compact('documents'));
    }

    public function read(Document $document)
    {
        abort_unless($document->is_published, 404);
        return view('documents.read', compact('document'));
    }

    // Streams the PDF inline for the in-platform reader (registered users only)
    public function view(Document $document)
    {
        abort_unless($document->is_published, 404);
        if (!Storage::disk('local')->exists($document->file_path)) {
            abort(404, 'File not found');
        }

        return response()->file(Storage::disk('local')->path($document->file_path), [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . str_replace('"', '', $document->title) . '.pdf"',
        ]);
    }

    public function download(Document $document)
    {
        abort_unless($document->is_published, 404);
        if (!Storage::disk('local')->exists($document->file_path)) {
            abort(404, 'File not found');
        }

        $document->increment('download_count');

        return response()->download(
            Storage::disk('local')->path($document->file_path),
            str_replace('"', '', $document->title) . '.pdf'
        );
    }
}
