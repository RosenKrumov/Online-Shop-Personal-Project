<?php


namespace Controllers;


use Framework\DefaultController;
use Models\Repositories\ShopData;

class Products extends DefaultController
{
    public function index(){
        $this->session->csrf = uniqid();
        $brandsCategories = ShopData::getInstance()->loadCategories();
        $data = ['isLogged' => $this->isLoggedIn(), 'brandsCategories' => $brandsCategories];
        $this->view->appendToLayout('main', 'products');
        $this->view->display('Layouts.default', $data);
    }

    public function category(){
        $this->session->csrf = uniqid();
        $brandsCategories = ShopData::getInstance()->loadCategories();
        $products = ShopData::getInstance()->loadProductsByCategory($this->input->get()[0]);
        $data = [
            'isLogged' => $this->isLoggedIn(),
            'products' => $products,
            'brandsCategories' => $brandsCategories,
            'csrf' => $this->session->csrf
        ];
        $this->view->appendToLayout('main', 'products_category');
        $this->view->display('Layouts.default', $data);
    }

    public function brands(){
        $this->session->csrf = uniqid();
        $brandsCategories = ShopData::getInstance()->loadCategories();
        $products = ShopData::getInstance()->loadProductsByBrand($this->input->get()[0]);
        $data = [
            'isLogged' => $this->isLoggedIn(),
            'products' => $products,
            'brandsCategories' => $brandsCategories,
            'csrf' => $this->session->csrf
        ];
        $this->view->appendToLayout('main', 'products_category');
        $this->view->display('Layouts.default', $data);
    }

    public function details(){
        $this->session->csrf = uniqid();
        $brandsCategories = ShopData::getInstance()->loadCategories();
        $product = ShopData::getInstance()->loadProductDetails($this->input->get()[0]);
        $data = [
            'isLogged' => $this->isLoggedIn(),
            'product' => $product,
            'brandsCategories' => $brandsCategories,
            'csrf' => $this->session->csrf
        ];
        $this->view->appendToLayout('main', 'product_details');
        $this->view->display('Layouts.default', $data);
    }

    public function buy(){
        if($this->input->get()[1] !== $this->session->csrf){
            throw new \Exception('Token invalid');
        }
        $productId = $this->input->get()[0];
        $userId = $this->session->userid;
        $success = ShopData::getInstance()->buyProduct($userId, $productId);
        if($success){
            header('Location: /');
            $this->session->csrf = uniqid();
        } else {
            throw new \Exception('Cannot buy product');
        }
    }
}