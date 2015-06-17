@extends('master')

@section('css')
<link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}"/>
@stop

@section('javascripts')
<script type="text/javascript" src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    // setup autocomplete function pulling from currencies[] array
    $('.autocomplete').autocomplete({
        source: "{{URL::to('genre/genrelist')}}",
        minLength: 2,
        select: function (event, data) {
            detail = data.item;
            $('.genre').val(detail.data);
        },
        response: function (event, ui) {
            if (ui.content == null) {
                var noResult = {value: "No results found", label: "No results found"};
                ui.content = noResult;
                console.log(ui);
            }
        }
    });

    $('.autocomplete2').autocomplete({
        source: "{{URL::to('artist/artistlist')}}",
        minLength: 2,
        select: function (event, data) {
            detail = data.item;
            $('.artist_id').val(detail.data);
        },
        response: function (event, ui) {
            if (ui.content == null) {
                var noResult = {value: "No results found", label: "No results found"};
                ui.content = noResult;
                console.log(ui);
            }
        }
    });
});
</script>
@stop

@section('content')
<h3>Add Song</h3>
<div class="row">

    <div class="col-xs-6">
        <form role="form" action="{{URL::current()}}" method="POST">
            <div class="form-group @if($errors->has('title')) has-error  has-feedback @endif">
                <label class="control-label" for="title">Title</label>
                <input type="input" class="form-control" id="title" name="title" value="{{Input::old('title')}}">
                @if($errors->has('title'))
                <p class="help-block">{{$errors->first('title')}}</p>
                @endif
            </div>


            <div class="form-group @if($errors->has('artist')) has-error  has-feedback @endif">
                <label class="control-label" for="artist">artist</label>
                <input type="input" class="form-control autocomplete2" id="artist" name="artist" value="{{Input::old('artist')}}">
                <input type="hidden" class="artist_id" name="artist_id" value="{{Input::old('artist_id')}}"/>
                @if($errors->has('artist'))
                <p class="help-block">{{$errors->first('artist')}}</p>
                @endif
            </div>


            <div class="form-group @if($errors->has('album')) has-error  has-feedback @endif">
                <label class="control-label" for="album">album</label>
                <input type="input" class="form-control" id="album" name="album" value="{{Input::old('album')}}">
                @if($errors->has('album'))
                <p class="help-block">{{$errors->first('album')}}</p>
                @endif
            </div>


            <div class="form-group @if($errors->has('release_year')) has-error  has-feedback @endif">
                <label class="control-label" for="release_year">release_year</label>
                <input type="input" class="form-control" id="release_year" name="release_year" value="{{Input::old('release_year')}}">
                @if($errors->has('release_year'))
                <p class="help-block">{{$errors->first('release_year')}}</p>
                @endif
            </div>


            <div class="form-group @if($errors->has('genre')) has-error  has-feedback @endif">
                <label class="control-label" for="genre">genre</label>
                <input type="input" class="form-control autocomplete" id="genre" name="genre" value="{{Input::old('genre')}}">
                <input type="hidden" class="genre" name="genre_id" value="{{Input::old('genre_id')}}"/>
                @if($errors->has('genre'))
                <p class="help-block">{{$errors->first('genre')}}</p>
                @endif
            </div>

            <div class="form-group @if($errors->has('bpm')) has-error  has-feedback @endif">
                <label class="control-label" for="bpm">bpm</label>
                <input type="input" class="form-control" id="bpm" name="bpm" value="{{Input::old('bpm')}}">
                @if($errors->has('bpm'))
                <p class="help-block">{{$errors->first('bpm')}}</p>
                @endif
            </div>



            <button type="submit" class="btn btn-info">Submit</button>
        </form>
    </div>
</div>
@if($errors->all())
{{s($errors->all())}}
@endif
@stop