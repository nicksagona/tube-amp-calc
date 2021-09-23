<?php

namespace Calc\Service;

class Calculator
{

    /**
     * Calculate voltage from Ohm's law
     *
     * @param  float $current
     * @param  float $resistance
     * @param  int   $round
     * @return float
     */
    public function calculateVoltage($current, $resistance, $round = 2)
    {
        return round(($this->convertToAmps($current) * $this->convertToOhms($resistance)), $round);
    }

    /**
     * Calculate resistance from Ohm's law
     *
     * @param  float $voltage
     * @param  float $current
     * @param  int   $round
     * @return float
     */
    public function calculateResistance($voltage, $current, $round = 2)
    {
        return round(($voltage / $this->convertToAmps($current)), $round);
    }

    /**
     * Calculate current from Ohm's law
     *
     * @param  float $voltage
     * @param  float $resistance
     * @return float
     */
    public function calculateCurrent($voltage, $resistance)
    {
        return ($voltage / $this->convertToOhms($resistance));
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
        return round(($this->convertToAmps($current) * $voltage), $round);
    }

    /**
     * Calculate dissipation
     *
     * @param  float $power
     * @param  float $max
     * @param  int   $round
     * @return float
     */
    public function calculateDissipation($power, $max, $round = 2)
    {
        return round((($power / $max) * 100), $round);
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
        $resistance = array_map([$this, 'convertToOhms'], $resistance);
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
            $resistanceTotal += (1 / $this->convertToOhms($r));
        }

