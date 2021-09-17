<?php

return [
    'voltage <current> <resistance>' => [
        'controller' => 'Calc\Console\Controller\ConsoleController',
        'action'     => 'voltage',
        'help'       => "Calculate voltage from Ohm's law"
    ],
    'voltage-div <voltageIn> <resistance1> <resistance2>' => [
        'controller' => 'Calc\Console\Controller\ConsoleController',
        'action'     => 'voltageDivider',
        'help'       => "Calculate voltage divider"
    ],
    'power <current> <voltage>' => [
        'controller' => 'Calc\Console\Controller\ConsoleController',
        'action'     => 'power',
        'help'       => "Calculate power in watts"
    ],
    'ohms [-p] [-s] [-o|--ohms=*]' => [
        'controller' => 'Calc\Console\Controller\ConsoleController',
        'action'     => 'resistance',
        'help'       => "Calculate resistance in parallel or series"
    ],
    'farads [-p] [-s] [-f|--farads=*]' => [
        'controller' => 'Calc\Console\Controller\ConsoleController',
        'action'     => 'capacitance',
        'help'       => "Calculate capacitance in parallel or series"
    ],
    'freq <resistance> <capacitance>' => [
        'controller' => 'Calc\Console\Controller\ConsoleController',
        'action'     => 'frequency',
        'help'       => "Calculate cutoff frequency for an RC filter" . PHP_EOL
    ],
    'help' => [
        'controller' => 'Calc\Console\Controller\ConsoleController',
        'action'     => 'help',
        'help'       => "Show the help screen"
    ],
    'version' => [
        'controller' => 'Calc\Console\Controller\ConsoleController',
        'action'     => 'version',
        'help'       => "Show the version"
    ],
    '*' => [
        'controller' => 'Calc\Console\Controller\ConsoleController',
        'action'     => 'error'
    ]
];