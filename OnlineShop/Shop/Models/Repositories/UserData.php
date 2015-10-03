<?php


namespace Models\Repositories;


use Models\DatabaseModels\User;
use Models\ViewModels\ProfileViewModel;

class UserData extends DefaultData
{
    private static $_instance;

    public function login(User $user)
    {
        $result = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $result->execute([$user->getUsername()]);

        if ($result->getAffectedRows() == 0) {
            throw new \Exception("Invalid username");
        }

        $fetchedUser = $result->fetchRowAssoc();
        $passwordsEqual = password_verify($user->getPassword(), $fetchedUser['password']);

        if ($passwordsEqual) {
            return $fetchedUser['id'];
        }

        throw new \Exception("Passwords do not match");
    }

    public function register(User $user)
    {
        if ($this->exists($user->getUsername())) {
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

        if ($result->getAffectedRows() > 0) {
            return true;
        }

        throw new \Exception('Cannot register user');
    }

    public function getInfo($id)
    {
        $result = $this->db->prepare("
            SELECT
                username,
                role_id,
                cash
            FROM
              users
            WHERE id = ?
        ");

        $data = $result->execute([$id])
            ->fetchRowAssoc();

        $products = $this->getUserProducts($id);

        $role = $this->db
            ->prepare("SELECT name FROM roles WHERE id = ?")
            ->execute([$data['role_id']])->fetchRowAssoc();

        $viewModel = new ProfileViewModel();
        $viewModel->setUsername($data['username']);
        $viewModel->setCash($data['cash']);
        $viewModel->setRole($role['name']);
        $viewModel->setProducts($products);

        return $viewModel;
    }

    private function getUserProducts($id)
    {
        $result = $this->db->prepare("
            SELECT
                up.user_id, p.name, p.model, count(p.id) as count
            FROM
                users_products up
            INNER JOIN
                products p
            ON
                up.product_id = p.id
            WHERE
                up.user_id = ?
            GROUP BY
                up.user_id, p.name, p.model
        ")->execute([$id])->fetchAllAssoc();

        return $result;
    }

    public function exists($username)
    {
        return $this->db
            ->prepare('SELECT id FROM users WHERE username = ?')
            ->execute([$username])
            ->getAffectedRows() > 0;
    }

    public function edit($oldPass, $password, $id)
    {
        $userCurrentPass = $this->db
            ->prepare("SELECT password FROM users WHERE id = ?")
            ->execute([$id])
            ->fetchRowAssoc();

        if (!password_verify($oldPass, $userCurrentPass['password'])) {
            throw new \Exception('Old password is different');
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $result = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $result->execute([
            $hashed, $id
        ]);
        return $result->getAffectedRows() > 0;
    }

    public function editCash($cash, $id)
    {
        $result = $this->db->prepare("UPDATE users SET cash = ? WHERE id = ?");
        $result->execute([
            $cash, $id
        ]);
        return $result->getAffectedRows() > 0;
    }

    public function getCartProducts($userId){
        $result = $this->db->prepare("
            SELECT
                p.id, p.name, p.model, p.price, up.quantiry, up.totalprice
            FROM
                products p
            INNER JOIN
                user_cart_products up
            ON
                p.id = up.product_id
            INNER JOIN
                users u
            ON
                u.id = up.user_id
            WHERE u.id = ?")->execute([$userId])->fetchAllAssoc();
        return $result;
    }

    public function checkout($userId){
        $userCash = $this->db->prepare("SELECT cash FROM users WHERE id = ?")
            ->execute([$userId])->fetchRowAssoc();
        $totalMoneyCart = $this->db->prepare("SELECT sum(totalprice) as sum FROM user_cart_products WHERE user_id = ?")->execute([$userId])->fetchRowAssoc();

        if($userCash['cash'] < $totalMoneyCart['sum']){
            throw new \Exception('You do not have enough money');
        }

        $userCart = $this->db->prepare("SELECT * FROM user_cart_products WHERE user_id = ?")
                        ->execute([$userId])->fetchAllAssoc();

        foreach ($userCart as $product) {
                for($i = 0; $i < $product['quantiry']; $i++){
                    $this->db->prepare("INSERT INTO users_products (user_id, product_id) VALUES (?, ?)")
                        ->execute([$product['user_id'], $product['product_id']]);
                }
            $this->db->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?")
                    ->execute([$product['quantiry'], $product['product_id']]);
            $this->db->prepare("UPDATE users SET cash = cash - ? WHERE id = ?")
                    ->execute([$product['totalprice'], $product['user_id']]);
            $remainingQuantities = $this->db->prepare("SELECT quantity FROM products WHERE id = ?")
                                ->execute([$product['product_id']]);
            if($remainingQuantities === 0){
                $this->db->prepare("DELETE FROM available_products WHERE product_id = ?")
                                ->execute([$product['product_id']]);
            }
        }

        $result = $this->db->prepare("DELETE FROM user_cart_products WHERE user_id = ?")
            ->execute([$userId])->getAffectedRows();

        if($result){
            return true;
        } else {
            return false;
        }
    }

    public function removeProductFromCart($productId, $userId){
        $quantity = $this->db->prepare("SELECT quantiry FROM user_cart_products WHERE user_id = ? AND product_id = ?")
                            ->execute([$userId, $productId])->fetchRowAssoc();
        $result = null;
        if($quantity['quantiry'] > 1) {
            $result = $this->db->prepare("UPDATE user_cart_products SET quantiry = quantiry - 1 WHERE user_id = ? AND product_id = ?")
                    ->execute([$userId, $productId]);
        } else {
            $result = $this->db->prepare("DELETE FROM user_cart_products WHERE user_id = ? AND product_id = ?")
                    ->execute([$userId, $productId]);
        }

        if($result->getAffectedRows() > 0){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return UserData
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new UserData();
        }

        return self::$_instance;
    }
}