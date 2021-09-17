<?php

namespace Calc\Console\Controller;

use Calc\Service\Calculator;
use Pop\Application;
use Pop\Console\Console;
use Pop\Controller\AbstractController;
use Calc\Exception;

/**
 * Console controller class
 *
 * @category   Nova\Auth
 * @package    Nova\Auth
 * @link       https://github.com/punctualabstract/titlenova-auth
 * @author     Nick Sagona, III <nsagona@punctualabstract.com>
 * @copyright  Copyright (c) 2018-2020 Punctual Abstract. (http://www.punctualabstract.com)
 * @version    0.0.8
 */
class ConsoleController extends AbstractController
{

    /**
     * Application object
     * @var Application
     */
    protected $application = null;

    /**
     * Console object
     * @var Console
     */
    protected $console = null;

    /**
     * Constructor for the controller
     *
     * @param  Application $application
     * @param  Console     $console
     */
    public function __construct(Application $application, Console $console)
    {
        $this->application = $application;
        $this->console     = $console;
        $moduleName        = null;

        foreach ($application->modules() as $module) {
            if ($module->hasName()) {
                $moduleName = $module->getName();
                break;
            }
        }

        $this->console->setHelpColors(Console::BOLD_CYAN, Console::BOLD_GREEN, Console::BOLD_MAGENTA);
        $this->console->addCommandsFromRoutes($application->router()->getRouteMatch(), './' . $moduleName);
    }

    /**
     * Print title to screen
     *
     * @param  string $title
     * @return void
     */
    public function printTitle($title)
    {
        $this->console->append($title);
        $this->console->append(str_repeat('-', strlen($title)));
        $this->console->append();
    }

    /**
     * Version command
     *
     * @return void
     */
    public function version()
    {
        $this->console->write('Version: ' . $this->console->colorize(\Calc\Module::VERSION, Console::BOLD_GREEN));
    }

    /**
     * Help command
     *
     * @return void
     */
    public function help()
    {
        $this->console->help();
    }

    /**
     * Convert command
     *
     * @return void
     */
    public function convert()
    {
        $this->printTitle("Capacitance Conversion Chart:");

        $this->console->write("Microfarads (uF) | Nanofarads (nF) | Picofarads (pF)");
        $this->console->write("----------------------------------------------------");

        $calculator = new Calculator();
        $farads     = $calculator->getFaradConversion();

        foreach ($farads as $farad) {
            $this->console->write(
                '| ' . $farad['micro'] . str_repeat(' ', 14 - strlen($farad['micro'])) . ' | ' .
                $farad['nano'] . str_repeat(' ', 15 - strlen($farad['nano'])) . ' | ' .
                $farad['pico'] . str_repeat(' ', 14 - strlen($farad['pico'])) . '|'
            );
        }

        $this->console->write("----------------------------------------------------");
    }

    /**
     * Voltage command
     *
     * @param  float $current
     * @param  float $resistance
     * @return void
     */
    public function voltage($current, $resistance)
    {
        $this->printTitle("Ohm's Law:");

        $calculator = new Calculator();
        $volts      = $calculator->calculateVoltage($calculator->convertToAmps($current), $calculator->convertToOhms($resistance));
        $this->console->write($volts . ' Volts');
    }

    /**
     * Resistance command
     *
     * @param  float $voltage
     * @param  float $current
     * @return void
     */
    public function resistance($voltage, $current)
    {
        $this->printTitle("Ohm's Law:");

        $calculator = new Calculator();
        $ohms       = $calculator->calculateResistance($voltage, $calculator->convertToAmps($current));
        $this->console->write($ohms . ' Ohms');
    }

    /**
     * Current command
     *
     * @param  float $voltage
     * @param  float $resistance
     * @return void
     */
    public function current($voltage, $resistance)
    {
        $this->printTitle("Ohm's Law:");

        $calculator = new Calculator();
        $amps       = $calculator->calculateCurrent($voltage, $calculator->convertToOhms($resistance));

        if ($amps < 1) {
            $amps .= ' Amps (' . $calculator->convertToMilliamps($amps) . 'mA)';
        } else {
            $amps .= ' Amps';
        }

        $this->console->write($amps);
    }

    /**
     * Voltage divider command
     *
     * @param  float $voltageIn
     * @param  float $resistance1
     * @param  float $resistance2
     * @return void
     */
    public function voltageDivider($voltageIn, $resistance1, $resistance2)
    {
        $this->printTitle("Voltage Divider");

        $calculator = new Calculator();
        $result     = $calculator->calculateVoltageDivider(
            $voltageIn, $calculator->convertToOhms($resistance1), $calculator->convertToOhms($resistance2)
        )
;
        $this->console->write('V(in):  ' . $voltageIn . ' Volts');
        $this->console->write('V(out): ' . $result['voltage_out'] . ' Volts');
        $this->console->write('dB:     ' . $result['db_reduction'] . ' dB');
    }

    /**
     * Power command
     *
     * @param  float $current
     * @param  float $voltage
     * @param  float $max
     * @return void
     */
    public function power($current, $voltage, $max = null)
    {
        $this->printTitle("Power:");

        $calculator = new Calculator();
        $power      = $calculator->calculatePower($calculator->convertToAmps($current), $voltage);

        if (null !== $max) {
            $dissipation = $calculator->calculateDissipation($power, $max);
            $power      .= ' Watts (' . $dissipation . '% dissipation)';
        } else {
            $power .= ' Watts';
        }

        $this->console->write($power);
    }

    /**
     * Frequency command
     *
     * @param  float $resistance
     * @param  float $capacitance
     * @return void
     */
    public function frequency($resistance, $capacitance)
    {
        $this->printTitle("RC Filter:");

        $calculator = new Calculator();
        $frequency  = $calculator->calculateRcFilter($calculator->convertToOhms($resistance), $calculator->convertToFarads($capacitance));
        $this->console->write($frequency . ' Hz');
    }

    /**
     * Resistance command
     *
     * @param  array $options
     * @return void
     */
    public function ohms(array $options = [])
    {
        $title      = 'Resistance';
        $calculator = new Calculator();

        if (isset($options['s'])) {
            $title      .= ' (in Series)';
            $resistance  = $calculator->calculateResistanceInSeries($options['ohms']);
        } else if (isset($options['p'])) {
            $title      .= ' (in Parallel)';
            $resistance  = $calculator->calculateResistanceInParallel($options['ohms']);
        } else {
            throw new Exception('Error: You must pass a parallel [-p] or series [-s] option flag.');
        }

        $this->printTitle($title);
        $this->console->write($resistance . ' Ohms');
    }

    /**
     * Capacitance command
     *
     * @param  array $options
     * @return void
     */
    public function farads(array $options = [])
    {
        $title      = 'Capacitance';
        $calculator = new Calculator();

        if (isset($options['s'])) {
            $title      .= ' (in Series)';
            $capacitance = $calculator->calculateCapacitanceInSeries($options['farads']);
        } else if (isset($options['p'])) {
            $title      .= ' (in Parallel)';
            $capacitance = $calculator->calculateCapacitanceInParallel($options['farads']);
        } else {
            throw new Exception('Error: You must pass a parallel [-p] or series [-s] option flag.');
        }

        $capacitance .= 'F';

        $uf = $calculator->convertToMicrofarads($capacitance);
        $nf = $calculator->convertToNanofarads($capacitance);
        $pf = $calculator->convertToPicofarads($capacitance);

        $this->printTitle($title);
        $this->console->write($capacitance . ' [' . $uf . 'uF, ' . $nf . 'nF, ' . $pf . 'pF]');
    }

}