<?php

namespace App\Http\Controllers;

use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_published', true)->get();
        $featuredCourse = Course::where('is_featured', true)->where('is_published', true)->first();
        return view('home', compact('courses', 'featuredCourse'));
    }
}
