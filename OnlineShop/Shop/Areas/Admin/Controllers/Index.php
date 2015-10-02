<?php


namespace Areas\Admin\Controllers;


use Areas\Admin\Models\BindingModels\AdminLoginBindingModel;
use Areas\Admin\Models\DbAppManipulation;
use Framework\DefaultController;

class Index extends DefaultController
{
    public function index(){
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
            } else {
                throw new \Exception('Cannot login user');
            }

            header('Location: /admin/index/home');
        }
    }

    public function home(){
        $this->view->setViewDirectory('../Areas/Admin/Views');
        $this->view->display('home');
    }
}