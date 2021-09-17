<?php

namespace Calc\Http\Controller;

use Pop\Application;
use Pop\Http\Server\Request;
use Pop\Http\Server\Response;
use Pop\Controller\AbstractController;

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

        $this->response->setBody($body);

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

        $this->response->setCode($code)
            ->setBody($body);

        $this->response->sendAndExit(null, $headers);
    }

    /**
     * Index action method
     *
     * @return void
     */
    public function index()
    {
        $this->send(200, '<html><head><title>Tube Amp Calc</title></head><body><h1>Tube Amp Calc</h1></body></html>');
    }

}