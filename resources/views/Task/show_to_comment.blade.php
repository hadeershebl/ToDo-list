@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-primary">Add new Comment For {{$task_record->name}}</h2>

            {{------- show specific alert section ------}}  
            @if (session('comment_created') != null) 
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>{{ session('comment_created')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
          @endif

               {{--------- show specific task and update it section -------}}  
            <div class="card" style="margin:20px;">
                
            <form action="{{ route('create_comment' , $task_record->id)}}" method="POST">
                @csrf
                <div class="card-body">
                    <h4 class="card-title">
                        <label class="w-70 font-weight-bold text-primary">Task name:</label>
                        {{$task_record->name}}
                    </h4>
                    <h5 class="card-text">
                        <label class="w-70 font-weight-bold text-primary">Task body</label>
                        <h3>{{$task_record->body}}</h3>
                    </h5>
                    {{-- comments section --}}
                    <label class="w-70 font-weight-bold text-primary">Comments</label> 
                <ul class="list-group list-group-flush">
                
                  @foreach ($task_comments as $comment)
                  <li class="list-group-item">{{ $comment->body}}</li>  
                  @endforeach
                 
                </ul>
                    <h5 class="card-text mt-4">
                        <label class="w-70 font-weight-bold text-primary">New comment</label>
                        <textarea class="form-control validate" 
                        rows="2" name="commentbody"></textarea>
                    </h5>   
                </div>
                {{-- update btn --}}
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary ">Comment</button>
                 </div>
                </div>
            </form>     
        </div>
    </div>
</div>
@endsection
