<?php

return [
    'logical_sensor_thresholds' => [
        'copy_warning' => 'All existing thresholds associated with the target sensor will be deleted.'
    ],

    'users' => [
        'setup_telegram_ok' =>  'Telegram is set up.',
        'setup_telegram_err' =>  'Telegram has not yet been set up.',
        'setup_telegram_description' => 'Please point your browser to <a href="https://web.telegram.org/#/im?p=@:bot_name">Telegram Web</a> or use your smartphone to contact <b>@:bot_name</b> with your verification code below.'
    ],

    'critical_state_generic' => 'Critical: :critical_state',

    'critical_state_notification_logical_sensors' => [
        'humidity_percent' => [
            'UNKNOWN' => 'Critical: The sensor :logical_sensor reports a humidity of :humidity_percent%C.',
            'LOWERLIMIT_DECEEDED' => 'Critical: The sensor :logical_sensor reports a too low humidity of :humidity_percent%C.',
            'UPPERLIMIT_EXCEEDED' => 'Critical: The sensor :logical_sensor reports a too high humidity of :humidity_percent%C.'
        ],
        'temperature_celsius' => [
            'UNKNOWN' => 'Critical: The sensor :logical_sensor reports a temperature of :temperature_celsius°C.',
            'LOWERLIMIT_DECEEDED' => 'Critical: The sensor :logical_sensor reports a too low temperature of :temperature_celsius°C.',
            'UPPERLIMIT_EXCEEDED' => 'Critical: The sensor :logical_sensor reports a too high temperature of :temperature_celsius°C.'
        ]
    ],
    'critical_state_recovery_notification_logical_sensors' => [
        'humidity_percent' => [
            'UNKNOWN' => 'OK: The sensor :logical_sensor reports a humidity of :humidity_percent%C.',
            'LOWERLIMIT_DECEEDED' => 'OK: The sensor :logical_sensor reports a humidity of :humidity_percent%C.',
            'UPPERLIMIT_EXCEEDED' => 'OK: The sensor :logical_sensor reports a humidity of :humidity_percent%C.'
        ],
        'temperature_celsius' => [
            'UNKNOWN' => 'OK: The sensor :logical_sensor reports a temperature of :temperature_celsius°C.',
            'LOWERLIMIT_DECEEDED' => 'OK: The sensor :logical_sensor reports a humidity of :humidity_percent%C.',
            'UPPERLIMIT_EXCEEDED' => 'OK: The sensor :logical_sensor reports a humidity of :humidity_percent%C.'
        ]
    ],
    'critical_state_notification_controlunits' => [
        'UNKNOWN' => 'Critical: The Control Unit :controlunit is in an unknown state.',
        'HEARTBEAT_CRITICAL' => 'Critical: The Control Unit :controlunit is not sending data.',
        'TIME_DIFF_CRITICAL' => 'Critical: The Control Unit :controlunit has a too large time difference.'
    ],
    'critical_state_recovery_notification_controlunits' => [
        'UNKNOWN' => 'OK: The Control Unit :controlunit is no longer in an unknown state.',
        'HEARTBEAT_CRITICAL' => 'OK: The Control Unit :controlunit is sending data again.',
        'TIME_DIFF_CRITICAL' => 'OK: The Control Unit :controlunit has an acceptable time difference again.'
    ],

    'daily' => [
        'intro' => 'Daily reminders',
        'feedings_due'  =>  'Feedings due:',
        'weighings_due' =>  'Weighings due:'
    ],

    'own_token_expires' => 'Token \':name\' expires in :days days.',

    'suggestions' => [
        'humidity_percent' => [
            'UPPERLIMIT_EXCEEDED' => 'Decrease humidity daily at :hour',
            'LOWERLIMIT_DECEEDED' => 'Increase humidity daily at :hour',
            'UNKNOWN' => 'Regulate humidity daily at :hour',
        ],
        'temperature_celsius' => [
            'UPPERLIMIT_EXCEEDED' => 'Decrease temperature daily at :hour',
            'LOWERLIMIT_DECEEDED' => 'Increase temperature daily at :hour',
            'UNKNOWN' => 'Regulate temperature daily at :hour'
        ]
    ],

    'cards' => [
        'no_feedings' => 'No feedings',
        'no_weight' => 'No weight',
        'no_humidity' => 'No humidity data',
        'no_temperature' => 'No temperature data',
        'data_too_old' => 'Data too old'
    ],

    'warnings' => [
        'physical_sensor_belonging' => 'When changing the belonging of a physical sensor all it\'s reading are then '.
            'associated with the new object. Usually in this situation it\'s best to create a new physical sensor.'
    ]
];