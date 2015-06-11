@extends('master')

@section('css')
@stop

@section('javascripts')
@stop

@section('content')
<h3>Genre Database</h3>
<div class="row">

    <div class="col-xs-9">

        <div class="panel panel-default">
            <div class="panel-heading">
                <form id="search-form" method="GET" action="{{URL::to('genre')}}">
                    <div class="input-group custom-search-form">
                        <input type="text" name="q" value="{{Input::get('q')}}" class="form-control"  placeholder="search genre by name" id="search-query">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit" id="search-button">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div><!-- /input-group -->
                </form>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Genre</th>
                        <th>Jumlah Artis</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($genres as $genre)
                    <tr>
                        <td>
                            <strong>{{$genre->name}}</strong>
                        </td>
                        <td>{{$genre->artists->count()}}</td>
                        <td>
                            <a href="{{URL::to('genre/edit/'.$genre->id)}}" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a href="{{URL::to('genre/delete/'.$genre->id)}}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$genres->appends(array('q' => Input::get('q')))->links()}}
    </div>



    <div class="col-xs-3">
    </div>
</div>

@stop