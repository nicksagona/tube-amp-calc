<?php

return [
    '<a href="#top" class="float-right small" style="margin-top: 10px; font-size: 0.45em;">Top</a>RC Filter <span class="small">[1 / 2&Pi;RC]</span>' => [
        'resistance_filter'   => [
            'type'  => 'text',
            'label' => 'Resistance (R)',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'capacitance_filter'   => [
            'type'  => 'text',
            'label' => 'Capacitance (F)',
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

