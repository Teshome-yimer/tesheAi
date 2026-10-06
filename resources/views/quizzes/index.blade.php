@extends('layouts.app')

@section('title', ' Quizzes')

@section('content')
<div class="container" style="padding:40px 24px 60px;">
    <div style="text-align:center;margin-bottom:40px;">
        <span class="badge badge-indigo" style="margin-bottom:12px;">📝 QUIZZES / ፈተና</span>
        <h1 style="font-size:2rem;font-weight:800;margin:10px 0 8px;">Online  Quizzes</h1>
        <p style="color:var(--muted);max-width:560px;margin:0 auto;">
            እውቀትዎን ይፈትሹ — ጥያቄዎች ከ A እስከ D ምርጫ አላቸው። ውጤትዎን ወዲያውኑ ያያሉ።<br>
            Test your knowledge — multiple choice (A–D), instant results.
        </p>
    </div>

    @if($quizzes->isEmpty())
        <div class="card" style="padding:48px;text-align:center;color:var(--muted);">
             No quizzes yet. Check back soon!
        </div>
    @else
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px;">
            @foreach($quizzes as $quiz)
                @php $last = $lastAttempts->get($quiz->id); @endphp
                <div class="card" style="padding:24px;display:flex;flex-direction:column;gap:12px;">
                    <div style="font-size:2rem;">📝</div>
                    <h3 style="font-size:1.05rem;font-weight:700;">{{ $quiz->title }}</h3>
                    @if($quiz->description)
                        <p style="color:var(--muted);font-size:0.85rem;flex:1;">{{ Str::limit($quiz->description, 110) }}</p>
                    @endif
                    <div style="display:flex;gap:12px;color:var(--muted);font-size:0.78rem;flex-wrap:wrap;">
                        <span>❓ {{ $quiz->questions_count }} ጥያቄዎች</span>
                        @if($quiz->time_limit_minutes)
                            <span>⏱ {{ $quiz->time_limit_minutes }} min</span>
                        @endif
                    </div>
                    @if($last)
                        <div class="badge {{ $last->percentage >= 50 ? 'badge-success' : 'badge-danger' }}" style="align-self:flex-start;">
                            የመጨረሻ ውጤት: {{ $last->score }}/{{ $last->total }} ({{ $last->percentage }}%)
                        </div>
                    @endif
                    <a href="{{ route('quizzes.take', $quiz) }}" class="btn btn-primary btn-sm" style="justify-content:center;margin-top:auto;">
                        {{ $last ? '🔄  Retake' : '▶️ Start Quiz' }}
                    </a>
                </div>
            @endforeach
        </div>

        <div style="margin-top:32px;">
            {{ $quizzes->links() }}
        </div>
    @endif
</div>
@endsection
