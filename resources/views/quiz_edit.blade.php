@extends('components.main')
@section('title', 'Edit Kuis')
@section('content')
    <div class="container mt-4">
        <div class="row gx-3 gy-3">
            <div class="col col-12">
                <div class="card h-100 rounded-3 overflow-hidden border-0 bg-light">
                    <div class="card-body bg-light d-flex flex-column gap-1 p-2">
                        <h4 class="fw-bold">Edit Kuis</h4>
                        <form action="{{ route('quizzes.update', ['classroom_id' => $classroom->id, 'id' => $quiz->id]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="title">Judul Kuis</label>
                                <input class="form-control" type="text" name="title" id="title"
                                    value="{{ $quiz->title }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Deskripsi</label>
                                <textarea class="form-control" name="description" id="description" rows="4" required>{{ $quiz->description }}</textarea>
                            </div>

                            <div id="questions-section">
                                <h5 class="fw-bold mt-3">Soal</h5>
                                @foreach ($quiz->questions as $qIndex => $question)
                                    <div class="question-item border p-3 mb-3 rounded" data-index="{{ $qIndex }}">
                                        <input type="hidden" name="questions[{{ $qIndex }}][id]"
                                            value="{{ $question->id }}">

                                        <div class="form-group mb-2">
                                            <label for="question_text_{{ $qIndex }}">Teks Soal</label>
                                            <textarea class="form-control" name="questions[{{ $qIndex }}][question_text]" rows="2" required>{{ $question->question_text }}</textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="question_image_{{ $qIndex }}">Gambar Soal</label>
                                            <input type="file" class="form-control"
                                                name="questions[{{ $qIndex }}][image]">
                                            @if ($question->image_url)
                                                <img src="{{ asset('storage/' . $question->image_url) }}"
                                                    class="img-thumbnail mt-2" width="100">
                                            @endif
                                        </div>
                                        <div>
                                            <label>Jawaban</label>
                                            <div id="answers-section-{{ $qIndex }}" class="answers-section">
                                                @foreach ($question->answers as $aIndex => $answer)
                                                    <div class="answer-item d-flex align-items-center gap-2 mb-2">
                                                        <input type="hidden"
                                                            name="questions[{{ $qIndex }}][answers][{{ $aIndex }}][id]"
                                                            value="{{ $answer->id }}">
                                                        <input type="text" class="form-control"
                                                            name="questions[{{ $qIndex }}][answers][{{ $aIndex }}][answer_text]"
                                                            value="{{ $answer->answer_text }}">
                                                        <input type="file" class="form-control"
                                                            name="questions[{{ $qIndex }}][answers][{{ $aIndex }}][image]">
                                                        @if ($answer->image_url)
                                                            <img src="{{ asset('storage/' . $answer->image_url) }}"
                                                                class="img-thumbnail" width="50">
                                                        @endif
                                                        <input type="checkbox" class="form-check-input"
                                                            name="questions[{{ $qIndex }}][answers][{{ $aIndex }}][is_correct]"
                                                            {{ $answer->is_correct ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jawaban Benar</label>
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-answer">Hapus</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-secondary btn-sm add-answer"
                                                data-question="{{ $qIndex }}">Tambah Jawaban</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm add-question">Tambah Soal</button>
                            <div class="d-block text-end">
                                <button class="btn btn-primary mt-3" type="submit">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let questionIndex = {{ $quiz->questions->count() }};

        document.querySelector('.add-question').addEventListener('click', function() {
            let questionHTML = `
                <div class="question-item border p-3 mb-3 rounded" data-index="${questionIndex}">
                    <div class="form-group mb-2">
                        <label>Teks Soal</label>
                        <textarea class="form-control" name="questions[${questionIndex}][question_text]" rows="2" required></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <label>Gambar Soal</label>
                        <input type="file" class="form-control" name="questions[${questionIndex}][image]">
                    </div>
                    <div>
                        <label>Jawaban</label>
                        <div id="answers-section-${questionIndex}" class="answers-section"></div>
                        <button type="button" class="btn btn-secondary btn-sm add-answer" data-question="${questionIndex}">Tambah Jawaban</button>
                    </div>
                </div>
            `;
            document.querySelector('#questions-section').insertAdjacentHTML('beforeend', questionHTML);
            questionIndex++;
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('add-answer')) {
                const questionId = event.target.getAttribute('data-question');
                const answersSection = document.querySelector(`#answers-section-${questionId}`);
                const answerIndex = answersSection.querySelectorAll('.answer-item').length;

                const answerHTML = `
                    <div class="answer-item d-flex align-items-center gap-2 mb-2">
                        <input type="text" class="form-control" name="questions[${questionId}][answers][${answerIndex}][answer_text]" placeholder="Jawaban teks">
                        <input type="file" class="form-control" name="questions[${questionId}][answers][${answerIndex}][image]">
                        <input type="checkbox" class="form-check-input" name="questions[${questionId}][answers][${answerIndex}][is_correct]">
                        <label class="form-check-label">Jawaban Benar</label>
                        <button type="button" class="btn btn-danger btn-sm remove-answer">Hapus</button>
                    </div>
                `;
                answersSection.insertAdjacentHTML('beforeend', answerHTML);
            }
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-answer')) {
                event.target.closest('.answer-item').remove();
            }
        });
    </script>
@endsection
