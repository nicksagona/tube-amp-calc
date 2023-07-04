<?php

namespace Calc\Model;

use Pop\Model\AbstractModel;

class Tube extends AbstractModel
{

    /**
     * Tube data
     * @var array
     */
    protected $tubes = [
        'EL34/6CA7' => [
            'plate_dissipation' => 25,
            'plate_voltage'     => 800,
            'cathode_current'   => 150
        ],
        '6L6GC'     => [
            'plate_dissipation' => 30,
            'plate_voltage'     => 500,
            'cathode_current'   => 80
        ],
        '5881'     => [
            'plate_dissipation' => 23,
            'plate_voltage'     => 500,
            'cathode_current'   => 80
        ],
        'EL84-12'   => [
            'plate_dissipation' => 12,
            'plate_voltage'     => 300,
            'cathode_current'   => 65
        ],
        'EL84-14'   => [
            'plate_dissipation' => 14,
            'plate_voltage'     => 300,
            'cathode_current'   => 65
        ],
        '6V6-12'    => [
            'plate_dissipation' => 12,
            'plate_voltage'     => 450,
            'cathode_current'   => 80
        ],
        '6V6-14'    => [
            'plate_dissipation' => 14,
            'plate_voltage'     => 450,
            'cathode_current'   => 80
        ],
        'KT66'      => [
            'plate_dissipation' => 25,
            'plate_voltage'     => 550,
            'cathode_current'   => 150
        ],
        'KT77'      => [
            'plate_dissipation' => 25,
            'plate_voltage'     => 800,
            'cathode_current'   => 180
        ],
        'KT88'      => [
            'plate_dissipation' => 42,
            'plate_voltage'     => 800,
            'cathode_current'   => 180
        ],
        '6550-35'      => [
            'plate_dissipation' => 35,
            'plate_voltage'     => 600,
            'cathode_current'   => 175
        ],
        '6550-42'      => [
            'plate_dissipation' => 42,
            'plate_voltage'     => 800,
            'cathode_current'   => 230
        ],
    ];

    /**
     * Bias settings
     * @var array
     */
    protected $biasSettings = [
        'Class A'  => [
            'Fixed-Biased'   => [
                'Hot'     => 100,
                'Warm'    => 90,
                'Nominal' => 80,
                'Cool'    => 70,
                'Cold'    => 60,
            ],
            'Cathode-Biased' => [
                'Hot'     => 120,
                'Warm'    => 110,
                'Nominal' => 95,
                'Cool'    => 85,
                'Cold'    => 70,
            ],
        ],
        'Class AB' => [
            'Fixed-Biased'   => [
                'Hot'     => 90,
                'Warm'    => 80,
                'Nominal' => 70,
                'Cool'    => 60,
                'Cold'    => 50,
            ],
            'Cathode-Biased' => [
                'Hot'     => 120,
                'Warm'    => 110,
                'Nominal' => 95,
                'Cool'    => 85,
                'Cold'    => 70,
            ],
        ]
    ];

    /**
     * Get tube values
     *
     * @param  string $tube
     * @return array
     */
    public function getTubeValues($tube)
    {
        return (isset($this->tubes[$tube])) ? $this->tubes[$tube] : [];
    }

    /**
     * Get nominal bias value
     *
     * @param  string $ampOperation
     * @param  string $ampBias
     * @return int|null
     */
    public function getNominalBiasValue($ampOperation, $ampBias)
    {
        return (isset($this->biasSettings[$ampOperation]) && isset($this->biasSettings[$ampOperation][$ampBias])) ?
            $this->biasSettings[$ampOperation][$ampBias]['Nominal'] : null;
    }

    /**
     * Get bias result
     *
     * @param  float  $biasValue
     * @param  string $ampOperation
     * @param  string $ampBias
     * @return string
     */
    public function getBiasResult($biasValue, $ampOperation, $ampBias)
    {
        $result    = '';
        $biasValue = (float)$biasValue;

        if (isset($this->biasSettings[$ampOperation]) && isset($this->biasSettings[$ampOperation][$ampBias])) {
            $biasSettings = $this->biasSettings[$ampOperation][$ampBias];

            if ($biasValue >= $biasSettings['Hot']) {
                $result = 'Hot';
            } else if (($biasValue < $biasSettings['Hot']) && ($biasValue >= $biasSettings['Warm'])) {
                $result = 'Warm';
            } else if (($biasValue < $biasSettings['Warm']) && ($biasValue >= $biasSettings['Nominal'])) {
                $result = 'Nominal';
            } else if (($biasValue < $biasSettings['Nominal']) && ($biasValue >= $biasSettings['Cool'])) {
                $result = 'Cool';
            } else if (($biasValue < $biasSettings['Cool']) && ($biasValue >= $biasSettings['Cold'])) {
                $result = 'Cold';
            } else if ($biasValue < $biasSettings['Cold']) {
                $result = 'Very Cold';
            }
        }

        return $result;
    }

}