<?php

return [
    "Power" => [
        'current'   => [
            'type'  => 'text',
            'label' => 'Current',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'voltage'   => [
            'type'  => 'text',
            'label' => 'Voltage',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'max'   => [
            'type'  => 'text',
            'label' => 'Max Dissipation',
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

