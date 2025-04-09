@extends('components.main')
@section('title', 'Detail Postingan')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                @if (isset($quiz) && auth()->user()->role === 'murid')
                    <div class="card mb-2 border-0 rounded-3 bg-light">
                        <div class="card-body">
                            <div class="d-flex justify-content-end">
                                <span class="bg-dark bg-opacity-10 p-1 px-2 rounded-3 d-flex gap-2 align-items-center">
                                    <span class="fs-6 d-flex align-items-center gap-1 fw-bold">Skor kamu:</span>
                                    <span
                                        class="fs-6 d-flex align-items-center gap-1">{{ $quizResult->score ?? 0 }}/100</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card border-0 rounded-3 bg-light">
                    <div class="card-body">
                        @if (isset($material))
                            <div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="fw-bold">Materi: {{ $material->title }}</h4>
                                    <span class="small">{{ $material->created_at->format('d M Y') }}</span>
                                </div>
                                <p class="mb-2">{{ $material->description }}</p>
                            </div>
                            <div class="bg-dark bg-opacity-10 d-flex rounded-3 mb-3">
                                @if ($filePath)
                                    <a class="text-decoration-none link-dark" href="{{ Storage::url($filePath) }}" download>
                                    @else
                                        <p>No attachment available.</p>
                                @endif
                                <span class="p-3 rounded-3 d-flex gap-2 align-items-center">
                                    <span class="fs-6">{{ $material->title }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icon-tabler-download">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                        <path d="M7 11l5 5l5 -5"></path>
                                        <path d="M12 4l0 12"></path>
                                    </svg>
                                </span>
                                </a>
                            </div>
                        @elseif (isset($quiz))
                            <div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="fw-bold">Kuis: {{ $quiz->title }}</h4>
                                    <span class="small">{{ $quiz->created_at->format('d M Y') }}</span>
                                </div>
                                <p class="mb-2">{{ $quiz->description }}</p>
                                <p class="mb-2 fw-bold text-primary">
                                    {{ floor($quiz->time_limit / 60) }} menit
                                </p>
                            </div>
                            <p class="mb-2">
                                <span class="text-dark">Level:</span>
                                <span class="fw-semibold {{ $levelClass }}">{{ ucfirst($quiz->level) }}</span>
                            </p>
                            <p class="mb-2">
                                <span class="text-dark">Estimasi per soal:</span>
                                <span class="fw-semibold text-info">{{ $formattedEstimatedTime }}</span>
                            </p>
                            <div class="d-flex mb-3">
                                <span class="bg-dark bg-opacity-10 p-1 px-2 rounded-3 d-flex gap-2 align-items-center">
                                    <span class="fs-6 d-flex align-items-center gap-1 fw-bold">Soal:</span>
                                    <span
                                        class="fs-6 d-flex align-items-center gap-1">{{ $quiz->questions->count() }}</span>
                                </span>
                            </div>
                            @if (auth()->user()->role === 'murid')
                                <div class="text-end">
                                    @if ($hasTakenQuiz)
                                        <button class="btn btn-secondary rounded-3 w" disabled>Sudah Dikerjakan</button>
                                    @else
                                        <a class="btn btn-primary rounded-3 w" role="button"
                                            href="{{ route('quiz.start', $quiz->id) }}">Mulai Kuis</a>
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                @if (@isset($quiz))
                    @if (auth()->user()->role === 'guru')
                        <div class="row mt-3">
                            <div class="col col-12">
                                <h6 class="fw-bold">Hasil Kuis</h6>
                            </div>
                        </div>
                        <div class="row gy-1">
                            @foreach ($allResults as $index => $result)
                                <div class="col col-12">
                                    <div class="card bg-light rounded-3 border-white">
                                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-3">
                                                <img class="rounded-circle bg-primary"
                                                    src="{{ $result->student->profile_photo ? Storage::$result->student->profile_photo : asset('assets/img/default_profile.jpg') }}"
                                                    width="42" height="42" style="object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-0 fw-semibold class-title">{{ $result->student->name }}
                                                    </h6>
                                                </div>
                                            </div>
                                            <p class="mb-0">{{ $result->score }} / 100</p>
                                        </div>
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
