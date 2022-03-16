@extends('main')
@section("container")
 
 

<div class="card" style="width: 50rem; margin-left:20%; margin-top:20px;">
    <div class="card-header">Detail</div>
    <div class="card-body">
    <div class="card-title">
        <h5 class="card-text" style="font-family:montsettrat; float:right;">{{ $todos->penerbit }}</h5>
        <h4 class="card-text" style="font-family:'segoe ui'; ">{{ $todos->task }}</h4>
        <p class="card-text" style="font-family:montsettrat-semibold;">{{ $todos->author }}</p>
        <p class="card-text" style="text-align: justify;"> {{ $todos->sinopsis }}</p> 
        <a class="btn btn-outline-warning" href="/todo">back</a>
    </div>
    </div>
</div>

