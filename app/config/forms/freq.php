<?php

$freqInstructions = <<<INSTR

Enter the resistance and capacitance values to calculate the value of the cut-off frequency.  

INSTR;

return [
    'RC Filter<br /><span class="small">[1 / 2&Pi;RC]</span><br /><span class="instructions">' . $freqInstructions . '</span>' => [
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

