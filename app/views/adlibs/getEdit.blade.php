@extends('master')

@section('css')
<link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}"/>
@stop

@section('javascripts')
<script type="text/javascript" src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }

    $( ".autocomplete" )
      // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
          event.preventDefault();
        }
      })
      .autocomplete({
        source: function( request, response ) {
          $.getJSON( "{{URL::to('genre/genrelist')}}", {
            term: extractLast( request.term )
          }, response );
        },
        search: function() {
          // custom minLength
          var term = extractLast( this.value );
          if ( term.length < 2 ) {
            return false;
          }
        },
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {
          var terms = split( this.value );
          // remove the current input
          terms.pop();
          // add the selected item
          terms.push( ui.item.value );
          // add placeholder to get the comma-and-space at the end
          terms.push( "" );
          this.value = terms.join( ", " );
          return false;
        }
      });

      $('.client').autocomplete({
        source: "{{URL::to('client/clientlist')}}",
        minLength: 2,
        select: function (event, data) {
            detail = data.item;
            $('.client_id').val(detail.data);
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
<h3>Edit</h3>
<div class="row">

    <div class="col-xs-6">
        <form role="form" action="{{URL::current()}}" method="POST">

            <div class="form-group @if($errors->has('client_id')) has-error  has-feedback @endif">
                <label class="control-label" for="client">client</label>
                <input type="input" class="form-control client" id="client" name="client" value="{{Input::old('client', $adlibs->nama)}}">
                <input type="hidden" class="client_id" name="client_id" value="{{Input::old('client_id', $adlibs->client_id)}}"/>
                @if($errors->has('client_id'))
                <p class="help-block">{{$errors->first('client_id')}}</p>
                @endif
            </div>

            <div class="form-group @if($errors->has('text')) has-error  has-feedback @endif">
                <label class="control-label" for="text">Text</label>
                <textarea class="form-control" id="text" name="text">{{Input::old('text', $adlibs->text)}}</textarea>
                @if($errors->has('text'))
                <p class="help-block">{{$errors->first('text')}}</p>
                @endif
            </div>


            <div class="form-group @if($errors->has('genre')) has-error  has-feedback @endif">
                <label class="control-label" for="genre">genre</label>
                <input type="input" class="form-control autocomplete" id="genre" placeholder="jika typenya event maka genre diisi dengan none" name="genre" value="{{Input::old('genre', $adlibs->genre)}}">
                @if($errors->has('genre'))
                <p class="help-block">{{$errors->first('genre')}}</p>
                @endif
            </div>


            <div class="form-group @if($errors->has('count')) has-error  has-feedback @endif">
                <label class="control-label" for="count">count</label>
                <input type="input" class="form-control" id="count" name="count" value="{{Input::old('count', $adlibs->count)}}">
                @if($errors->has('count'))
                <p class="help-block">{{$errors->first('count')}}</p>
                @endif
            </div>

            <div class="form-group @if($errors->has('type')) has-error  has-feedback @endif">
                <label class="control-label" for="type">type</label>
                {{ Form::select('type', ["genre" => "genre", "event" => "event"], $adlibs->type, ['class' => 'form-control']) }}
                @if($errors->has('type'))
                <p class="help-block">{{$errors->first('type')}}</p>
                @endif
            </div>


            <div class="form-group @if($errors->has('status')) has-error  has-feedback @endif">
                <label class="control-label" for="status">status</label>
                {{ Form::select('status', ["active" => "active", "nonactive" => "nonactive"], $adlibs->status, ['class' => 'form-control']) }}
                @if($errors->has('status'))
                <p class="help-block">{{$errors->first('status')}}</p>
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