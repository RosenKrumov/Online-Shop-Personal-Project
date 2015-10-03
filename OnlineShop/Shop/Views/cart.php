<p style="font-size: 50px; text-align: center">Your cart - <?= $this->products ? '<a href="/users/checkout/'. $this->csrf .'">Chekout</a></p>' : 'empty</p>' ?>
<ul>
    <?php foreach($this->products as $product): ?>
        <li>Name: <?=htmlspecialchars($product['name'])?></li>
        <li>Model: <?=htmlspecialchars($product['model'])?></li>
        <li>Price: <?=number_format($product['price'], 2)?>$</li>
        <li>Quantity: <?=$product['quantiry']?></li>
        <li>Total price after discount: <?=number_format($product['totalprice'], 2)?>$</li>
        <a href="/users/removeproductfromcart/<?=$product['id']?>/<?=$this->csrf?>">Remove product</a>
        <hr>
    <?php endforeach; ?>
</ul>
