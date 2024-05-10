@extends('layouts.default')
@section('content')
<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Title</th>
            <th>img</th>
            <th>Category</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($stacks as $stack)
        <tr>
            <td>{{ $stack->title }}</td>
            <td>{{ $stack->description }}</td>
            <td>{{$stack->category->title}}</td>
            <td><a href="{{ '' }}" class="btn btn-primary btn-sm">Edit</a></td>
            <td>
                <form action="{{ '' }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Title</th>
            <th>img</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>
<div class="container mt-5">
    <div class="row">
@foreach ($stacks as $stack)
<div class="col-sm">
    <div class="card">
    <div class="card-header">
        <h5 class="card-title">{{ $stack->title }}</h5>
    </div>
    <div class="card-body">
        <p class="card-text">{{ $stack->description }}</p>
    </div>
    <div class="card-footer">
        <div class="row">
        <div class="col-sm">
            <a href="{{ '' }}" class="btn btn-primary btn-sm">Edit</a>
        </div>
        <div class="col-sm">
            <form action="{{ '' }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
        </div>
    </div>
    </div>
</div>
@endforeach
</div>
</div>

{{-- <div>
    <h3>Stacks</h3>
    <ul>
        @foreach($stacks as $stack)
        <li>{{ $stack->title }} ({{$stack->category->title}})</li>
        @endforeach
    </ul>
</div> --}}

@stop

