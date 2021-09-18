<?php

namespace Calc\Http\Controller;

use Calc\Form;
use Calc\Service;
use Pop\Application;
use Pop\Http\Server\Request;
use Pop\Http\Server\Response;
use Pop\Controller\AbstractController;
use Pop\View\View;

class IndexController extends AbstractController
{

    /**
     * Application object
     * @var Application
     */
    protected $application = null;

    /**
     * Request object
     * @var Request
     */
    protected $request = null;

    /**
     * Response object
     * @var Response
     */
    protected $response = null;
    /**
     * View path
     * @var string
     */
    protected $viewPath = null;

    /**
     * View object
     * @var View
     */
    protected $view = null;

    /**
     * Constructor for the controller
     *
     * @param  Application $application
     * @param  Request     $request
     * @param  Response    $response
     */
    public function __construct(Application $application, Request $request, Response $response)
    {
        $this->application = $application;
        $this->request     = $request;
        $this->response    = $response;
        $this->viewPath    = __DIR__ . '/../../../view';
    }

    /**
     * Get application object
     *
     * @return Application
     */
    public function application()
    {
        return $this->application;
    }

    /**
     * Get request object
     *
     * @return Request
     */
    public function request()
    {
        return $this->request;
    }

    /**
     * Get response object
     *
     * @return Response
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * Redirect response
     *
     * @param  string $url
     * @param  string $code
     * @param  string $version
     * @return void
     */
    public function redirect($url, $code = '302', $version = '1.1')
    {
        Response::redirect($url, $code, $version);
        exit();
    }

    /**
     * Prepare view
     *
     * @param  string $template
     * @return void
     */
    protected function prepareView($template)
    {
        $this->view = new View($this->viewPath . '/' . $template);
    }

    /**
     * Send response
     *
     * @param  int    $code
     * @param  mixed  $body
     * @param  string $message
     * @param  array  $headers
     * @return void
     */
    public function send($code = 200, $body = null, $message = null, array $headers = null)
    {
        $this->application->trigger('app.send.pre', ['controller' => $this]);

        $this->response->setCode($code);

        if (null !== $message) {
            $this->response->setMessage($message);
        }

        if (null !== $body) {
            $this->response->setBody($body);
        } else if (null !== $this->view) {
            $this->response->setBody($this->view->render());
        }

        $this->application->trigger('app.send.post', ['controller' => $this]);
        $this->response->send(null, $headers);
    }

    /**
     * Custom error handler method
     *
     * @param  int    $code
     * @param  string $message
     * @return void
     */
    public function error($code = 404, $body = null, $message = null, array $headers = null)
    {
        if (null === $message) {
            $message = Response::getMessageFromCode($code);
        }

        if (null !== $message) {
            $this->response->setMessage($message);
        }

        $this->prepareView('error.phtml');
        $this->view->title = 'Tube Amp Calculator';

        $this->response->setCode($code)
            ->setBody($this->view->render());

        $this->response->sendAndExit(null, $headers);
    }

    /**
     * Index action method
     *
     * @return void
     */
    public function index()
    {
        $calculator = new Service\Calculator();

        $this->prepareView('index.phtml');
        $this->view->title = 'Tube Amp Calculator';

        $this->view->formOhm         = Form\Calculator::createFromFieldsetConfig($this->application->config['forms']['ohms']);
        $this->view->formVoltageDiv  = Form\Calculator::createFromFieldsetConfig($this->application->config['forms']['voltage-div']);
        $this->view->formPower       = Form\Calculator::createFromFieldsetConfig($this->application->config['forms']['power']);
        $this->view->formFreq        = Form\Calculator::createFromFieldsetConfig($this->application->config['forms']['freq']);
        $this->view->formResistance  = Form\Calculator::createFromFieldsetConfig($this->application->config['forms']['resistance']);
        $this->view->formCapacitance = Form\Calculator::createFromFieldsetConfig($this->application->config['forms']['capacitance']);

        $this->view->formOhm->setAttributes(['id' => 'ohms-form']);
        $this->view->formVoltageDiv->setAttributes(['id' => 'voltage-form']);
        $this->view->formPower->setAttributes(['id' => 'power-form']);
        $this->view->formFreq->setAttributes(['id' => 'freq-form']);
        $this->view->formResistance->setAttributes(['id' => 'res-form']);
        $this->view->formCapacitance->setAttributes(['id' => 'cap-form']);

        $this->view->farads = $calculator->getFaradConversion();

        $this->send();
    }

    /**
     * Process action method
     *
     * @return void
     */
    public function process()
    {
        if ($this->request->isPost()) {
            $post       = $this->request->getPost();
            $results    = [];
            $calculator = new Service\Calculator();

            switch ($post['type']) {
                case 'ohms':
                    if (!empty($post['current']) && !empty($post['resistance'])) {
                        $results = ['voltage' => $calculator->calculateVoltage($post['current'], $post['resistance'])];
                    } else if (!empty($post['voltage']) && !empty($post['resistance'])) {
                        $results = ['current' => $calculator->calculateCurrent($post['voltage'], $post['resistance'])];
                    } else if (!empty($post['voltage']) && !empty($post['current'])) {
                        $results = ['resistance' => $calculator->calculateResistance($post['voltage'], $post['current'])];
                    }
                    break;
                case 'voltage-div':
                    $results = $calculator->calculateVoltageDivider($post['voltage'], $post['resistance1'], $post['resistance2']);
                    break;
                case 'power':
                    $results = ['power' => $calculator->calculatePower($post['current'], $post['voltage'])];
                    if (!empty($post['max'])) {
                        $results['dissipation'] = $calculator->calculateDissipation($results['power'], $post['max']);
                    }
                    break;
                case 'freq':
                    $results = ['frequency' => $calculator->calculateRcFilter($post['resistance'], $post['capacitance'])];
                    break;
                case 'resistance':
                    $resistanceValues = array_map('trim', explode(',', $post['resistance_values']));
                    if ($post['resistance_type'] == 'Parallel') {
                        $results = ['resistance' => $calculator->calculateResistanceInParallel($resistanceValues)];
                    } else {
                        $results = ['resistance' => $calculator->calculateResistanceInSeries($resistanceValues)];
                    }
                    break;
                case 'capacitance':
                    $capacitanceValues = array_map('trim', explode(',', $post['capacitance_values']));
                    $capacitance = ($post['capacitance_type'] == 'Parallel') ?
                        $calculator->calculateCapacitanceInParallel($capacitanceValues) :
                        $calculator->calculateCapacitanceInSeries($capacitanceValues);

                    $capacitance .= 'F';

                    $uf = $calculator->convertToMicrofarads($capacitance);
                    $nf = $calculator->convertToNanofarads($capacitance);
                    $pf = $calculator->convertToPicofarads($capacitance);

                    $results = [
                        'capacitance' => [
                            'F'  => $capacitance,
                            'uF' => $uf,
                            'nF' => $nf,
                            'pF' => $pf
                        ]
                    ];

                    break;
            }

            $this->send(200, json_encode($results, JSON_PRETTY_PRINT), 'OK', ['Content-Type' => 'application/json']);
        } else {
            $this->send(404, json_encode(['error' => 'Page not found'], JSON_PRETTY_PRINT), null, ['Content-Type' => 'application/json']);
        }
    }

}