@extends('layouts.default')
@section('content')

@if(session()->has('exist'))
<p class="alert alert-success"> {{ session()->get('message') }}</p>
@endif


<div class="container h-100 mt-5">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="col-10 col-md-8 col-lg-6">
        <h3>Edit Stack</h3>
        <form action="{{ route('stacks.update', [$stack->id]) }}" method="post">
          @csrf
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" value="{{$stack->title}}" class="form-control" id="title" name="title" required>
            @error('title')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" value="{{$stack->title}}" id="description" name="description" rows="2"></textarea>
          </div>
          <div class="form-group">
            <label for="category">Category</label>
            <select name="category_id" class="form-select" aria-label=".form-select">
                <option value="" selected>Choose the category</option>
                @foreach ($categories as $key => $category)
                  <option value="{{ $category->id }}"
                    {{ $stack->category->id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                @endforeach
            </select>
            @error('category_id')
              <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>

          <br>
          <button type="submit" class="btn btn-primary">Create Post</button>
        </form>
      </div>
    </div>
  </div>
  
  @stop
