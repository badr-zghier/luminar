<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Course;

class TeacherCoursesController extends Controller
{
    public function index()
    {
        $courses = Course::where("user_id", auth()->user()->id)->get();

        return Inertia::render('Courses')->with("courses", $courses);
    }
}
