@extends('main')
@section("container")





    <div class="card" style="width: max-content; margin: 10px auto 10px;">
        <div class="card-header">Tambah</div>
        <div class="card-body">
        <form action='{{ url("todo") }}' method="POST">
            @csrf
                <label for="">Judul</label><br>
                <input type="text" name="task" class="form-control" placeholder="Masukan Judul"><br>
                <label for="">Author</label><br>
                <input type="text" name="author" class="form-control" placeholder="Masukan Author"><br>
                <label for="">Penerbit</label><br>
                <input type="text" name="penerbit" class="form-control" placeholder="Masukan Penerbir"><br>
                <label for="">Sinopsis</label><br>
                <textarea name="sinopsis" id="" cols="50" rows="5" placeholder=" Masukan Sinopsis"></textarea><br><br>
                <button class="btn btn-outline-warning" type="submit">Submit</button>
                <a class="btn btn-outline-warning" href="/todo">back</a>
        </form>
        </div>
    </div>



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
