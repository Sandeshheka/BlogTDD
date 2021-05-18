@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <p class="float-left">{{$blog->title}}</p>
                    <div class="float-right">
                    <p >Created By {{$blog->user->name}}</p>
                    <a class="btn btn-sm btn-warning" href="{{'/blog/'.$blog->slug . '/edit'}}">Edit</a>
                    </div>
                 
                </div>

                <div class="card-body">
                    <img src="{{ asset('/storage/'.$blog->image) }}"  width="20%" alt="">
                    <p>{{$blog->body}}</p>
                    
                    Tags:
                    @foreach($blog->tags as $tag)
                        <button class="btn btn-info btn-sm text-white">{{$tag->name}}</button>
                    

                    @endforeach
                    <br>
           
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


