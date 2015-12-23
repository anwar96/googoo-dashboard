@extends('master')

@section('css')
@stop

@section('javascripts')
@stop

@section('content')
<h3>Create New Program</h3>
<div class="row">

    <div class="col-xs-6">
        @if($errors->all())
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                @foreach($errors->all() as $e)
                <li>{{$e}}</li>
                @endforeach
            </ul>
        </div>
        @endif
        {{Form::open(array('url' => 'weeklyprogram/store'))}}
        <div class="form-group">
            <label for="name">Weekly Program</label>
            <input type="input" class="form-control" id="name" name="name" placeholder="name of program">
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group">
                    <label for="day">Day</label>
                    <select name="day" id="days" class="form-control">
                        @foreach(array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu') as $k => $v)
                          <option value="{{$k}}">{{$v}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="col-xs-3">
                <div class="form-group">
                    <label for="from">From</label>
                    <select name="from" id="from" class="form-control">
                        @foreach(range(1,24) as $k => $v)
                          <option value="{{$v}}">{{date("g A", strtotime("$v:00"))}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-xs-3">
                <div class="form-group">
                    <label for="to">To</label>
                    <select name="to" id="to" class="form-control">
                        @foreach(range(1,24) as $k => $v)
                          <option value="{{$v}}">{{date("g A", strtotime("$v:00"))}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-default btn-info ">Submit</button>
        {{Form::close()}}
    </div>
</div>

@stop