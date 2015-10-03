<?php


namespace Models\ViewModels;


use Framework\Common;

class ProfileViewModel
{
    private $username;
    private $cash;
    private $role;
    private $isLogged = true;
    private $csrfToken;
    private $navbarData = [];
    private $products = [];

    /**
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param array $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return array
     */
    public function getNavbarData()
    {
        return $this->navbarData;
    }

    /**
     * @param array $navbarData
     */
    public function setNavbarData($key, $value)
    {
        $this->navbarData[$key] = $value;
    }

    /**
     * @return mixed
     */
    public function getCsrfToken()
    {
        return $this->csrfToken;
    }

    /**
     * @param mixed $csrfToken
     */
    public function setCsrfToken($csrfToken)
    {
        $this->csrfToken = $csrfToken;
    }

    public function isLogged(){
        return $this->isLogged;
    }

    /**
     * @return mixed
     */
    public function getUsername($escaping = true)
    {
        if($escaping){
            return htmlspecialchars($this->username);
        } else {
            return $this->username;
        }
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getCash()
    {
        return $this->cash;
    }

    /**
     * @param mixed $cash
     */
    public function setCash($cash)
    {
        $this->cash = number_format($cash, 2);
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }
}