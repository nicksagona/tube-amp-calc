<?php

namespace Calc\Service;

use Calc\Model;

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
        return round(($this->convertToVolts($voltage) / $this->convertToAmps($current)), $round);
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
        return ($this->convertToVolts($voltage) / $this->convertToOhms($resistance));
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
        return round(($this->convertToAmps($current) * $this->convertToVolts($voltage)), $round);
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
        $voltageOut  = round(($this->convertToVolts($voltageIn) * ($resistance2 / ($resistance1 + $resistance2))), 2);
        $dbReduction = round((20 * log10($this->convertToVolts($voltageOut) / $this->convertToVolts($voltageIn))), 2);

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
     * Calculate Bias
     *
     * @param  array  $data
     * @param  int    $round
     * @return array
     */
    public function calculateBias(array $data, $round = 2)
    {
        $tubeModel    = new Model\Tube();
        $ampOperation = $data['amp_operation'] ?? null;
        $ampBiasType  = $data['amp_bias_type'] ?? null;
        $ampConfig    = null;
        $tubeType     = $data['tube_type'] ?? null;
        $numOfTubes   = null;
        $bPlus        = $data['bPlus'] ?? null;
        $ot1          = $data['ot1'] ?? null;
        $ot2          = $data['ot2'] ?? null;
        $pv1          = $data['pv1'] ?? null;
        $pv2          = $data['pv2'] ?? null;
        $tubeData     = $tubeModel->getTubeValues($tubeType);

        if (strpos($ampConfig, 'Quartet') !== false) {
            $numOfTubes = 4;
        } else if (strpos($ampConfig, 'Pair') !== false) {
            $numOfTubes = 2;
        } else if (strpos($ampConfig, 'Single') !== false) {
            $numOfTubes = 1;
        }

        switch ($data['amp_config']) {
            case 'PP-Pair':
                $ampConfig  = 'Push-Pull';
                $numOfTubes = 2;
                break;
            case 'PP-Quartet':
                $ampConfig  = 'Push-Pull';
                $numOfTubes = 4;
                break;
            case 'SE-Single':
                $ampConfig  = 'Single-Ended';
                $numOfTubes = 1;
                break;
            case 'SE-Pair':
                $ampConfig  = 'Single-Ended';
                $numOfTubes = 2;
                break;
        }

        $results = [
            'amp_operation' => $ampOperation,
            'amp_bias_type' => $ampBiasType,
            'amp_config'    => $ampConfig,
            'tube_type'     => (strpos($tubeType, '-') !== false) ? substr($tubeType, 0, strpos($tubeType, '-')) : $tubeType,
            'num_of_tubes'  => $numOfTubes,
            'nominal_bias'  => $tubeModel->getNominalBiasValue($ampOperation, $ampBiasType)
        ];

        if (!empty($tubeData['plate_dissipation'])) {
            $results['max_plate_dissipation'] = $tubeData['plate_dissipation'] . 'W';
            $results['max_plate_voltage']     = $tubeData['plate_voltage'] . 'V';
            $results['max_cathode_current']   = $tubeData['cathode_current'] . 'mA';

            $tube1VoltageDrop      = round(($bPlus - $pv1), $round);
            $tube1PlateCurrent     = (($data['amp_config'] == 'PP-Quartet') || ($data['amp_config'] == 'SE-Pair')) ? round(((($tube1VoltageDrop / $ot1) * 1000) / 2), $round) : round((($tube1VoltageDrop / $ot1) * 1000), $round);
            $tube1PlateDissipation = round((($tube1PlateCurrent / 1000) * $pv1), $round);
            $tube1BiasPoint        = round((($tube1PlateDissipation / $tubeData['plate_dissipation']) * 100), $round);

            $results['tube1_voltage_drop']      = $tube1VoltageDrop . 'V';
            $results['tube1_plate_current']     = $tube1PlateCurrent . 'mA';
            $results['tube1_plate_dissipation'] = $tube1PlateDissipation . 'W';
            $results['tube1_bias_point']        = $tube1BiasPoint . '%';
            $results['tube1_bias_result']       = $tubeModel->getBiasResult($tube1BiasPoint, $ampOperation, $ampBiasType);

            if (!empty($ot2) && !empty($pv2) && ($ampConfig == 'Push-Pull')) {
                $tube2VoltageDrop      = round(($bPlus - $pv2), $round);
                $tube2PlateCurrent     = ($data['amp_config'] == 'PP-Quartet') ? round(((($tube2VoltageDrop / $ot2) * 1000) / 2), $round) : round((($tube2VoltageDrop / $ot2) * 1000), $round);
                $tube2PlateDissipation = round((($tube2PlateCurrent / 1000) * $pv2), $round);
                $tube2BiasPoint        = round((($tube2PlateDissipation / $tubeData['plate_dissipation']) * 100), $round);

                $results['tube2_voltage_drop']      = $tube2VoltageDrop . 'V';
                $results['tube2_plate_current']     = $tube2PlateCurrent . 'mA';
                $results['tube2_plate_dissipation'] = $tube2PlateDissipation . 'W';
                $results['tube2_bias_point']        = $tube2BiasPoint . '%';
                $results['tube2_bias_result']       = $tubeModel->getBiasResult($tube2BiasPoint, $ampOperation, $ampBiasType);
            }
        }

        return $results;
    }

    /**
     * Calculate Output Transformer Values
     *
     * @param  int    $voltagePrimary
     * @param  int    $voltageSecondary
     * @param  int    $primaryImpedance
     * @param  int    $speakerImpedance
     * @param  int    $round
     * @return array
     */
    public function calculateOTValues($voltagePrimary = null, $voltageSecondary = null, $primaryImpedance = null, $speakerImpedance = null, $round = 2)
    {
        $windingRatio   = null;
        $impedanceRatio = null;

        if (!empty($primaryImpedance) && (stripos($primaryImpedance, 'K') !== false)) {
            $primaryImpedance = strtolower($primaryImpedance);
            $primaryImpedance = substr($primaryImpedance, 0, stripos($primaryImpedance, 'k')) * 1000;
        }
        if (!empty($voltagePrimary)) {
            $voltagePrimary = $this->convertToVolts($voltagePrimary);
        }
        if (!empty($voltageSecondary)) {
            $voltageSecondary = $this->convertToVolts($voltageSecondary);
        }
        
        if (!empty($voltageSecondary) && !empty($voltagePrimary) && !empty($primaryImpedance)) {
            $windingRatio     = round(($voltagePrimary / $voltageSecondary), $round);
            $impedanceRatio   = round(pow($windingRatio, 2), $round);
            $speakerImpedance = round(($primaryImpedance / $impedanceRatio), $round);
        } else if (!empty($voltageSecondary) && !empty($voltagePrimary) && !empty($speakerImpedance)) {
            $windingRatio     = round(($voltagePrimary / $voltageSecondary), $round);
            $impedanceRatio   = round(pow($windingRatio, 2), $round);
            $primaryImpedance = round(($speakerImpedance * $impedanceRatio), $round);
        } else if (!empty($primaryImpedance) && !empty($speakerImpedance)) {
            $impedanceRatio = round(($primaryImpedance / $speakerImpedance), $round);
            $windingRatio   = round(sqrt($impedanceRatio), $round);
        }

        return [
            'voltage_primary'   => $voltagePrimary,
            'voltage_secondary' => $voltageSecondary,
            'winding_ratio'     => $windingRatio,
            'impedance_ratio'   => $impedanceRatio,
            'primary_impedance' => $primaryImpedance,
            'speaker_impedance' => $speakerImpedance
        ];
    }

    /**
     * Calculate B+ voltage
     *
     * @param  int    $vac
     * @param  string $rectifier
     * @param  int    $round
     * @return array
     */
    public function calculateBPlusVoltage($vac, $rectifier, $round = 2)
    {
        $upperFactor = null;
        $lowerFactor = null;

        switch ($rectifier) {
            case 'GZ34':
                $upperFactor = 1.3;
                break;
            case 'EZ81':
                $upperFactor = 1.3;
                $lowerFactor = 1.2;
                break;
            case '5U4':
                $upperFactor = 1.2;
                break;
            case '5Y3':
                $upperFactor = 1.175;
                $lowerFactor = 1.025;
                break;
            case 'Silicon':
                $upperFactor = 1.4;
                $lowerFactor = 1.35;
                break;
        }

        $upperVoltage = round(($vac * $upperFactor), $round);
        $lowerVoltage = null;

        if (null !== $lowerFactor) {
            $lowerVoltage = round(($vac * $lowerFactor), $round);
        }

        return [
            'upper_voltage' => $upperVoltage,
            'lower_voltage' => $lowerVoltage
        ];
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
     * Convert string value to volts
     *
     * @param  string $voltage
     * @return float
     */
    public function convertToVolts($voltage)
    {
        if (substr(strtolower($voltage), -2) == 'mv') {
            $voltage = substr($voltage, 0, -2) / 1000;
        }

        return $voltage;
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