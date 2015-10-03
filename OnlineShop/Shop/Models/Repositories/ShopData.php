<?php


namespace Models\Repositories;


class ShopData extends DefaultData
{
    private static $_instance;

    public function loadCategories(){
        $categories = $this->db->prepare("SELECT * FROM categories")->execute([])->fetchAllAssoc();
        $brands = $this->db->prepare("SELECT DISTINCT name FROM products LIMIT 5")->execute([])->fetchAllAssoc();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        return $data;
    }

    public function loadIndexProducts(){
        $featuredProducts = $this->db
            ->prepare("SELECT p.id, p.name, p.model, p.price, ap.discount FROM available_products ap INNER JOIN products p ON ap.product_id = p.id LIMIT 4")
            ->execute([])->fetchAllAssoc();
        $newProducts = $this->db
            ->prepare("SELECT p.id, p.name, p.model, p.price, ap.discount FROM available_products ap INNER JOIN products p ON ap.product_id = p.id ORDER BY p.id DESC LIMIT 4")
            ->execute([])->fetchAllAssoc();
        $data['featuredProducts'] = $featuredProducts;
        $data['newProducts'] = $newProducts;
        return $data;
    }

    public function loadProductsByCategory($category){
        $products = $this->db
            ->prepare("SELECT p.id, p.name, p.model, p.price, ap.discount FROM available_products ap INNER JOIN products p ON ap.product_id = p.id INNER JOIN categories c ON c.id = p.category_id WHERE c.name = ?")
            ->execute([$category])
            ->fetchAllAssoc();

        $data['products'] = $products;
        return $data;
    }

    public function loadProductsByBrand($brand){
        $products = $this->db
            ->prepare("SELECT p.id, p.name, p.model, p.price, ap.discount FROM available_products ap INNER JOIN products p ON ap.product_id = p.id WHERE p.name = ?")
            ->execute([$brand])
            ->fetchAllAssoc();

        $data['products'] = $products;
        return $data;
    }

    public function loadProductDetails($id) {
        $product = $this->db
            ->prepare("SELECT p.id, p.name, p.model, p.price, ap.discount FROM products p INNER JOIN available_products ap ON ap.product_id = p.id WHERE p.id = ?")
            ->execute([$id])
            ->fetchRowAssoc();

        $data['product'] = $product;
        return $data;
    }

    public function buyProduct($userId, $productId){
        $sameProducts = $this->db
            ->prepare("SELECT * FROM user_cart_products WHERE user_id = ? AND product_id = ?")
            ->execute([$userId, $productId])
            ->fetchAllAssoc();

        $hasDiscount = $this->db->prepare("SELECT discount FROM available_products WHERE product_id = ?")
                            ->execute([$productId])->fetchRowAssoc();
        $price = $this->db->prepare("SELECT price FROM products WHERE id = ?")->execute([$productId])->fetchRowAssoc();
        $price = $price['price'];

        if($hasDiscount['discount']){
            $price -= $price * $hasDiscount['discount'] / 100;
        }

        if(count($sameProducts) > 0) {
            $this->db
                ->prepare("UPDATE user_cart_products SET totalprice = totalprice + ?, quantiry = quantiry + 1 WHERE product_id = ? AND user_id = ?")
                ->execute([$price, $productId, $userId]);

            return $this->db->getAffectedRows() > 0;
        } else {
            $this->db
                ->prepare("INSERT INTO
                                user_cart_products (user_id, product_id, totalprice, quantiry)
                            VALUES
                                (?, ?, ?, 1)")
                ->execute([$userId, $productId, $price]);
            return $this->db->getAffectedRows() > 0;
        }
    }

    /**
     * @return ShopData
     */
    public static function getInstance(){
        if(self::$_instance == null){
            self::$_instance = new ShopData();
        }

        return self::$_instance;
    }
}