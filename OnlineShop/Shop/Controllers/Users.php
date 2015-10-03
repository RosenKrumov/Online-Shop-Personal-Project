<?php


namespace Controllers;


use Framework\DefaultController;
use Framework\Sessions\NativeSession;
use Models\BindingModels\EditCashBindingModel;
use Models\BindingModels\EditProfileBindingModel;
use Models\BindingModels\LoginBindingModel;
use Models\BindingModels\RegisterBindingModel;
use Models\DatabaseModels\User;
use Models\Repositories\ShopData;
use Models\Repositories\UserData;
use Models\ViewModels\ProfileViewModel;

class Users extends DefaultController
{
    /**
     * @var UserData
     */
    private $data;

    public function __construct()
    {
        parent::__construct();
        $this->data = UserData::getInstance();
    }


    public function login(){
        if($this->isLoggedIn()){
            header('Location: \users\profile');
            $this->session->csrf = uniqid();
            exit;
        }
        $brandsCategories = ShopData::getInstance()->loadCategories();
        $data = ['isLogged' => $this->isLoggedIn(), 'brandsCategories' => $brandsCategories];
        $this->session->csrf = uniqid();
        $this->view->appendToLayout('main', 'login');
        $this->view->display('layouts.default', $data);
    }

    public function register(){
        if($this->isLoggedIn()){
            header('Location: \users\profile');
            $this->session->csrf = uniqid();
            exit;
        }
        $brandsCategories = ShopData::getInstance()->loadCategories();
        $data = ['isLogged' => $this->isLoggedIn(), 'brandsCategories' => $brandsCategories];
        $this->session->csrf = uniqid();
        $this->view->appendToLayout('main', 'register');
        $this->view->display('layouts.default', $data);
    }

    public function cart(){
        if(!$this->isLoggedIn()){
            header('Location: \users\login');
            $this->session->csrf = uniqid();
            exit;
        }

        $this->session->csrf = uniqid();
        $brandsCategories = ShopData::getInstance()->loadCategories();
        $products = $this->data->getCartProducts($this->session->userid);
        $data = [
            'isLogged' => $this->isLoggedIn(),
            'brandsCategories' => $brandsCategories,
            'products' => $products,
            'csrf' => $this->session->csrf
        ];
        $this->view->appendToLayout('main', 'cart');
        $this->view->display('layouts.default', $data);
    }

    public function removeproductfromcart(){
        if(!$this->isLoggedIn()){
            header('Location: \users\login');
            $this->session->csrf = uniqid();
            exit;
        }

        if($this->input->get()[1] !== $this->session->csrf){
            throw new \Exception('Token invalid');
        }

        $productId = $this->input->get()[0];
        $userId = $this->session->userid;
        $success = $this->data->removeProductFromCart($productId, $userId);

        if($success){
            header('Location: /users/cart');
            $this->session->csrf = uniqid();
            exit;
        } else {
            throw new \Exception('Cannot delete product from cart');
        }
    }

    public function checkout(){
        if(!$this->isLoggedIn()){
            header('Location: \users\login');
            $this->session->csrf = uniqid();
            exit;
        }

        if($this->input->get()[0] !== $this->session->csrf){
            throw new \Exception('Token invalid');
        }

        $this->session->csrf = uniqid();
        $success = $this->data->checkout($this->session->userid);
        if($success){
            header('Location: /users/profile');
            exit;
        } else {
            throw new \Exception('Cannot checkout the cart');
        }
    }

    public function profile(){
        if(!$this->isLoggedIn()){
            header('Location: \users\login');
            $this->session->csrf = uniqid();
            exit;
        }

        $this->session->csrf = uniqid();
        $viewModel = $this->data->getInfo($this->session->userid);
        $viewModel->setCsrfToken($this->session->csrf);

        $brandsCategories = ShopData::getInstance()->loadCategories();
        $viewModel->setNavbarData('brands', $brandsCategories['brands']);
        $viewModel->setNavbarData('categories', $brandsCategories['categories']);

        $this->view->appendToLayout('main', 'profile');
        $this->view->display('profile', $viewModel);
    }

    /**
     * @BindingModels EditProfileBindingModel
     */
    public function editprofile(EditProfileBindingModel $bindingModel){

        if($bindingModel){
            if($this->input->post()['CsrfToken'] !== $this->session->csrf) {
                throw new \Exception('CSRF Token invalid');
            }
            if($bindingModel->getNewPass() !== $bindingModel->getConfirmPass()){
                throw new \Exception('Passwords do not match');
            } else {
                $success = $this->data->edit($bindingModel->getOldPass(), $bindingModel->getNewPass(), $this->session->userid);
                if(!$success) {
                    throw new \Exception('Cannot change password');
                } else {
                    header('Location: /users/profile');
                    $this->session->csrf = uniqid();
                }
            }
        }
    }

    /**
     * @BindingModels EditCashBindingModel
     */
    public function editcash(EditCashBindingModel $bindingModel){
        if($bindingModel){
            if($this->input->post()['CsrfToken'] !== $this->session->csrf) {
                throw new \Exception('CSRF Token invalid');
            }
            if(!is_numeric($bindingModel->getCash()) || !is_numeric($bindingModel->getConfirm())){
                throw new \Exception('Cash must be a number!');
            }
            if($bindingModel->getCash() !== $bindingModel->getConfirm()){
                throw new \Exception('Money do not match');
            } else {
                $success = $this->data->editCash($bindingModel->getCash(), $this->session->userid);
                if(!$success) {
                    throw new \Exception('Cannot change cash');
                } else {
                    header('Location: /users/profile');
                    $this->session->csrf = uniqid();
                }
            }
        }
    }

    /**
     * @BindingModels RegisterBindingModel
     */
    public function registerpost(RegisterBindingModel $bindingModel){
        if($bindingModel){
            $user = new User();
            $user->setUsername($bindingModel->getUsername());
            $user->setPassword($bindingModel->getPassword());
            $user->setCash();
            $user->setRole();
            $success = $this->data->register($user);
            if($success){
                $this->initLogin($user->getUsername(), $user->getPassword());
            } else {
                throw new \Exception('Cannot register user');
            }
        }
    }

    /**
     * @BindingModels LoginBindingModel
     */
    public function loginpost(LoginBindingModel $bindingModel){
        if($bindingModel){
            $user = new User();
            $user->setUsername($bindingModel->getUsername());
            $user->setPassword($bindingModel->getPassword());
            $this->initLogin($user->getUsername(), $user->getPassword());
        }
    }

    public function logout(){
        if(!$this->isLoggedIn()){
            header('Location: /users/login');
            $this->session->csrf = uniqid();
            exit;
        }

        $this->session->destroySession();
        header('Location: /');
        $this->session->csrf = uniqid();
        exit;
    }

    private function initLogin($username, $pass)
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($pass);
        $userId = $this->data->login($user);
        if($userId){
            $this->session->userid = $userId;
            $this->session->csrf = md5(uniqid(rand(), true));
        } else {
            throw new \Exception('Cannot login user');
        }
        header('Location: /');
        exit;
    }
}