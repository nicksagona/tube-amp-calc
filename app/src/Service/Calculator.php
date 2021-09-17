<?php

namespace Calc\Service;

class Calculator
{

    /**
     * Calculate voltage
     *
     * @param  float $current
     * @param  float $resistance
     * @param  int   $round
     * @return float
     */
    public function calculateVoltage($current, $resistance, $round = 2)
    {
        return round(($current * $resistance), $round);
    }

    /**
     * Calculate power
     *
     * @param  float $current
     * @param  float $voltage
     * @param  int   $round
     * @return float
     */
    public function calculatePower($current, $voltage, $round = 2)
    {
        return round(($current * $voltage), $round);
    }

    /**
     * Calculate resistance in series
     *
     * @param  array $resistance
     * @param  int   $round
     * @return float
     */
    public function calculateResistanceInSeries(array $resistance, $round = 2)
    {
        return round(array_sum($resistance), $round);
    }

    /**
     * Calculate resistance in parallel
     *
     * @param  array $resistance
     * @param  int   $round
     * @return float
     */
    public function calculateResistanceInParallel(array $resistance, $round = 2)
    {
        $resistanceTotal = 0;

        foreach ($resistance as $r) {
            $resistanceTotal += (1 / $r);
        }

        return round(1 / $resistanceTotal, $round);
    }

    /**
     * Calculate capacitance in series
     *
     * @param  array $capacitance
     * @param  int   $round
     * @return float
     */
    public function calculateCapacitanceInSeries(array $capacitance, $round = 2)
    {
        $capacitanceTotal = 0;

        foreach ($capacitance as $c) {
            $capacitanceTotal += (1 / $c);
        }

        return round(1 / $capacitanceTotal, $round);
    }

    /**
     * Calculate capacitance in parallel
     *
     * @param  array $capacitance
     * @param  int   $round
     * @return float
     */
    public function calculateCapacitanceInParallel(array $capacitance, $round = 2)
    {
        return round(array_sum($capacitance), $round);
    }

    /**
     * Calculate voltage divider
     *
     * @param  float $voltageIn
     * @param  float $resistance1
     * @param  float $resistance2
     * @param  int   $round
     * @return array
     */
    public function calculateVoltageDivider($voltageIn, $resistance1, $resistance2, $round = 2)
    {
        $voltageOut  = round(($voltageIn * ($resistance2 / ($resistance1 + $resistance2))), 2);
        $dbReduction = round((20 * log10($voltageOut / $voltageIn)), 2);

        return [
            'voltage_out'  => $voltageOut,
            'db_reduction' => $dbReduction
        ];
    }

    /**
     * Calculate RC filter cutoff frequency
     *
     * @param  float $resistance
     * @param  float $capacitance
     * @param  int   $round
     * @return float
     */
    public function calculateRcFilter($resistance, $capacitance, $round = 2)
    {
        $frequencyCutoff = 1 / (2 * pi() * $resistance * $capacitance);
        return round($frequencyCutoff, $round);
    }

}