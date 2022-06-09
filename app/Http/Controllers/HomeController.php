<?php

namespace App\Http\Controllers;

use App\Models\Peserta;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // $pesertas = Peserta::where('email', auth()->user()->email)->value('id');
        return view('dashboard');
    }
}