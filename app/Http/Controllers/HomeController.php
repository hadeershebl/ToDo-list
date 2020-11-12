<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;



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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $auth_user_id = auth()->user()->id;
        $tasks = User::findOrFail($auth_user_id)
        ->tasks()->with('comments')->orderBy('created_at', 'desc')->get();

        

        return view('home', ['tasks' => $tasks]);
    }
}
