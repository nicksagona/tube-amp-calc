<?php

return [
    '<a href="#top" class="float-right small" style="margin-top: 10px; font-size: 0.45em;">Top</a> <a href="/?reset=1#bias-calc" class="float-right small" style="margin-top: 10px; margin-right: 20px; font-size: 0.45em;">Reset</a> Bias' => [
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
                'placeholder' => '(Right Tube Set)'
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

