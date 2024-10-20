@extends('main')
@section("container")
<section class="flex justify-between w-3/4 mx-auto mt-16">
    <div class="flex flex-col gap-4">
        <p class="text-5xl font-semibold">New task?</p>
        <p class="text-xl">Fill the task details first.</p>
    </div>
    <form action="{{ url('todo') }}" method="POST" class="flex flex-col gap-4 w-1/2">
        @csrf
        <!-- Task input -->
        <input type="text" name="task" class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2" placeholder="Your Task">

        <!-- Subject or Topic input -->
        <input type="text" name="subject" class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2" placeholder="Subject or Topic">

        <!-- Due Date input -->
        <input type="text" name="due_date" class="w-full px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2" placeholder="Due Date">

        <!-- Description input (textarea) -->
        <textarea name="description" class="w-full h-56 px-4 py-4 rounded-xl border-gray-400 focus:border-gray-500 focus:outline-none border-2" placeholder="Fill the description"></textarea>

        <!-- Submit and Back buttons -->
        <div class="flex gap-2">
            <button class=" bg-blue-400 w-fit px-12 py-3 rounded-full text-white font-medium" type="submit">Submit</button>
            <a class="border-2 border-slate-400 w-fit px-8 py-3 rounded-full text-blue-400 font-medium" href="/todo">Back</a>
        </div>
    </form>

</section>



<!--<div class="card">
    <div class="card-header"></div>
    <div class="card-body">
        <form action='{{ url("todo") }}' method="POST">
            @csrf
            <label for="">Judul</label><br>
                <input type="text" name="task" class="form-control" placeholder="Add your task"><br>
                <label for="">Author</label><br>
                <input type="text" name="author" class="form-control" placeholder="Add your task"><br>
                <label for="">Penerbit</label><br>
                <input type="text" name="penerbit" class="form-control" placeholder="Add your task"><br>
                <label for="">Sinopsis</label><br>
                <input type="text" name="sinopsis" class="form-control" placeholder="Add your task"><br>
                <button class="btn btn-outline-secondarty" type="submit">Add</button>
        </form>
    </div>
</div>-->