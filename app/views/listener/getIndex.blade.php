@extends('master')

@section('css')
<link href="{{asset('/css/bootstrap-datepicker3.css')}}" rel="stylesheet">
@stop

@section('javascripts')
<script src="{{asset('amcharts/amcharts.js')}}" type="text/javascript"></script>
<script src="{{asset('amcharts/serial.js')}}" type="text/javascript"></script>
<script src="{{asset('js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script>
    var chart;
    var chartData = [];
    var chartCursor;
    var chartunique = [];
    
    AmCharts.ready(function () {
        // generate some data first
        generateChartData();

        // SERIAL CHART
        chart = new AmCharts.AmSerialChart();

        chart.dataProvider = chartData;
        chart.categoryField = "date";
        chart.balloon.bulletSize = 5;

        // listen for "dataUpdated" event (fired when chart is rendered) and call zoomChart method when it happens
        chart.addListener("dataUpdated", zoomChart);

        // AXES
        // category
        var categoryAxis = chart.categoryAxis;
        categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
        categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
        categoryAxis.dashLength = 1;
        categoryAxis.minorGridEnabled = true;
        categoryAxis.twoLineMode = true;
        categoryAxis.dateFormats = [{
            period: 'fff',
            format: 'JJ:NN:SS'
        }, {
            period: 'ss',
            format: 'JJ:NN:SS'
        }, {
            period: 'mm',
            format: 'JJ:NN'
        }, {
            period: 'hh',
            format: 'JJ:NN'
        }, {
            period: 'DD',
            format: 'DD'
        }, {
            period: 'WW',
            format: 'DD'
        }, {
            period: 'MM',
            format: 'MMM'
        }, {
            period: 'YYYY',
            format: 'YYYY'
        }];

        categoryAxis.axisColor = "#DADADA";

        // value
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.axisAlpha = 0;
        valueAxis.dashLength = 1;
        chart.addValueAxis(valueAxis);

        // GRAPH
        var graph = new AmCharts.AmGraph();
        graph.title = "red line";
        graph.valueField = "visits";
        graph.bullet = "round";
        graph.bulletBorderColor = "#FFFFFF";
        graph.bulletBorderThickness = 2;
        graph.bulletBorderAlpha = 1;
        graph.lineThickness = 2;
        graph.lineColor = "#5fb503";
        graph.negativeLineColor = "#efcc26";
        graph.hideBulletsCount = 50; // this makes the chart to hide bullets when there are more than 50 series in selection
        chart.addGraph(graph);

        // CURSOR
        chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorPosition = "mouse";
        chartCursor.pan = true; // set it to fals if you want the cursor to work in "select" mode
        chart.addChartCursor(chartCursor);

        // SCROLLBAR
        var chartScrollbar = new AmCharts.ChartScrollbar();
        chart.addChartScrollbar(chartScrollbar);

        chart.creditsPosition = "bottom-right";

        // WRITE
        chart.write("chartdiv");
    });
    // generate some random data, quite different range
    function generateChartData() {
        <?php 
            foreach ($listener as $key => $value) {
                ?>
                chartData.push({
                    date: new Date("{{$value['date']}}"),
                    visits: {{$value['visits']}}
                });
                <?php
            }
        ?>
    }
    
    // this method is called when chart is first inited as we listen for "dataUpdated" event
    function zoomChart() {
        // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
        chart.zoomToIndexes(chartData.length - 40, chartData.length - 1);
    }
    
    AmCharts.ready(function () {
        // generate some data first
        generateUniqueData();

        // SERIAL CHART
        chart = new AmCharts.AmSerialChart();

        chart.dataProvider = chartunique;
        chart.categoryField = "date";
        chart.balloon.bulletSize = 5;

        // listen for "dataUpdated" event (fired when chart is rendered) and call zoomChart method when it happens
        chart.addListener("dataUpdated", zoomChartUnique);

        // AXES
        // category
        var categoryAxis = chart.categoryAxis;
        categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
        categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
        categoryAxis.dashLength = 1;
        categoryAxis.minorGridEnabled = true;
        categoryAxis.twoLineMode = true;
        categoryAxis.dateFormats = [{
            period: 'fff',
            format: 'JJ:NN:SS'
        }, {
            period: 'ss',
            format: 'JJ:NN:SS'
        }, {
            period: 'mm',
            format: 'JJ:NN'
        }, {
            period: 'hh',
            format: 'JJ:NN'
        }, {
            period: 'DD',
            format: 'DD'
        }, {
            period: 'WW',
            format: 'DD'
        }, {
            period: 'MM',
            format: 'MMM'
        }, {
            period: 'YYYY',
            format: 'YYYY'
        }];

        categoryAxis.axisColor = "#DADADA";

        // value
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.axisAlpha = 0;
        valueAxis.dashLength = 1;
        chart.addValueAxis(valueAxis);

        // GRAPH
        var graph = new AmCharts.AmGraph();
        graph.title = "red line";
        graph.valueField = "visits";
        graph.bullet = "round";
        graph.bulletBorderColor = "#FFFFFF";
        graph.bulletBorderThickness = 2;
        graph.bulletBorderAlpha = 1;
        graph.lineThickness = 2;
        graph.lineColor = "#5fb503";
        graph.negativeLineColor = "#efcc26";
        graph.hideBulletsCount = 50; // this makes the chart to hide bullets when there are more than 50 series in selection
        chart.addGraph(graph);

        // CURSOR
        chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorPosition = "mouse";
        chartCursor.pan = true; // set it to fals if you want the cursor to work in "select" mode
        chart.addChartCursor(chartCursor);

        // SCROLLBAR
        var chartScrollbar = new AmCharts.ChartScrollbar();
        chart.addChartScrollbar(chartScrollbar);

        chart.creditsPosition = "bottom-right";

        // WRITE
        chart.write("chartdivunique");
    });
    // generate some random data, quite different range
    function generateUniqueData() {
        <?php 
            foreach ($unique as $key => $value) {
                ?>
                chartunique.push({
                    date: new Date("{{$value['date']}}"),
                    visits: {{$value['visits']}}
                });
                <?php
            }
        ?>
    }
    
    // this method is called when chart is first inited as we listen for "dataUpdated" event
    function zoomChartUnique() {
        // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
        chart.zoomToIndexes(chartunique.length - 40, chartunique.length - 1);
    }
    
    var chartGenre = [];
    
    AmCharts.ready(function () {
        generateGenreData();
        // SERIAL CHART
        var chart = new AmCharts.AmSerialChart();
        chart.dataProvider = chartGenre;
        chart.categoryField = "country";
        chart.rotate = true;
        chart.color = "#FFFFFF";
        chart.handDrawn = true;
        chart.handDrawScatter = 4;

        // this line makes the chart to show image in the background
        //chart.backgroundImage = "images/bg.jpg";

        // sometimes we need to set margins manually
        // autoMargins should be set to false in order chart to use custom margin values
        chart.autoMargins = false;
        chart.marginTop = 100;
        chart.marginLeft = 50;
        chart.marginRight = 30;
        chart.startDuration = 2;

        // AXES
        // category
        var categoryAxis = chart.categoryAxis;
        categoryAxis.gridAlpha = 0;
        categoryAxis.axisAlpha = 0;
        categoryAxis.labelsEnabled = false;

        // value
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.gridAlpha = 0;
        valueAxis.axisAlpha = 0;
        valueAxis.labelsEnabled = false;
        valueAxis.minimum = 0;
        chart.addValueAxis(valueAxis);

        // GRAPH
        var graph = new AmCharts.AmGraph();
        graph.balloonText = "[[category]]: [[value]]";
        graph.valueField = "count";
        graph.type = "column";
        graph.lineAlpha = 0;
        graph.fillAlphas = 0.5;
        // you can pass any number of colors in array to create more fancy gradients
        graph.fillColors = ["#000000", "#FF6600"];
        graph.gradientOrientation = "horizontal";
        graph.labelPosition = "inside";
        graph.labelText = "[[category]]: [[value]] ";
        graph.balloonText = "[[category]]: [[value]] ";
        chart.addGraph(graph);

        
        chart.creditsPosition = "bottom-right";

        // WRITE
        chart.write("chartdivgenre");
    });
    
    function generateGenreData() {
        <?php 
            foreach ($genre as $key => $value) {
                ?>
                chartGenre.push({
                    "country": '{{$value["name"]}}',
                    "count": {{$value['total']}}
                });
                <?php
            }
        ?>
    }
    
    $(document).ready(function(){
        $('#type').change(function(){
            $('#form-filter').submit();
        });
        
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
    });
