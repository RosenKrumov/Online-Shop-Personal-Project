<?php


namespace Controllers;


use Framework\DefaultController;
use Models\Repositories\ShopData;

class Index extends DefaultController
{
    public function index(){
        $this->session->csrf = uniqid();
        $brandsCategories = ShopData::getInstance()->loadCategories();
        $indexProducts = ShopData::getInstance()->loadIndexProducts();
        $data = [
            'isLogged' => $this->isLoggedIn(),
            'brandsCategories' => $brandsCategories,
            'indexProducts' => $indexProducts,
            'csrf' => $this->session->csrf
        ];
        $this->view->appendToLayout('main', 'index');
        $this->view->display('Layouts.default', $data);
    }

    public function contact(){
        $this->session->csrf = uniqid();
        $brandsCategories = ShopData::getInstance()->loadCategories();
        $data = ['isLogged' => $this->isLoggedIn(), 'brandsCategories' => $brandsCategories];
        $this->view->appendToLayout('main', 'contact');
        $this->view->display('Layouts.default', $data);
    }
}