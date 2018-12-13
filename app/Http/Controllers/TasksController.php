<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;
use App\Glist;

class TasksController extends Controller
{
    public function __construct() {

		$this->middleware('auth');

    }

    public function store(Glist $glist) {
        
        $attributes = request()->validate(['title' => 'required']);

        $glist->addTask($attributes);

        return back();
    }
    
    public function update(Task $task) {

        $task->complete(request()->has('completed'));

        return back();

    }
}
