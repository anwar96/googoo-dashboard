@extends('master')

@section('css')
@stop

@section('javascripts')
@stop

@section('content')
<h3>Audio Spot</h3>
<div class="row">
    <div class="col-md-3" style="margin-bottom:20px;">
        <a href="{{URL::to('audiospot/add')}}" class="btn btn-block btn-info">add new</a>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <form id="search-form" method="GET" action="{{URL::to('audiospot')}}">
                    <div class="input-group custom-search-form">
                        <input type="text" name="q" value="{{Input::get('q')}}" class="form-control"  placeholder="search audiospots" id="search-query">
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
                        <th>audio spot</th>
                        <th>client</th>
                        <th>type</th>
                        <th>genre</th>
                        <th>count</th>
                        <th>status</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($audiospots as $lib)
                    <tr>
                        <td><p>{{$lib->text}}</p></td>
                        <td>{{$lib->nama.", ".$lib->instansi}}</td>
                        <td>{{$lib->type}}</td>
                        <td>{{($lib->type == 'genre') ? $lib->genre : ""}}</td>
                        <td>{{$lib->count}} x</td>
                        <td>{{$lib->status}}</td>
                        <td class="text-right">
                            <a href="{{URL::to('audiospot/edit/'.$lib->id)}}" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a href="{{URL::to('audiospot/delete/'.$lib->id)}}" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$audiospots->appends(array('q' => Input::get('q')))->links()}}
    </div>
</div>

@stop