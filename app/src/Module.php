<?php
/**
 * Tube Amp Common Equations
 *
 * @link       https://github.com/nicksagona/tube-amp-calc
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2018 NOLA Interactive. (http://www.nolainteractive.com)
 */

/**
 * @namespace
 */
namespace TubeCalc;

use Pop\Application;
use Pop\Http\Request;
use Pop\Http\Response;
use Pop\View\View;

/**
 * TubeCalc module class
 *
 * @category   TubeCalc
 * @package    TubeCalc
 * @link       https://github.com/nicksagona/tube-amp-calc
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2018 NOLA Interactive. (http://www.nolainteractive.com)
 * @version    0.0.1-alpha
 */
class Module extends \Pop\Module\Module
{

    /**
     * Module version
     * @var string
     */
    const VERSION = '0.0.1-alpha';

    /**
     * Module name
     * @var string
     */
    const NAME = 'tube-amp-calc';

    /**
     * Module name
     * @var string
     */
    protected $name = self::NAME;

    /**
     * Module version
     * @var string
     */
    protected $version = self::VERSION;

    /**
     * Register module
     *
     * @param  Application $application
     * @return Module
     */
    public function register(Application $application)
    {
        parent::register($application);

        if (null !== $this->application->router()) {
            $this->application->router()->addControllerParams(
                '*', [
                    'application' => $this->application,
                    'request'     => new Request(),
                    'response'    => new Response()
                ]
            );
        }

        return $this;
    }

    /**
     * HTTP error handler method
     *
     * @param  \Exception $exception
     * @return void
     */
    public function httpError(\Exception $exception)
    {
        $response = new Response();
        $view     = new View(__DIR__ . '/../view/exception.phtml', ['message' => $exception->getMessage()]);

        $response->setHeader('Content-Type', 'text/html');
        $response->setBody($view->render());
        $response->send(500);
    }

}