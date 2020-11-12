@extends('layouts.app')

@section('content')
<div class="container">
    {{------------- add new task section  ------------}}
  <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
      aria-hidden="true">
    <form action="{{ route('create_task')}}" method="POST">
      @csrf
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-center">
              <h4 class="modal-title w-100 font-weight-bold" style="font-size: 18pt">New task</h4>
              <button type="button" class="close btn-success" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body mx-3">
            {{-- task name input section --}}
            <div class="md-form mb-5">
              <i class="fas fa-envelope prefix grey-text"></i>
              <label data-error="wrong" data-success="right" for="exampleFormControlTextarea1" 
                class="w-70 font-weight-bold text-success">Task name</label>
              <input type="text" class="form-control validate" id="exampleFormControlTextarea1" name="taskname">
            </div>
            {{-- task body input section --}}
            <div class="md-form mb-5">
              <i class="fas fa-envelope prefix grey-text"></i>
              <label data-error="wrong" data-success="right" for="exampleFormControlTextarea1" 
              class="w-70 font-weight-bold text-success">Task body</label>
              <textarea class="form-control validate" id="exampleFormControlTextarea1" 
                rows="4" name="taskbody"></textarea>
            </div>
          </div>
          <div class="modal-footer d-flex" style="">
            <button class="btn btn-success" type="submit" 
              style="color: white; font-size:16pt">Add</button>
          </div>
        </div>
      </div>
    </form> 
  </div>
{{-- /*-----------------------------------------------*/ --}}


      {{-- add task btn --}}
    <div class="text-center">
        <a href="" class="btn btn-success btn-rounded mb-4" 
        data-toggle="modal" data-target="#modalLoginForm">Add new task now!</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">

          <h2 class="text-info">Tasks List</h2>
            {{------- show specific alert section ------}} 
            
            
            @if (session('task_created') != null) 
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>{{ session('task_created')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
          @endif
          
          @if (session('task_deleted') != null) 
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>{{ session('task_deleted')}}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          @endif
          
          @if (session('task_updated') != null) 
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>{{ session('task_updated')}}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          @endif

          @if (session('task_restored') != null) 
          <div class="alert alert-info alert-dismissible fade show" role="alert">
              <strong>{{ session('task_restored')}}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          @endif
               {{--------- show tasks section -------}}
               @foreach ($tasks as $task)
               <div class="card" style="margin:20px;">

                <div class="card-header">
                  Created_at {{$task->created_at}}

                  {{-- delete button --}}
                  <form action="{{route('delete_task' , $task->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                     <button class="btn btn-danger float-right btn-sm" type="submit">
                        Delete  </button>
                  </form>
  
                  {{-- update button --}}
                  <a class="btn btn-success float-right btn-sm mr-2" 
                  href="{{route('show_to_update' , $task->id)}}">Update </a>

                  {{-- archive button --}}
                  <form action="{{route('archive_task' , $task->id)}}" method="GET">
                    @csrf
                     <button class="btn btn-warning float-right btn-sm mr-2" 
                     type="submit" >Archive  </button>
                  </form>
                </div>
                
                <div class="card-body">
                  <h4 class="card-title">{{$task->name}}</h4>
                  <h5 class="card-text">{{$task->body}}</h5>   
                </div>

                {{-- comments section --}}
                <h5 class="ml-3 mb-2">
                  <label class="w-70 font-weight-bold text-primary">Comments</label> 
                </h5> 
                <ul class="list-group list-group-flush">

                  @foreach ($task->comments as $comment)
                  <li class="list-group-item">{{ $comment->body}}</li>  
                  @endforeach
                 
                </ul>

                {{-- add comment btn --}}
                <div class="card-footer">
                  <a href="{{ route('show_to_comment' , $task->id)}}" class="btn btn-primary">Comment</a>
                 </div>
              </div>
               @endforeach
              
        </div>
    </div>
</div>
@endsection
