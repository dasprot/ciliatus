<?php

return [
    'ctrltoselect'          =>  'Ctrl-click to deselect',
    'active'                =>  'Active',
    'showondefaultdashboard'=>  'Show on default dashboard',
    'autoirrigation'        =>  'Automatic irrigation (if available)',
    'sendnotificationsfor'  =>  'Send notifications for',
    'loadandrendergraph'    =>  'Collection data and rendering graph',
    'disables_option'       =>  'Disables ":option"',
    'phone_number'          =>  'Mobile number',
    'contact_bot'           =>  'Contacting the bot',
    'wait_confirmation'     =>  'Waiting for confirmation',
    'set_state_to'          =>  'Set state of <b>:target</b> to <b>:state</b> for <b>:minutes minutes</b>',
    'start_after_started'   =>  'Starts as soon as step <b>:id</b> was started',
    'start_after_finished'   =>  'Starts as soon as step <b>:id</b> finished',
    'sendnotifications'     =>  'Send notifications',
    'no_schedules'          =>  'No schedules',
    'runonce'               =>  'Run once',
    'heartbeat_critical'    =>  'Heartbeat is critical!',
    'copy_thresholds_warning'=> 'All existing thresholds on the target sensor will be removed.',
    'animal_feeding_schedule_matrix' => 'This matrix contains all defined feeding schedules. A number in a column represents the schedule\'s interval in days followed by the remaining time in days until it\'s due next.',
    'animal_weighing_schedule_matrix' => 'This matrix contains all defined weighing schedules. A number in a column represents the schedule\'s interval in days followed by the next due date.',
    'done'                  =>  'Done',
    'skip'                  =>  'Skip',
    'material_icons_list'   =>  'Visit <a href="https://cdn.materialdesignicons.com/2.1.99/">materialdesignicons.com</a> for a complete icon overview.',
    'no_data'               =>  'No data.',
    'connecting_to_server'  =>  'Connecting to Ciliatus Server. If this takes longer then a few seconds please check your internet connection.',
    'custom_components' => [
        'about'                 => 'Custom components are used to supplement the default components provided by Ciliatus.',
        'type_about'            => 'Custom component types define name, properties and possible states of a custom component. They are used as a template when creating a new custom component.',
        'property_templates'    => 'Define properties for this custom component type. Each time you create a new component of this type you will be prompted to fill in these properties.',
        'state_templates'       => 'Define possible states for a component of this type. When creating an action sequence you can chose a state from this list as a desired state.<br /><br />The radio box on the left defines the default \'running\' state.',
        'type_delete_warning'   => 'When deleting a component type <strong>all components of this type</strong> will also be deleted.',
        'intentions'            => 'Intentionen of custom components allows them to be automatically used within action sequences.'
    ],
    'minimum_timeout_minutes'=> 'Defines the minimum timeout before the action sequence can be started by this trigger after the last time it was triggered.',
    'reference_value' => 'Reference value which will be compared to the sensor values.',
    'reference_value_duration_threshold_minutes' => 'Duration in minutes for which the sensor value has to be greater/lower/equal to the reference value before triggering the action sequence.',
    'emergency_stop'    =>  'Instantly stops all running action sequences and prohibits action sequences from starting.',
    'emergency_resume'  =>  'Revokes the emergency stop and allows action sequences to start.',
    'leave_empty_for_auto'=>'Leave empty for automatic',
    'intention_increase_decrease'=>'Defines whether the intention of this action sequence is to increase or decrease the sensor\'s readings',
    'suggestions_unit'  =>  'Minimum number of critical states within the timeframe before a suggestion should be generated.',
    'suggestion_timeframe_unit' => 'Timeframe used for analysis (Unit)',
    'suggestions_timeframe' => 'Timeframe used for analysis (Value)',
    'show_suggestions'  =>  'Show suggestions',
    'bus_type_edit_form'=>  'Allows Ciliatus to automatically generate Control Unit configurations.',
    'gpio_default_high' =>  'GPIO Pin will be pulled to high. When activating a component to low.',
    'adjust_rawvalue'   =>  'When receiving a reading from this sensor you can adjust the raw value.',
    'experimental_feature'=>'This is an experimental feature.',
    'action_sequence_schedules' => [
        'skip'  => 'Skip today\'s run.'
    ],
    'associate_new' => 'Associate <i class="material-icons">:source_icon</i> :source_type ":source_name" with <i class="material-icons">:target_icon</i> :target_type',
    'floating' => [
        'add' => 'New',
        'edit' => 'Edit',
        'delete' => 'Delete'
    ],
    'ciliatus_up_to_date' => 'Up to date',
    'ciliatus_not_up_to_date' => 'Update available: <a href=":url">GitHub</a>',
    'no_feeding_types' => 'There are no food types defined yet.',
    'max_file_size' => 'The maximum file size is :size.',
    'animal_weighing' => [
        'trend' => 'Trend within the last 60 days from the last weighing'
    ],
    'logical_sensor_thresholds' => [
        'limits'     => 'Non-critical range. Values outside this range will be considered critical',
        'lowerlimit' => 'Sensor reading will be considered critical, if below this value',
        'upperlimit' => 'Sensor reading will be considered critical, if above this value',
        'starts_at'  => 'Time from which on this threshold is active'
    ],
    'logical_sensor_rawvalue_limit' => 'Valid value range for this sensor. Values outside this range submitted via the API will be rejected',
    'caresheet' => [
        'sensor_history_days' => 'Timespan for sensor readings to include in the average/min/max calculation',
        'data_history_days' => 'Timespan of animal feedings, weighings and biography entries to include'
    ],
    'set_as_background' => 'Set as background',
    'critical_state_actuality' => 'This is current information which could have been different at the time of the critical state.',
    'i2c' => [
        'bus_num' => 'For Raspberry Pi: Use 0 for RPI1, 1 for all other models'
    ],
    'feature_discovery' => [
        'floating_button' => [
            'title' => 'Actions',
            'text' => 'Create, edit, connect and delete objects.'
        ]
    ]
];