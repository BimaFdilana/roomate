<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Roomate</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Berkshire+Swash&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand&amp;display=swap">
    <link rel="stylesheet" href="assets/css/styles.min.css">
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
                        <h1 class="fw-semibold">Login</h1>
                    </div>
                    <h6 class="h5 mb-0">Selamat datang!</h6>
                    <p class="text-muted mt-2 mb-5">Mohon login sebelum melanjutkan</p>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login.process') }}">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="phone" class="mb-1">Telepon</label>
                            <input class="form-control form-control rounded-3" type="text" id="phone" name="phone" value="{{ old('phone') }}">
                        </div>
                        <div class="form-group mb-2">
                            <label for="password" class="mb-1">Kata Sandi</label>
                            <input class="form-control form-control rounded-3" type="password" id="password" name="password">
                        </div>
                        <button class="btn btn-primary w-100 rounded-3" type="submit">Login</button>
                        <div class="py-3 d-flex align-items-center">
                            <hr class="w-100">
                            <span class="text-nowrap px-3">
                                Belum punya akun?&nbsp;
                                <a class="text-decoration-none" href="{{ route('register.form') }}">Daftar</a>
                            </span>
                            <hr class="w-100">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/script.min.js"></script>
</body>

</html>
