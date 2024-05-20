@extends('layouts.default')
@section('content')
<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Title</th>
            <th>Img</th>
            <th>Category</th>
            <th>Is Main</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($stacks as $stack)
        <tr>
            <td>{{ $stack->title }}</td>
            <td>{{ $stack->img }}</td>
            <td>
                @if (!is_null($stack->category))
                    {{ $stack->category->title }}
                @else
                    <span style="color:grey;">None</span>
                @endif
            </td>
            <td>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckCheckedDisabled" {{ $stack->is_main ? 'checked' : '' }}  disabled>
                    <label class="form-check-label" for="flexSwitchCheckCheckedDisabled">
                        @if ($stack->is_main)
                            <span style="color: green">True</span>
                        @else
                            <span style="color: red">False</span>
                        @endif
                    </label>
                </div>
            </td>
            <td><a href="{{ route('stacks.edit', [$stack->id]) }}" class="btn btn-primary">Edit</a></td>
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
