<?php

$voltageInstructions = <<<INSTR

Enter all three variables and click calculate.

INSTR;

return [
    'Voltage Divider<br /><span class="small">[V<sub>(out)</sub> = V<sub>(in)</sub> x (R<sub>2</sub> / (R<sub>1</sub> + R<sub>2</sub>))]</span><br /><span class="instructions">' . $voltageInstructions . '</span>' => [
        'voltage_in'   => [
            'type'  => 'text',
            'label' => 'V<sub>(in)</sub>',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'resistance1'   => [
            'type'  => 'text',
            'label' => 'Resistance 1 (R<sub>1</sub>)',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'resistance2'   => [
            'type'  => 'text',
            'label' => 'Resistance 2 (R<sub>2</sub>)',
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

