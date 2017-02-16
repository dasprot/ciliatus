@extends('master')

@section('breadcrumbs')
    <a href="/controlunits" class="breadcrumb">@choice('components.controlunits', 2)</a>
@stop


@section('content')
    <div class="container">
        <controlunits-list-widget :refresh-timeout-seconds="60" container-classes="" wrapper-classes=""></controlunits-list-widget>
    </div>

    <div class="fixed-action-btn">
        <a class="btn-floating btn-large teal">
            <i class="large material-icons">mode_edit</i>
        </a>
        <ul>
            <li><a class="btn-floating green" href="/controlunits/create"><i class="material-icons">add</i></a></li>
        </ul>
    </div>
@stop