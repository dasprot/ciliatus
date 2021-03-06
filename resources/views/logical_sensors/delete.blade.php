@extends('master')

@section('breadcrumbs')
    <a href="/logical_sensors" class="breadcrumb hide-on-small-and-down">@choice('labels.logical_sensors', 2)</a>
    <a href="/logical_sensors/{{ $logical_sensor->id }}" class="breadcrumb hide-on-small-and-down">{{ $logical_sensor->name }}</a>
    <a href="/logical_sensors/{{ $logical_sensor->id }}/delete" class="breadcrumb hide-on-small-and-down">@lang('buttons.delete')</a>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l6">
                <div class="card">
                    <form action="{{ url('api/v1/logical_sensors/' . $logical_sensor->id) }}"
                          data-method="DELETE" data-redirect-success="{{ url('logical_sensors') }}">
                        <div class="card-content">

                            <span class="card-title activator truncate">
                                <span>{{ $logical_sensor->name }}</span>
                            </span>

                            <p>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" readonly placeholder="ID" name="id" value="{{ $logical_sensor->id }}">
                                    <label for="id">ID</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" placeholder="@lang('labels.name')" readonly name="display_name" value="{{ $logical_sensor->name }}">
                                    <label for="name">@lang('labels.name')</label>
                                </div>
                            </div>

                        </div>

                        <div class="card-action">

                            <div class="row">
                                <div class="input-field col s12">
                                    <button class="btn waves-effect waves-light red" type="submit">@lang('buttons.delete')
                                        <i class="mdi mdi-18px mdi-delete left"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop