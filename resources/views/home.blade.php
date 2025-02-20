@extends('components.main')
@section('title', 'Home')
@section('content')
    <div class="container mt-4">
        <div class="row mb-2">
            <div class="col">
                <div>
                    <h3>Hai,<span class="ms-2">{{ auth()->user()->name }}</span></h3>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <h6 class="mb-0 fw-semibold">Ringkasan</h6>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card rounded-3 border-0 bg-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="card border-0 rounded-3 h-100">
                                    <div class="card-body p-5">
                                        <div class="gap-2 d-flex flex-column h-100">
                                            <div class="d-flex flex-column justify-content-between h-100 w-100">
                                                <p class="mb-2 mb-md-0 mb-0 text-center">Poin Kamu:</p>
                                                <p class="fs-1 mb-0 text-center fw-bold">{{ $totalPoints ?? 0 }}</p>
                                                <div class="d-flex justify-content-between w-100 align-items-end">
                                                    <h6 class="mb-0 mb-2 mb-md-0">Jumlah Kelas: {{ $totalClasses ?? 0 }}</h6>
                                                    <h6 class="mb-0 mb-2 mb-md-0">Total Materi: {{ $totalMaterials ?? 0 }}</h6>
                                                    <h6 class="mb-0 mb-2 mb-md-0">Total Kuis: {{ $totalQuizzes ?? 0 }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="gap-2 d-flex flex-column h-100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 rounded-3 h-100">
                                    <div class="card-body">
                                        <div class="performance-chart">
                                            <h3>Analitik Performa</h3>
                                            <canvas id="performanceChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2 mt-3">
            <div class="col">
                <h6 class="mb-0 fw-semibold">Postingan Terbaru</h6>
            </div>
        </div>
        <div class="row gy-1">
            @if (isset($activities) && $activities->isNotEmpty())
                @foreach ($activities as $activity)
                    <div class="col col-12">
                        <a class="text-decoration-none" href="{{ route('classroom.show', $activity['classroom']->id) }}">
                            <div class="card bg-light rounded-3 post-card border-white">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="d-flex align-items-center gap-3 w-100">
                                        <img class="border rounded-circle"
                                            src="{{ asset('storage/' . $activity['classroom']->class_image) }}"
                                            width="42" height="42">
                                        <div>
                                            <h6 class="mb-0 fw-semibold class-title">{{ $activity['classroom']->name }}</h6>
                                            <p class="mb-1 class-desc">{{ $activity['type'] }}: {{ $activity['title'] }}</p>
                                            <span class="small fw-light">{{ $activity['time']->format('H:i') }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icon-tabler-chevron-right mx-3 mx-md-4">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9 6l6 6l-6 6"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <div>
                    <p class="text-muted">{{ $noActivityMessage }}</p>
                </div>
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const performanceData = @json($performanceData->values());

        const labels = performanceData.map(data => data.class);
        const data = performanceData.map(data => data.average_score);

        const ctx = document.getElementById('performanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Skor Rata-rata',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
