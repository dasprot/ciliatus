@extends('master')

@section('content')
<div class="col-md-6 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>{{ $animal->display_name }}</h2>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <br />
            <form class="form-horizontal form-label-left" name="f_edit_animal" action="{{ url('api/v1/animals/' . $animal->id) }}" data-method="PUT">

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">ID</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" readonly="readonly" placeholder="ID" name="f_edit_animal_id" value="{{ $animal->id }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('labels.display_name')</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" placeholder="@lang('labels.display_name')" name="f_edit_animal_displayname" value="{{ $animal->display_name }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('labels.common_name')</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" placeholder="@lang('labels.common_name')" name="f_edit_animal_commonname" value="{{ $animal->common_name }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('labels.latin_name')</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" placeholder="@lang('labels.latin_name')" name="f_edit_animal_latinname" value="{{ $animal->lat_name }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('labels.gender')</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <select class="form-control" name="f_edit_animal_gender">
                            <option></option>
                            <option value="male" @if($animal->gender == 'male')selected="selected"@endif>@lang('labels.gender_male')</option>
                            <option value="female" @if($animal->gender == 'female')selected="selected"@endif>@lang('labels.gender_female')</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('labels.date_birth')</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control datepicker" placeholder="@lang('labels.date_birth')" name="f_edit_animal_birthdate" value="{{ $animal->birth_date }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">@lang('labels.date_death')</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control datepicker" placeholder="@lang('labels.date_death')" name="f_edit_animal_deathdate" value="{{ $animal->death_date }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">@choice('components.terraria', 1)</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <select class="form-control" name="f_edit_animal_terrarium">
                            <option></option>
                            @foreach ($terraria as $t)
                                <option value="{{ $t->id }}" @if($animal->terrarium_id == $t->id)selected="selected"@endif>{{ $t->friendly_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success" name="f_edit_animal_submit">@lang('buttons.save')</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true
        });
    });
</script>
@stop