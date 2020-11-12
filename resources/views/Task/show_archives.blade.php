@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-danger">Archive List</h2>
            {{------- show specific alert section ------}}  
            @if (session('task_archieved') != null) 
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>{{ session('task_archieved')}}</strong>
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
         
               {{--------- show  archived tasks section -------}}
               
               @foreach ($archived_tasks as $task)
               <div class="card" style="margin:20px;">

                <div class="card-header">
                  Archived_at {{$task->deleted_at}}

                  {{-- delete button --}}
                  <form action="{{route('delete_archive_task' , $task->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                     <button class="btn btn-danger float-right btn-sm" type="submit">
                        Delete  </button>
                  </form>
  
                 {{-- restore button --}}
                  <form action="{{route('restore_task' , $task->id)}}" method="GET">
                    @csrf
                     <button class="btn btn-info float-right btn-sm mr-2" 
                     type="submit" style="color: white">Re-store  </button>
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
              </div>
              
               @endforeach
              
        </div>
    </div>
</div>
@endsection
