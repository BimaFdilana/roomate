@extends('components.main')
@section('title', 'Dashboard')
@section('content')
    <div class="container mt-4">
        <div class="row gx-3 gy-3">
            <div class="col col-12">
                <div class="card h-100 rounded-3 overflow-hidden border-0 bg-light">
                    <div class="card-body bg-light d-flex flex-column gap-1 p-2">
                        <h4 class="fw-bold">Materi</h4>
                        <div>
                            <form action="{{ route('material.store', $classroom->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="d-md-flex gap-3">
                                    <div class="form-group mb-2 w-100">
                                        <label for="title">Judul Materi</label>
                                        <input class="form-control" type="text" name="title" id="title" required>
                                    </div>
                                    <div class="form-group mb-2 w-100">
                                        <label for="attachment">Lampiran</label>
                                        <input class="form-control form-control" type="file" name="attachment" id="attachment">
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="description">Keterangan</label>
                                    <textarea class="form-control" name="description" id="description" required></textarea>
                                </div>
                                <button class="btn btn-primary mt-2" type="submit">Posting</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
