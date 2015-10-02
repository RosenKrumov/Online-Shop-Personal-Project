<?php


namespace Models\Repositories;


use Models\DatabaseModels\User;
use Models\ViewModels\ProfileViewModel;

class UserData extends DefaultData
{
    private static $_instance;

    public function login(User $user){
        $result = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $result->execute([$user->getUsername()]);

        if($result->getAffectedRows() == 0){
            throw new \Exception("Invalid username");
        }

        $fetchedUser = $result->fetchRowAssoc();
        $passwordsEqual = password_verify($user->getPassword(), $fetchedUser['password']);

        if($passwordsEqual){
            return $fetchedUser['id'];
        }

        throw new \Exception("Passwords do not match");
    }

    public function register(User $user){
        if($this->exists($user->getUsername())){
            throw new \Exception("User already registered");
        }
        $hashedPass = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $result = $this->db->prepare("
            INSERT INTO users (username, password, role_id, cash)
            VALUES (?, ?, ?, ?);
        ");
        $result->execute(
            [
                $user->getUsername(),
                $hashedPass,
                $user->getRole(),
                $user->getCash()
            ]
        );

        if($result->getAffectedRows() > 0){
            return true;
        }

        throw new \Exception('Cannot register user');
    }

    public function getInfo($id){
        $result = $this->db->prepare("
            SELECT
                *
            FROM
              users
            WHERE id = ?
        ");

        $data = $result->execute([$id])
            ->fetchRowAssoc();

        $role = $this->db
            ->prepare("SELECT name FROM roles WHERE id = ?")
            ->execute([$data['role_id']])->fetchRowAssoc();

        $viewModel = new ProfileViewModel();
        $viewModel->setUsername($data['username']);
        $viewModel->setCash($data['cash']);
        $viewModel->setRole($role['name']);

        return $viewModel;
    }

    public function exists($username){
        return $this->db
            ->prepare('SELECT id FROM users WHERE username = ?')
            ->execute([$username])
            ->getAffectedRows() > 0;
    }

    public function edit($oldPass, $password, $id){
        $userCurrentPass = $this->db
            ->prepare("SELECT password FROM users WHERE id = ?")
            ->execute([$id])
            ->fetchRowAssoc();

        if(!password_verify($oldPass, $userCurrentPass['password'])){
            throw new \Exception('Old password is different');
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $result = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $result->execute([
            $hashed, $id
        ]);
        return $result->getAffectedRows() > 0;
    }

    public function editCash($cash, $id){
        $result = $this->db->prepare("UPDATE users SET cash = ? WHERE id = ?");
        $result->execute([
            $cash, $id
        ]);
        return $result->getAffectedRows() > 0;
    }

    /**
     * @return UserData
     */
    public static function getInstance(){
        if(self::$_instance == null){
            self::$_instance = new UserData();
        }

        return self::$_instance;
    }
}