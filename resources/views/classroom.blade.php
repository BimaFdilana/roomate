@extends('components.main')
@section('title', 'Classroom')
@section('content')
    <div class="container mt-4">
        <div class="row gx-3 gy-3">
            <div class="col-xxl-6 col-12">
                <div class="card h-100 rounded-3 overflow-hidden border-0 bg-light">
                    <img class="card-img-top w-100 d-block class-banner"
                        src="{{ asset('storage/' . $classroom->banner_class_image) }}" style="object-fit: cover;">
                    <div class="card-body d-flex flex-column justify-content-between p-3">
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $classroom->name }}</h5>
                            <h6 class="small mb-3">{{ $classroom->teacher->name }}</h6>
                            <p>{{ $classroom->description }}</p>
                        </div>
                        <div class="d-flex gap-3"><span
                                class="bg-dark bg-opacity-10 p-1 px-2 rounded-3 d-flex gap-2 align-items-center"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icon-tabler-users-group fs-5">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                    <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                    <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                                </svg><span
                                    class="fs-6 d-flex align-items-center gap-1 small">{{ count($classroom->students) }}</span></span><span
                                class="bg-dark bg-opacity-10 p-1 px-2 rounded-3 d-flex gap-2 align-items-center"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icon-tabler-book fs-5">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0"></path>
                                    <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0"></path>
                                    <path d="M3 6l0 13"></path>
                                    <path d="M12 6l0 13"></path>
                                    <path d="M21 6l0 13"></path>
                                </svg><span
                                    class="fs-6 d-flex align-items-center gap-1 small">{{ $allPosts->where('type', 'material')->count() }}</span></span>
                            <span class="bg-dark bg-opacity-10 p-1 px-2 rounded-3 d-flex gap-2 align-items-center"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icon-tabler-puzzle fs-5">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M4 7h3a1 1 0 0 0 1 -1v-1a2 2 0 0 1 4 0v1a1 1 0 0 0 1 1h3a1 1 0 0 1 1 1v3a1 1 0 0 0 1 1h1a2 2 0 0 1 0 4h-1a1 1 0 0 0 -1 1v3a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-1a2 2 0 0 0 -4 0v1a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1h1a2 2 0 0 0 0 -4h-1a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1">
                                    </path>
                                </svg><span
                                    class="fs-6 d-flex align-items-center gap-1 small">{{ $allPosts->where('type', 'quiz')->count() }}</span></span>
                            <span class="bg-dark bg-opacity-10 p-1 px-2 rounded-3 d-flex gap-2 align-items-center"><span
                                    class="fs-6 d-flex align-items-center gap-1 small">{{ $classroom->class_code }}</span></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-12">
                <div class="card h-100 rounded-3 overflow-hidden border-0 bg-light">
                    <div class="card-header border-0 bg-light">
                        <h6 class="mb-0 fw-bold text-center">Leaderboard</h6>
                    </div>
                    <div class="card-body bg-light d-flex flex-column gap-1 p-2" style="overflow-y: scroll;height: 277px;">
                        @foreach ($students as $index => $student)
                            <div class="card border-0 rounded-3">
                                <div class="card-body d-flex align-items-center justify-content-between py-2">
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($index == 0)
                                            <img class="img-fluid" src="{{ asset('assets/img/rank-1.png') }}" width="42"
                                                height="42">
                                        @elseif($index == 1)
                                            <img class="img-fluid" src="{{ asset('assets/img/rank-2.png') }}" width="42"
                                                height="42">
                                        @elseif($index == 2)
                                            <img class="img-fluid" src="{{ asset('assets/img/rank-3.png') }}"
                                                width="42" height="42">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center"
                                                style="height: 42px;width: 42px;">
                                                <h4 class="mb-0">{{ $index + 1 }}</h4>
                                            </div>
                                        @endif
                                        <p class="mb-0">{{ $student->name }}</p>
                                    </div>
                                    <div>
                                        <span>{{ $student->total_score }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link active" role="tab" data-bs-toggle="tab"
                        href="#tab-1">Postingan</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" role="tab" data-bs-toggle="tab"
                        href="#tab-2">Anggota Kelas</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="tab-1">
                    <div>
                        <div class="row mt-5">
                            <div class="col">
                                <div>
                                    <div class="d-flex align-items-center justify-content-start mb-2 gap-2">
                                        <h4 class="fw-bold mb-0">Postingan</h4>
                                        @if (auth()->user()->role === 'guru')
                                            <button class="btn btn-primary d-flex gap-1 align-items-center" type="button"
                                                data-bs-target="#modal-1" data-bs-toggle="modal"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icon-tabler-circle-plus">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                                    <path d="M9 12h6"></path>
                                                    <path d="M12 9v6"></path>
                                                </svg>Buat
                                            </button>
                                        @endif
                                        <div class="modal fade" role="dialog" tabindex="-1" id="modal-1">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="mb-0">Pilih Postingan</h4><button class="btn-close"
                                                            type="button" aria-label="Close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <a href="{{ route('material_post', ['classroom_id' => $classroom->id]) }}"
                                                            class="btn btn-success w-100 mb-2">
                                                            Buat Materi
                                                        </a>
                                                        <a href="{{ route('quiz.create', ['classroom_id' => $classroom->id]) }}"
                                                            class="btn btn-info w-100">
                                                            Buat Kuis
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 gap-lg-3">
                                        <input class="form-control rounded-3 shadow-none" type="text" id="searchPost"
                                            placeholder="Cari postingan...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gy-1 mt-3" id="postList">
                            @if ($allPosts->isNotEmpty())
                                @foreach ($allPosts as $post)
                                    <div class="col col-12 post-item">
                                        <a class="text-decoration-none"
                                            href="{{ route('post.detail', ['type' => $post->type, 'id' => $post->id]) }}">
                                            <div class="card bg-light rounded-3 post-card border-white">
                                                <div class="card-body p-3 d-flex align-items-center">
                                                    <div class="d-flex align-items-center gap-3 w-100">
                                                        @if ($post->type == 'material')
                                                            <span class="bg-primary p-2 rounded-circle">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                                    height="1em" viewBox="0 0 24 24" stroke-width="2"
                                                                    stroke="currentColor" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icon-tabler-book-2 fs-3 text-light">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                    </path>
                                                                    <path
                                                                        d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z">
                                                                    </path>
                                                                    <path d="M19 16h-12a2 2 0 0 0 -2 2"></path>
                                                                    <path d="M9 8h6"></path>
                                                                </svg>
                                                                <i class="bi bi-book"></i>
                                                            </span>
                                                        @elseif ($post->type == 'quiz')
                                                            <span class="bg-primary p-2 rounded-circle">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                                    height="1em" viewBox="0 0 24 24" stroke-width="2"
                                                                    stroke="currentColor" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icon-tabler-puzzle fs-3 text-light">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                    </path>
                                                                    <path
                                                                        d="M4 7h3a1 1 0 0 0 1 -1v-1a2 2 0 0 1 4 0v1a1 1 0 0 0 1 1h3a1 1 0 0 1 1 1v3a1 1 0 0 0 1 1h1a2 2 0 0 1 0 4h-1a1 1 0 0 0 -1 1v3a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-1a2 2 0 0 0 -4 0v1a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1h1a2 2 0 0 0 0 -4h-1a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1">
                                                                    </path>
                                                                </svg>
                                                                <i class="bi bi-pencil"></i>
                                                            </span>
                                                        @endif
                                                        <div>
                                                            @if ($post->type == 'material')
                                                                <h6 class="mb-0 fw-semibold">Materi: {{ $post->title }}
                                                                </h6>
                                                            @elseif ($post->type == 'quiz')
                                                                <h6 class="mb-0 fw-semibold">Kuis: {{ $post->title }}
                                                                </h6>
                                                            @endif
                                                            <span
                                                                class="small fw-light">{{ \Carbon\Carbon::parse($post->created_at)->format('d M Y') }}</span>
                                                        </div>
                                                    </div>
                                                    <div><i class="icon ion-chevron-right px-3 px-md-4 px-lg-5"></i></div>
                                                </div>
                                            </div>

                                            {{-- button edit delete --}}
                                            @if (auth()->check() && auth()->user()->role === 'guru')
                                                @if ($post->type == 'material')
                                                    <div class="d-flex gap-2 mt-2 mb-4">
                                                        <a href="{{ route('material.edit', ['classroom_id' => $classroom->id, 'id' => $post->id]) }}"
                                                            class="btn btn-primary d-flex gap-1 align-items-center me-2">
                                                            Edit
                                                        </a>
                                                        <a href="#"
                                                            class="btn btn-danger d-flex gap-1 align-items-center delete-button"
                                                            data-url="{{ route('material.destroy', ['classroom_id' => $classroom->id, 'id' => $post->id]) }}">
                                                            Hapus
                                                        </a>
                                                    </div>
                                                @elseif ($post->type == 'quiz')
                                                    <div class="d-flex gap-2 mt-2 mb-4">
                                                        <a href="{{ route('quizzes.edit', ['classroom_id' => $classroom->id, 'id' => $post->id]) }}"
                                                            class="btn btn-primary d-flex gap-1 align-items-center me-2">
                                                            Edit
                                                        </a>
                                                        <a href="#"
                                                            class="btn btn-danger d-flex gap-1 align-items-center delete-button"
                                                            data-url="{{ route('quizzes.destroy', ['classroom_id' => $classroom->id, 'id' => $post->id]) }}">
                                                            Hapus
                                                        </a>
                                                    </div>
                                                @endif
                                            @endif
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <p>Belum ada postingan</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="tab-pane" role="tabpanel" id="tab-2">
                    <div>
                        <div class="row mt-5">
                            <div class="col">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h4 class="fw-bold mb-0">Anggota Kelas</h4>
                                    </div>
                                    <div class="d-flex gap-2 gap-lg-3">
                                        <input class="form-control rounded-3 shadow-none" type="text"
                                            id="searchStudent" placeholder="Cari anggota...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($students->isNotEmpty())
                            <div class="row gy-1 mt-3" id="studentList">
                                @foreach ($students as $student)
                                    <div class="col col-12 student-item">
                                        <div class="card bg-light rounded-3 border-white">
                                            <div class="card-body p-3 d-flex align-items-center">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img class="rounded-circle bg-primary"
                                                        src="{{ $student->profile_photo ? Storage::url($student->profile_photo) : asset('assets/img/default_profile.jpg') }}"
                                                        width="42" height="42" style="object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold class-title">{{ $student->name }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="mt-3">Belum ada anggota</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS code to filter posts and students -->
    <script>
        document.getElementById('searchPost').addEventListener('input', function() {
            let searchTerm = this.value.toLowerCase();
            let posts = document.querySelectorAll('.post-item');
            posts.forEach(function(post) {
                let title = post.querySelector('.card-body h6').textContent.toLowerCase();
                if (title.includes(searchTerm)) {
                    post.style.display = 'block';
                } else {
                    post.style.display = 'none';
                }
            });
        });

        document.getElementById('searchStudent').addEventListener('input', function() {
            let searchTerm = this.value.toLowerCase();
            let students = document.querySelectorAll('.student-item');
            students.forEach(function(student) {
                let name = student.querySelector('.card-body h6').textContent.toLowerCase();
                if (name.includes(searchTerm)) {
                    student.style.display = 'block';
                } else {
                    student.style.display = 'none';
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah navigasi langsung

                    const deleteUrl = this.getAttribute('data-url');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: 'Materi akan dihapus secara permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = deleteUrl;
                            form.innerHTML = `
                            @csrf
                            @method('DELETE')
                        `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

@endsection
