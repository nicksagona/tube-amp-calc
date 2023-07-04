<?php

$bPlusInstructions = <<<INSTR

To estimate the rectified B+ voltage, enter the secondary VAC value and select the type of rectifier used. Results are approximate.

INSTR;

return [
    'B+ Voltage<br /><span class="instructions">' . $bPlusInstructions . '</span>' => [
        'vac'   => [
            'type'  => 'text',
            'label' => 'Secondary VAC',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'rectifier'   => [
            'type'  => 'select',
            'label' => 'Rectifier',
            'attributes' => [
                'class' => 'form-control'
            ],
            'values' => [
                'GZ34'    => 'GZ34/5AR4',
                'EZ81'    => 'EZ81/6CA4',
                '5U4'     => '5U4',
                '5Y3'     => '5Y3',
                'Silicon' => 'Silicon',
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

