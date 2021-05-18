@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><p class="float-left">My Blogs</p>
                    <a href="{{route('blog.create')}}" class="float-right btn btn-sm btn-success">Create</a></div>

                <div class="card-body row">
             
                   
                        @foreach($blogs as $blog)
                     
                        <a href="{{asset('/blog/'.$blog->slug)}}" class="d-flex pb-2 col-10" >
                        <img src="{{ asset('/storage/'.$blog->image) }}" width="50px" alt="">
                        <p class="ml-4" >{{$blog->title}}</p> </a>
                       
                        
                        <div class="float-right">
                                <a class="btn btn-sm btn-warning" href="{{'/blog/'.$blog->slug.'/edit'}}">Edit</a>
                                <a class="btn btn-sm btn-danger" href="{{'/blog/'.$blog->slug.'/edit'}}"
                                onclick="event.preventDefault();
                                                     document.getElementById('delete-form-{{$blog->id}}').submit();">Delete</a>
                            </div>
                            <form id="{{'delete-form-'.$blog->id}}" action="{{ route('blog.destroy',$blog->slug) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('delete')
                                    </form>
                       

                     
                      
                         
                            <form id="{{'delete-form-'.$blog->id}}" action="{{ route('blog.destroy',$blog->slug) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('delete')
                                    </form>
                    @endforeach
                  
                     
               
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
