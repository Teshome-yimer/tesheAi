@extends('layouts.app')

@section('title', 'ውጤት / Result — ' . $attempt->quiz->title)

@section('content')
<div class="container" style="padding:32px 24px 60px;max-width:840px;">
    <a href="{{ route('quizzes.index') }}" style="font-size:0.85rem;color:var(--muted);">← ሁሉም ፈተናዎች / All Quizzes</a>

    {{-- Score summary --}}
    <div class="card" style="padding:36px;text-align:center;margin:16px 0 28px;">
        <div style="font-size:3rem;margin-bottom:8px;">{{ $attempt->percentage >= 50 ? '🎉' : '📖' }}</div>
        <h1 style="font-size:1.4rem;font-weight:800;margin-bottom:8px;">{{ $attempt->quiz->title }}</h1>
        <div style="font-size:2.4rem;font-weight:800;background:linear-gradient(135deg,var(--indigo),var(--cyan));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
            {{ $attempt->score }} / {{ $attempt->total }}
        </div>
        <div class="badge {{ $attempt->percentage >= 50 ? 'badge-success' : 'badge-danger' }}" style="font-size:0.95rem;padding:6px 18px;margin-top:10px;">
            {{ $attempt->percentage }}% — {{ $attempt->percentage >= 50 ? 'ጥሩ ስራ! / Passed' : 'እንደገና ይሞክሩ / Try again' }}
        </div>
        <div style="margin-top:20px;">
            <a href="{{ route('quizzes.take', $attempt->quiz) }}" class="btn btn-primary btn-sm">🔄 እንደገና ተፈተን / Retake Quiz</a>
        </div>
    </div>

    {{-- Answer review --}}
    <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:16px;">📋 የመልስ ማብራሪያ / Answer Review</h2>
    @foreach($attempt->quiz->questions as $i => $q)
        @php
            $given = $attempt->answers[$q->id] ?? null;
            $isCorrect = $given === $q->correct_option;
        @endphp
        <div class="card" style="padding:20px;margin-bottom:14px;border-color:{{ $isCorrect ? 'var(--success)' : 'var(--danger)' }};">
            <div style="display:flex;justify-content:space-between;gap:10px;margin-bottom:12px;">
                <div style="font-weight:700;">{{ $i + 1 }}. {{ $q->question }}</div>
                <span class="badge {{ $isCorrect ? 'badge-success' : 'badge-danger' }}" style="flex-shrink:0;">
                    {{ $isCorrect ? '✓ ትክክል' : '✗ ስህተት' }}
                </span>
            </div>
            <div style="display:flex;flex-direction:column;gap:6px;font-size:0.88rem;">
                @foreach($q->options as $key => $text)
                    @php
                        $style = 'border:1px solid var(--border);color:var(--muted);';
                        if ($key === $q->correct_option) {
                            $style = 'border:1px solid var(--success);color:var(--success);font-weight:600;';
                        } elseif ($key === $given && !$isCorrect) {
                            $style = 'border:1px solid var(--danger);color:var(--danger);';
                        }
                    @endphp
                    <div style="padding:8px 14px;border-radius:8px;{{ $style }}">
                        {{ strtoupper($key) }}. {{ $text }}
                        @if($key === $q->correct_option) ✓ ትክክለኛ መልስ @endif
                        @if($key === $given && !$isCorrect) ← የእርስዎ መልስ @endif
                        @if($key === $given && $isCorrect) ← የእርስዎ መልስ @endif
                    </div>
                @endforeach
                @if($given === null)
                    <div style="color:var(--danger);font-size:0.8rem;">⚠️ አልመለሱም / Not answered</div>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
