@extends('components.main')
@section('title', 'Edit Materi')
@section('content')
    <div class="container mt-4">
        <div class="row gx-3 gy-3">
            <div class="col col-12">
                <div class="card h-100 rounded-3 overflow-hidden border-0 bg-light">
                    <div class="card-body bg-light d-flex flex-column gap-1 p-2">
                        <h4 class="fw-bold">Edit Materi</h4>
                        <div>
                            <form action="{{ route('material.update', [$classroom->id, $material->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="d-md-flex gap-3">
                                    <div class="form-group mb-2 w-100">
                                        <label for="title">Judul Materi</label>
                                        <input class="form-control" type="text" name="title" id="title"
                                            value="{{ old('title', $material->title) }}" required>
                                    </div>
                                    <div class="form-group mb-2 w-100">
                                        <label for="attachment">Lampiran</label>
                                        <input class="form-control" type="file" name="attachment" id="attachment">
                                        @if ($material->attachments->isNotEmpty())
                                            <small class="text-muted">File saat ini: <a
                                                    href="{{ asset('storage/' . $material->attachments->first()->file_path) }}"
                                                    target="_blank">Lihat File</a></small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="description">Keterangan</label>
                                    <textarea class="form-control" name="description" id="description" required>{{ old('description', $material->description) }}</textarea>
                                </div>
                                <button class="btn btn-primary mt-2" type="submit">Perbarui</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
