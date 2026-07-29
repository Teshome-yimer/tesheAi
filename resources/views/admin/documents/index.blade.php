@extends('layouts.admin')

@section('title', 'PDF Documents')

@section('content')
<div class="page-header">
    <h1 class="page-title">📄 PDF Documents (Free Library)</h1>
    <button class="btn btn-primary" onclick="toggleUploadPanel()">⬆️ Upload PDF</button>
</div>

<p style="color:var(--muted);font-size:0.85rem;margin-bottom:20px;">
    እነዚህ PDF ሰነዶች ለተመዘገቡ ተጠቃሚዎች በነጻ ይታያሉ እና ይወርዳሉ። / These PDFs are free to read &amp; download for registered users only.
</p>

@if($errors->any())
    <div class="flash flash-error">❌ {{ $errors->first() }}</div>
@endif

{{-- Upload panel --}}
<div id="upload-panel" class="form-card" style="display:none;margin-bottom:24px;">
    <h3 style="font-size:1rem;margin-bottom:16px;">Upload New PDF</h3>
    <form method="POST" action="{{ route('admin.documents.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">PDF File * (max 50MB)</label>
                <input type="file" name="file" class="form-control" accept="application/pdf" required>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Description (optional)</label>
            <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">⬆️ Upload</button>
        <button type="button" class="btn btn-secondary" onclick="toggleUploadPanel()">Cancel</button>
    </form>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Size</th>
                <th>Downloads</th>
                <th>Status</th>
                <th>Uploaded</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documents as $doc)
                <tr>
                    <td>
                        <div style="font-weight:600;">📄 {{ $doc->title }}</div>
                        @if($doc->description)
                            <div style="color:var(--muted);font-size:0.78rem;margin-top:2px;">{{ Str::limit($doc->description, 80) }}</div>
                        @endif
                    </td>
                    <td>{{ $doc->formatted_size }}</td>
                    <td>{{ $doc->download_count }}</td>
                    <td>
                        @if($doc->is_published)
                            <span class="badge badge-success">Published</span>
                        @else
                            <span class="badge badge-muted">Hidden</span>
                        @endif
                    </td>
                    <td style="color:var(--muted);">{{ $doc->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            <a href="{{ route('documents.read', $doc) }}" target="_blank" class="btn btn-secondary btn-sm">👁 Preview</a>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEdit({{ $doc->id }})">✎ Edit</button>
                            <form method="POST" action="{{ route('admin.documents.toggle-publish', $doc) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">{{ $doc->is_published ? 'Hide' : 'Publish' }}</button>
                            </form>
                            <form method="POST" action="{{ route('admin.documents.destroy', $doc) }}" style="display:inline;"
                                  onsubmit="return confirm('Delete this document permanently?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr id="edit-row-{{ $doc->id }}" style="display:none;">
                    <td colspan="6" style="background:var(--bg3);">
                        <form method="POST" action="{{ route('admin.documents.update', $doc) }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
                            @csrf @method('PUT')
                            <div style="flex:1;min-width:200px;">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $doc->title }}" required>
                            </div>
                            <div style="flex:2;min-width:260px;">
                                <label class="form-label">Description</label>
                                <input type="text" name="description" class="form-control" value="{{ $doc->description }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEdit({{ $doc->id }})">Cancel</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;color:var(--muted);padding:32px;">
                        No documents yet. Click "Upload PDF" to add your first document.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $documents->links() }}
</div>
@endsection

@push('scripts')
<script>
    function toggleUploadPanel() {
        const p = document.getElementById('upload-panel');
        p.style.display = p.style.display === 'none' ? 'block' : 'none';
    }
    function toggleEdit(id) {
        const row = document.getElementById('edit-row-' + id);
        row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
    }
    @if($errors->any())
        document.getElementById('upload-panel').style.display = 'block';
    @endif
</script>
@endpush
