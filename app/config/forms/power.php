<?php

return [
    '<a href="#top" class="float-right small" style="margin-top: 10px; font-size: 0.45em;">Top</a>Power<br /><span class="small">[P = I x V]</span>' => [
        'current_power'   => [
            'type'  => 'text',
            'label' => 'Current (I)',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'voltage_power'   => [
            'type'  => 'text',
            'label' => 'Voltage (V)',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'max'   => [
            'type'  => 'text',
            'label' => 'Max Dissipation (W) <em class="small light">[Optional]</em>',
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

