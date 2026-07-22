<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Setting;

class TeacherController extends Controller
{
    /**
     * Daftar guru publik
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        $teachers = Guru::latest()->get();

        return view('public.guru.index', compact('settings', 'teachers'));
    }

    /**
     * Detail guru
     */
    public function show($id)
    {
        $settings = Setting::pluck('value', 'key');
        $teacher = Guru::findOrFail($id);

        return view('public.guru.show', compact('settings', 'teacher'));
    }
}
