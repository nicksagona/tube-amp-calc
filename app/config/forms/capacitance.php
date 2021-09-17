<?php

return [
    "Capacitance" => [
        'capacitance_values'   => [
            'type'  => 'text',
            'label' => 'Capacitance Values (comma-separated)',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'type'   => [
            'type'  => 'radio-set',
            'label' => 'Type',
            'values' => [
                'Parallel' => 'Parallel',
                'Series'   => 'Series'
            ],
            'checked' => 'Series'
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

