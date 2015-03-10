@extends('master')

@section('css')
@stop

@section('javascripts')
@stop

@section('content')
<h3>Banners</h3>
<div class="row">

    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{URL::to('banner/create')}}" class="btn btn-xs btn-info">add banner</a>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Picture</th>
                        <th>Url</th>
                        <th class="col-xs-2">Status</th>
                        <th class="col-xs-2">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $banner)
                    <tr>
                        <td>
                            <div class="media">
                                <a class="pull-left" href="#">
                                    <img class="media-object" src="{{$banner->picture}}" alt="..." width="120">
                                </a>
                                <div class="media-body">
                                    <p>{{$banner->name}}</p>
                                </div>
                            </div>
                        </td>
                        <td><a target="_blank" href="{{$banner->image_data}}">{{$banner->image_data}}</a></td>
                        <td><a href="{{URL::to('banner/'.$banner->id.'/edit')}}">{{$banner->is_active == 'true' ? 'active': 'not-active'}}</a></td>
                        <td>
                            <a href="{{URL::to('banner/'.$banner->id)}}" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{$banners->links()}}
    </div>
</div>

@stop