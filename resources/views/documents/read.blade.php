@extends('layouts.app')

@section('title', $document->title)

@section('content')
<div class="container" style="padding:24px;">
    <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:16px;">
        <div>
            <a href="{{ route('documents.index') }}" style="font-size:0.85rem;color:var(--muted);">← ሁሉም መፅሀፍት All Books</a>
            <h1 style="font-size:1.3rem;font-weight:800;margin-top:6px;">📄 {{ $document->title }}</h1>
        </div>
        <a href="{{ route('documents.download', $document) }}" class="btn btn-cyan">⬇️ አውርድ / Download books</a>
    </div>

    <div class="card" style="padding:0;overflow:hidden;">
        <iframe src="{{ route('documents.view', $document) }}"
                style="width:100%;height:82vh;border:none;display:block;background:#fff;"
                title="{{ $document->title }}"></iframe>
    </div>

    <p style="color:var(--muted);font-size:0.8rem;margin-top:12px;text-align:center;">
        PDF ካልታየ <a href="{{ route('documents.download', $document) }}">እዚህ ጠቅ አድርገው ያውርዱት</a> / If the PDF doesn't display, download it instead.
    </p>
</div>
@endsection
