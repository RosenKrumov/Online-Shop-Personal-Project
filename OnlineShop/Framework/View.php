<?php


namespace Framework;


class View
{
    private static $_instance = null;
    private $data = null;
    private $viewPath = null;
    private $viewDir = null;
    private $extension = '.php';
    private $layoutParts = array();
    private $layoutData = array();

    private function __construct()
    {
        $this->viewPath = App::getInstance()->getConfig()->app['viewsDirectory'];
        if ($this->viewPath == null) {
            $this->viewPath = realpath('../views/');
        }
    }

    public function setViewDirectory($path)
    {
        $path = trim($path);
        if ($path) {
            $path = realpath($path) . DIRECTORY_SEPARATOR;
            if (is_dir($path) && is_readable($path)) {
                $this->viewDir = $path;
            } else {
                throw new \Exception('Invalid view folder path', 500);
            }
        } else {
            throw new \Exception('Invalid view folder path', 500);
        }
    }

    public function display($name, $data = array())
    {
        $viewModel = get_class($data);
        $this->data = $data;
        if (count($this->layoutParts) > 0) {
            foreach ($this->layoutParts as $k => $v) {
                $r = $this->_includeFile($v, $viewModel);
                if ($r) {
                    $this->layoutData[$k] = $r;
                }
            }
        }
        echo $this->_includeFile($name, $viewModel);
    }

    public function getLayoutData($name)
    {
        return $this->layoutData[$name];
    }

    public function appendToLayout($key, $template)
    {
        if ($key && $template) {
            $this->layoutParts[$key] = $template;
        } else {
            throw new \Exception('Layout require valid key and template', 500);
        }
    }

    private function _includeFile($file, $viewModel)
    {
        if ($this->viewDir == null) {
            $this->setViewDirectory($this->viewPath);
        }
        $__fl = $this->viewDir . str_replace('.', DIRECTORY_SEPARATOR, $file) . $this->extension;
        $el = explode(".", $file);
        if ($el[1] !== "default") {
            preg_match_all('/@var\s+(.*?)\s/', file_get_contents($__fl), $viewType);
            if (strcmp($viewModel, $viewType[1][0]) != 0) {
                throw new \Exception("The view doesn't accept this view model", 500);
            }
        }
        if (file_exists($__fl) && is_readable($__fl)) {
            ob_start();
            include $__fl;
            return ob_get_clean();
        } else {
            throw new \Exception('View' . $file . ' cannot be included', 500);
        }
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new View();
        }
        return self::$_instance;
    }
}