<?php

return [
    "Voltage Divider" => [
        'voltage'   => [
            'type'  => 'text',
            'label' => 'V<sub>(in)</sub>',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'resistance1'   => [
            'type'  => 'text',
            'label' => 'Resistance 1',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'resistance2'   => [
            'type'  => 'text',
            'label' => 'Resistance 2',
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

