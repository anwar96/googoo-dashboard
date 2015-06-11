@extends('master')

@section('css')
@stop

@section('javascripts')
@stop

@section('content')
<h3>Client</h3>
<div class="row">
    <div class="col-md-3" style="margin-bottom:20px;">
        <a href="{{URL::to('client/add')}}" class="btn btn-block btn-info">add new</a>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <form id="search-form" method="GET" action="{{URL::to('client')}}">
                    <div class="input-group custom-search-form">
                        <input type="text" name="q" value="{{Input::get('q')}}" class="form-control"  placeholder="search Client" id="search-query">
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
                        <th>Nama</th>
                        <th>Instansi</th>
                        <th>Email</th>
                        <th>Telp</th>
                        <th>Alamat</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $c)
                    <tr>
                        <td>{{$c->nama}}</td>
                        <td>{{$c->instansi}}</td>
                        <td>{{$c->email}}</td>
                        <td>{{$c->telp}}</td>
                        <td>{{$c->alamat}}</td>
                        <td class="text-right">
                            <a href="{{URL::to('client/edit/'.$c->id)}}" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a href="{{URL::to('client/delete/'.$c->id)}}" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$clients->appends(array('q' => Input::get('q')))->links()}}
    </div>
</div>

@stop