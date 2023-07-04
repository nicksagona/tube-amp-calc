<?php

$biasInstructions = <<<INSTR

This calculator utilizes the output transformer resistance to measure the plate current to calculate the bias. Select the correct amp configuration parameters. Enter the B+ voltage and at least one OT primary resistance value and one tube plate voltage value.<br /><br />

<em style="font-size: 0.9em;"><strong class="error">Warning:</strong> To perform this calculation, it requires measurements of high voltage while the amp is turned on. Working with voltages can be very dangerous or even fatal, so do not do so unless you are knowledgeable and skilled enough to work on tube amps. Please see these reference links for more information on this procedure: <a href="https://www.youtube.com/watch?v=w9B0Rhr_Y-E" target="_blank">Biasing an Amp (Part 1)</a>, <a href="https://www.youtube.com/watch?v=pjKYiSr497w" target="_blank">Biasing an Amp (Part 2)</a>, <a href="https://robrobinette.com/How_to_Bias_a_Tube_Amp.htm" target="_blank">How to Bias an Amp</a>.</em><br /><br />
INSTR;

return [
    'Bias<br /><span class="instructions">' . $biasInstructions . '</span>' => [
        'amp_operation'   => [
            'type'  => 'select',
            'label' => 'Amp Operation &amp; Bias Type',
            'attributes' => [
                'class' => 'form-control'
            ],
            'values' => [
                'Class AB' => 'Class AB',
                'Class A'  => 'Class A',
            ]
        ],
        'amp_bias_type'   => [
            'type'  => 'select',
            'attributes' => [
                'class' => 'form-control'
            ],
            'values' => [
                'Fixed-Biased'   => 'Fixed-Biased',
                'Cathode-Biased' => 'Cathode-Biased',
            ]
        ],
        'amp_config'   => [
            'type'  => 'select',
            'label' => 'Amp Configuration & Tube Type',
            'attributes' => [
                'class' => 'form-control'
            ],
            'values' => [
                'PP-Pair'    => 'Push-Pull, Pair',
                'PP-Quartet' => 'Push-Pull, Quartet',
                'SE-Single'  => 'Single-Ended',
                'SE-Pair'    => 'Single-Ended, Parallel Pair',
            ]
        ],
        'tube_type'   => [
            'type'  => 'select',
            'attributes' => [
                'class' => 'form-control'
            ],
            'values' => [
                'EL34/6CA7' => 'EL34/6CA7 (25W)',
                '6L6GC'     => '6L6GC (30W)',
                '5881'      => '5881 (23W)',
                'EL84-12'   => 'EL84 (12W)',
                'EL84-14'   => 'EL84 (14W)',
                '6V6-12'    => '6V6 (12W)',
                '6V6-14'    => '6V6 (14W)',
                'KT66'      => 'KT66 (25W)',
                'KT77'      => 'KT77 (25W)',
                'KT88'      => 'KT88 (42W)',
                '6550-35'   => '6550 (35W)',
                '6550-42'   => '6550 (42W)',
            ]
        ],
        'b_plus'   => [
            'type'  => 'text',
            'label' => 'B+ Voltage',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'ot_primary_resistance_1'   => [
            'type'  => 'text',
            'label' => 'OT Primary Resistance #1 &amp; #2',
            'attributes' => [
                'class'       => 'form-control',
                'placeholder' => '(Left of Center Tap, or Single-Ended Tap)'
            ]
        ],
        'ot_primary_resistance_2'   => [
            'type'  => 'text',
            'attributes' => [
                'class'       => 'form-control',
                'placeholder' => '(Right of Center Tap)'
            ]
        ],
        'plate_voltage_1'   => [
            'type'  => 'text',
            'label' => 'Plate Voltage of Tube Set #1 &amp; #2',
            'attributes' => [
                'class'       => 'form-control',
                'placeholder' => '(Left Tube Set, or Single Tube)'
            ]
        ],
        'plate_voltage_2'   => [
            'type'  => 'text',
            'attributes' => [
                'class'       => 'form-control',
                'placeholder' => '(Right Tube Set, or Single Tube)'
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

