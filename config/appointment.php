<?php 

return [
    'max_appointments_per_professional' => 9999,

    'status' => [
        'libre' => 0,
        'ocupado' => 1,
        'espera' => 2,
        'finalizado' => 3,
        'cancelado' => 4

    ],

    'status_name' => [
        'cancelado' => 'Cancelado',
        'ocupado' => 'Ocupado'
    ],

    'max_low_disponibility' => 3,

    'max_media_disponibility' => 6,

    'number_of_appointments_in_carousel' => 3,

    'max_number_of_appointments_in_carousel' => 10,

    'calendar_class' => [
        'no_appointments_class' => 'xdsoft_disabled',
        'low_appointments_class' => 'low-disponibility',   
        'high_appointments_class' => 'high-disponibility'
    ],

    'calendar' => [
        'showmonthsafter' => 12,
        'showmonthsbefore' => 12
    ]

];