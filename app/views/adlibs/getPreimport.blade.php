@extends('master')

@section('css')
@stop

@section('javascripts')
@stop

@section('content')
<h3>Import Lagu2 Baru, Hanya 20 Lagu Teratas yang akan diimport</h3>
<div class="row">

    <div class="col-xs-12">
        <ul class="list-group">
            <li class="list-group-item">1. Siapkan data lagu anda melalui SAM Broadcaster</li>
            <li class="list-group-item">2. Lewat SAM Broadcaster, Import dalam bentuk CSV</li>
            <li class="list-group-item">3. Buka <a class="" target="_blank" href="https://docs.google.com/spreadsheet/pub?key=0Aq79H_FkDfcZdGZWQk9lQU1jZVY5WVB4UVduZV80UWc">Google Spreadsheet ini</a></li>
            <li class="list-group-item">4. Copy pastekan sesuai data yang CSV dari SAM Broadcaste, atau isi sendiri juga boleh</li>
            <li class="list-group-item">5. Klik <a href="{{URL::to('song/import')}}">disini</a> untuk mengimport kalo sudah yakin datanya benar</li>
            <li class="list-group-item">6. harus sabar.. kecepatan koneksi dan besar data sangat berpengaruh</li>
            <li class="list-group-item">7. atau klik <a href="{{URL::to('song/add')}}">disini</a> untuk add new song secara manual</li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-xs-4 col-xs-offset-4">

        <a href="{{URL::to('song/import')}}" class="btn btn-danger btn-block btn-lg">IMPORT!!!</a>
    </div>
</div>
@stop