@extends('layouts.app')

@section('styles')
<style>
    #outer {
        width: 100%;
        text-align: center;
    }
    .inner {
        display: inline-block;
    }
</style>

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (Session::has('alert-success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('alert-success') }}
                            </div>
                        @endif
                        @if (Session::has('alert-info'))
                            <div class="alert alert-info" role="alert">
                                {{ Session::get('alert-info') }}
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        <a href="{{ route('todos.create') }}" class="btn btn-sm btn-info">Create Todo</a>

                        @if (count($todos) > 0)
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Completed</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($todos as $todo)
                                        <tr>
                                            <td>{{ $todo->title }}</td>
                                            <td>{{ $todo->description }}</td>
                                            <td>
                                                @if ($todo->is_completed == 1)
                                                    <a href="" class="btn btn-sm btn-success">completed</a>
                                                @else
                                                    <a href="" class="btn btn-sm btn-danger">in completed</a>
                                                @endif
                                            </td>
                                            <td id="outer">
                                                <a href="{{ route('todos.show', $todo->id) }}" class="inner btn btn-sm btn-success">View</a>
                                                <a href="{{ route('todos.edit', $todo->id) }}" class="inner btn btn-sm btn-info">Edit</a>
                                                <form method="POST" action="{{ route('todos.destroy') }}" class="inner">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="todo_id" value="{{ $todo->id }}">
                                                    <input type="submit" class="btn btn-danger btn-sm" value="Delete">
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h4>No todos are created yet</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
