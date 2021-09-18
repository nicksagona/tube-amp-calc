<?php

return [
    '[/]' => [
        'controller' => 'Calc\Http\Controller\IndexController',
        'action'     => 'index'
    ],
    '/process[/]' => [
        'controller' => 'Calc\Http\Controller\IndexController',
        'action'     => 'process'
    ],
    '*' => [
        'controller' => 'Calc\Http\Controller\IndexController',
        'action'     => 'error'
    ]
];