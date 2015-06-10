@extends('master')

@section('css')
@stop

@section('javascripts')
@stop

@section('content')
<h3>Adlibs</h3>
<div class="row">
    <div class="col-md-3" style="margin-bottom:20px;">
        <a href="{{URL::to('adlibs/add')}}" class="btn btn-block btn-info">add new</a>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <form id="search-form" method="GET" action="{{URL::to('adlibs')}}">
                    <div class="input-group custom-search-form">
                        <input type="text" name="q" value="{{Input::get('q')}}" class="form-control"  placeholder="search adlibs" id="search-query">
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
                        <th>Adlibs</th>
                        <th class="col-xs-3">genre</th>
                        <th class="col-xs-1">count</th>
                        <th class="col-xs-1">status</th>
                        <th class="col-xs-2">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($adlibs as $lib)
                    <tr>
                        <td>
                            <p>
                                {{$lib->text}}
                            </p>
                        </td>
                        <td>{{$lib->genre}}</td>
                        <td>{{$lib->count}} x</td>
                        <td>{{$lib->status}}</td>
                        <td class="text-right">
                            <a href="{{URL::to('adlibs/edit/'.$lib->id)}}" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a href="{{URL::to('adlibs/delete/'.$lib->id)}}" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$adlibs->appends(array('q' => Input::get('q')))->links()}}
    </div>
</div>

@stop