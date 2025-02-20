<!DOCTYPE html>
<html data-bs-theme="light" lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Kuis Interaktif</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&amp;display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.5/dist/sweetalert2.min.css">
</head>

<body class="bg-light bg-gradient min-vh-100 d-flex align-items-center">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div id="quiz-container" class="p-4 rounded bg-white">
                    <h3 id="quiz-title" class="text-center mb-4"></h3>
                    <div class="text-center mb-3">
                        <p id="question-text" class="lead"></p>
                        <div class="d-flex justify-content-center mb-4">
                            <img id="question-image" class="rounded img-fluid" src="" alt="Question Image"
                                width="250">
                        </div>
                    </div>
                    <div id="answers-container" class="row row-cols-4 g-3"></div>
                    <div id="timer-container" class="text-center mt-3">
                        <p id="timer" class="lead">Waktu tersisa: <span id="time-left">00:00</span></p>
                    </div>
                </div>

                <div id="result-container" class="d-none text-center p-4 rounded bg-white">
                    <h4 class="mb-3">Hasil Kuis</h4>
                    <p class="lead" id="score-text"></p>
                    <a href="{{ route('post.detail', ['type' => $type, 'id' => $quizId]) }}"
                        class="btn btn-restart">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        let quizData = [];
        let currentQuestionIndex = 0;
        let score = 0;
        let pointsPerQuestion = 0;
        let timeLeft = 20; // untuk mengubah waktu
        let timerInterval;

        function startTimer() {
            timerInterval = setInterval(() => {
                if (timeLeft > 0) {
                    timeLeft--;
                    updateTimerDisplay();
                } else {
                    clearInterval(timerInterval);
                    endQuiz();
                }
            }, 1000);
        }

        // Fungsi untuk memperbarui tampilan timer
        function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById("time-left").innerText =
                `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        // Fungsi untuk mengakhiri kuis ketika waktu habis
        function endQuiz() {
            Swal.fire({
                title: "Waktu Habis!",
                text: "Waktu untuk mengerjakan kuis telah habis.",
                icon: "warning",
                confirmButtonText: "Lihat Hasil"
            }).then(() => {
                showResult();
            });
        }

        // Fungsi untuk memuat data kuis dari backend
        function loadQuizData(quizId) {
            fetch(`/quiz/${quizId}/questions`)
                .then(response => response.json())
                .then(data => {
                    quizData = data.questions.map(question => ({
                        question: question.question_text,
                        image: question.image_url,
                        answers: question.answers.map(answer => ({
                            id: answer.id,
                            text: answer.answer_text,
                            isCorrect: answer.is_correct,
                            image: answer.image_url
                        }))
                    }));

                    // Hitung nilai per soal dan pastikan itu integer
                    pointsPerQuestion = Math.round(100 / quizData.length); // Membulatkan hasil per soal menjadi integer

                    displayQuestion(); // Tampilkan soal pertama
                    startTimer(); // Mulai timer
                })
                .catch(error => console.error("Error loading quiz data:", error));
        }

        // Fungsi untuk menampilkan soal
        function displayQuestion() {
            const question = quizData[currentQuestionIndex];

            // Menampilkan judul soal
            document.getElementById("quiz-title").innerText = `Soal ${currentQuestionIndex + 1} dari ${quizData.length}`;
            document.getElementById("question-text").innerText = question.question;

            // Memeriksa apakah ada gambar soal
            const questionImage = document.getElementById("question-image");
            if (question.image) {
                questionImage.src = "{{ asset('storage/') }}" + '/' + question.image;
                questionImage.style.display = 'block'; // Menampilkan gambar jika ada
            } else {
                questionImage.style.display = 'none'; // Menyembunyikan gambar jika tidak ada
            }

            const answersContainer = document.getElementById("answers-container");
            answersContainer.innerHTML = ""; // Bersihkan jawaban sebelumnya

            question.answers.forEach((answer) => {
                const answerDiv = document.createElement("div");
                answerDiv.classList.add("col");

                // Membuat elemen untuk jawaban
                let answerContent =
                    `<button class="btn btn-outline-dark w-100" onclick="checkAnswer(${answer.isCorrect})">`;

                // Memeriksa apakah ada gambar jawaban
                if (answer.image) {
                    answerContent +=
                        `<img src="{{ asset('storage/${answer.image}') }}" class="img-fluid rounded mb-2" style="max-height: 100px;">`;
                }

                // Memeriksa apakah ada teks jawaban
                if (answer.text) {
                    answerContent += `<p class="m-0">${answer.text}</p>`;
                }

                answerContent += `</button>`;

                answerDiv.innerHTML = answerContent;
                answersContainer.appendChild(answerDiv);
            });
        }

        // Fungsi untuk memeriksa jawaban
        function checkAnswer(isCorrect) {
            if (isCorrect) {
                score += pointsPerQuestion; // Menambahkan skor berdasarkan nilai per soal
                Swal.fire({
                    title: "Benar!",
                    text: "Jawaban Anda benar!",
                    icon: "success",
                    timer: 1000,
                    showConfirmButton: false
                }).then(nextQuestion);
            } else {
                Swal.fire({
                    title: "Salah!",
                    text: "Cobalah lagi di soal berikutnya.",
                    icon: "error",
                    timer: 1000,
                    showConfirmButton: false
                }).then(nextQuestion);
            }
        }

        // Fungsi untuk melanjutkan ke soal berikutnya
        function nextQuestion() {
            currentQuestionIndex++;
            if (currentQuestionIndex < quizData.length) {
                displayQuestion();
            } else {
                clearInterval(timerInterval); // Hentikan timer jika semua soal telah dijawab
                showResult();
            }
        }

        // Fungsi untuk menampilkan hasil akhir
        function showResult() {
            document.getElementById("quiz-container").classList.add("d-none");
            document.getElementById("result-container").classList.remove("d-none");
            document.getElementById("score-text").innerText = `Skor Anda: ${score} dari 100`; // Skor maksimal 100
            saveResult(); // Simpan hasil ke database

            // Menambahkan efek konfeti
            confetti({
                particleCount: 1000,
                angle: -90,
                spread: 180,
                startVelocity: 70,
                gravity: 1,
                origin: {
                    x: 0.5,
                    y: -1
                },
                zIndex: 9999
            });
        }

        // Fungsi untuk menyimpan hasil ke database
        function saveResult() {
            fetch('/save-quiz-result', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        quiz_id: quizId,
                        student_id: userId,
                        score: score,
                    }),
                }).then(response => response.json())
                .then(data => console.log("Result saved:", data))
                .catch(error => console.error("Error:", error));
        }

        // Panggil fungsi untuk memuat data kuis saat halaman dimuat
        const userId = {{ Auth::user()->id }}; // Ganti dengan ID kuis yang sesuai
        const quizId = {{ $quiz->id }}; // Ganti dengan ID kuis yang sesuai
        window.onload = () => loadQuizData(quizId);
    </script>
    <script>
        function goBack() {
            // Ganti 'quiz' dan 'quizId' dengan nilai yang sesuai
            const type = "quiz"; // Anda dapat mengubahnya sesuai kebutuhan
            const id = {{ $quiz->id }}; // Pastikan ID kuis sudah tersedia di template
            window.location.href = `{{ url('/') }}/${type}/${id}`;
        }
    </script>
</body>

</html>
