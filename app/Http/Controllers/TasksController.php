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
    
    public function update(Request $request) {

		$attributes['title'] = $request->title;

        $task = Task::where('id', $request->id)->update($attributes);
        
        return $task;

    }

    // delete tasks from a specific list
    public function destroy(Glist $glist) {

        $tasks = Task::where(['glist_id' => $glist->id, 'completed' => 1])->delete();

        return back();

    }

    // delete all completed tasks from all lists
    public function destroyAll() {

        $tasks = Task::with(['Glist' => function($query) {
            $query->where(['user_id' => auth()->user()]);
        }])->where(['completed' => 1])->delete();

        return back();

    }

    public function completed(Task $task) {

        $task->complete(request()->has('completed'));

        return $task;

    }

    public function order(Request $request) {

        $ids = json_decode($request->ids);

        foreach ($ids as $key => $value){

            $attributes['order'] = $key;

            $updatedTask = Task::where(['id' => $value])->update($attributes);

          }

          return response()->json([
            'success' => true,
            'status' => 200
        ]);
    }

    public function copyto($listId, $glistId) {

        $itemsToCopy = Task::select('title')->where(['glist_id' => $listId])->get();
        
        foreach ($itemsToCopy as $item) {

            $task['glist_id'] = $glistId;
            
            $task['title'] = $item->title;

            $task['order'] = $item->order;
            
            Task::create($task);

        }

        return back();
    }

}
