@extends('master')

@section('css')
@stop

@section('javascripts')
@stop

@section('content')
<h3>Weekly Programs</h3>
<div class="row">

    <div class="col-xs-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{URL::to('weeklyprogram/create')}}" class="btn btn-xs btn-info">add program</a>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="col-xs-2">Day</th>
                        <th class="col-xs-2">Hour</th>
                        <th class="col-xs-2">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($programs) && count($programs) > 0) 
                        @foreach($programs as $program)
                        <tr>
                            <td>{{$program->name}}</td>
                            <td>{{Weeklyprogram::getDay($program->day)}}</td>
                            <td>{{$program->hour}}</td>
                            <td>
                                <a href="{{URL::to('weeklyprogram/edit/'.$program->id)}}" class="btn btn-info btn-xs">Edit</a>
                                 <a href='{{URL::to("weeklyprogram/destroy/$program->id?_token=".csrf_token())}}' class="btn btn-danger btn-xs">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
            {{$programs->appends(array('q' => Input::get('q')))->links()}}

    </div>
</div>

@stop