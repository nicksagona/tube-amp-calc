<?php

return [
    "Resistance" => [
        'resistance_values'   => [
            'type'  => 'text',
            'label' => 'Resistance Values (comma-separated)',
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
            'checked' => 'Parallel'
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

