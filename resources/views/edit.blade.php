@extends('main')
@section("container")

@if ($errors->any())
<div class="alert alert-danger" style='position: fixed;
    top: 0;
    left: 0;
    width: 20%;'>
    <strong>Gagal!</strong> Coba cek kembali!
  </div>
        @foreach ($errors->all() as $error)
        @endforeach
    </ul>
  </div>
</div>
@endif



<div class="card" style="width: max-content; margin: 5px auto ; ">
    <div class="card-header">Edit</div>
    <div class="card-body">
    <form action='{{ url("todo",$todo->id) }}' method="POST">
        @csrf
        @method("PUT")
            <label for="">Judul</label><br>
            <input type="text" name="task" class="form-control" placeholder="Masukan Judul" value="{{$todo->task}}"><br>
            <label for="">Author</label><br>
            <input type="text" name="author" class="form-control" placeholder="Masukan Author" value="{{$todo->author}}"><br>
            <label for="">Penerbit</label><br>
            <input type="text" name="penerbit" class="form-control" placeholder="Masukan Penerbit" value="{{$todo->penerbit}}"><br>
            <label for="">Sinopsis</label><br>
            <textarea name="sinopsis" id="" cols="60" rows="5" placeholder="Masukan Sinopsis">{{$todo->sinopsis}}</textarea><br><br>
            <button class="btn btn-outline-warning" type="submit">Edit</button>
            <a class="btn btn-outline-warning" href="/todo">back</a>
    </form>
    </div>
</div>




@endsection