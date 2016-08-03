/*
    LiveData objects refresh data automatically
    - source_uri provides the data source. Normally an API
    - interval sets the interval between data pulls
    - type sets the type of data we're fetching and defines
      what the callback method will do with new data
    - target defines the element where the callback
      function will put the new data
 */

var liveDataObjects = [];

function LiveData(source_uri, interval, callback, target)
{
    liveDataObjects += this;
    this.source_uri = source_uri;
    this.interval = interval * 1000;
    this.callback = callback;
    this.target = target;
    this.refs = new Array();
    console.log(this.callback);

    return this;
}

LiveData.prototype.run = function()
{
    var ld = this;
    ld.fetchData(ld);
    setInterval(function() {
        ld.fetchData(ld)
    }, this.interval);
};

LiveData.prototype.fetchData = function(ld)
{
    $.ajax({
        url: ld.source_uri,
        type: 'GET',
        error: function() {
            ld.callback(false, 'error', ld);
        },
        success: function(data) {
            ld.callback(true, data, ld);
        }
    });
};

LiveData.prototype.cleanupRefs = function ()
{
    $.each(this.refs, function() { this.remove() });

    this.refs = new Array();
};

$('form').submit(function (e)
{
    e.preventDefault();
    $.ajax({
        url: $(e.target).prop('action'),
        type: $(e.target).data('method'),
        data: $(e.target).serialize(),
        success: function(data) {
            notification('success', 'Saved');
            if (data.meta.redirect != undefined) {
                window.setTimeout(function() {
                    window.location.replace(data.meta.redirect.uri)
                }, data.meta.redirect.delay || 2000);
            }
        },
        error: function(data) {
            var msg = 'Unknown';
            if (data.responseJSON !== undefined)
                msg = data.responseJSON.error.message;
            notification('danger', 'Error ' + data.status, data.statusText + ':<br />' + msg);
        }
    });
});


function renderTemperatureSparklineById(id, height, width)
{
    return $(id).sparkline('html', {
        type: 'line',
        width: width,
        height: height,
        lineColor: '#BF0000',
        fillColor: '#FFAAAA',
        lineWidth: 1,
        spotColor: undefined,
        minSpotColor: undefined,
        maxSpotColor: undefined,
        highlightSpotColor: undefined,
        highlightLineColor: undefined,
        spotRadius: 0,
        chartRangeMin: 0,
        chartRangeMax: 40
    });
}

function renderHumiditySparklineById(id, height, width)
{
    return $(id).sparkline('html', {
        type: 'line',
        width: width,
        height: height,
        lineColor: '#0000BF',
        fillColor: '#AAAAFF',
        lineWidth: 1,
        spotColor: undefined,
        minSpotColor: undefined,
        maxSpotColor: undefined,
        highlightSpotColor: undefined,
        highlightLineColor: undefined,
        spotRadius: 0,
        chartRangeMin: 0,
        chartRangeMax: 100
    });
}

function notification(level, title, text)
{
    text = text || '';

    console.log(level + ' - ' + title + ' - ' + text);
    new PNotify({
        title: title,
        text: text,
        type: level,
        styling: 'bootstrap3'
    });
}

/*
 * Callbacks
 */
var domCallbacks = new Array();

/*
 * Render terrarium dashboard with sparklines
 */
domCallbacks['terrariaDashboardCallback'] = function (success, data, ld) {
    ld.cleanupRefs();
    if (data.data.heartbeat_ok === true) {
        $(this.target).find('.x_panel').removeClass('x_panel-danger');
        $(this.target).find('.terrarium-widget-heartbeat-temp').html('<i class="fa fa-check text-success"></i>')
    }
    else {
        $(this.target).find('.x_panel').addClass('x_panel-danger');
        $(this.target).find('.terrarium-widget-heartbeat-temp').html('<i class="fa fa-times text-danger"></i>')
    }
    var temptrendicontemp = data.data.temperature_trend > 0.2 ? 'wi-direction-up-right' : data.data.temperature_trend < -0.2 ? 'wi-direction-down-right' : 'wi-direction-right';
    var temptrendiconhumidity = data.data.humidity_trend > 0.2 ? 'wi-direction-up-right' : data.data.humidity_trend < -0.2 ? 'wi-direction-down-right' : 'wi-direction-right';

    $(this.target).find('.terrarium-widget-temp').html(data.data.cooked_temperature_celsius + '°C <span class="wi ' + temptrendicontemp + '"></span>');
    $(this.target).find('.terrarium-widget-humidity').html(data.data.cooked_humidity_percent + '% <span class="wi ' + temptrendiconhumidity + '"></span>');
    $(this.target).find('.dashboard-widget-sparkline-temp').html('<div id="sparkline-temperature-' + data.data.id + '" style="background-color: #FFDDDD;">' + data.data.temperature_history + '</div>');
    $(this.target).find('.dashboard-widget-sparkline-humidity').html('<div id="sparkline-humidity-' + data.data.id + '" style="background-color: #DDDDFF;">' + data.data.humidity_history + '</div>');

    ld.refs.push(renderHumiditySparklineById('#sparkline-humidity-' + data.data.id, 40, '100%'));
    ld.refs.push(renderTemperatureSparklineById('#sparkline-temperature-' + data.data.id, 40, '100%'));
};

function runPage()
{
    $('[data-livedata="true"]').each(function() {
        console.log(window);
        new LiveData($(this).data('livedatasource'), $(this).data('livedatainterval'), domCallbacks[$(this).data('livedatacallback')], this).run();
    })
}