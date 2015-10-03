<h1>Edit product panel</h1>
<form action="/admin/products/editpost" method="post">
    <input type="hidden" name="Id" value="<?=$this->data['product']['id']?>"><br><br>
    Name: <input type="text" value="<?=$this->data['product']['name']?>" name="Productname"><br><br>
    Model: <input type="text" value="<?=$this->data['product']['model']?>" name="Productmodel"><br><br>
    Quantity: <input type="number" value="<?=$this->data['product']['quantity']?>" name="Productquantity"><br><br>
    Price: <input type="number" value="<?=$this->data['product']['price']?>" name="Productprice"><br><br>
    Category: <select name="Category">
        <?php foreach($this->data['categories'] as $category): ?>
            <option value="<?= $category['id'] ?>" <?= strcmp($category['id'], $this->data['product']['categoryId']) === 0 ? 'selected="selected"' : ''  ?>><?=$category['name']?></option>
        <?php endforeach; ?>
    </select><br><br>
    <input type="submit" value="Edit">
</form>

