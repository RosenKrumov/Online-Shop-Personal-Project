<?php


namespace Controllers;


use Framework\DefaultController;

class Index extends DefaultController
{
    public function index(){
        $this->session->csrf = uniqid();
        $data = ['isLogged' => $this->isLoggedIn()];
        $this->view->appendToLayout('main', 'index');
        $this->view->display('Layouts.default', $data);
    }
}