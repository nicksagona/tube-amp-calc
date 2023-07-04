<?php

$powerInstructions = <<<INSTR

Enter the current and voltage values to calculate the power in watts. Entering the max dissipation value in watts will give you the percentage of dissipation achieved.  

INSTR;

return [
    'Power<br /><span class="small">[P = I x V]</span><br /><span class="instructions">' . $powerInstructions . '</span>' => [
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

