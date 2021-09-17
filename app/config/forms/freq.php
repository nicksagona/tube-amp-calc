<?php

return [
    "RC Filter" => [
        'resistance'   => [
            'type'  => 'text',
            'label' => 'Resistance',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'capacitance'   => [
            'type'  => 'text',
            'label' => 'Capacitance',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'submit' => [
            'type'       => 'submit',
            'label'      => '&nbsp;',
            'value'      => 'Calculate',
            'attributes' => [
                'class'  => 'btn btn-md btn-info btn-block text-uppercase'
            ]
        ]
    ]
];

