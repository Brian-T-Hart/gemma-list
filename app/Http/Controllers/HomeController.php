<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Glist;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $glists = Glist::where(['user_id' => auth()->id(), 'archived' => 0])->with('tasks')->get();

        return view('home', compact('glists'));

    }
}
