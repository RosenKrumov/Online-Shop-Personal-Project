<div class="section group">
    <?php $id = 1; foreach($this->products['products'] as $product): ?>
        <div class="grid_1_of_4 images_1_of_4">
            <a href="/products/details/<?=$product['id']?>"><img src="/images/feature-pic<?=$id?>.png" alt="" /></a>
            <h2><?=htmlspecialchars($product['name'])?></h2>
            <p><?=htmlspecialchars($product['model'])?></p>
            <?= $product['discount'] > 0
                ? '<p><span class="strike">$'.number_format($product['price'], 2).
                '</span><span class="price">$'.number_format(($product['price'] - ($product['price'] * $product['discount'] / 100)), 2).'</span></p>'
                : '<p><span class="price">$'.number_format($product['price'], 2).'</span></p>'?>
            <div class="button"><span><img src="/images/cart.jpg" alt="" /><a href="/products/buy/<?=$product['id']?>/<?=$this->csrf?>" class="cart-button">Add to Cart</a></span> </div>
            <div class="button"><span><a href="/products/details/<?=$product['id']?>" class="details">Details</a></span></div>
        </div>
        <?php $id++; endforeach; ?>
</div>
