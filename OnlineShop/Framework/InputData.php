<?php


namespace Framework;


class InputData
{
    private static $_instance = null;
    private $_get = [];
    private $_post = [];
    private $_cookies = [];

    private function __construct(){
        $this->_cookies = $_COOKIE;
    }

    public function setPost($ar){
        if(is_array($ar)){
            $this->_post = $ar;
        }
    }

    public function setGet($ar){
        if(is_array($ar)){
            $this->_get = $ar;
        }
    }

    public function hasGet(){
        return count($this->_get) > 0;
    }

    public function hasPost(){
        return count($this->_post) > 0;
    }

    public function hasCookies($name){
        return array_key_exists($name, $this->_cookies);
    }

    public function get(){
        return $this->_get;
    }

    public function post(){
        return $this->_post;
    }

    public function cookies($name, $normalize = null, $default = null){
        if($this->hasCookies($name)){
            if($normalize != null){
                return Common::normalize($this->_cookies[$name], $normalize);
            }
            return $this->_cookies[$name];
        }
        return $default;
    }

    public static function getInstance(){
        if (self::$_instance == null) {
            self::$_instance = new InputData();
        }

        return self::$_instance;
    }
}