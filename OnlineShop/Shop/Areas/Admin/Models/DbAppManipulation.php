<?php

namespace Areas\Admin\Models;


use Framework\DB\SimpleDB;

class DbAppManipulation
{
    private $db;

    public function __construct()
    {
        $this->db = new SimpleDB();
    }

    public function login($username, $password){
        $result = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $result->execute([$username]);

        if($result->getAffectedRows() == 0){
            throw new \Exception("Invalid username");
        }

        $fetchedUser = $result->fetchRowAssoc();
        $passwordsEqual = password_verify($password, $fetchedUser['password']);

        if($passwordsEqual){
            return $fetchedUser['id'];
        }

        throw new \Exception("Passwords do not match");
    }
}