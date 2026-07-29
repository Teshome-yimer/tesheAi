<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::orderByDesc('created_at')->paginate(20);
        return view('admin.documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'file'        => 'required|file|mimes:pdf|max:51200', // 50MB, PDF only
        ]);

        $file = $request->file('file');
        // Stored on the private (local) disk — served only through auth-checked routes
        $path = $file->store('documents', 'local');

        Document::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'file_path'    => $path,
            'file_size'    => $file->getSize(),
            'is_published' => true,
        ]);

        return back()->with('success', 'PDF document uploaded successfully!');
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
        ]);

        $document->update($request->only('title', 'description'));

        return back()->with('success', 'Document updated!');
    }

    public function togglePublish(Document $document)
    {
        $document->update(['is_published' => !$document->is_published]);
        return back()->with('success', $document->is_published ? 'Document published!' : 'Document hidden!');
    }

    public function destroy(Document $document)
    {
        Storage::disk('local')->delete($document->file_path);
        $document->delete();
        return back()->with('success', 'Document deleted!');
    }
}
