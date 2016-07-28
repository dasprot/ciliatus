@extends('master')

@section('content')
<div class="col-md-6 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>{{ $physical_sensor->name }} <small>Edit</small></h2>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <br />
            <form class="form-horizontal form-label-left" name="f_edit_physical_sensor" action="{{ url('api/v1/physical_sensors/' . $physical_sensor->id) }}" data-method="PUT">

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">ID</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" readonly="readonly" placeholder="ID" name="f_edit_physical_sensor_id" value="{{ $physical_sensor->id }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" placeholder="Name" name="f_edit_physical_sensor_name" value="{{ $physical_sensor->name }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Model</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" placeholder="Name" name="f_edit_physical_sensor_model" value="{{ $physical_sensor->model }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Terrarium</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <select class="form-control" name="f_edit_physical_sensor_terrarium">
                            <option></option>
                            @foreach ($terraria as $t)
                                <option value="{{ $t->id }}" @if($physical_sensor->belongsTo_id == $t->id && $physical_sensor->belongsTo_type == 'terrarium')selected="selected"@endif>{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Control Unit</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <select class="form-control" name="f_edit_physical_sensor_controlunit">
                            <option></option>
                            @foreach ($controlunits as $c)
                                <option value="{{ $c->id }}" @if($physical_sensor->controlunit_id == $c->id)selected="selected"@endif>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success" name="f_edit_physical_sensor_submit">Save</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@stop