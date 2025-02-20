<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'guru') {

            $classrooms = $user->classroomsAsTeacher()->with(['materials', 'quizzes'])->get();

            $activities = collect();

            foreach ($classrooms as $classroom) {
                $materials = $classroom->materials()
                    ->whereDate('created_at', now()->toDateString())
                    ->get()
                    ->map(function ($material) use ($classroom) {
                        return [
                            'classroom' => $classroom,
                            'type' => 'Materi baru',
                            'title' => $material->title,
                            'time' => $material->created_at,
                        ];
                    });

                $quizzes = $classroom->quizzes()
                    ->whereDate('created_at', now()->toDateString())
                    ->get()
                    ->map(function ($quiz) use ($classroom) {
                        return [
                            'classroom' => $classroom,
                            'type' => 'Kuis baru',
                            'title' => $quiz->title,
                            'time' => $quiz->created_at,
                        ];
                    });

                $activities = $activities->concat($materials)->concat($quizzes);
            }

            $activities = $activities->sortByDesc('time');

            if ($activities->isNotEmpty()) {
                return view('dashboard', compact('activities'));
            }

            $noActivityMessage = 'Tidak ada postingan hari ini';
            return view('dashboard', compact('noActivityMessage'));
        } elseif ($user->role == 'murid') {
            $classrooms = $user->classroomsAsStudent()->with(['materials', 'quizzes'])->get();

            // Total poin (dari seluruh hasil kuis)
            $totalPoints = $user->quizResults()->sum('score');

            // Total kelas yang diikuti
            $totalClasses = $classrooms->count();

            // Total materi dari semua kelas yang diikuti
            $totalMaterials = $classrooms->sum(function ($classroom) {
                return $classroom->materials->count();
            });

            // Total kuis dari semua kelas yang diikuti
            $totalQuizzes = $classrooms->sum(function ($classroom) {
                return $classroom->quizzes->count();
            });

            // Data untuk chart analitik performa
            $performanceData = $user->quizResults()
                ->with('quiz.classroom')
                ->get()
                ->groupBy(function ($result) {
                    return $result->quiz->classroom->name;
                })
                ->map(function ($results, $className) {
                    return [
                        'class' => $className,
                        'average_score' => $results->avg('score'),
                    ];
                });

            $activities = collect();

            foreach ($classrooms as $classroom) {
                $materials = $classroom->materials()
                    ->whereDate('created_at', now()->toDateString())
                    ->get()
                    ->map(function ($material) use ($classroom) {
                        return [
                            'classroom' => $classroom,
                            'type' => 'Materi baru',
                            'title' => $material->title,
                            'time' => $material->created_at,
                        ];
                    });

                $quizzes = $classroom->quizzes()
                    ->whereDate('created_at', now()->toDateString())
                    ->get()
                    ->map(function ($quiz) use ($classroom) {
                        return [
                            'classroom' => $classroom,
                            'type' => 'Kuis baru',
                            'title' => $quiz->title,
                            'time' => $quiz->created_at,
                        ];
                    });

                $activities = $activities->concat($materials)->concat($quizzes);
            }

            $activities = $activities->sortByDesc('time');

            if ($activities->isNotEmpty()) {
                return view('home', compact(
                    'activities',
                    'totalPoints',
                    'totalClasses',
                    'totalMaterials',
                    'totalQuizzes',
                    'performanceData',
                ));
            }

            $noActivityMessage = 'Tidak ada postingan hari ini';
            return view('home', compact(
                'noActivityMessage',
                'totalPoints',
                'totalClasses',
                'totalMaterials',
                'totalQuizzes',
                'performanceData',
            ));
        }
    }
}
