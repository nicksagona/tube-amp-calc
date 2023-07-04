<?php

$capacitanceInstructions = <<<INSTR

Enter comma-separated values of capacitance to calculate the total capacitance. Select the correct configuration in which the capacitors are configured.

INSTR;

return [
    'Capacitance<br /><span class="instructions">' . $capacitanceInstructions . '</span>' => [
        'capacitance_values'   => [
            'type'  => 'text',
            'label' => 'Capacitance Values (comma-separated)',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'cap_config'   => [
            'type'  => 'radio-set',
            'label' => 'Configuration',
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

