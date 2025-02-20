@extends('components.main')
@section('title', 'Buat Kuis')
@section('content')
    <div class="container mt-4">
        <div class="row gx-3 gy-3">
            <div class="col col-12">
                <div class="card h-100 rounded-3 overflow-hidden border-0 bg-light">
                    <div class="card-body bg-light d-flex flex-column gap-1 p-2">
                        <h4 class="fw-bold">Buat Kuis</h4>
                        <form action="{{ route('quizzes.store', ['classroom_id' => $classroom->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">

                            <div class="form-group mb-3">
                                <label for="title">Judul Kuis</label>
                                <input class="form-control" type="text" name="title" id="title" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Deskripsi</label>
                                <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
                            </div>

                            <div id="questions-section">
                                <h5 class="fw-bold mt-3">Soal</h5>
                            </div>
                            <div class="d-block">
                                <button type="button" class="btn btn-secondary btn-sm add-question">Tambah Soal</button>
                            </div>
                            <div class="d-block text-end">
                                <button class="btn btn-primary mt-3" type="submit">Posting</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <template id="question-template">
        <div class="question-item border p-3 mb-3 rounded">
            <div class="form-group mb-2">
                <label for="question_text_{index}">Teks Soal</label>
                <textarea class="form-control" name="questions[{index}][question_text]" id="question_text_{index}" rows="2"></textarea>
            </div>
            <div class="form-group mb-2">
                <label for="question_image_{index}">Gambar Soal</label>
                <input type="file" class="form-control" name="questions[{index}][image]">
            </div>
            <div>
                <label>Jawaban</label>
                <div id="answers-section-{index}" class="answers-section"></div>
                <button type="button" class="btn btn-secondary btn-sm add-answer" data-question="{index}">Tambah
                    Jawaban</button>
            </div>
        </div>
    </template>

    <script>
        let questionIndex = 0;

        document.querySelector('.add-question').addEventListener('click', function() {
            const template = document.querySelector('#question-template').innerHTML;
            const section = document.querySelector('#questions-section');
            const newQuestion = template.replace(/{index}/g, questionIndex);
            section.insertAdjacentHTML('beforeend', newQuestion);
            questionIndex++;
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('add-answer')) {
                const questionId = event.target.getAttribute('data-question');
                const answersSection = document.querySelector(`#answers-section-${questionId}`);
                const answerIndex = answersSection.querySelectorAll('.answer-item').length;

                const answerItem = `
                    <div class="answer-item d-flex align-items-center gap-2 mb-2">
                        <input type="text" class="form-control" name="questions[${questionId}][answers][${answerIndex}][answer_text]" placeholder="Jawaban teks">
                        <input type="file" class="form-control" name="questions[${questionId}][answers][${answerIndex}][image]">
                        <input type="checkbox" class="form-check-input" name="questions[${questionId}][answers][${answerIndex}][is_correct]">
                        <label class="form-check-label">Jawaban Benar</label>
                        <button type="button" class="btn btn-danger btn-sm remove-answer">Hapus</button>
                    </div>
                `;
                answersSection.insertAdjacentHTML('beforeend', answerItem);
            }
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-answer')) {
                event.target.closest('.answer-item').remove();
            }
        });
    </script>
@endsection
