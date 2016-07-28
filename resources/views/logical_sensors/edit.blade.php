@extends('master')

@section('content')
<div class="col-md-6 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>{{ $logical_sensor->name }} <small>Edit</small></h2>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <br />
            <form class="form-horizontal form-label-left" name="f_edit_logical_sensor" action="{{ url('api/v1/logical_sensors/' . $logical_sensor->id) }}" data-method="PUT">

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">ID</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" readonly="readonly" placeholder="ID" name="f_edit_logical_sensor_id" value="{{ $logical_sensor->id }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" placeholder="Name" name="f_edit_logical_sensor_name" value="{{ $logical_sensor->name }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Type</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <select class="form-control" name="f_edit_logical_sensor_type">
                            <option></option>
                            <option value="humidity_percent" @if($logical_sensor->type == 'humidity_percent')selected="selected"@endif>Humidity (%)</option>
                            <option value="temperature_celsius" @if($logical_sensor->type == 'temperature_celsius')selected="selected"@endif>Temperature (°C)</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Rawvalue lower limit</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" placeholder="Name" name="f_edit_logical_sensor_lowerlimit" value="{{ $logical_sensor->rawvalue_lowerlimit }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Rawvalue upper limit</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" placeholder="Name" name="f_edit_logical_sensor_upperlimit" value="{{ $logical_sensor->rawvalue_upperlimit }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Control Unit</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <select class="form-control" name="f_edit_logical_sensor_physical_sensor">
                            <option></option>
                            @foreach ($physical_sensors as $ps)
                                <option value="{{ $ps->id }}" @if($logical_sensor->physical_sensor_id == $ps->id)selected="selected"@endif>{{ $ps->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success" name="f_edit_logical_sensor_submit">Save</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@stop