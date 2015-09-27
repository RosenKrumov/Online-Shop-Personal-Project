<?php
namespace Framework;


use Framework\Routers\DefaultRouter;
use Framework\Routers\IRouter;

class FrontController
{
    private static $_instance = null;
    private $namespace = null;
    private $controller = null;
    private $method = null;
    private $router = null;

    private function __construct()
    {

    }

    public function getRouter()
    {
        return $this->router;
    }

    public function setRouter(IRouter $router)
    {
        $this->router = $router;
    }

    public function dispatch()
    {
        if($this->router == null){
            throw new \Exception('No valid router found', 500);
        }

        $_uri = $this->router->getUri();
        $routes = App::getInstance()->getConfig()->routes;
        $configParams = null;
        if (is_array($routes) && count($routes) > 0) {
            foreach ($routes as $key => $value) {
                if (stripos($_uri, $key) === 0 &&
                    ($_uri == $key || stripos($_uri, $key . '/') === 0)
                    && $value['namespace']
                ) {
                    $this->namespace = $value['namespace'];
                    $_uri = substr($_uri, strlen($key) + 1);
                    $configParams = $value;
                    break;
                }
            }
        } else {
            throw new \Exception('Default route missing', 500);
        }

        if ($this->namespace == null && $routes['*']['namespace']) {
            $this->namespace = $routes['*']['namespace'];
            $configParams = $routes['*'];
        } else if ($this->namespace == null && !$routes['*']['namespace']) {
            throw new \Exception('Default route missing', 500);
        }

        $_params = explode('/', $_uri);
        if ($_params[0]) {
            $this->controller = strtolower($_params[0]);

            if ($_params[1]) {
                $this->method = strtolower($_params[1]);
            } else {
                $this->method = $this->getDefaultMethod();
            }
        } else {
            $this->controller = $this->getDefaultController();
            $this->method = $this->getDefaultMethod();
        }

        if (is_array($configParams) && $configParams['controllers']) {
            if ($configParams['controllers'][$this->controller]['methods'][$this->method]) {
                $this->method = strtolower($configParams['controllers'][$this->controller]['methods'][$this->method]);
            }
            if(isset($configParams['controllers'][$this->controller]['to'])){
                $this->controller = strtolower($configParams['controllers'][$this->controller]['to']);
            }
        }

        //TODO Fix
        $controller = $this->namespace . '\\' . ucfirst($this->controller);
        $newController = new $controller();
        $newController->{$this->method}();
    }

    public function getDefaultController()
    {
        $controller = App::getInstance()->getConfig()->app['default_controller'];
        if ($controller) {
            return strtolower($controller);
        }
        return 'index';
    }

    public function getDefaultMethod()
    {
        $method = App::getInstance()->getConfig()->app['default_method'];
        if ($method) {
            return strtolower($method);
        }
        return 'index';
    }

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new FrontController();
        }

        return self::$_instance;
    }
}