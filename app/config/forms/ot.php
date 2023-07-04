<?php

$otInstructions = <<<INSTR

This calculator can be used in one of three ways:<br />
<ol>
    <li>To calculate the unknown primary impedance of an output transformer</li>
    <li>To calculate the unknown speaker impedance of a secondary tap of an output transformer</li>
    <li>To calculate impedance and winding ratios of an output transformer</li>
</ol>

To calculate the unknown primary impedance, you must enter the voltages applied and transformed on the primary and secondary taps, as well as <strong><em>the known speaker impedance of the secondary tap</em></strong>.<br /><br />
To calculate the unknown speaker impedance of a secondary tap, you must enter the voltages applied and transformed on the primary and secondary taps, as well as <strong><em>the known primary impedance</em></strong>.<br /><br />
To calculate the impedance and winding ratios, simply enter the known primary impedance and the speaker impedance of the secondary tap.<br /><br />

<em style="font-size: 0.9em;"><strong class="error">Warning:</strong> To perform this calculation, you must apply voltage to the taps of the output transformer and take measurements of what the voltages are on the primary and secondary taps. Working with voltages can be very dangerous or even fatal, so do not do so unless you are knowledgeable and skilled enough to work on tube amps. Please reference <a href="https://www.youtube.com/watch?v=5jUitplchok" target="_blank">this video</a> for more information on this procedure.</em><br /><br />

INSTR;

return [
    'Output Transformers<br /><span class="instructions">' . $otInstructions . '</span>' => [
        'ot_voltage_primary'   => [
            'type'  => 'text',
            'label' => 'V<sub>(primary)</sub>',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'ot_voltage_secondary'   => [
            'type'  => 'text',
            'label' => 'V<sub>(secondary)</sub>',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'ot_primary_impedance'   => [
            'type'  => 'text',
            'label' => 'Primary Impedance',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'ot_speaker_impedance'   => [
            'type'  => 'text',
            'label' => 'Speaker Impedance',
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

