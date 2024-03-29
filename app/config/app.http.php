<?php

return [
    'routes' => include 'routes/http.php',
    'forms'  => [
        'ohms'        => include 'forms/ohms.php',
        'voltage-div' => include 'forms/voltage-div.php',
        'power'       => include 'forms/power.php',
        'freq'        => include 'forms/freq.php',
        'resistance'  => include 'forms/resistance.php',
        'capacitance' => include 'forms/capacitance.php',
        'bias'        => include 'forms/bias.php',
        'b-plus'      => include 'forms/b-plus.php',
        'ot'          => include 'forms/ot.php',
    ]
];