</script>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <form id="form-filter" class="form-inline" method="get" action="{{URL::current()}}">
            <div class="form-group">
                <label for="type">Data Type</label>
                {{ Form::select('type', ['m' => 'Monthly', 'h' => 'Hourly'], Input::get('type'), ['class' => 'form-control', 'id' => 'type', 'name' => 'type']) }}
            </div>
            <div class="form-group">
              <label for="start">Start</label>
              <input class="datepicker" type="text" name="start" class="form-control" id="start" placeholder="Start" value="{{Input::get('start')}}">
            </div>
            <div class="form-group">
              <label for="end">End</label>
              <input class="datepicker" type="text" name="end" class="form-control" id="end" placeholder="End" value="{{Input::get('end')}}">
            </div>
            <input class="btn btn-primary" type="submit" value="submit" />
        </form>
    </div>
</div>
<h3>Listener</h3>
<div class="row">
    <div class="col-xs-12">
        <div id="chartdiv" style="width: 100%; height: 400px;"></div>
    </div>
</div>
<h3>Unique Listener</h3>
<div class="row">
    <div class="col-xs-12">
        <div id="chartdivunique" style="width: 100%; height: 400px;"></div>
    </div>
</div>
<h3>Top Genre</h3>
<div class="row">
    <div class="col-xs-12">
        <div id="chartdivgenre" style="width: 100%; height: 400px;"></div>
    </div>
</div>

@stop