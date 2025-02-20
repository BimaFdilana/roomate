@extends('components.main')
@section('title', 'Dashboard')
@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row mb-2">
            <div class="col">
                <div>
                    <h3>Selamat Datang, {{ Auth::user()->name }}</h3>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <h6 class="mb-0 fw-semibold">Ringkasan</h6>
            </div>
        </div>
        <div class="row gx-3 gy-3">
            <div class="col-sm-12 col-md-6 col-xl-3">
                <div class="card bg-primary bg-opacity-10 bg-gradient border-0 rounded-3 h-100">
                    <div class="card-body">
                        <h5>Total Kelas</h5>
                        <p class="fs-5 fw-bold mb-0">{{ Auth::user()->classroomsAsTeacher->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-xl-3">
                <div class="card bg-success bg-opacity-10 bg-gradient border-0 rounded-3 h-100">
                    <div class="card-body">
                        <h5>Total Siswa</h5>
                        <p class="fs-5 fw-bold mb-0">{{ Auth::user()->classroomsAsTeacher->flatMap->students->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-xl-3">
                <div class="card bg-danger bg-opacity-10 border-0 rounded-3 h-100">
                    <div class="card-body">
                        <h5>Total Materi</h5>
                        <p class="fs-5 fw-bold mb-0">{{ Auth::user()->classroomsAsTeacher->flatMap->materials->count() }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-xl-3">
                <div class="card bg-warning bg-opacity-10 bg-gradient border-0 rounded-3 h-100">
                    <div class="card-body">
                        <h5>Total Kuis</h5>
                        <p class="fs-5 fw-bold mb-0">{{ Auth::user()->classroomsAsTeacher->flatMap->quizzes->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2 mt-4">
            <div class="col">
                <h6 class="mb-0 fw-semibold">Latest Activity</h6>
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
                                            <p class="mb-1 class-desc">{{ $activity['type'] }}: {{ $activity['title'] }}
                                            </p>
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
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="modal-create-class">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Buat Kelas</h4><button class="btn-close" type="button" aria-label="Close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('classroom.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex flex-column gap-2">
                            <label>Banner Kelas
                                <input type="file" class="form-control" id="banner_class_image"
                                    name="banner_class_image">
                            </label>
                            <label>Logo Kelas
                                <input type="file" class="form-control" id="class_image" name="class_image">
                            </label>
                            <label>Nama Kelas
                                <input type="text" class="form-control shadow-none rounded-3" name="name" required>
                            </label>
                            <label>Deskripsi
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Deskripsi kelas" name="description" style="height: 100px;" required></textarea>
                                </div>
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="modal-join-class">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Gabung ke kelas</h4><button class="btn-close" type="button"
                        aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body"><label class="w-100">Masukkan Kode Kelas<br><input type="text"
                            class="form-control shadow-none rounded-3" aria-label="default input example"></label></div>
                <div class="modal-footer"><button class="btn btn-light" type="button"
                        data-bs-dismiss="modal">Batal</button><button class="btn btn-primary"
                        type="button">Gabung</button></div>
            </div>
        </div>
    </div>
@endsection
