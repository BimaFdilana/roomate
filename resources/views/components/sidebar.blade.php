<div id="sidebar" class="shadow-lg">
    <div class="d-flex flex-column justify-content-between w min-vh-100">
        <div>
            <div class="p-3 py-4 sidebar-header sticky-top bg-body">
                <h2 class="fw-semibold text-primary d-flex mb-0" style="font-family: 'Berkshire Swash', serif;">Roomate
                </h2><span class="d-lg-none close-btn"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                        viewBox="0 0 24 24" fill="none">
                        <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg></span>
            </div>
            <ul class="nav flex-column gap-2">
                <li class="nav-item"><a class="btn btn-outline-light w-100 text-start d-flex align-items-stretch gap-2"
                        role="button" href="{{ route('home') }}"><svg xmlns="http://www.w3.org/2000/svg" width="1em"
                            height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icon-tabler-home fs-5">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                        </svg>Beranda</a></li>
                <li class="nav-item"><a class="btn btn-outline-light w-100 text-start d-flex align-items-stretch gap-2"
                        role="button" href="{{ route('account') }}"><svg xmlns="http://www.w3.org/2000/svg" width="1em"
                            height="1em" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icon-tabler-settings fs-5">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path
                                d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z">
                            </path>
                            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                        </svg>Pengaturan</a></li>
                @if (auth()->user()->role === 'guru')
                    <li class="nav-item"><button
                            class="btn btn-primary w-100 text-start d-flex align-items-stretch gap-2" type="button"
                            data-bs-target="#modal-create-class" data-bs-toggle="modal"><svg
                                xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icon-tabler-school fs-5">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                                <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                            </svg>Buat Kelas</button></li>
                @endif
                @if (auth()->user()->role === 'murid')
                    <li class="nav-item"><button
                            class="btn btn-primary w-100 text-start d-flex align-items-stretch gap-2" type="button"
                            data-bs-target="#modal-join-class" data-bs-toggle="modal"><svg
                                xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icon-tabler-school fs-5">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                                <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                            </svg>Kode Kelas</button></li>
                @endif
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item mt-3 fw-bold"><span>Kelas Anda</span></li>
                @if (auth()->user()->role === 'guru')
                    @foreach (auth()->user()->classroomsAsTeacher as $classroom)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('classroom.show', $classroom->id) }}">
                                <img class="border-0 rounded-circle"
                                    src="{{ asset('storage/' . $classroom->class_image) }}" width="42"
                                    height="42">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">{{ $classroom->name }}</span>
                                    <span class="small">{{ $classroom->teacher->name }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @endif

                @if (auth()->user()->role === 'murid')
                    @foreach (auth()->user()->classroomsAsStudent as $classroom)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('classroom.show', $classroom->id) }}">
                                <img class="border-0 rounded-circle"
                                    src="{{ asset('storage/' . $classroom->class_image) }}" width="42"
                                    height="42">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">{{ $classroom->name }}</span>
                                    <span class="small">{{ $classroom->teacher->name }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
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
            <div class="modal-body">
                <form action="{{ route('join-class') }}" method="POST">
                    @csrf
                    <label class="w-100">Masukkan Kode Kelas<br>
                        <input type="text" class="form-control shadow-none rounded-3" id="class_code"
                            name="class_code" placeholder="Enter class code">
                    </label>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary" type="submit">Gabung</button>
            </div>
            </form>
        </div>
    </div>
</div>
