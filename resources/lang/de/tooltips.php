<?php

return [
    'ctrltoselect'          =>  'Strg+Klick zum selektieren',
    'active'                =>  'Aktiv',
    'showondefaultdashboard'=>  'Auf Default Dashboard anzeigen',
    'autoirrigation'        =>  'Automatische Bewässerung',
    'sendnotificationsfor'  =>  'Benachrichtigungen versenden für',
    'loadandrendergraph'    =>  'Daten werden ermittelt und Graph wird gerendert',
    'disables_option'       =>  'Deaktiviert ":option"',
    'phone_number'          =>  'Mobilnummer',
    'contact_bot'           =>  'Den Bot kontaktieren',
    'wait_confirmation'     =>  'Auf Bestätigung warten',
    'set_state_to'          =>  'Zustand von <b>:target</b> auf <b>:state</b> ändern für <b>:minutes Minuten</b>',
    'start_after_started'   =>  'Startet wenn Schritt <b>:id</b> gestartet wurde',
    'start_after_finished'  =>  'Startet wenn Schritt <b>:id</b> beendet wurde',
    'sendnotifications'     =>  'Benachrichtigungen versenden',
    'no_schedules'          =>  'Keine Zeitpläne',
    'runonce'               =>  'Einmalig',
    'heartbeat_critical'    =>  'Heartbeat ist kritisch!',
    'copy_thresholds_warning'=> 'Alle existierenden Schwellenwerte des Zielsensors werden entfernt.',
    'animal_feeding_schedule_matrix' => 'Diese Matrix enthält alle definierten Fütterungspläne. Die Zahl in einer Spalte stellt das Intervall dar, gefolgt von den verbleibenden Tagen bis zur nächsten Fälligkeit.',
    'animal_weighing_schedule_matrix' => 'Diese Matrix enthält alle definierten Wiegepläne. Die Zahl in einer Spalte stellt das Intervall gefolgt vom nächsten Fälligkeitsdatum dar.',
    'done'                  =>  'Erledigt',
    'skip'                  =>  'Überspringen',
    'material_icons_list'   =>  'Die komplette Symbolliste ist unter <a href="https://cdn.materialdesignicons.com/2.1.99/">materialdesignicons.com</a> einsehbar.',
    'no_data'               =>  'Keine Daten.',
    'connecting_to_server'  =>  'Verbindung zum Ciliatus Server wird hergestellt. Sollte dies länger als einige Sekunden dauern, überprüfen Sie bitte Ihre Internetverbindung.',
    'custom_components' => [
        'about'                 => 'Benutzerdefinierte Komponenten werden benutzt, um die Standardkomponenten von Ciliatus zu ergänzen.',
        'type_about'            => 'Benutzerdefinierte Komponententypen definieren Name, Eigenschaften und mögliche Zustände für benutzerdefinierte Komponenten. Sie dienen als Vorlage beim Erstellen einer neuen benutzerdefinierten Komponente.',
        'property_templates'    => 'Definiert die Eigenschaften eines benutzerdefinierten Komponententyps. Beim Erstellen einer neuen Komponente diesen Typs wird man aufgefordert, diese Eigenschaften auszufüllen.',
        'state_templates'       => 'Definiert mögliche Zustände, die eine Komponente diesen Typs haben kann. Beim Erstellen einer Aktionssequenz kann man aus den hier definierten Zuständen den gewünschten Zustand auswählen.<br /><br />Die Checkbox links definiert den standardmäßigen \'laufend\'-Zustand.',
        'type_delete_warning'   => 'Beim Löschen eines Komponententyps werden <strong>alle Komponenten dieses Typs</strong> gelöscht.',
        'intentions'            => 'Intentionen von benutzerdefinierten Komponenten ermöglichen deren automatisches Einbinden in Aktionssequenzen.'
    ],
    'minimum_timeout_minutes'=> 'Definiert die Dauer der minimalen Pause, bevor die Aktionssequenz durch diesen Auslöser nach einem Durchlauf erneut gestartet werden kann.',
    'reference_value' => 'Der Wert, mit dem der Sensorwert verglichen werden soll.',
    'reference_value_duration_threshold_minutes' => 'Dauer in Minuten, die der Sensorwert den Grenzwert unter/überschritten haben muss, bevor die Aktionssequenz ausgelöst wird.',
    'emergency_stop'    =>  'Hält sofort alle Aktionssequenzen an und verhindert das Starten neuer Aktionssequenzen bis der Notaus aufgehoben wird.',
    'emergency_resume'  =>  'Hebt den Notaus auf und erlaubt den Start von Aktionssequenzen.',
    'leave_empty_for_auto'=>'Frei lassen für automatisch',
    'intention_increase_decrease'=>'Definiert ob die Intention dieser Aktionssequenz das Erhöhen oder Senken des Sensorwerts ist.',
    'suggestions_unit'  =>  'Mindestanzahl von Kritischen Zuständen innerhalb des Zeitrahmens, bevor ein Vorschlag generiert werden soll.',
    'suggestion_timeframe_unit' => 'Zeitrahmen der zur Analyse herangezogen werden soll (Einheit)',
    'suggestions_timeframe' => 'Zeitrahmen der zur Analyse herangezogen werden soll (Wert)',
    'show_suggestions'  =>  'Vorschläge anzeigen',
    'bus_type_edit_form'=>  'Ermöglicht Ciliatus das automatische Generieren von Kontroleinheitskonfigurationen.',
    'gpio_default_high' =>  'GPIO Pin wird im Betrieb auf High gezogen. Zum aktivieren der Komponente auf Low.',
    'adjust_rawvalue'   =>  'Beim Empfangen eines Werts durch diesen Sensor kann der Wert korrigiert werden.',
    'experimental_feature'=>'Dieses Feature ist experimentell.',
    'action_sequence_schedules' => [
        'skip'  => 'Heutigen Durchlauf überspringen.'
    ],
    'associate_new' => 'Verknüpfe <i class="material-icons">:source_icon</i> :source_type ":source_name" mit <i class="material-icons">:target_icon</i> :target_type',
    'floating' => [
        'add' => 'Neu',
        'edit' => 'Bearbeiten',
        'delete' => 'Löschen'
    ],
    'ciliatus_up_to_date' => 'Aktuell',
    'ciliatus_not_up_to_date' => 'Update verfügbar: <a href=":url">GitHub</a>',
    'no_feeding_types' => 'Es wurden noch keine Futtertypen definiert.',
    'max_file_size' => 'Die maximale Dateigröße beträgt :size.',
    'animal_weighing' => [
        'trend' => 'Trend der letzten 60 Tage bis zum letzten Wiegen'
    ],
    'logical_sensor_thresholds' => [
        'limits'     => 'Nicht-kritischer Wertebereich. Werte außerhalb des Bereichs werden als kritisch angesehen',
        'lowerlimit' => 'Sensorwert ist kritisch, falls er unter diesem Wert liegt',
        'upperlimit' => 'Sensorwert ist kritisch, falls er über diesem Wert liegt',
        'starts_at'  => 'Zeitpunkt, ab dem der Grenzwert gelten soll'
    ],
    'logical_sensor_rawvalue_limit' => 'Gültigkeitsbereich dieses Sensors. Sensorwerte außerhalb dieses Bereichs werden abgelehnt, wenn sie über die API gesendet werden.',
    'caresheet' => [
        'sensor_history_days' => 'Zeitraum der in die Berechnung von Durschnitts-/Max-/Min-Werten einbezogen werden soll',
        'data_history_days' => 'Zeitraum aus dem Biographieinträge, Fütterungen und Gewichtsverlauf einbezogen werden soll'
    ],
    'set_as_background' => 'Als Hintergrund setzen',
    'critical_state_actuality' => 'Daten werden zum jetzigen Zeitpunkt ermittelt und könnten zum Zeitpunkt des kritischen Zustand unterschiedlich gewesen sein.',
    'i2c' => [
        'bus_num' => 'Für Raspberry Pi: 0 für RPI1, 1 für alle anderen Modelle'
    ],
    'feature_discovery' => [
        'floating_button' => [
            'title' => 'Aktionen',
            'text' => 'Objekte hinzufügen, zu editieren, verknüpfen und löschen.'
        ]
    ]
];