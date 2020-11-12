<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location as Location;



class TaskController extends Controller
{
    public function create()
    {
        $new_task_record = new Task();

        $new_task_record->user_id = auth()->user()->id;
        $new_task_record->name = request('taskname');
        $new_task_record->body = request('taskbody');

        $new_task_record->save();
        return redirect('/home')->with('task_created' , 'your task added successfully');
        
    }

    public function destroy($taskid)
    {
       $task_record = Task::findOrFail($taskid)->forceDelete();

       return redirect()->back()->with('task_deleted' , 'your task deleted successfully');
    }

    public function show_to_update($taskid)
    {
        $task_record = Task::findOrFail($taskid);
        $task_comments =  Task::findOrFail($taskid)->comments()->orderBy('created_at', 'desc')->get();

        $position = Location::get($task_record->ip);
        $pos = $position->countryName;

        return view('Task.specificTask' , 
        ['task_record' =>$task_record , 'task_comments' =>$task_comments , 'pos' =>$pos]);
    }

    public function update($taskid)
    {
        $task_record = Task::findOrFail($taskid);

        $task_record->name = request('taskname');
        $task_record->body = request('taskbody');

        $task_record->save();
        return redirect('/home')->with('task_updated' , 'your task updated successfully');
    }

    public function show_archive()
    {
        $auth_user_id = auth()->user()->id;
        $archived_tasks = User::findOrFail($auth_user_id)
        ->tasks()->with('comments')->onlyTrashed()->get();
       
        return  view('Task.show_archives' , ['archived_tasks' => $archived_tasks]);
    }

    public function archive($taskid)
    {
        $task_record = Task::findOrFail($taskid)->delete();

        $auth_user_id = auth()->user()->id;
        $archived_tasks = User::findOrFail($auth_user_id)->tasks()->onlyTrashed()->get();

        return  redirect()
        ->action([TaskController::class, 'show_archive'])
        ->with('task_archieved' , 'your task archived successfully');
    
    }

    public function destroy_archived($taskid)
    {
        $auth_user_id = auth()->user()->id;
        $task_record = User::findOrFail($auth_user_id)
        ->tasks()->onlyTrashed()->where('id' ,'=' , $taskid)->forceDelete();

       return redirect()->back()->with('task_deleted' , 'your task deleted successfully');
    }

    public function restore_task($taskid)
    {
        $auth_user_id = auth()->user()->id;
        $task_record = User::findOrFail($auth_user_id)
        ->tasks()->onlyTrashed()->where('id' ,'=' , $taskid)->restore();

        return  redirect()
        ->action([HomeController::class, 'index'])
        ->with('task_restored' , 'your task restored successfully');
    }

    public function show_to_comment($taskid)
    {
        $task_record = Task::findOrFail($taskid);

        $task_comments =  Task::findOrFail($taskid)->comments()->orderBy('created_at', 'desc')->get();

        return view('Task.show_to_comment' , 
        ['task_record' =>$task_record , 'task_comments' => $task_comments]);
    }

    public function create_comment($taskid)
    {
        $new_comment_record = new Comment();

        $new_comment_record->task_id = $taskid;
        $new_comment_record->body = request('commentbody');
        
        $new_comment_record->save();
        return redirect()->back()->with('comment_created' , 'your comment added successfully'); 
    }

    
}
