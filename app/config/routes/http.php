<?php

return [
    '[/]' => [
        'controller' => 'Calc\Http\Controller\IndexController',
        'action'     => 'index'
    ],
    '*' => [
        'controller' => 'Calc\Auth\Http\Controller\IndexController',
        'action'     => 'error'
    ]
];