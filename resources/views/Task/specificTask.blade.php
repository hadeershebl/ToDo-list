@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
               {{--------- show specific task and update it section -------}}
               <h2 class="text-success">Update your owen task</h2>

            <div class="card" style="margin:20px;">
                <div class="card-header">
                    your task created from {{$pos}}
                </div>
                
            <form action="{{ route('update_task', $task_record->id)}}" method="POST">
                @csrf
                <div class="card-body">
                    
                    <h4 class="card-title">
                        <label class="w-70 font-weight-bold text-success">Task name</label>
                        <textarea class="form-control validate" 
                        rows="1" name="taskname">{{$task_record->name}}</textarea>
                    </h4>
                    <h5 class="card-text">
                        <label class="w-70 font-weight-bold text-success">Task body</label>
                        <textarea class="form-control validate" 
                        rows="4" name="taskbody">{{$task_record->body}}</textarea>
                    </h5> 
                    {{-- comments section --}}
                    <h5 class="card-text">
                        <label class="w-70 font-weight-bold text-success">Comments</label>
                        <ul class="list-group list-group-flush">
                
                            @foreach ($task_comments as $comment)
                                <li class="list-group-item">
                                    {{$comment->body}}   
                                </li> 
                                   
                            @endforeach
                            {{-- add comment btn --}}
                            <div class="card-footer text-right">
                                 <a href="{{ route('show_to_comment' , $task_record->id)}}" class="btn btn-success"> Add new comment</a>
                             </div>
                          </ul>  
                    </h5> 
                    
                
                </div>
                {{-- update btn --}}
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-success ">Update</button>
                 </div>
                </div>
            </form>     
        </div>
    </div>
</div>
@endsection