        return round(1 / $resistanceTotal, $round);
    }

    /**
     * Calculate capacitance in series
     *
     * @param  array $capacitance
     * @return float
     */
    public function calculateCapacitanceInSeries(array $capacitance)
    {
        $capacitanceTotal = 0;

        foreach ($capacitance as $c) {
            $capacitanceTotal += (1 / $this->convertToFarads($c));
        }

        $cap = (1 / $capacitanceTotal);

        if ($this->isScientificNotation($cap)) {
            $cap = $this->convertScientificNotation($cap);
        }

        return $cap;
    }

    /**
     * Calculate capacitance in parallel
     *
     * @param  array $capacitance
     * @return float
     */
    public function calculateCapacitanceInParallel(array $capacitance)
    {
        $capacitance = array_map([$this, 'convertToFarads'], $capacitance);
        $capacitance = array_sum($capacitance);

        if ($this->isScientificNotation($capacitance)) {
            $capacitance = $this->convertScientificNotation($capacitance);
        }

        return $capacitance;
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
        $resistance1 = $this->convertToOhms($resistance1);
        $resistance2 = $this->convertToOhms($resistance2);
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
        $frequencyCutoff = 1 / (2 * pi() * $this->convertToOhms($resistance) * $this->convertToFarads($capacitance));
        return round($frequencyCutoff, $round);
    }

    /**
     * Get farad conversion values
     *
     * @return array
     */
    public function getFaradConversion()
    {
        $conversion  = [];
        $microFarads = [
            1, 0.68, 0.47, 0.33, 0.22, 0.1,
            0.068, 0.047, 0.033, 0.022, 0.01,
            0.0068, 0.0047, 0.0033, 0.0022, 0.001,
            0.00068, 0.00047, 0.00033, 0.00022, 0.0001,
            0.000068, 0.000047, 0.000033, 0.000022, 0.00001
        ];

        foreach ($microFarads as $microFarad) {
            if ($microFarad < 0.0001) {
                $microFaradValue = sprintf('%f', $microFarad);
            } else {
                $microFaradValue = $microFarad;
            }

            $conversion[] = [
                'micro' => $microFaradValue . 'uF',
                'nano'  => $this->convertToNanofarads($microFaradValue . 'uF') . 'nF',
                'pico'  => $this->convertToPicofarads($microFaradValue . 'uF') . 'pF'
            ];
        }

        return $conversion;
    }

    /**
     * Convert string value to ohms
     *
     * @param  string $resistance
     * @return float
     */
    public function convertToOhms($resistance)
    {
        if (substr(strtolower($resistance), -1) == 'k') {
            $resistance = substr($resistance, 0, -1) * 1000;
        } else if (substr(strtolower($resistance), -1) == 'm') {
            $resistance = substr($resistance, 0, -1) * 1000000;
        } else if (substr(strtolower($resistance), -1) == 'g') {
            $resistance = substr($resistance, 0, -1) * 1000000000;
        }

        return $resistance;
    }

    /**
     * Convert string value to farads
     *
     * @param  string $capacitance
     * @return float
     */
    public function convertToFarads($capacitance)
    {
        if (substr(strtolower($capacitance), -2) == 'pf') {
            $capacitance = substr($capacitance, 0, -2) / 1000000000000;
        } else if (substr(strtolower($capacitance), -2) == 'nf') {
            $capacitance = substr($capacitance, 0, -2) / 1000000000;
        } else if (substr(strtolower($capacitance), -2) == 'uf') {
            $capacitance = substr($capacitance, 0, -2) / 1000000;
        } else if (substr(strtolower($capacitance), -1) == 'f') {
            $capacitance = substr($capacitance, 0, -1);
        }

        return $capacitance;
    }

    /**
     * Convert string value to uF
     *
     * @param  string $capacitance
     * @return float
     */
    public function convertToMicrofarads($capacitance)
    {
        if (substr(strtolower($capacitance), -2) == 'pf') {
            $capacitance = substr($capacitance, 0, -2) / 1000000;
        } else if (substr(strtolower($capacitance), -2) == 'nf') {
            $capacitance = substr($capacitance, 0, -2) / 1000;
        } else if (substr(strtolower($capacitance), -1) == 'f') {
            $capacitance = substr($capacitance, 0, -1) * 1000000;
        }

        return $capacitance;
    }

    /**
     * Convert string value to nF
     *
     * @param  string $capacitance
     * @return float
     */
    public function convertToNanofarads($capacitance)
    {
        if (substr(strtolower($capacitance), -2) == 'pf') {
            $capacitance = substr($capacitance, 0, -2) / 1000;
        } else if (substr(strtolower($capacitance), -2) == 'uf') {
            $capacitance = substr($capacitance, 0, -2) * 1000;
        } else if (substr(strtolower($capacitance), -1) == 'f') {
            $capacitance = substr($capacitance, 0, -1) * 1000000000;
        }

        return $capacitance;
    }

    /**
     * Convert string value to pF
     *
     * @param  string $capacitance
     * @return float
     */
    public function convertToPicofarads($capacitance)
    {
        if (substr(strtolower($capacitance), -2) == 'nf') {
            $capacitance = substr($capacitance, 0, -2) * 1000;
        } else if (substr(strtolower($capacitance), -2) == 'uf') {
            $capacitance = substr($capacitance, 0, -2) * 1000000;
        } else if (substr(strtolower($capacitance), -1) == 'f') {
            $capacitance = substr($capacitance, 0, -1) * 1000000000000;
        }

        return $capacitance;
    }

    /**
     * Convert string value to amps
     *
     * @param  string $current
     * @return float
     */
    public function convertToAmps($current)
    {
        if (substr(strtolower($current), -2) == 'ma') {
            $current = substr($current, 0, -2) / 1000;
        }

        return $current;
    }

    /**
     * Convert string value to amps
     *
     * @param  string $current
     * @return float
     */
    public function convertToMilliamps($current)
    {
        if (substr(strtolower($current), -1) == 'a') {
            $current = substr($current, 0, -2);
        }

        return ($current * 1000);
    }

    /**
     * Check if number is in scientific notation
     *
     * @param  mixed $number
     * @return boolean
     */
    public function isScientificNotation($number)
    {
        return (is_numeric($number) && (stripos($number, 'E') !== false));
    }

    /**
     * Convert number from scientific notation to normal notation
     *
     * @param  mixed $number
     * @return mixed
     */
    public function convertScientificNotation($number)
    {
        if ((strpos($number, 'E-') !== false)) {
            $e      = substr($number, (strpos($number, 'E-') + 2)) + 1;
            $number = sprintf('%.' . $e . 'f', $number);
        } else if ((strpos($number, 'E+') !== false)) {
            $e      = substr($number, (strpos($number, 'E+') + 2));
            $number = sprintf('%' . $e . 'f', $number);
        } else if ((strpos($number, 'E') !== false)) {
            $e      = substr($number, (strpos($number, 'E') + 1));
            $number = sprintf('%' . $e . 'f', $number);
        }

        return $number;
    }

}