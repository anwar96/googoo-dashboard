@extends('master')

@section('css')
<link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}"/>
@stop

@section('content')
<h3>Teaser</h3>
<div class="row">
    <div class="col-md-12">
        
    </div> 
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{URL::to('teaser/upload')}}" class="btn btn-xs btn-info">Add Teaser</a>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Picture</th>
                        <th class="col-xs-2">Status</th>
                        <th class="col-xs-2">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($teasers) && count($teasers) > 0)
                        @foreach($teasers as $teaser)
                        <tr>
                            <td>
                                <div class="media">
                                    <a class="pull-left" href="#">
                                        <img class="media-object" src="{{$teaser->teaser}}" alt="..." width="500">
                                    </a>
                                </div>
                            </td>
                            <td><a href="{{URL::to('teaser/edit/'.$teaser->id)}}">{{$teaser->status == 1 ? 'active': 'not-active'}}</a></td>
                            <td>
                                 <a href='{{URL::to("teaser/destroy/$teaser->id?_token=".csrf_token())}}' class="btn btn-danger btn-xs">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
            {{$teasers->appends(array('q' => Input::get('q')))->links()}}

    </div>
</div>
@if($errors->all())
{{s($errors->all())}}
@endif
@stop