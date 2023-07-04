<?php

$resistanceInstructions = <<<INSTR

Enter comma-separated values of resistance to calculate the total resistance. Select the correct configuration in which the resistors are configured.

INSTR;

return [
    'Resistance<br /><span class="instructions">' . $resistanceInstructions . '</span>' => [
        'resistance_values'   => [
            'type'  => 'text',
            'label' => 'Resistance Values (comma-separated)',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'res_config'   => [
            'type'  => 'radio-set',
            'label' => 'Configuration',
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

