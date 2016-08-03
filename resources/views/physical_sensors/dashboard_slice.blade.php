@foreach ($physical_sensors as $ps)
    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 dashboard-box" id="physical_sensor-{{ $ps->id }}">
        <div class="x_panel">

            <div class="x_title">
                <h2>{{ $ps->name }}</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('physical_sensors/' . $ps->id . '/edit') }}">@lang('menu.edit')</a>
                            </li>
                            <li>
                                <a href="{{ url('physical_sensors/' . $ps->id . '/delete') }}">@lang('menu.delete')</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="row">
                    <div class="col-xs-12">
                        <strong>@choice('components.controlunits', 1):</strong> <a href="{{ url('controlunits/' . $ps->controlunit->id) }}">{{ $ps->controlunit->name }}</a>
                    </div>
                </div>
                <div class="row weather-days">
                    @foreach ($ps->logical_sensors as $ls)
                        <div class="col-sm-6">
                            <div class="daily-weather">
                                <h2 class="day"><a href="{{ url('logical_sensors/' . $ls->id) }}">{{ $ls->name }}</a></h2>
                                <h3 class="terrarium-widget-temp">{{ $ls->valueReadable() }}</h3>
                            </div>
                        </div>
                    @endforeach
                    <div class="clearfix"></div>
                </div>
                @if(isset($show_details))
                    <div class="row">
                        <pre>{{ $ps->generateConfig() }}</pre>
                    </div>
                @endif
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endforeach