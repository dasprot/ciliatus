@extends('master')

@section('breadcrumbs')
    <a href="/action_sequence_intentions" class="breadcrumb hide-on-small-and-down">@choice('labels.action_sequence_intentions', 2)</a>
    <a href="/action_sequence_intentions/create" class="breadcrumb hide-on-small-and-down">@lang('buttons.create')</a>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l6">
                <div class="card">
                    <form action="{{ url('api/v1/action_sequence_intentions') }}" data-method="POST"
                          data-redirect-success="auto">
                        <div class="card-content">

                            <div class="row">
                                <div class="input-field col s12">
                                    <select name="action_sequence">
                                        @foreach ($action_sequences as $as)
                                            <option value="{{ $as->id }}"
                                                @if(isset($preset['action_sequence']) && $preset['action_sequence'] == $as->id) selected @endif >@if(is_null($as->display_name)){{ $as->name }}@else{{ $as->display_name }}@endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="action_sequence">@choice('labels.action_sequences', 1)</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12 m6 l6">
                                    <input class="timepicker" placeholder="@lang('labels.timeframe_start')"
                                           name="timeframe_start" data-default="08:00:00" value="08:00:00">
                                    <label for="timeframe_start">@lang('labels.timeframe_start')</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    <input class="timepicker" placeholder="@lang('labels.timeframe_end')"
                                           name="timeframe_end" data-default="20:00:00" value="20:00:00">
                                    <label for="timeframe_end">@lang('labels.timeframe_end')</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12 m6 l6 tooltipped" data-position="top"
                                     data-delay="50" data-html="true" data-tooltip="<div style='max-width: 300px'>@lang('tooltips.intention_increase_decrease')</div>">
                                    <select name="intention">
                                        <option value="increase">@lang('labels.increases')</option>
                                        <option value="decrease">@lang('labels.decreases')</option>
                                    </select>
                                    <label for="intention">
                                        @lang('labels.intention')
                                    </label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    <select name="type">
                                        @foreach ($sensorreading_types as $srt)
                                            <option value="{{ $srt }}">@lang('labels.' . $srt)</option>
                                        @endforeach
                                    </select>
                                    <label for="type">@choice('labels.logical_sensors', 1)</label>
                                </div>
                            </div>


                            <div class="row">
                                <div class="input-field col s12 tooltipped" data-position="top"
                                     data-delay="50" data-html="true" data-tooltip="<div style='max-width: 300px'>@lang('tooltips.minimum_timeout_minutes')</div>">
                                    <input type="text" name="minimum_timeout_minutes" placeholder="@lang('labels.minimum_timeout_minutes')">
                                    <label for="minimum_timeout_minutes">
                                        @lang('labels.minimum_timeout_minutes')
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">

                            <div class="row">
                                <div class="input-field col s12">
                                    <button class="btn waves-effect waves-light" type="submit">@lang('buttons.save')
                                        <i class="mdi mdi-18px mdi-floppy left"></i>
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

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.timepicker').timepicker({
                twelveHour: false
            });
        });
    </script>
@stop