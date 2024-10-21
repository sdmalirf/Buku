<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $statusFilter = $request->input('status');
        $startDate = $request->input('startDate');
        $search = $request->input('search');
        $endDate = $request->input('endDate');

        $query = Todo::query();

        // Filter berdasarkan status (done atau not_done)
        if ($statusFilter === 'done') {
            $query->where('is_done', true);
        } elseif ($statusFilter === 'not_done') {
            $query->where('is_done', false);
        }

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('task', 'like', "%{$search}%")
                    ->orWhere('sinopsis', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan rentang tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('penerbit', [$startDate, $endDate]);
        }



        // Ambil semua todos sesuai dengan filter yang diterapkan
        $todos = $query->get();

        // Pisahkan data menjadi pinned dan regular
        $pinnedTodos = $todos->where('is_pinned', true);
        $regularTodos = $todos->where('is_pinned', false);

        // Kembalikan view dengan data yang sudah dipisahkan
        return view("todo", compact('pinnedTodos', 'regularTodos', 'todos'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required',
            'author' => 'required',
            'penerbit' => 'required',
            'sinopsis' => 'required'

        ]);

        $todo = $request->all();
        $todos = Todo::create($todo);
        return redirect('/todo')->with('success', ' ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = Todo::find($id);
        return view("show")->with('todos', $todo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = Todo::findOrFail($id);
        return view("edit", ["todo" => $todo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'task' => 'required',
            'author' => 'required',
            'penerbit' => 'required',
            'sinopsis' => 'required'
        ]);
        $todo = Todo::find($id)->update($request->all());
        return redirect("todo")->with('success', ' ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);

        $todo->delete();

        return back()->with('success', ' ');
    }

    public function pin($id)
    {
        $todo = Todo::find($id);
        if ($todo) {
            $todo->is_pinned = true; // Set is_pinned ke true
            $todo->save();
        }

        return redirect()->back()->with('success', 'Task pinned successfully!');
    }

    public function unpin($id)
    {
        $todo = Todo::find($id);
        if ($todo) {
            $todo->is_pinned = false; // Set is_pinned ke false
            $todo->save();
        }

        return redirect()->back()->with('success', 'Task unpinned successfully!');
    }

    public function markAsDone($id)
    {
        $todo = Todo::find($id);
        if ($todo) {
            $todo->is_done = true; // Set is_done ke true
            $todo->save();
        }

        return redirect()->back()->with('success', 'Task marked as done successfully!');
    }

    public function filter(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Pastikan menggunakan kolom yang berisi data tanggal
        $todos = Todo::whereBetween('penerbit', [$startDate, $endDate])->get();

        // Pisahkan data menjadi pinned dan regular
        $pinnedTodos = $todos->where('is_pinned', true);
        $regularTodos = $todos->where('is_pinned', false);

        // Kembalikan view dengan data yang sudah dipisahkan
        return view('todo', compact('pinnedTodos', 'regularTodos', 'todos'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Cari task dan sinopsis yang cocok
        $todos = Todo::where('task', 'like', "%{$query}%")
            ->orWhere('sinopsis', 'like', "%{$query}%")
            ->get(['id', 'task', 'sinopsis']); // Ambil hanya kolom yang dibutuhkan

        return response()->json($todos);
    }
}
