<?php

return [
    '<a href="#top" class="float-right small" style="margin-top: 10px; font-size: 0.45em;">Top</a>Output Transformers' => [
        'ot_voltage_in'   => [
            'type'  => 'text',
            'label' => 'V<sub>(in)</sub>',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'ot_voltage_out'   => [
            'type'  => 'text',
            'label' => 'V<sub>(out)</sub>',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'ot_primary_impedance'   => [
            'type'  => 'text',
            'label' => 'Primary Impedance',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'ot_speaker_impedance'   => [
            'type'  => 'text',
            'label' => 'Speaker Impedance',
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

