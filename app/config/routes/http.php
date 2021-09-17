<?php

return [
    '[/]' => [
        'controller' => 'Calc\Http\Controller\IndexController',
        'action'     => 'index'
    ],
    '*' => [
        'controller' => 'Calc\Http\Controller\IndexController',
        'action'     => 'error'
    ]
];