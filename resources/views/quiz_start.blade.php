<!DOCTYPE html>
<html data-bs-theme="light" lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Kuis {{ $quiz->title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.5/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/start.css') }}">
</head>

<body class="bg-light min-vh-100 d-flex align-items-center justify-content-center">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="container mb-2">
                    <div class="row">
                        <div class="col text-start">
                            <p id="quiz-title" class="text-dark mb-2 fw-normal"></p>
                        </div>
                    </div>

                    <!-- Progress bar -->
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-primary" id="progress-bar" role="progressbar" style="width: 0%;"
                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div id="quiz-container" class="p-4 rounded-4 bg-white shadow-lg">
                    <div class="text-center mb-4">
                        <p id="question-text" class="fs-5 fw-normal"></p>
                        <div class="d-flex justify-content-center mb-3">
                            <img id="question-image" class="rounded img-fluid shadow-sm" src=""
                                alt="Question Image" style="max-height: 250px; display: none;">
                        </div>
                    </div>
                    <div id="answers-container" class="row row-cols-1 row-cols-sm-2 g-3"></div>
                    <div id="timer-container" class="text-center mt-4">
                        <p id="timer" class="fs-5 fw-bold text-danger">Waktu tersisa: <span
                                id="time-left">00:00</span></p>
                    </div>
                </div>

                <div id="result-container" class="d-none text-center p-4 rounded-4 bg-white shadow-lg mt-4">
                    <h4 class="mb-3 fw-bold text-success">Hasil Kuis</h4>
                    <p class="lead" id="score-text"></p>
                    <a href="{{ route('post.detail', ['type' => $type, 'id' => $quizId]) }}"
                        class="btn btn-restart mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        let quizData = [];
        let currentQuestionIndex = 0;
        let score = 0;
        let pointsPerQuestion = 0;
        let timeLeft = {{ isset($quiz->time_limit) ? $quiz->time_limit : 1200 }};
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

        function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById("time-left").innerText =
                `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        function updateProgressBar() {
            const progress = Math.round(((currentQuestionIndex + 1) / quizData.length) * 100);
            const progressBar = document.getElementById("progress-bar");
            progressBar.style.width = `${progress}%`;
            progressBar.setAttribute("aria-valuenow", progress);
        }

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

                    pointsPerQuestion = Math.round(100 / quizData.length);
                    displayQuestion();
                    startTimer();
                })
                .catch(error => console.error("Error loading quiz data:", error));
        }

        function displayQuestion() {
            const question = quizData[currentQuestionIndex];

            document.getElementById("quiz-title").innerText = `Soal ${currentQuestionIndex + 1} dari ${quizData.length}`;
            document.getElementById("question-text").innerText = question.question;

            const questionImage = document.getElementById("question-image");
            if (question.image) {
                questionImage.src = "{{ asset('storage') }}/" + question.image;
                questionImage.style.display = 'block';
            } else {
                questionImage.style.display = 'none';
            }

            const answersContainer = document.getElementById("answers-container");
            answersContainer.innerHTML = "";

            const optionClasses = ['answer-option-a', 'answer-option-b', 'answer-option-c', 'answer-option-d'];

            question.answers.forEach((answer, index) => {
                const answerDiv = document.createElement("div");
                answerDiv.classList.add("col");

                const label = String.fromCharCode(65 + index); // 'A', 'B', ...

                let answerContent = `
            <div class="answer-card p-3 ${optionClasses[index]} text-dark" onclick="checkAnswer(${answer.isCorrect})" role="button">
                <div class="d-flex flex-wrap align-items-start gap-2">
                    <div class="answer-label">${label}.</div>
                    <div class="answer-text-wrapper">
        `;

                if (answer.text) {
                    answerContent += `<p class="mb-1">${answer.text}</p>`;
                }

                if (answer.image) {
                    answerContent +=
                        `<img src="{{ asset('storage/${answer.image}') }}" class="img-fluid rounded answer-img mt-2">`;
                }

                answerContent += `
                    </div>
                </div>
            </div>
        `;

                answerDiv.innerHTML = answerContent;
                answersContainer.appendChild(answerDiv);
            });

            updateProgressBar();
        }


        function checkAnswer(isCorrect) {
            if (isCorrect) {
                score += pointsPerQuestion;
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

        function nextQuestion() {
            currentQuestionIndex++;
            if (currentQuestionIndex < quizData.length) {
                displayQuestion();
            } else {
                clearInterval(timerInterval);
                updateProgressBar(); // Pastikan 100% di akhir
                showResult();
            }
        }

        function showResult() {
            Swal.fire({
                title: '🎉 Selamat!',
                text: `Kamu telah menyelesaikan kuis! Skor kamu: ${score} dari 100`,
                imageUrl: 'https://cdn-icons-png.flaticon.com/512/3159/3159066.png',
                imageWidth: 100,
                imageHeight: 100,
                background: '#fff3cd',
                confirmButtonColor: '#ff6f61',
                confirmButtonText: 'Lihat Hasil 🎯',
                customClass: {
                    popup: 'rounded-4 shadow-lg'
                }
            }).then(() => {
                document.getElementById("quiz-container").classList.add("d-none");
                document.getElementById("result-container").classList.remove("d-none");
                document.getElementById("score-text").innerText = `Skor Kamu: ${score} dari 100`;
                saveResult();
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
            });
        }


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

        const userId = {{ Auth::user()->id }};
        const quizId = {{ $quiz->id }};
        window.onload = () => loadQuizData(quizId);
    </script>
</body>

</html>
