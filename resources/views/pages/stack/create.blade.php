@extends('layouts.default')
@section('content')

{{-- @if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif
@if (Session::has('exist'))
   <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
@error('exist')
              <div class="text-danger">{{ Session::get() }}</div>
            @enderror
@if (Session::has('exist'))
    <div class="alert alert-success">
        <ul>
            <li>{{ Session::get('exist') }}</li>
        </ul>
    </div>
@endif --}}
@if(session()->has('exist'))
<p class="alert alert-success"> {{ session()->get('message') }}</p>
@endif


<div class="container h-100 mt-5">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="col-10 col-md-8 col-lg-6">
        <h3>Add a Stack</h3>
        <form action="{{ route('stacks.store') }}" method="post">
          @csrf
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
            @error('title')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="2"></textarea>
          </div>
          <div class="form-group">
            <label for="category">Category</label>
            <select name="category_id" class="form-select" aria-label=".form-select">
                <option value="" selected>Choose the category</option>
                @foreach ($categories as $key => $category)
                  <option value="{{ $category->id }}"
                    {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
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
