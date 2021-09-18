<?php

return [
    '<a href="#top" class="float-right small" style="margin-top: 10px; font-size: 0.45em;">Top</a>Ohm\'s Law<br /><span class="small">[V = I x R]</span>' => [
        'current'   => [
            'type'  => 'text',
            'label' => 'Current (I)',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'resistance'   => [
            'type'  => 'text',
            'label' => 'Resistance (R)',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'voltage'   => [
            'type'  => 'text',
            'label' => 'Voltage (V)',
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

