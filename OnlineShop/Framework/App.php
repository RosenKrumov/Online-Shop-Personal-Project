<?php

namespace Framework;

use Framework\Routers\DefaultRouter;
use Framework\Routers\IRouter;
use Framework\Sessions\ISession;
use Framework\Sessions\NativeSession;
use ReflectionClass;

include_once 'Loader.php';

class App
{
    private static $_instance = null;
    private $_config = null;
    private $_frontController = null;
    private $router = null;
    private $_dbConnections = [];
    private $_session = null;

    private function __construct()
    {
        //set_exception_handler(array($this, '_exceptionHandler'));
        Loader::registerNamespace('Framework', dirname(__FILE__) . DIRECTORY_SEPARATOR);
        Loader::registerAutoLoad();
        $this->_config = Config::getInstance();
        if($this->_config->getConfigFolder() == null){
            $this->setConfigFolder('../Config');
        }
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function setRouter($router)
    {
        $this->router = $router;
    }

    public function setConfigFolder($path) {
        $this->_config->setConfigFolder($path);
    }

    public function getConfigFolder(){
        return $this->_configFolder;
    }

    /**
     * @return Config
     */
    public function getConfig(){
        return $this->_config;
    }

    public function run(){
        if($this->_config->getConfigFolder() == null){
            $this->setConfigFolder('../Config');
        }

        $this->_frontController = FrontController::getInstance();

        if($this->router instanceof IRouter){
            $this->_frontController->setRouter($this->router);
        } else if($this->router == 'JsonRPCRouter'){
            //TODO fix it when RPC is done
            $this->_frontController->setRouter(new DefaultRouter());
        } else if($this->router == 'CLIRouter'){
            //TODO fix it when CLI is done
            $this->_frontController->setRouter(new DefaultRouter());
        } else {
            $this->_frontController->setRouter(new DefaultRouter());
        }

        $_sess = $this->_config->app['session'];
        if($_sess['autostart']){
            if($_sess['type'] == 'native'){
                $s = new NativeSession
                (
                    $_sess['name'],
                    $_sess['lifetime'],
                    $_sess['path'],
                    $_sess['domain'],
                    $_sess['secure']
                );
            }

            $this->setSession($s);
        }

        $this->overrideRoutes();
        $this->_frontController->dispatch();
    }

    public function getSession(){
        return $this->_session;
    }

    public function setSession(ISession $session){
        $this->_session = $session;
    }

    public function getDbConnection($connection = null){
        if($connection == null){
            $connection = 'default';
        }

        if(!$connection){
            throw new \Exception('No connection identifier provided', 500);
        }

        if($this->_dbConnections[$connection]){
            return $this->_dbConnections[$connection];
        }

        $_cnf = $this->getConfig()->database;
        if(!$_cnf[$connection]){
            throw new \Exception('No valid connection identifier is provided', 500);
        }

        $newConnection = new \PDO(
            $_cnf[$connection]['connection_uri'],
            $_cnf[$connection]['username'],
            $_cnf[$connection]['password'],
            $_cnf[$connection]['pdo_options']
        );
        $this->_dbConnections[$connection] = $newConnection;
        return $newConnection;
    }

    public function _exceptionHandler(\Exception $ex){
        if($this->_config && $this->_config->app['displayExceptions'] == true){
            var_dump($ex);
        } else {
            $this->displayError($ex);
        }
    }

    public function displayError(\Exception $error){
        $message = ['error' => $error->getMessage(), 'isLogged' => $this->_session->userid];

        try {
            $view = View::getInstance();
            $view->display('error', $message);
        } catch (\Exception $ex) {
            Common::headerStatus($error);
            echo '<h1>' . $error->getMessage() . '</h1>';
            exit;
        }
    }

    /**
     * @return App
     */
    public static function getInstance(){
        if (self::$_instance == null) {
            self::$_instance = new App();
        }

        return self::$_instance;
    }


    private function overrideRoutes()
    {
        $configRoute = $this->_config->getConfigFolder() . "routes.php";
        $testFile = fopen($configRoute, "w") or die("Unable to open file!");
        $startTag = "<?php\n";
        fwrite($testFile, $startTag);

        $namespaces = $this->getConfig()->app['namespaces'];
        foreach ($namespaces as $namespace => $value) {
            if(strpos($namespace, 'Controllers') || $namespace == 'Controllers') {
                $files = scandir($value);
                foreach ($files as $file) {
                    if(strpos($file, '.php')) {
                        $controllerName = str_replace('.php', '', $file);
                        $controller = $namespace . '\\' . $controllerName;
                        $reflectionController = new ReflectionClass(new $controller);
                        $reflectionMethods = $reflectionController->getMethods();
                        foreach ($reflectionMethods as $reflectionMethod) {
                            $doc = $reflectionMethod->getDocComment();
                            $annotations = array();
                            preg_match_all('#@(.*?)\n#s', $doc, $annotations);
                            foreach ($annotations[1] as $annotation) {
                                if(substr($annotation, 0, 5) == 'Route') {

                                    $newRoute = array();
                                    preg_match('/"(.*?)"/', $annotation, $newRoute);

                                    $params = explode("/", $newRoute[1]);
                                    $params = array_values(array_filter($params));

                                    if(count($params) > 2) {

                                        $area = $params[0];
                                        $areaNamespace = "\$cnf['". $area ."']['namespace'] = '". $namespace ."';\n";
                                        fwrite($testFile, $areaNamespace);

                                        $oldControllerName = strtolower($controllerName);
                                        $newControllerName = $params[1];

                                        if($newControllerName !== $oldControllerName) {
                                            $replaceController = "\$cnf['". $area ."']['controllers']['". $newControllerName ."']['to'] = '". $oldControllerName ."';\n";
                                            fwrite($testFile, $replaceController);
                                        }

                                        $oldMethodName = $reflectionMethod->getName();
                                        $newMethodName = $params[2];

                                        $replaceMethod = "\$cnf['". $area ."']['controllers']['". $newControllerName ."']['methods']['" . $newMethodName . "'] = '" . $oldMethodName . "';\n";
                                        fwrite($testFile, $replaceMethod);

                                        if($oldMethodName !== $newMethodName) {
                                            $replaceMethod = "\$cnf['". $area ."']['controllers']['". $newControllerName ."']['methods']['" . $oldMethodName . "'] = '" . "notFound" . "';\n";
                                            fwrite($testFile, $replaceMethod);
                                        }

                                    } else {
                                        $oldControllerName = strtolower($controllerName);
                                        $newControllerName = $params[0];

                                        if($newControllerName !== $oldControllerName) {
                                            $replaceController = "\$cnf['*']['controllers']['". $newControllerName ."']['to'] = '". $oldControllerName ."';\n";
                                            fwrite($testFile, $replaceController);
                                        }

                                        $oldMethodName = $reflectionMethod->getName();
                                        $newMethodName = $params[1];

                                        $replaceMethod = "\$cnf['*']['controllers']['". $newControllerName ."']['methods']['" . $newMethodName . "'] = '" . $oldMethodName . "';\n";
                                        fwrite($testFile, $replaceMethod);

                                        if($oldMethodName !== $newMethodName) {
                                            $replaceMethod = "\$cnf['*']['controllers']['". $newControllerName ."']['methods']['" . $oldMethodName . "'] = '" . "notFound" . "';\n";
                                            fwrite($testFile, $replaceMethod);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $namespacesConfig = App::getInstance()->getConfig()->namespaces;
        foreach ($namespacesConfig as $k => $v) {
            $customNamespace = "\$cnf['". $k ."']['namespace'] = '". $v['namespace'] ."';\n";
            fwrite($testFile, $customNamespace);
        }

        $defaultRoute = "\$cnf['*']['namespace'] = 'Controllers';\n";
        fwrite($testFile, $defaultRoute);

        $returnCnf = "return \$cnf;";
        fwrite($testFile, $returnCnf);

        fclose($testFile);
    }
}