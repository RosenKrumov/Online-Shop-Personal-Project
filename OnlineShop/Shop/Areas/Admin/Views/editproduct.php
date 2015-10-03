<h1>Edit product panel</h1>
<form action="/admin/products/editpost" method="post">
    <input type="hidden" name="Id" value="<?=$this->product['product']['id']?>"><br><br>
    <input type="hidden" name="csrf" value="<?=$this->csrf?>">
    Name: <input type="text" value="<?=htmlspecialchars($this->product['product']['name'])?>" name="Productname"><br><br>
    Model: <input type="text" value="<?=htmlspecialchars($this->product['product']['model'])?>" name="Productmodel"><br><br>
    Quantity: <input type="number" value="<?=$this->product['product']['quantity']?>" name="Productquantity"><br><br>
    Price: <input type="number" value="<?=$this->product['product']['price']?>" name="Productprice"><br><br>
    Category: <select name="Category">
        <?php foreach($this->product['categories'] as $category): ?>
            <option value="<?= $category['id'] ?>" <?= strcmp($category['id'], $this->data['product']['categoryId']) === 0 ? 'selected="selected"' : ''  ?>><?=htmlspecialchars($category['name'])?></option>
        <?php endforeach; ?>
    </select><br><br>
    <input type="submit" value="Edit">
</form>
