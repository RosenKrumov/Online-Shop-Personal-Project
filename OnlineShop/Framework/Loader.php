<?php

namespace Framework;

final class Loader
{
    private static $namespace = [];

    private function __construct()
    {

    }

    public static function registerAutoLoad()
    {
        spl_autoload_register(array('\Framework\Loader', 'autoload'));
    }

    public static function autoload($class)
    {
        self::loаdClass($class);
    }

    public static function loаdClass($class)
    {
        foreach (self::$namespace as $k => $v) {
            if(strpos($class, $k) === 0) {
                $file = realpath(substr_replace(str_replace('\\', DIRECTORY_SEPARATOR, $class), $v, 0, strlen($k)) . '.php');
                if($file && is_readable($file)) {
                    include $file;
                } else {
                    throw new \Exception('File cannot be included' . $file);
                }
                break;
            }
        }
    }

    public static function registerNamespace($namespace, $path)
    {
        $namespace = trim($namespace);
        if (strlen($namespace) > 0) {
            if (!$path) {
                throw new \Exception('Invalid path');
            }
            $_path = realpath($path);
            if ($_path && is_dir($path) && is_readable($path)) {
                self::$namespace[$namespace.'\\'] = $_path . DIRECTORY_SEPARATOR;
            } else {
                throw new \Exception('Namespace directory read error:' . $path);
            }

        } else {
            throw new \Exception('Invalid namespace' . $namespace);
        }
    }

    public static function registerNamespaces($ar){
        if(is_array($ar)){
            foreach ($ar as $k => $v) {
                self::registerNamespace($k, $v);
            }
        } else {
            throw new \Exception('Invalid namespaces');
        }
    }
}