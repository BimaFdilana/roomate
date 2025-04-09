<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Material;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function detail($type, $id)
    {
        if ($type === 'material') {
            $material = Material::findOrFail($id);
            $material->load('attachments');
            return view('post_detail', ['material' => $material]);
        } elseif ($type === 'quiz') {
            $quiz = Quiz::findOrFail($id);
            $quiz->load('questions');
            $quiz->load('results');

            $hasTakenQuiz = QuizResult::where('quiz_id', $quiz->id)
                ->where('student_id', Auth::user()->id)
                ->exists();

            $quizResult = QuizResult::where('quiz_id', $quiz->id)
                ->where('student_id', Auth::user()->id)
                ->first();

            $allResults = $quiz->results;

            $levelClass = match ($quiz->level) {
                'Mudah' => 'text-success',
                'Sedang' => 'text-warning',
                'Sulit' => 'text-danger',
                default => 'text-light',
            };

            $estimatedTimePerQuestionInSeconds = $quiz->questions->count() > 0
                ? round($quiz->time_limit / $quiz->questions->count())
                : 0;

            $estimatedMinutes = floor($estimatedTimePerQuestionInSeconds / 60);
            $estimatedSeconds = $estimatedTimePerQuestionInSeconds % 60;

            $formattedEstimatedTime = $estimatedMinutes . ' menit ' . str_pad($estimatedSeconds, 2, '0', STR_PAD_LEFT) . ' detik';

            return view('post_detail', [
                'quiz' => $quiz,
                'hasTakenQuiz' => $hasTakenQuiz,
                'quizResult' => $quizResult,
                'allResults' => $allResults,
                'levelClass' => $levelClass,
                'formattedEstimatedTime' => $formattedEstimatedTime,
            ]);
        } else {
            abort(404, 'Tipe postingan tidak valid.');
        }
    }




    public function createMaterialPost($classroom_id)
    {
        return view('material_post', compact('classroom_id'));
    }

    public function createQuizPost($classroom_id)
    {
        return view('quiz_post', compact('classroom_id'));
    }
}



 // public function detail($type, $id)
    // {
    //     if ($type === 'material') {
    //         $material = Material::findOrFail($id);
    //         $material->load('attachments');
    //         return view('post_detail', ['material' => $material]);
    //     } elseif ($type === 'quiz') {
    //         $quiz = Quiz::findOrFail($id);
    //         $quiz->load('questions');
    //         $quiz->load('results');

    //         $hasTakenQuiz = QuizResult::where('quiz_id', $quiz->id)
    //             ->where('student_id', Auth::user()->id)
    //             ->exists();

    //         $quizResult = QuizResult::where('quiz_id', $quiz->id)
    //             ->where('student_id', Auth::user()->id)
    //             ->first();

    //         return view('post_detail', [
    //             'quiz' => $quiz,
    //             'hasTakenQuiz' => $hasTakenQuiz,
    //             'quizResult' => $quizResult
    //         ]);
    //     } else {
    //         abort(404, 'Tipe postingan tidak valid.');
    //     }
    // }