@extends('layouts.app')

@section('title', 'Free Books & Resources')

@section('content')
<div class="container" style="padding:40px 24px 60px;">
    <div style="text-align:center;margin-bottom:30px;">
        <span class="badge badge-cyan" style="margin-bottom:12px;">📄 TESHEAI - RESOURCES</span>
        <h1 style="font-size:2rem;font-weight:800;margin:10px 0 8px;">ያላስተማሪ የሚያስተምሩ BOOKS & RESOURCES</h1>
        <p style="color:var(--muted);max-width:560px;margin:0 auto;">
            የተመዘገበ ብቻ በነፃ።<br>
            free for all registered users (only registered).
        </p>
    </div>

    <!-- Category Filter Buttons -->
    <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; margin-bottom: 35px;">
        <a href="{{ route('documents.index') }}" class="btn {{ !request('category') ? 'btn-primary' : 'btn-secondary' }}" style="border-radius: 20px; padding: 6px 18px; font-size: 0.85rem;">
            🔥 ሁሉንም / All
        </a>
        <a href="{{ route('documents.index', ['category' => 'coding']) }}" class="btn {{ request('category') == 'coding' ? 'btn-primary' : 'btn-secondary' }}" style="border-radius: 20px; padding: 6px 18px; font-size: 0.85rem;">
            💻 Coding
        </a>
        <a href="{{ route('documents.index', ['category' => 'graphics']) }}" class="btn {{ request('category') == 'graphics' ? 'btn-primary' : 'btn-secondary' }}" style="border-radius: 20px; padding: 6px 18px; font-size: 0.85rem;">
            🎨 Graphics
        </a>
        <a href="{{ route('documents.index', ['category' => 'video']) }}" class="btn {{ request('category') == 'video' ? 'btn-primary' : 'btn-secondary' }}" style="border-radius: 20px; padding: 6px 18px; font-size: 0.85rem;">
            🎥 Video Editing
        </a>
        <a href="{{ route('documents.index', ['category' => 'freshman']) }}" class="btn {{ request('category') == 'freshman' ? 'btn-primary' : 'btn-secondary' }}" style="border-radius: 20px; padding: 6px 18px; font-size: 0.85rem;">
            📚 Freshman Book
        </a>
    </div>

    @if($documents->isEmpty())
        <div class="card" style="padding:48px;text-align:center;color:var(--muted);">
            No Books found in this category. Check back soon!
        </div>
    @else
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px;">
            @foreach($documents as $doc)
                <div class="card" style="padding:24px;display:flex;flex-direction:column;gap:12px;">
                    <div style="font-size:2rem;">📄</div>
                    <h3 style="font-size:1.05rem;font-weight:700;">{{ $doc->title }}</h3>
                    @if($doc->description)
                        <p style="color:var(--muted);font-size:0.85rem;flex:1; margin-bottom: 0;">{{ $doc->description }}</p>
                    @endif
                    <div style="display:flex;gap:12px;color:var(--muted);font-size:0.78rem;">
                        <span>💾 {{ $doc->formatted_size }}</span>
                        <span>⬇️ {{ $doc->download_count }} downloads</span>
                    </div>
                    <div style="display:flex;gap:10px;margin-top:auto;">
                        <a href="{{ route('documents.read', $doc) }}" class="btn btn-primary btn-sm" style="flex:1;justify-content:center;">📖 አንብብ / Read</a>
                        <a href="{{ route('documents.download', $doc) }}" class="btn btn-secondary btn-sm" style="flex:1;justify-content:center;">⬇️ አውርድ / Download</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top:32px;">
            {{ $documents->links() }}
        </div>
    @endif
</div>
@endsection
