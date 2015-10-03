<?php
namespace Framework;


use Framework\Routers\DefaultRouter;
use Framework\Routers\IRouter;
use ReflectionClass;

class FrontController
{
    private static $_instance = null;
    private $namespace = null;
    private $controller = null;
    private $method = null;
    /**
     * @var InputData
     */
    private $input = null;
    /**
     * @var IRouter
     */
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

        $this->input = InputData::getInstance();
        $_params = explode('/', $_uri);
        if ($_params[0]) {
            $this->controller = strtolower($_params[0]);

            if ($_params[1]) {
                $this->method = strtolower($_params[1]);
                unset($_params[0], $_params[1]);
                $this->input->setGet(array_values($_params));
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

        $this->input->setPost($this->router->getPost());
        //TODO Fix
        $controller = $this->namespace . '\\' . ucfirst($this->controller);
        $newController = new $controller();
        $this->loadMethod($newController);
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

    private function loadMethod($newController)
    {
        $isMethodExists = false;

        $reflectionController = new ReflectionClass($newController);
        $reflectionMethods = $reflectionController->getMethods();

        $roles = App::getInstance()->getInstance()->getConfig()->roles;

        $bindingModel = null;

        foreach ($reflectionMethods as $reflectionMethod) {
            if ($this->method === $reflectionMethod->getName()) {
                $doc = $reflectionMethod->getDocComment();

                $annotations = array();
                preg_match_all('#@(.*?)\n#s', $doc, $annotations);
                foreach ($annotations[1] as $annotation) {
                    $annotation = trim($annotation);
                    if ($annotation === "POST" && $this->input->hasGet()) {
                        throw new \Exception("Cannot access Post method with Get request", 406);
                    }
                    if ($annotation === "GET" && $this->input->hasPost()) {
                        throw new \Exception("Cannot access Get method with Post request", 406);
                    }
                    if($annotation == 'Authorize' && !$_SESSION['userid']){
                        throw new \Exception('You are not authorized to do this');
                    }
                    if($annotation == 'Admin' && !$_SESSION['adminId']){
                        throw new \Exception('You are not admin');
                    }
                }

                if($this->input->hasPost()){
                    $bindingModel = $this->BindModel($annotations[1]);
                }

                $isMethodExists = true;
            }
        }

        if ($isMethodExists) {
            if($bindingModel){
                $newController->{$this->method}($bindingModel);
            } else {
                $newController->{$this->method}();
            }
        } else {
            throw new \Exception("This action do not exists", 404);
        }
    }

    private function BindModel($annotations)
    {
        $bindingNamespace = null;
        $appConfig = App::getInstance()->getConfig()->app;
        $namespaces = $appConfig['namespaces'];
        foreach ($namespaces as $key => $value) {
            if (strpos($key, "BindingModels")) {
                $bindingNamespace = $key;
            }
        }
        $bindingModelName = null;
        foreach ($annotations as $annotation) {
            $bindingAnnotation = explode(' ', $annotation);
            if (trim($bindingAnnotation[0]) === 'BindingModels') {
                $bindingModelName = trim($bindingAnnotation[1]);
            }
        }
        $bindingModel = null;
        if ($bindingNamespace && $bindingModelName) {
            $bindingModelClass = $bindingNamespace . "\\" . $bindingModelName;
            $bindingModel = new $bindingModelClass;
            $reflectionModel = new ReflectionClass($bindingModel);
            $properties = $reflectionModel->getProperties();
            $post = $this->input->post();
            foreach ($properties as $property) {
                $propertyName = ucfirst($property->getName());
                $propertyDoc = $property->getDocComment();
                $annotations = array();
                preg_match_all('#@(.*?)\n#s', $propertyDoc, $annotations);
                $set = 'set' . $propertyName;
                if (trim($annotations[1][0]) === "Required" && !$post[$propertyName]) {
                    throw new \Exception("Field " . $propertyName . " is required");
                }
                if (array_key_exists($propertyName, $post)) {
                    $bindingModel->$set($post[$propertyName]);
                } else {
                    throw new \Exception("Field " . $propertyName . " is not accepted");
                }
            }
        }
        return $bindingModel;
    }
}