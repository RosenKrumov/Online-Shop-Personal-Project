<?php


namespace Areas\Admin\Controllers;


use Areas\Admin\Models\DbAppManipulation;
use Framework\DefaultController;
use Models\BindingModels\AdminLoginBindingModel;

class Index extends DefaultController
{
    public function index(){
        $this->session->csrf = uniqid();
        if($this->isAdminLoggedIn()){
            header('Location: /admin/index/home');
        }
        $this->view->setViewDirectory('../Areas/Admin/Views');
        $this->view->display('index');
    }

    /**
     * @BindingModels AdminLoginBindingModel
     */
    public function login(AdminLoginBindingModel $bindingModel){
        if($bindingModel){
            $data = new DbAppManipulation();
            $adminId = $data->login($bindingModel->getUsername(), $bindingModel->getPassword());

            if($adminId){
                $this->session->adminId = $adminId;
                $this->session->csrf = uniqid();
            } else {
                throw new \Exception('Cannot login user');
            }

            header('Location: /admin/index/home');
            $this->session->csrf = uniqid();
        }
    }

    public function home(){
        $this->session->csrf = uniqid();
        if(!$this->isAdminLoggedIn()){
            header('Location: /admin');
        }
        $data = new DbAppManipulation();
        $productsCategories =  $data->loadData();
        $viewData = ['productsCategories' => $productsCategories, 'csrf' => $this->session->csrf];
        $this->view->setViewDirectory('../areas/admin/views');
        $this->view->appendToLayout("admin", "home");
        $this->view->display('home', $viewData);
    }

    public function logout()
    {
        $this->session->destroySession();
        header("Location: /admin/");
        $this->session->csrf = uniqid();
    }
}