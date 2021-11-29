<?php

return [
    '<a href="#top" class="float-right small" style="margin-top: 10px; font-size: 0.45em;">Top</a>B+ Voltage' => [
        'vac'   => [
            'type'  => 'text',
            'label' => 'VAC',
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

