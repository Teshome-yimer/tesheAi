@extends('layouts.app')

@section('title', $quiz->title)

@section('content')
<div class="container" style="padding:32px 24px 60px;max-width:840px;">
    <a href="{{ route('quizzes.index') }}" style="font-size:0.85rem;color:var(--muted);">← ሁሉም ፈተናዎች / All Quizzes</a>

    <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;margin:12px 0 8px;">
        <h1 style="font-size:1.5rem;font-weight:800;">📝 {{ $quiz->title }}</h1>
        @if($quiz->time_limit_minutes)
            <div id="quiz-timer" class="badge badge-indigo" style="font-size:1rem;padding:8px 16px;">
                ⏱ <span id="timer-value">{{ $quiz->time_limit_minutes }}:00</span>
            </div>
        @endif
    </div>

    @if($quiz->description)
        <p style="color:var(--muted);font-size:0.9rem;margin-bottom:8px;">{{ $quiz->description }}</p>
    @endif
    <p style="color:var(--muted);font-size:0.82rem;margin-bottom:24px;">
        ❓ {{ $quiz->questions->count() }} ጥያቄዎች — ትክክለኛውን መልስ ይምረጡ (A–D)። ሲጨርሱ "Submit" ይጫኑ።
    </p>

    <form id="quiz-form" method="POST" action="{{ route('quizzes.submit', $quiz) }}">
        @csrf
        @foreach($quiz->questions as $i => $q)
            <div class="card" style="padding:22px;margin-bottom:16px;" data-quiz-question data-check-url="{{ route('quizzes.question.check', [$quiz, $q]) }}">
                <div style="font-weight:700;margin-bottom:14px;">{{ $i + 1 }}. {{ $q->question }}</div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach($q->options as $key => $text)
                        <label data-option="{{ $key }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;border:1px solid var(--border);border-radius:8px;cursor:pointer;font-size:0.9rem;transition:border-color .15s, background-color .15s;"
                               onmouseover="this.style.borderColor='var(--indigo)'" onmouseout="if(!this.querySelector('input').checked)this.style.borderColor='var(--border)'">
                            <input type="radio" name="answers[{{ $q->id }}]" value="{{ $key }}" style="accent-color:var(--indigo);">
                            <strong style="color:var(--cyan);">{{ strtoupper($key) }}.</strong> {{ $text }}
                        </label>
                    @endforeach
                </div>
                <div data-feedback style="margin-top:10px;font-size:0.85rem;color:var(--muted);min-height:1.2em;"></div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-cyan" style="width:100%;justify-content:center;padding:14px;font-size:1rem;"
                onclick="return confirm('Submit your answers?');">
            ✅ Submit Answers
        </button>
    </form>
</div>
@endsection

@push('scripts')
@if($quiz->time_limit_minutes)
<script>
    (function () {
        let remaining = {{ $quiz->time_limit_minutes }} * 60;
        const el = document.getElementById('timer-value');
        const timer = setInterval(function () {
            remaining--;
            const m = Math.floor(remaining / 60);
            const s = remaining % 60;
            el.textContent = m + ':' + (s < 10 ? '0' : '') + s;
            if (remaining <= 60) {
                document.getElementById('quiz-timer').classList.remove('badge-indigo');
                document.getElementById('quiz-timer').classList.add('badge-danger');
            }
            if (remaining <= 0) {
                clearInterval(timer);
                document.getElementById('quiz-form').submit();
            }
        }, 1000);
    })();
</script>
@endif
<script>
    (function () {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        document.querySelectorAll('[data-quiz-question]').forEach(function (card) {
            const checkUrl = card.getAttribute('data-check-url');
            const feedback = card.querySelector('[data-feedback]');
            card.querySelectorAll('input[type="radio"]').forEach(function (input) {
                input.addEventListener('change', function () {
                    const selectedLabel = input.closest('label');
                    card.querySelectorAll('label[data-option]').forEach(function (l) {
                        l.style.borderColor = 'var(--border)';
                        l.style.backgroundColor = 'transparent';
                    });
                    if (feedback) {
                        feedback.textContent = '...';
                        feedback.style.color = 'var(--muted)';
                    }
                    fetch(checkUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({ option: input.value })
                    }).then(function (r) {
                        return r.json();
                    }).then(function (data) {
                        if (!selectedLabel) return;
                        if (data && data.correct) {
                            selectedLabel.style.borderColor = 'var(--success)';
                            selectedLabel.style.backgroundColor = 'rgba(16,185,129,.12)';
                            if (feedback) {
                                feedback.textContent = 'Correct';
                                feedback.style.color = 'var(--success)';
                            }
                        } else {
                            selectedLabel.style.borderColor = 'var(--danger)';
                            selectedLabel.style.backgroundColor = 'rgba(239,68,68,.12)';
                            if (feedback) {
                                feedback.textContent = 'Incorrect';
                                feedback.style.color = 'var(--danger)';
                            }
                        }
                    }).catch(function () {
                        if (feedback) {
                            feedback.textContent = 'Please try again';
                            feedback.style.color = 'var(--muted)';
                        }
                    });
                });
            });
        });
    })();
</script>
@endpush
