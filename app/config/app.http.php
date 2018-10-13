<?php
return [
    'routes' => [
        '[/]' => [
            'controller' => 'TubeCalc\Controller\IndexController',
            'action'     => 'index'
        ],
        '*' => [
            'controller' => 'TubeCalc\Controller\IndexController',
            'action'     => 'error'
        ]
    ]
];