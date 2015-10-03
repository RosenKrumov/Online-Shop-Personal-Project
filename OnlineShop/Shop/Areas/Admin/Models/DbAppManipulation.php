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

    public function loadData()
    {
        $categories = $this->db
            ->prepare("SELECT * FROM categories")
            ->execute([])
            ->fetchAllAssoc();
        $products = $this->db
            ->prepare("SELECT p.id, p.name, p.price, p.quantity, p.model, c.name as categoryName FROM products p INNER JOIN categories c ON p.category_id = c.id")
            ->execute([])
            ->fetchAllAssoc();
        $data['categories'] = $categories;
        $data['products'] = $products;
        return $data;
    }

    public function addProduct(Product $product, $id){
        $addStmt = $this->db
            ->prepare("INSERT INTO
                            products
                          (name, model, price, quantity, category_id)
                        VALUES
                          (?, ?, ?, ?, ?)")
            ->execute([
                $product->getProductname(),
                $product->getProductmodel(),
                $product->getProductprice(),
                $product->getProductquantity(),
                $product->getCategory()
            ]);

        if($addStmt->getAffectedRows() > 0){
            $productId = $this->db->prepare("SELECT id FROM products ORDER BY id DESC LIMIT 1")->execute()->fetchRowAssoc();
            $this->db
                ->prepare("INSERT INTO users_products (user_id, product_id) VALUES (?, ?)")
                ->execute([$id, $productId['id']]);
            $this->db
                ->prepare("INSERT INTO available_products (user_id, product_id, discount) VALUES (?, ?, 0)")
                ->execute([$id, $productId['id']]);
            return true;
        }

        return false;
    }

    public function loadProduct($id){
        $product = $this->db
            ->prepare("SELECT
                              p.id, p.name, p.price, p.quantity, p.model, c.name as categoryName, c.id as categoryId
                        FROM
                              products p
                        INNER JOIN
                              categories c
                        ON
                              p.category_id = c.id
                        WHERE p.id = ?")
            ->execute([$id])
            ->fetchRowAssoc();

        $categories = $this->db
            ->prepare("SELECT * FROM categories")
            ->execute([])
            ->fetchAllAssoc();

        $data['product'] = $product;
        $data['categories'] = $categories;
        return $data;
    }

    public function editProduct(Product $product){
        $editStmt = $this->db
            ->prepare("UPDATE
                            products
                       SET
                            name = ?, model = ?, price = ?, quantity = ?, category_id = ?
                        WHERE id = ?")
            ->execute([
                $product->getProductname(),
                $product->getProductmodel(),
                $product->getProductprice(),
                $product->getProductquantity(),
                $product->getCategory(),
                $product->getId()
            ]);

        if($editStmt->getAffectedRows() > 0){
            return true;
        }

        return false;
    }

    public function deleteProduct($id){
        $deleteStmt = $this->db
            ->prepare("DELETE FROM products WHERE id = ?")
            ->execute([$id]);

        if($deleteStmt->getAffectedRows() > 0) {
            return true;
        }

        return false;
    }
}