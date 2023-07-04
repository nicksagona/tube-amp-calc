<?php

$ohmsInstructions = <<<INSTR

Enter two of the variables to calculate the value of the third variable.

INSTR;

return [
    'Ohm\'s Law<br /><span class="small">[V = I x R]</span><br /><span class="instructions">' . $ohmsInstructions . '</span>' => [
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

