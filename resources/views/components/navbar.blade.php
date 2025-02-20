<nav class="navbar bg-body navbar-light sticky-top px-3 flex-wrap">
    <div class="container-fluid"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"
            fill="none" id="sidebarToggle" class="fs-3">
            <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round"></path>
        </svg>
        <div class="d-flex gap-2">
            <div class="d-flex align-items-center">
                <p class="fw-bold mb-0 text-end">{{ auth()->user()->name }}</p>
            </div><img class="rounded-circle bg-primary" src="{{ auth()->user()->photos ? Storage::url(auth()->user()->photos) : asset('assets/img/default_profile.jpg') }}"  width="42"
                height="42" style="object-fit: cover;">
        </div>
    </div>
</nav>
