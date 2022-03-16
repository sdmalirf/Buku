@extends('main')
@section("container")


@if (session('success'))
<div class="alert alert-success" style="position: fixed;
    top: 0;
    left: 0;
    width: 20%;">
    <strong>Berhasi!</strong> Data kamu telah ditambahkan.
    <p>{{ session('success') }}</p>
  </div>
@endif

@if ($errors->any())
<div class="alert alert-success style='position: fixed;
    top: 0;
    left: 0;
    width: 20%;'">
    <strong>Gagal!</strong> Coba cek kembali!
    <p>{{ session('success') }}</p>
  </div>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
  </div>
</div>
@endif

<div>
    <div class="card">
        <div class="card-header" style="background-color: #C8C6C6; font-family:Arial;">Daftar Buku</div>
        <div class="card-body">
            <a href="{{ url('/todo/create') }}" class="btn btn-success btn-sm" title="Add New Contact" style="margin-bottom: 10px;">
                <i class="fa fa-plus" aria-hidden="true"></i> Tambah
             </a>
            
            <ul class="list-group">
            @foreach ($todos as $todo)  
                <li class="list-group-item" style="margin-bottom: 20px; border:2px solid black; border-radius:10px;" >
                    <p style="text-align:center; font-size:20px; font-family:arial; font-weight:5px;">{{ $todo->task }}</p>
                        <div class="row">
                            <div class="col">
                                <a href="{{ url('/todo/' . $todo->id) }}" class="btn btn-info">Detail</a>
                            </div>
                            <div class="col">
                                <a href="todo/{{ $todo->id }}/edit" class="btn btn-warning">Ubah</a>
                            </div>
                            <div class="col">
                                <form action="{{ url('todo',$todo->id) }}" method="POST">
                                    @csrf
                                    @method("Delete")
                                <button class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                </li>
            @endforeach
            </ul>
    </div>
    </div>
</div>




@endsection