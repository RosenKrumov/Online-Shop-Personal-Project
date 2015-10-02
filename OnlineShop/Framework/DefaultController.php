<?php


namespace Framework;


use Framework\Sessions\NativeSession;

abstract class DefaultController
{
    /**
     * @var App
     */
    protected $app;

    /**
     * @var View
     */
    protected $view;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var InputData|null
     */
    protected $input;

    /**
     * @var NativeSession|null
     */
    protected $session;

    public function __construct()
    {
        $this->app = App::getInstance();
        $this->view = View::getInstance();
        $this->config = $this->app->getConfig();
        $this->input = InputData::getInstance();
        if(is_null($this->session)){
            $this->session = new NativeSession('session');
        }
    }

    protected function isLoggedIn(){
        return $this->session->userid;
    }
}