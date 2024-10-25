<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Information; // Import the Information model

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Ambil inputan dari query string
        $statusFilter = $request->input('status');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $search = $request->input('search');

        // Mulai query ke model Todo
        $query = Todo::query();

        // Filter berdasarkan rentang tanggal penerbit jika ada
        if ($startDate && $endDate) {
            $query->whereBetween('deadline', [$startDate, $endDate]);
        }

        // Filter berdasarkan pencarian kata kunci
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('task', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($statusFilter) {
            $query->whereHas('information', function ($q) use ($statusFilter) {
                if ($statusFilter === 'done') {
                    $q->where('is_done', true);
                } elseif ($statusFilter === 'not_done') {
                    $q->where('is_done', false);
                }
            });
        }

        // Jalankan query dan ambil hasilnya
        $todos = $query->with('information')->get(); // Eager load information

        // Pisahkan data menjadi pinned dan regular
        $pinnedTodos = $todos->filter(function ($todo) {
            return $todo->information && $todo->information->is_pinned;
        });
        $regularTodos = $todos->filter(function ($todo) {
            return $todo->information && !$todo->information->is_pinned;
        });

        // Kembalikan view dengan data yang sudah difilter
        return view("todo", compact('pinnedTodos', 'regularTodos', 'todos'));
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
            'matkul' => 'required',
            'deadline' => 'required',
            'deskripsi' => 'required'
        ]);

        // Create the Todo item
        $todo = Todo::create($request->all());

        // Create corresponding Information entry
        Information::create([
            'todo_id' => $todo->id,
            'is_pinned' => false,
            'is_done' => false // Set default as not done
        ]);

        return redirect('/todo')->with('success', 'Task created successfully!');
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
            'matkul' => 'required',
            'deadline' => 'required',
            'deskripsi' => 'required'
        ]);

        $todo = Todo::find($id);
        $todo->update($request->all());

        // Update the corresponding Information entry
        $information = Information::where('todo_id', $id)->first();
        if ($information) {
            $information->save(); // If you need to save any changes, otherwise this is not necessary
        }

        return redirect("todo")->with('success', 'Task updated successfully!');
    }

    /**
     * Mark the specified task as done.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsDone($id)
    {
        $information = Information::where('todo_id', $id)->first();
        if ($information) {
            $information->is_done = true; // Set is_done to true
            $information->save();
        }

        return redirect()->back()->with('success', 'Task marked as done successfully!');
    }


    /**
     * Pin the specified task.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pin($id)
    {
        $information = Information::where('todo_id', $id)->first();
        if ($information) {
            $information->is_pinned = true; // Set is_pinned to true
            $information->save();
        }

        return redirect()->back()->with('success', 'Task pinned successfully!');
    }

    /**
     * Unpin the specified task.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unpin($id)
    {
        $information = Information::where('todo_id', $id)->first();
        if ($information) {
            $information->is_pinned = false; // Set is_pinned to false
            $information->save();
        }

        return redirect()->back()->with('success', 'Task unpinned successfully!');
    }

    /**
     * Search for tasks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Cari task dan deskripsi yang cocok
        $todos = Todo::where('task', 'like', "%{$query}%")
            ->orWhere('deskripsi', 'like', "%{$query}%")
            ->with('information') // Eager load information
            ->get(['id', 'task', 'deskripsi']); // Ambil hanya kolom yang dibutuhkan

        return response()->json($todos);
    }


    public function filter(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $statusFilter = $request->input('status');

        // Initialize the query
        $query = Todo::query();

        // Add filtering for deadline range if provided
        if ($startDate && $endDate) {
            $query->whereBetween('deadline', [$startDate, $endDate]);
        }

        // Filter based on status if provided
        if ($statusFilter) {
            $query->whereHas('information', function ($q) use ($statusFilter) {
                if ($statusFilter === 'done') {
                    $q->where('is_done', true);
                } elseif ($statusFilter === 'not_done') {
                    $q->where('is_done', false);
                }
            });
        }

        // Execute the query to get the todos
        $todos = $query->get();

        // Load the related information to get pinned status and completion status
        $todos->load('information');

        // Separate pinned and regular todos
        $pinnedTodos = $todos->where('information.is_pinned', true);
        $regularTodos = $todos->where('information.is_pinned', false);

        // Return the view with separated data
        return view('todo', compact('pinnedTodos', 'regularTodos', 'todos'));
    }



    public function destroy($id)
    {
        $todo = Todo::find($id);

        if ($todo) {
            $todo->delete(); // Delete the todo
        }

        return back()->with('success', 'Task deleted successfully!');
    }
}
