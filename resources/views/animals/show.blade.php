@extends('master')

@section('content')

    <div class="row">
        @include('animals.dashboard_slice', ['animals' => [$animal]])
        @include('animals.details_slice', ['animal' => $animal])
    </div>

    <script>
        $(function() {
            runPage();
        });
    </script>
@stop