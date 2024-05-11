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
            <td>
                @if (!is_null($stack->category))
                    {{ $stack->category->title }}
                @else
                    <span style="color:grey;">None</span>
                @endif
            </td>
            <td><a href="{{ '' }}" class="btn btn-primary disabled">Edit</a></td>
            <td>
                <form action="{{ route('stacks.destroy', $stack->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm"
                    onclick="return confirm('Are you sure you want to delete this?');"
                    type="submit" >Delete</button>
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

@stop
