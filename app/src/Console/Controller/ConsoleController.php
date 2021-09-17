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
     * Voltage command
     *
     * @param  float $current
     * @param  float $resistance
     * @return void
     */
    public function voltage($current, $resistance)
    {
        $calculator = new Calculator();
        $this->console->write($calculator->calculateVoltage($current, $resistance) . ' Volts');
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
        $calculator = new Calculator();
        $result     = $calculator->calculateVoltageDivider($voltageIn, $resistance1, $resistance2);
        $this->console->write('V(in):  ' . $voltageIn . ' Volts');
        $this->console->write('V(out): ' . $result['voltage_out'] . ' Volts');
        $this->console->write('dB:     ' . $result['db_reduction'] . ' dB');
    }

    /**
     * Power command
     *
     * @param  float $current
     * @param  float $voltage
     * @return void
     */
    public function power($current, $voltage)
    {
        $calculator = new Calculator();
        $this->console->write($calculator->calculatePower($current, $voltage) . ' Watts');
    }

    /**
     * Resistance command
     *
     * @param  array $options
     * @return void
     */
    public function resistance(array $options = [])
    {
        $calculator = new Calculator();

        if (isset($options['s'])) {
            $resistance =
                $calculator->calculateResistanceInSeries($options['ohms']);
        } else if (isset($options['p'])) {
            $resistance = $calculator->calculateResistanceInParallel($options['ohms']);
        } else {
            throw new Exception('Error: You must pass a parallel [-p] or series [-s] option flag.');
        }

        $this->console->write($resistance . ' Ohms');
    }

    /**
     * Capacitance command
     *
     * @param  array $options
     * @return void
     */
    public function capacitance(array $options = [])
    {
        $calculator = new Calculator();

        if (isset($options['s'])) {
            $capacitance =
                $calculator->calculateCapacitanceInSeries($options['farads']);
        } else if (isset($options['p'])) {
            $capacitance = $calculator->calculateCapacitanceInParallel($options['farads']);
        } else {
            throw new Exception('Error: You must pass a parallel [-p] or series [-s] option flag.');
        }

        $this->console->write($capacitance . ' Farads');
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
        if (substr(strtolower($capacitance), -2) == 'pf') {
            $capacitance = substr($capacitance, 0, -2) / 1000000000000;
        } else if (substr(strtolower($capacitance), -2) == 'nf') {
            $capacitance = substr($capacitance, 0, -2) / 1000000000;
        } else if (substr(strtolower($capacitance), -2) == 'uf') {
            $capacitance = substr($capacitance, 0, -2) / 1000000;
        }

        $calculator = new Calculator();
        $this->console->write($calculator->calculateRcFilter($resistance, $capacitance) . ' Hz');
    }

}