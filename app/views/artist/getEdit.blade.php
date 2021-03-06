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
            source: "{{URL::to('artist/artistlist')}}",
            minLength: 2,
            select: function(event, data) {
                var hid_class = $(this).attr('id');
                detail = data.item;
                $('.'+hid_class).val(detail.data);
            },
            response: function(event, ui) {
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
<h3>Edit {{$artist->name}}</h3>
<div class="row">

    <div class="col-xs-6">
        <form role="form" action="{{URL::current()}}" method="POST">
            <div class="form-group @if($errors->has('name')) has-error  has-feedback @endif">
                <label class="control-label" for="name">Name</label>
                <input type="input" class="form-control" id="name" name="name" value="{{Input::old('name',$artist->name)}}">
                @if($errors->has('name'))
                <p class="help-block">{{$errors->first('name')}}</p>
                @endif
            </div>
            <div class="form-group @if($errors->has('genre')) has-error  has-feedback @endif">
                <label class="control-label" for="genre">Genre <span style="font-size: 9px">jika lebih dari satu pisahkan dengan koma (,)</span></label>
                <?php
                $genre_list = "";
                ?>
                @foreach($artist->genres as $genre)
                <?php $genre_list .= $genre->name . ", "; ?>
                @endforeach
                <input type="input" class="form-control" id="genre" name="genre" value="{{Input::old('genre',$genre_list)}}">
                @if($errors->has('genre'))
                <p class="help-block">{{$errors->first('genre')}}</p>
                @endif
            </div>
            <div class="form-group input_fields_wrap">
                <label class="control-label" for="similar">Similar Artist</label></br>
                @if ($similar_artist)
                @foreach ($similar_artist as $key => $sim_art)
                    <div>
                        <input type="text" id="text_{{$key}}" class="form-control autocomplete" name="sim_name[]" value="{{$sim_art->name}}" />
                        <input type="hidden" class="text_{{$key}}" name="sim_id[]" value="{{$sim_art->id}}"/>
                    </div>
                    <br/>
                @endforeach
                @endif
                <?php 
                    $x = 5 - count($similar_artist);
                    $n = count($similar_artist);
                ?>
                @for ($i = 1; $i <= $x; $i++)
                    <?php $n++ ?>
                    <div>
                        <input type="text" id="text_{{$n}}" class="form-control autocomplete" name="sim_name[]" />
                        <input type="hidden" class="text_{{$n}}" name="sim_id[]" />
                    </div>
                    <br/>
                @endfor
            </div>
            <button type="submit" class="btn btn-info">Submit</button>
        </form>
    </div>
</div>

@stop