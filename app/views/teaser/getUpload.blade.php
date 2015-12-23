@extends('master')

@section('css')
@stop

@section('javascripts')
@stop

@section('content')
<h3>Upload New Teaser</h3>
<div class="row">

    <div class="col-xs-6">
        {{Form::open(array('url' => 'teaser/upload', 'files' => true))}}

        <div class="form-group">
            <label for="file">Upload the file</label>
            <input type="file" id="file" name="file">
            <p class="help-block">gambar </p>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
        {{Form::close()}}
    </div>
</div>

@stop