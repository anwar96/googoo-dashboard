@extends('master')

@section('css')
@stop

@section('javascripts')
@stop

@section('content')
<h3>Import Lagu2 Baru</h3>
<div class="row">
    <div class="col-xs-9">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Artist</th>
                    <th>genre</th>
                    <th>year</th>
                    <th>bpm</th>
                </tr>
            </thead>
            <tbody>
                @foreach($songs as $song)
                <tr>
                    <td>{{$song->title}}</td>
                    <td>{{HTML::link('artist/show/'.$song->id,$song->artist)}}</td>
                    <td>{{HTML::link('genre/edit/'.$song->id,$song->genre)}}</td>
                    <td>{{$song->year_release}}</td>
                    <td>{{$song->bpm}}</td>
                    <td>{{$song->updated}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>
@stop