@extends('master')

@section('css')
@stop

@section('javascripts')
@stop

@section('content')
<h3>Create New Banner</h3>
<div class="row">

    <div class="col-xs-6">
        {{Form::open(array('url' => 'banner', 'files' => true))}}
        <div class="form-group">
            <label for="name">Name</label>
            <input type="input" class="form-control" id="name" name="name" placeholder="name banner">
        </div>
        
        <div class="form-group">
            <label for="url">Url</label>
            <input type="input" class="form-control" id="url" name="url" placeholder="url">
        </div>

        <div class="form-group">
            <label for="file">File input</label>
            <input type="file" id="file" name="file">
            <p class="help-block">gambar saja</p>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
        {{Form::close()}}
    </div>
</div>

@stop