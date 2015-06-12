@extends('master')

@section('css')
@stop

@section('javascripts')
<script type="text/javascript" src="{{asset('js/handlebars.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.timeago.js')}}"></script>
<script type="text/javascript" src="{{asset('js/ruangsiar.js')}}"></script>
@stop

@section('content')
<h3>Ruang Siar</h3>
<hr/>
<div class="row">
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Crowd Songs
                <a class="btn btn-primary btn-xs pull-right" id="btn-reload-crowd">
                    <i class="glyphicon glyphicon-refresh"></i>
                    <span id="text-reload-crowd">reload</span>
                </a>
            </div>
            <div style="max-height: 350px;overflow-y: auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-xs-4">Artist</th>
                            <th class="col-xs-1">BPM</th>
                            <th>Songs</th>
                            <th>Genres</th>
                            <th>Year</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody id="playlist"></tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Hits Songs
                <a class="btn btn-primary btn-xs pull-right" id="btn-reload-hits">
                    <i class="glyphicon glyphicon-refresh"></i>
                    <span id="text-reload-hits">reload</span>
                </a>
            </div>
            <div style="max-height: 400px;overflow-y: auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-xs-4">Artist</th>
                            <th class="col-xs-1">BPM</th>
                            <th>Songs</th>
                            <th>Genre</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody id="hitslist"></tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                New Songs
                <a class="btn btn-primary btn-xs pull-right" id="btn-reload-new">
                    <i class="glyphicon glyphicon-refresh"></i>
                    <span id="text-reload-new">reload</span>
                </a>
            </div>
            <div style="max-height: 400px;overflow-y: auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-xs-4">Artist</th>
                            <th class="col-xs-1">BPM</th>
                            <th>Songs</th>
                            <th>Genre</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody id="newsong"></tbody>
                </table>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                Adlibs
                <a class="btn btn-primary btn-xs pull-right" id="btn-reload-adlibs">
                    <i class="glyphicon glyphicon-refresh"></i>
                    <span id="text-reload-adlibs">reload</span>
                </a>
            </div>
            <div style="max-height: 400px;overflow-y: auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Adlibs</th>
                            <th>Genre</th>
                            <th>Sisa</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody id="adlibs"></tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="col-xs-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                Programs
                <div class="pull-right action-buttons">
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-cog" style="margin-right: 0px;"></span> change
                        </button>
                        <ul class="dropdown-menu slidedown">
                            @foreach($programs as $p)
                            <li><a href="{{URL::to('/api/program/change/'.$p->id)}}" class="program-change">{{$p->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div id="program-current">
                    <h4 id="current-program-name" data-id="{{$currentProgram->id}}">{{$currentProgram->name}}</h4>
                    <p>
                        BPM
                        <span  id="current-program-minbpm">{{$currentProgram->min_bpm}}</span> -
                        <span  id="current-program-maxbpm">{{$currentProgram->max_bpm}}</span>
                    </p>
                    <p>
                    </p>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Ignore List
                <div class="pull-right action-buttons">
                    <div class="btn-group pull-right">
                        <a href="{{URL::to('/api/ignore/list')}}" class="btn btn-primary btn-xs pull-right" id="btn-reload-ignore">
                            <i class="glyphicon glyphicon-refresh"></i>
                            <span id="text-reload-ignore"></span>
                        </a>&nbsp;
                        <a href="{{URL::to('/api/ignore/removeall')}}" class="btn btn-danger btn-xs pull-right" id="btn-delete-ignore">
                            delete all
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div id="program-current" style="height:200px;overflow: auto;">
                    <table class="table table-hover">
                        <tbody  id="ignore-list">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                Listeners
                <div class="pull-right action-buttons">
                    <div class="btn-group pull-right">
                        <a href="{{URL::to('/api/listeners/'.$currentProgram->id)}}" class="btn btn-primary btn-xs pull-right" id="btn-reload-connected-user">
                            <i class="glyphicon glyphicon-refresh"></i>
                            <span id="text-reload-connected-user"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div id="program-current" style="height:200px;overflow: auto;">
                    <table class="table table-hover">
                        <tbody  id="listeners-list">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><strong>Fave Artist But No Song</strong></div>
            <div id="nosong-list" style="height:200px;overflow: auto;">
                <div class="list-group" style="display: block;">
                    @foreach($nosongs as $s)
                    <a href="{{URL::to('artist/show/'.$s->id)}}" class="list-group-item">{{$s->name}} <span class="badge pull-right">{{$s->total}} </span></a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <a class="twitter-timeline" href="https://twitter.com/search?q=%40googooradio" data-widget-id="519074417914040320">Tweets about "@googooradio"</a>
            <script>!function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
    if (!d.getElementById(id)) {
        js = d.createElement(s);
        js.id = id;
        js.src = p + "://platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js, fjs);
    }
}(document, "script", "twitter-wjs");</script>
        </div>


    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="likedMemberModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>
<!-- Modal -->
<div class="modal fade" id="likedArtistModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>

<!-- Modal -->
<div class="modal fade" id="similarArtistModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>

<!-- Modal -->
<div class="modal fade" id="similarGenreModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>

<div class="modal fade" id="similarYearModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

</div>


<script id="hb-listeners" type="text/x-handlebars-template">
    @include('ruangsiar._listeners')
</script>

<script id="hb-playlist" type="text/x-handlebars-template">
    @{{#each data}}
    @include('ruangsiar._playlist');
    @{{/each}}
</script>

<script id="hb-hitslist" type="text/x-handlebars-template">
    @{{#each data}}
    @include('ruangsiar._hitslist');
    @{{/each}}
</script>

<script id="hb-newsong" type="text/x-handlebars-template">
    @{{#each data}}
    @include('ruangsiar._newsong');
    @{{/each}}
</script>

<script id="hb-adlibs" type="text/x-handlebars-template">
    @{{#each data}}
    @include('ruangsiar._adlibs');
    @{{/each}}
</script>

<script id="hb-likedmember" type="text/x-handlebars-template">
    @include('ruangsiar._likedmember');
</script>

<script id="hb-likedartist" type="text/x-handlebars-template">
    @include('ruangsiar._likedartist');
</script>

<script id="hb-ignore" type="text/x-handlebars-template">
    @include('ruangsiar._ignore')
</script>

<script id="hb-similarartist" type="text/x-handlebars-template">
    @include('ruangsiar._similarartist');
</script>

<script id="hb-similargenre" type="text/x-handlebars-template">
    @include('ruangsiar._similargenre');
</script>

<script id="hb-similaryear" type="text/x-handlebars-template">
    @include('ruangsiar._similaryear');
</script>

@stop