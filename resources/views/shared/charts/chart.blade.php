@foreach($charts as $chart)
    <div class="{{isset($col) ? $col : (isset($chart['size']) ? $chart['size'] : 'col-sm-6')}}">
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
