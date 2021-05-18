@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                <p class="float-left">Create New Blog</p>
                    <a href="{{route('blog.index')}}" class="float-right btn btn-sm btn-secondary">Back</a></div>
@if($errors)
    @foreach($errors as $error)
        {{$error}}
    @endforeach
@endif
                <div class="card-body">
                <form method="POST" action="{{ route('blog.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}"  autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="body" class="col-md-4 col-form-label text-md-right">Body</label>

                            <div class="col-md-6">
                                <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror" cols="30" rows="10"></textarea>
                                @error('body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <label for="tags" class="col-md-4 col-form-label text-md-right">Tags</label>

                       
                            <div class="col-md-6">
                               <select name="tag_ids[]" class="form-control @error('tag_ids') is-invalid @enderror" multiple>
                                    <option selected disabled >Select Blog Tags</option>
                                    @foreach($tags as $tag)
                                    <option  
                                    value="{{$tag->id}}">{{$tag->name}}</option>    
                                    @endforeach
                               </select>
                            
                                @error('tag_ids')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">Image</label>

                       
                            <div class="col-md-6">
                               <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">Published At</label>

                       
                            <div class="col-md-6">
                              
                               <input type="datetime-local" name="published_at" class="form-control @error('published_at') is-invalid @enderror">
                                @error('published_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                 
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                   Create
                                </button>

                             
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
