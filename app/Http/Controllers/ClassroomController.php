<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Material;
use App\Models\Classroom;
use App\Models\QuizResult;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StudentClassroom;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClassroomController extends Controller
{

    public function show($id)
    {
        $classroom = Classroom::findOrFail($id);

        $materials = Material::where('classroom_id', $id)
            ->select('id', 'title', 'created_at', DB::raw("'material' as type"));

        $quizzes = Quiz::where('classroom_id', $id)
            ->select('id', 'title', 'created_at', DB::raw("'quiz' as type"));

        $allPosts = $materials->union($quizzes)->orderBy('created_at', 'desc')->get();

        $students = $classroom->students;

        foreach ($students as $student) {
            $totalScore = QuizResult::where('student_id', $student->id)
                ->whereIn('quiz_id', $quizzes->pluck('id'))
                ->sum('score');
            $student->total_score = $totalScore;
        }

        $students = $students->sortByDesc('total_score')->values();

        return view('classroom', compact('classroom', 'allPosts', 'students'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_class_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'class_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if (Auth::user()->role !== 'guru') {
            return redirect()->back()->withErrors(['error' => 'Only teachers can create a classroom.']);
        }

        $bannerPath = $request->file('banner_class_image')->store('classroom/banners', 'public');
        $logoPath = $request->file('class_image')->store('classroom/logos', 'public');

        $classCode = strtoupper(Str::random(8));

        $classroom = Classroom::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'banner_class_image' => $bannerPath,
            'class_image' => $logoPath,
            'teacher_id' => Auth::user()->id,
            'class_code' => $classCode,
        ]);

        return redirect()->back()->with('success', 'Classroom successfully created!');
    }

    public function joinClass(Request $request)
    {
        $request->validate([
            'class_code' => 'required|string|exists:classrooms,class_code',
        ]);

        $classroom = Classroom::where('class_code', $request->class_code)->first();

        if (!$classroom) {
            return redirect()->back()->withErrors(['class_code' => 'Kode kelas tidak valid']);
        }

        $alreadyJoined = StudentClassroom::where('student_id', Auth::user()->id)
            ->where('classroom_id', $classroom->id)
            ->exists();

        if ($alreadyJoined) {
            return redirect()->back()->with('status', 'Anda sudah bergabung di kelas ini.');
        }

        StudentClassroom::create([
            'student_id' => Auth::user()->id,
            'classroom_id' => $classroom->id,
        ]);

        return redirect()->route('home')->with('status', 'Berhasil bergabung di kelas!');
    }
}
