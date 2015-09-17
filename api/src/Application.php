<?php

namespace Favoroute;

use \Exception;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *
 * @package    Favoroute Image Uploader
 * @author     Paolo Pietropoli (ilpaijin) <ilpaijin@gmail.com>
 * @copyright  ilpaijin
 * @license
 * @version    Release: @package_version@
 */
class Application
{
    /**
     * @var [type]
     */
    private $request;

    /**
     * @var array
     */
    private $routes = array();


    /**
     * run the application
     *
     * @return mixed
     */
    public function run()
    {
        $this->boot();

        $this->request = Request::createFromGlobals();

        if (!array_key_exists($uri = $_SERVER['REQUEST_URI'], $this->routes)) {
            $this->notFound();
        }

        list($controller, $action) = explode(":", $this->routes[$uri]);

        $c = "Favoroute\Controller\\".$controller;
        $controller = new $c(/*some Dependeny Container*/);

        if (!method_exists($c, strtolower($_SERVER['REQUEST_METHOD']))) {
            $this->methodNotAllowed();
        }

        $response = $controller->$action($this->request);
        $response->send();
    }

    /**
     * post router's action
     * @param  string $path
     * @param  string $controller
     * @return void
     */
    public function post($path, $controller)
    {
        $this->routes[$path] = $controller;
    }

    /**
     * boot the application behaviour
     *
     * @return void
     */
    public function boot()
    {
        set_exception_handler(array($this, 'exception_handler'));
    }

    /**
     * Exception handler
     *
     * @param  Exception $e
     * @return mixed
     */
    public function exception_handler(Exception $e)
    {
        $response = new JsonResponse(
            array(
                'error' => array(
                    'statusMessage' => $e->getMessage(),
                    'statusCode' => $e->getCode(),
                    'details' => '//'
                )
            ),
            $e->getCode()
        );

       $response->send();
    }

    /**
     * Sugar for erorr methid call, mapped to http spec responses
     *
     * @throws Exception
     * @return void
     */
    public function notFound()
    {
        throw new Exception('Endpoint not found', 404);
    }

    public function methodNotAllowed()
    {
        throw new Exception('method not allowed', 405);
    }
}
