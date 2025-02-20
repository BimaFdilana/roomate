@extends('components.main')
@section('title', 'Account')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <div>
                    <h5 class="fw-bold">Profile</h5>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card border-0 rounded-3 bg-light">
            <div class="card-body p-2 p-md-3 px-lg-4">
                <div></div>
                <div></div>
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-3">
                        <div class="d-flex justify-content-center"><img class="rounded-circle bg-primary" style="height: 250px; width: 250px; object-fit: cover"
                            src="{{ auth()->user()->photos ? Storage::url(auth()->user()->photos) : asset('assets/img/default_profile.jpg') }}"></div>
                        <form action="{{ route('account.updateProfile') }}" method="POST" enctype="multipart/form-data"
                            id="profileForm" class="h-100 d-flex flex-column justify-content-between">
                            @csrf
                            <div class="mt-3">
                                <input name="photos" type="file" class="form-control shadow-none rounded-3" disabled>
                            </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-xl-6 col-xxl-6">
                                <label class="col-form-label w-100">Nama
                                    <input id="field" name="name" class="form-control shadow-none rounded-3" type="text"
                                        value="{{ old('name', $user->name) }}" disabled>
                                </label>
                            </div>
                            <div class="col-xl-6 col-xxl-6">
                                <label class="col-form-label w-100">Telepon
                                    <input id="field" name="phone" class="form-control shadow-none rounded-3" type="text"
                                        value="{{ old('phone', $user->phone) }}" disabled>
                                </label>
                            </div>
                            <div class="col-xl-6 col-xxl-6">
                                <label class="col-form-label w-100">Email
                                    <input id="field" name="email" class="form-control shadow-none rounded-3" type="email"
                                        value="{{ old('email', $user->email) }}" disabled>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-2">
                            <button id="editBtn" class="btn btn-primary rounded-3" type="button">Ubah</button>
                            <button id="saveBtn" class="btn btn-success rounded-3 d-none" type="submit">Simpan</button>
                            <button id="cancelBtn" class="btn btn-danger rounded-3 d-none" type="button">Batal</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <div>
                    <h5 class="fw-bold">Ubah Kata Sandi</h5>
                </div>
            </div>
        </div>
        <div class="card border-0 rounded-3 bg-light">
            <div class="card-body p-2 p-md-3 px-lg-4">
                <div></div>
                <div></div>
                <div class="row">
                    <div class="col-xxl-12">
                        <form action="{{ route('account.updatePassword') }}" method="POST"
                            class="h-100 d-flex flex-column justify-content-between">
                            @csrf
                            <div class="d-md-flex gap-3 w-100">
                                <label class="form-label w-100">Kata sandi sebelumnya
                                    <input name="current_password" class="form-control shadow-none rounded-3"
                                        type="password">
                                </label>
                                <label class="form-label w-100">Kata sandi baru
                                    <input name="new_password" class="form-control shadow-none rounded-3" type="password">
                                </label>
                                <label class="form-label w-100">Konfirmasi katasandi baru
                                    <input name="new_password_confirmation" class="form-control shadow-none rounded-3"
                                        type="password">
                                </label>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-2">
                                <button class="btn btn-primary rounded-3" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <div class="card border-0 rounded-3 bg-light">
                <div class="card-body p-2 p-md-3 px-lg-4">
                    <div></div>
                    <div></div>
                    <div class="row">
                        <div class="col-xxl-12">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <div class="d-flex justify-content-end gap-2"><button class="btn btn-danger rounded-3"type="submit">Keluar</button></div>
                            </form>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editBtn = document.getElementById('editBtn');
            const saveBtn = document.getElementById('saveBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const formFields = document.querySelectorAll('#profileForm input');
            const field = document.querySelectorAll('#field');

            editBtn.addEventListener('click', () => {
                field.forEach(field => field.removeAttribute('disabled'));
                document.querySelector('input[name="photos"]').removeAttribute('disabled');
                editBtn.classList.add('d-none');
                saveBtn.classList.remove('d-none');
                cancelBtn.classList.remove('d-none');
            });

            cancelBtn.addEventListener('click', () => {
                field.forEach(field => field.setAttribute('disabled', true));
                document.querySelector('input[name="photos"]').setAttribute('disabled', true);
                editBtn.classList.remove('d-none');
                saveBtn.classList.add('d-none');
                cancelBtn.classList.add('d-none');
            });
        });
    </script>
@endsection
