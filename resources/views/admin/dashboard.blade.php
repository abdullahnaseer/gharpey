@extends('admin.layouts.dashboard', ['page_title' => "Dashboard"])

@section('breadcrumb')
    <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
    <span class="breadcrumb-item active">Dashboard</span>
@endsection

@section('content')
    <div class="alert alert-primary">Welcome to Admin Panel!</div>

    <div class="row">
        @foreach($charts as $chart)
            <div class="col-sm-6">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head kt-portlet__head--lg">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon"><i class="kt-font-brand flaticon2-chart"></i></span>
                            <h3 class="kt-portlet__head-title">{{ $chart['name'] }}</h3>
                        </div>
                    </div>
                    <div class="kt-portlet__head kt-portlet__head--lg">
                        <div id="{{$chart['id']}}-chart" style="width:100%; height:400px"></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection


@push('scripts')
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="https://www.amcharts.com/lib/4/lang/de_DE.js"></script>
    <script src="https://www.amcharts.com/lib/4/geodata/germanyLow.js"></script>
    <script src="https://www.amcharts.com/lib/4/fonts/notosans-sc.js"></script>

    @foreach($charts as $chart)
        <!-- Chart code -->
        <script>
            am4core.ready(function() {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart = am4core.create("{{$chart['id']}}-chart", am4charts.XYChart);

                chart.data = {!! $chart['data'] !!};

                // Set input format for the dates
                // chart.dateFormatter.inputDateFormat = "yyyy-MM-dd H:m:s";
                chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

                // Create axes
                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

                // Create series
                var series = chart.series.push(new am4charts.LineSeries());
                series.dataFields.valueY = "value";
                series.dataFields.dateX = "date";
                series.tooltipText = "{value}"
                series.strokeWidth = 2;
                series.minBulletDistance = 15;

                // Drop-shaped tooltips
                series.tooltip.background.cornerRadius = 20;
                series.tooltip.background.strokeOpacity = 0;
                series.tooltip.pointerOrientation = "vertical";
                series.tooltip.label.minWidth = 40;
                series.tooltip.label.minHeight = 40;
                series.tooltip.label.textAlign = "middle";
                series.tooltip.label.textValign = "middle";

                // Make bullets grow on hover
                var bullet = series.bullets.push(new am4charts.CircleBullet());
                bullet.circle.strokeWidth = 2;
                bullet.circle.radius = 4;
                bullet.circle.fill = am4core.color("#fff");

                var bullethover = bullet.states.create("hover");
                bullethover.properties.scale = 1.3;

                // Make a panning cursor
                chart.cursor = new am4charts.XYCursor();
                chart.cursor.behavior = "panXY";
                chart.cursor.xAxis = dateAxis;
                chart.cursor.snapToSeries = series;

                // Create vertical scrollbar and place it before the value axis
                chart.scrollbarY = new am4core.Scrollbar();
                chart.scrollbarY.parent = chart.leftAxesContainer;
                chart.scrollbarY.toBack();

                // Create a horizontal scrollbar with previe and place it underneath the date axis
                chart.scrollbarX = new am4charts.XYChartScrollbar();
                chart.scrollbarX.series.push(series);
                chart.scrollbarX.parent = chart.bottomAxesContainer;

                dateAxis.start = 0.79;
                dateAxis.keepSelection = true;
            }); // end am4core.ready()
        </script>
    @endforeach
@endpush
