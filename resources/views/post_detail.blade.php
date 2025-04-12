@extends('components.main')
@section('title', 'Detail Postingan')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/detail.css') }}">
@endpush

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col">

                @if (isset($quiz) && auth()->user()->role === 'murid')
                    <div class="mb-3 text-end">
                        <span class="score-box">
                            🏆 Skor kamu: {{ $quizResult->score ?? 0 }}/100
                        </span>
                    </div>
                @endif

                <div class="card custom-card mb-4">
                    <div class="card-body">
                        @if (isset($material))
                            <h4 class="fw-bold title-highlight">📘 Materi: {{ $material->title }}</h4>
                            <p class="mt-2">{{ $material->description }}</p>

                            @if ($filePath)
                                <div class="mt-3">
                                    <a href="{{ Storage::url($filePath) }}" class="attachment-box" download>
                                        📎 Unduh Materi: {{ $material->title }}
                                    </a>
                                </div>
                            @else
                                <p class="text-muted">Tidak ada lampiran tersedia.</p>
                            @endif
                        @elseif (isset($quiz))
                            <h4 class="fw-bold title-highlight">📝 Kuis: {{ $quiz->title }}</h4>
                            <p class="mt-2">{{ $quiz->description }}</p>

                            <div class="my-2 bg-glow">
                                ⏰ Waktu: {{ floor($quiz->time_limit / 60) }} menit
                            </div>

                            <p class="mb-2 mt-2">
                                🎯 <strong>Level:</strong>
                                <span class="fw-semibold {{ $levelClass }}">{{ ucfirst($quiz->level) }}</span>
                            </p>

                            <p class="mb-2">
                                🕐 <strong>Estimasi per soal:</strong>
                                <span class="fw-semibold text-info">{{ $formattedEstimatedTime }}</span>
                            </p>

                            <div class="bg-glow mb-3">
                                📚 Jumlah Soal: {{ $quiz->questions->count() }}
                            </div>

                            @if (auth()->user()->role === 'murid')
                                <div class="text-end">
                                    @if ($hasTakenQuiz)
                                        <button class="btn btn-secondary rounded-3" disabled>✅ Sudah Dikerjakan</button>
                                    @else
                                        <a class="btn btn-primary rounded-3" href="{{ route('quiz.start', $quiz->id) }}">🚀
                                            Mulai Kuis</a>
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                @if (@isset($quiz))
                    @if (auth()->user()->role === 'guru')
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5 class="fw-bold">📊 Hasil Kuis</h5>
                            </div>
                        </div>

                        <div class="row gy-2">
                            @foreach ($allResults as $index => $result)
                                <div class="col-12">
                                    <div class="card student-result p-3 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-3">
                                            <img class="rounded-circle"
                                                src="{{ $result->student->profile_photo ? Storage::url($result->student->profile_photo) : asset('assets/img/default_profile.jpg') }}"
                                                width="42" height="42" style="object-fit: cover;">
                                            <strong>{{ $result->student->name }}</strong>
                                        </div>
                                        <span class="fw-semibold">{{ $result->score }} / 100</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif

            </div>
        </div>
    </div>
@endsection
