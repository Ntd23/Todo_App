<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodosRequest;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller {
    public function index() {
        $todos = Todo::all();
        return view('todos.index', compact('todos'));
    }
    public function create() {
        return view('todos.create');
    }
    public function store(TodosRequest $request) {
        Todo::create([
            'title'       => $request->title,
            'description' => $request->description,
            'is_complete' => 0
        ]);

        $request->session()->flash('alert-success', 'Todo Created Successfully');
        return to_route('todos.index');
    }
    public function show($id) {
        $todo = Todo::find($id);
        if(!$todo) {
            request()->session()->flash('alert-success', 'Unable to locate to Todo');
            return to_route('todos.index')->withErrors(['error' => 'Unable to locate to Todo']);
        }
        return view('todos.show', compact('todo'));
    }
    public function edit($id) {
        $todo = Todo::find($id);
        if(!$todo) {
            request()->session()->flash('alert-success', 'Unable to locate to Todo');
            return to_route('todos.index')->withErrors(['error' => 'Unable to locate to Todo']);
        }
        return view('todos.edit', compact('todo'));
    }
    public function update(TodosRequest $request) {
        $todo= Todo::find($request->todo_id);
        if(!$todo) {
            request()->session()->flash('alert-success', 'Unable to locate to Todo');
            return to_route('todos.index')->withErrors(['error' => 'Unable to locate to Todo']);
        }

        $todo->update([
            'title'=> $request->title,
            'description'=>$request->description,
            'is_completed'=>$request->is_completed,
        ]);
        $request->session()->flash('alert-info', 'Todo Updated Successfully');
        return to_route('todos.index');
    }
    public function destroy(Request $request) {
        $todo = Todo::find($request->todo_id);
        if(!$todo) {
            request()->session()->flash('alert-success', 'Unable to locate to Todo');
            return to_route('todos.index')->withErrors(['error' => 'Unable to locate to Todo']);
        }
        $todo->delete();
        $request->session()->flash('alert-success', 'Todo Deleted Successfully');
        return to_route('todos.index');
    }
}
