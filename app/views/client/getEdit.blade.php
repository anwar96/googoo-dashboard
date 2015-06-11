@extends('master')

@section('css')
@stop

@section('javascripts')
@stop

@section('content')
<h3>Edit</h3>
<div class="row">

    <div class="col-xs-6">
        <form role="form" action="{{URL::current()}}" method="POST">

            <div class="form-group @if($errors->has('nama')) has-error  has-feedback @endif">
                <label class="control-label" for="nama">Nama</label>
                <input type="input" class="form-control" id="nama" name="nama" value="{{Input::old('nama', $client->nama)}}">
                @if($errors->has('nama'))
                <p class="help-block">{{$errors->first('nama')}}</p>
                @endif
            </div>

            <div class="form-group @if($errors->has('instansi')) has-error  has-feedback @endif">
                <label class="control-label" for="instansi">Instansi</label>
                <input type="input" class="form-control" id="instansi" name="instansi" value="{{Input::old('instansi', $client->instansi)}}">
                @if($errors->has('instansi'))
                <p class="help-block">{{$errors->first('instansi')}}</p>
                @endif
            </div>

            <div class="form-group @if($errors->has('email')) has-error  has-feedback @endif">
                <label class="control-label" for="email">Email</label>
                <input type="input" class="form-control" id="email" name="email" value="{{Input::old('email', $client->email)}}">
                @if($errors->has('email'))
                <p class="help-block">{{$errors->first('email')}}</p>
                @endif
            </div>

            <div class="form-group @if($errors->has('telp')) has-error  has-feedback @endif">
                <label class="control-label" for="telp">Telp</label>
                <input type="input" class="form-control" id="telp" name="telp" value="{{Input::old('telp', $client->telp)}}">
                @if($errors->has('telp'))
                <p class="help-block">{{$errors->first('telp')}}</p>
                @endif
            </div>

            <div class="form-group @if($errors->has('alamat')) has-error  has-feedback @endif">
                <label class="control-label" for="alamat">Alamat</label>
                <input type="input" class="form-control" id="alamat" name="alamat" value="{{Input::old('alamat', $client->alamat)}}">
                @if($errors->has('alamat'))
                <p class="help-block">{{$errors->first('alamat')}}</p>
                @endif
            </div>


            <button type="submit" class="btn btn-info">Submit</button>
        </form>
    </div>
</div>
@stop