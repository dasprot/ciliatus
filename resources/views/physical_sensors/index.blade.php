@extends('master')

@section('content')

    <div class="row">
        @include('physical_sensors.dashboard_slice', ['physical_sensors' => $physical_sensors, 'show_details' => true])
    </div>

    <script>
        $(function() {
            runPage();
        });
    </script>
@stop