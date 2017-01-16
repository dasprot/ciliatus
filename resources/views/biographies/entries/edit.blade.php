@extends('master')

@section('breadcrumbs')
    <a href="/biography_entries" class="breadcrumb">@choice('components.biography_entries', 2)</a>
    <a href="/biography_entries/{{ $entry->id }}" class="breadcrumb">/{{ $entry->name }}</a>
    <a href="/biography_entries/{{ $entry->id }}/edit" class="breadcrumb">@lang('buttons.edit')</a>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l6">
                <div class="card">
                    <form action="{{ url('api/v1/biography_entries/' . $entry->id) }}" data-method="PUT" data-redirect-success="auto">
                        <div class="card-content">

                            <div class="row">
                                <div class="input-field col s12">
                                    <select name="belongsTo" disabled>
                                        <option></option>
                                        @foreach ($belongTo_Options as $t=>$objects)
                                            <optgroup label="@choice('components.' . strtolower($t), 2)">
                                                @foreach ($objects as $o)
                                                    <option value="{{ $t }}|{{ $o->id }}"
                                                            @if($entry->belongsTo_type == $t && $entry->belongsTo_id == $o->id)
                                                            selected
                                                            @endif>@if(is_null($o->display_name)) {{ $o->name }} @else {{ $o->display_name }} @endif</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    <label for="belongsTo">@lang('labels.belongsTo')</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <select name="category">
                                        <option></option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->name }}"
                                            @if(!is_null($category))
                                            @if($category->name == $cat->name)
                                            selected
                                            @endif
                                            @endif>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="category">@lang('labels.bio_categories')</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" placeholder="@lang('labels.title')" name="title" value="{{ $entry->name }}">
                                    <label for="name">@lang('labels.title')</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea placeholder="@lang('labels.text')" rows="15"
                                              name="text" class="materialize-textarea">{{ preg_replace('/\<br(\s*)?\/?\>/i', "\n", $entry->value) }}</textarea>
                                    <label for="text">@lang('labels.text')</label>
                                </div>
                            </div>

                        </div>

                        <div class="card-action">

                            <div class="row">
                                <div class="input-field col s12">
                                    <button class="btn waves-effect waves-light" type="submit">@lang('buttons.next')
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed-action-btn">
        <a class="btn-floating btn-large teal">
            <i class="large material-icons">mode_edit</i>
        </a>
        <ul>
            <li><a class="btn-floating red" href="/biography_entries/{{ $entry->id }}/delete"><i class="material-icons">delete</i></a></li>
            <li><a class="btn-floating green" href="/biography_entries/create?preset[belongsTo_type]={{ $entry->belongsTo_type }}&preset[belongsTo_id]={{ $entry->belongsTo_id }}"><i class="material-icons">add</i></a></li>
        </ul>
    </div>
@stop

@section('scripts')
@stop