<h1>Admin Panel - App Manipulation</h1>

<h3><a href="/admin/index/logout">Logout</a></h3>

<h1>Add product</h1>
<form action="/admin/products/add" method="post">
    <?php
    $start = \Framework\ViewHelpers\DropdownViewHelper::init()->setAttribute("name", "Category");
    foreach ($this->data['categories'] as $category) {
        $start->initOption()
            ->setValue($category['id'])
            ->setInnerValue($category['name'])
            ->create();
    }
    $start->render()
    ?>
    <input type="text" placeholder="Product name" name="Productname"/>
    <input type="text" placeholder="Product model" name="Productmodel"/>
    <input type="text" placeholder="Product price" name="Productprice"/>
    <input type="number" placeholder="Product quantity" name="Productquantity"/>
    <input type="submit" value="Add">
</form>

<h1>Manipulate products in DB</h1>
<table border="1">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Model</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Category</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
        <?php foreach($this->data['products'] as $product): ?>
        <tr>
            <td><?= $product['id'] ?></td>
            <td><?= $product['name'] ?></td>
            <td><?= $product['model'] ?></td>
            <td><?= $product['price'] ?></td>
            <td><?= $product['quantity'] ?></td>
            <td><?= $product['categoryName'] ?></td>
            <td><a href="/admin/products/edit/<?=$product['id']?>">Edit</a></td>
            <td><a href="/admin/products/delete/<?=$product['id']?>">Delete</a></td>
        </tr>
        <?php endforeach;?>
</table>