<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Quiz;
use App\Models\Classroom;
use App\Models\Question;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function create($classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        return view('quiz_post', compact('classroom'));
    }

    public function store(Request $request, $classroom_id)
    {
        $validated = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'time_limit' => 'required|integer|min:5',
            'level' => 'required',
            'questions' => 'required|array',
            'questions.*.question_text' => 'required|string',
            'questions.*.answers' => 'required|array',
            'questions.*.answers.*.answer_text' => 'nullable|string',
            'questions.*.answers.*.type' => 'nullable|in:text,image,image-text',
            'questions.*.answers.*.is_correct' => 'nullable|in:on',
            'questions.*.image' => 'nullable|file|image',
            'questions.*.answers.*.image' => 'nullable|file|image',
        ]);

        $quiz = Quiz::create([
            'classroom_id' => $validated['classroom_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'time_limit' => $validated['time_limit'],
            'level' => $validated['level'],
        ]);

        foreach ($validated['questions'] as $questionData) {
            $question = $quiz->questions()->create([
                'question_text' => $questionData['question_text'],
                'image_url' => isset($questionData['image']) ? $questionData['image']->store('answer', 'public') : null,
            ]);

            foreach ($questionData['answers'] as $answerData) {
                $question->answers()->create([
                    'answer_text' => $answerData['answer_text'],
                    // 'type' => $answerData['type'],
                    'is_correct' => isset($answerData['is_correct']) && $answerData['is_correct'] === 'on' ? 1 : 0,
                    'image_url' => isset($answerData['image']) ? $answerData['image']->store('questions', 'public') : null,
                ]);
            }
        }

        return redirect()->route('classroom.show', $classroom_id)->with('success', 'Kuis berhasil dibuat!');
    }

    public function start(Quiz $quiz)
    {
        $quiz->load('questions.answers');

        $type = 'quiz';

        return view('quiz_start', [
            'quiz' => $quiz,
            'type' => $type,
            'quizId' => $quiz->id
        ]);
    }


    public function submit(Request $request, Quiz $quiz)
    {
        $answers = $request->input('answers');

        $score = 0;
        foreach ($quiz->questions as $question) {
            $correctAnswer = $question->answers->firstWhere('is_correct', true);
            if (isset($answers[$question->id]) && $answers[$question->id] == $correctAnswer->id) {
                $score++;
            }
        }

        QuizResult::create([
            'student_id' => Auth::user()->id,
            'quiz_id' => $quiz->id,
            'score' => $score,
        ]);

        return redirect()->route('quiz.start', $quiz->id)->with('message', "Skor Anda: $score/" . $quiz->questions->count());
    }

    public function getQuizQuestions(Quiz $quiz)
    {
        $quiz->load('questions.answers');
        return response()->json($quiz);
    }

    public function saveResult(Request $request)
    {
        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'student_id' => 'required|exists:users,id',
            'score' => 'required|integer',
        ]);

        QuizResult::create($validated);

        return response()->json(['message' => 'Result saved successfully!']);
    }

    public function edit($classroom_id, $quiz_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        $quiz = Quiz::with('questions.answers')->findOrFail($quiz_id);

        return view('quiz_edit', compact('classroom', 'quiz'));
    }

    public function update(Request $request, $classroom_id, $quiz_id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'time_limit' => 'required|integer',
            'level' => 'required',
            'questions' => 'required|array',
            'questions.*.id' => 'nullable|exists:questions,id',
            'questions.*.question_text' => 'required|string',
            'questions.*.answers' => 'required|array',
            'questions.*.answers.*.id' => 'nullable|exists:answers,id',
            'questions.*.answers.*.answer_text' => 'nullable|string',
            'questions.*.answers.*.is_correct' => 'nullable|in:on',
            'questions.*.image' => 'nullable|file|image',
            'questions.*.answers.*.image' => 'nullable|file|image',
        ]);

        // Ambil kuis yang akan diupdate
        $quiz = Quiz::findOrFail($quiz_id);

        // Update informasi kuis
        $quiz->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'time_limit' => $validated['time_limit'],
            'level' => $validated['level'],
        ]);

        // Ambil daftar ID pertanyaan yang dikirim dari form
        $questionIds = collect($validated['questions'])->pluck('id')->filter()->toArray();

        // Hapus pertanyaan yang tidak ada dalam form
        $quiz->questions()->whereNotIn('id', $questionIds)->delete();

        foreach ($validated['questions'] as $questionData) {
            // Jika ada ID, update pertanyaan yang sudah ada
            if (isset($questionData['id'])) {
                $question = Question::findOrFail($questionData['id']);
                $question->update([
                    'question_text' => $questionData['question_text'],
                    'image_url' => isset($questionData['image']) ? $questionData['image']->store('questions', 'public') : $question->image_url,
                ]);
            } else {
                // Jika tidak ada ID, buat pertanyaan baru
                $question = $quiz->questions()->create([
                    'question_text' => $questionData['question_text'],
                    'image_url' => isset($questionData['image']) ? $questionData['image']->store('questions', 'public') : null,
                ]);
            }

            // Ambil daftar ID jawaban yang dikirim dari form
            $answerIds = collect($questionData['answers'])->pluck('id')->filter()->toArray();

            // Hapus jawaban yang tidak ada dalam form
            $question->answers()->whereNotIn('id', $answerIds)->delete();

            foreach ($questionData['answers'] as $answerData) {
                // Jika ada ID, update jawaban yang sudah ada
                if (isset($answerData['id'])) {
                    $answer = Answer::findOrFail($answerData['id']);
                    $answer->update([
                        'answer_text' => $answerData['answer_text'],
                        'is_correct' => isset($answerData['is_correct']) && $answerData['is_correct'] === 'on' ? 1 : 0,
                        'image_url' => isset($answerData['image']) ? $answerData['image']->store('answers', 'public') : $answer->image_url,
                    ]);
                } else {
                    // Jika tidak ada ID, buat jawaban baru
                    $question->answers()->create([
                        'answer_text' => $answerData['answer_text'],
                        'is_correct' => isset($answerData['is_correct']) && $answerData['is_correct'] === 'on' ? 1 : 0,
                        'image_url' => isset($answerData['image']) ? $answerData['image']->store('answers', 'public') : null,
                    ]);
                }
            }
        }

        return redirect()->route('classroom.show', $classroom_id)->with('success', 'Kuis berhasil diperbarui!');
    }



   public function destroy($classroom_id, $quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);

        // Hapus semua hasil kuis terkait (quiz_results)
        $quiz->results()->delete();

        // Hapus semua jawaban terkait
        foreach ($quiz->questions as $question) {
            $question->answers()->delete();
        }

        // Hapus semua pertanyaan terkait
        $quiz->questions()->delete();

        // Hapus kuis
        $quiz->delete();

        return redirect()->route('classroom.show', $classroom_id)->with('success', 'Kuis berhasil dihapus!');
    }




}