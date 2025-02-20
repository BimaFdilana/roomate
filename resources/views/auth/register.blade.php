<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Roomate | Login</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Berkshire+Swash&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.5/dist/sweetalert2.min.css">
</head>

<body>
    <div class="container-fluid d-flex align-items-center vh-100">
        <div class="row gy-4 gy-md-0 d-md-flex justify-content-md-center min-vh-100">
            <div class="col-md-6 col-lg-7 d-flex align-items-center justify-content-center">
                <div class="p-xl-5 m-xl-5"><img class="rounded img-fluid w-100 fit-cover" style="min-height: 300px;"
                        src="assets/img/register.png"></div>
            </div>
            <div class="col-lg-5 d-flex align-items-center justify-content-center bg-light">
                <div class="px-2 px-lg-5 p-5 w-100">
                    <div class="mb-5">
                        <h1 class="fw-semibold">Register</h1>
                    </div>
                    <h6 class="h5 mb-0">Selamat datang di Roomate!</h6>
                    <p class="text-muted mt-2 mb-5">Mohon lakukan pendaftaran sebelum lanjut.</p>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="role" class="mb-1">Pilih Peran</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="guru"
                                        value="guru" checked>
                                    <label class="form-check-label" for="guru">Guru</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="role" id="murid"
                                        value="murid">
                                    <label class="form-check-label" for="murid">Murid</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="name" class="mb-1">Nama Lengkap</label>
                            <input class="form-control form-control rounded-3" type="text" id="name"
                                name="name" value="{{ old('name') }}">
                        </div>
                        <div class="form-group mb-2">
                            <label for="phone" class="mb-1">No. Telepon</label>
                            <input class="form-control form-control rounded-3" type="text" id="phone"
                                name="phone" value="{{ old('phone') }}">
                        </div>
                        <div class="form-group mb-2">
                            <label for="password" class="mb-1">Kata Sandi</label>
                            <input class="form-control form-control rounded-3" type="password" id="password"
                                name="password">
                        </div>
                        <div class="form-group mb-2">
                            <label for="password_confirmation" class="mb-1">Konfirmasi Kata Sandi</label>
                            <input class="form-control form-control rounded-3" type="password"
                                id="password_confirmation" name="password_confirmation">
                        </div>
                        <button class="btn btn-primary w-100 rounded-3" type="submit">Register</button>
                        <div class="py-3 d-flex align-items-center">
                            <hr class="w-100">
                            <span class="text-nowrap px-3">
                                Sudah punya akun?&nbsp;<a class="text-decoration-none" href="{{ route('login') }}">Login</a>
                            </span>
                            <hr class="w-100">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/script.min.js') }}"></script>
</body>

</html>
