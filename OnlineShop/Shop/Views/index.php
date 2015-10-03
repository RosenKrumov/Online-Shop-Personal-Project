<div class="header_bottom">
    <div class="header_bottom_left">
        <div class="section group">
            <div class="listview_1_of_2 images_1_of_2">
                <div class="listimg listimg_2_of_1">
                    <a href="#"> <img src="images/pic4.png" alt="" /></a>
                </div>
                <div class="text list_2_of_1">
                    <h2>Iphone</h2>
                    <p>Brand new Chinese Iphones.</p>
                </div>
            </div>
            <div class="listview_1_of_2 images_1_of_2">
                <div class="listimg listimg_2_of_1">
                    <a href="#"><img src="images/pic3.png" alt="" / ></a>
                </div>
                <div class="text list_2_of_1">
                    <h2>Samsung</h2>
                    <p>Brand new Chinese Freezers.</p>
                </div>
            </div>
        </div>
        <div class="section group">
            <div class="listview_1_of_2 images_1_of_2">
                <div class="listimg listimg_2_of_1">
                    <a href="#"> <img src="images/pic3.jpg" alt="" /></a>
                </div>
                <div class="text list_2_of_1">
                    <h2>Acer</h2>
                    <p>Brand new Chinese Laptops.</p>
                </div>
            </div>
            <div class="listview_1_of_2 images_1_of_2">
                <div class="listimg listimg_2_of_1">
                    <a href="#"><img src="images/pic1.png" alt="" /></a>
                </div>
                <div class="text list_2_of_1">
                    <h2>Canon</h2>
                    <p>Brand new Chinese Cameras.</p>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="main">
    <div class="content">
        <div class="content_top">
            <div class="heading">
                <h3>Feature Products</h3>
            </div>
            <div class="sort">
                <p>Sort by:
                    <select>
                        <option>Lowest Price</option>
                        <option>Highest Price</option>
                        <option>Lowest Price</option>
                        <option>Lowest Price</option>
                        <option>Lowest Price</option>
                        <option>In Stock</option>
                    </select>
                </p>
            </div>
            <div class="show">
                <p>Show:
                    <select>
                        <option>4</option>
                        <option>8</option>
                        <option>12</option>
                        <option>16</option>
                        <option>20</option>
                        <option>In Stock</option>
                    </select>
                </p>
            </div>
            <div class="page-no">
                <p>Result Pages:<ul>
                    <li><a href="#">1</a></li>
                    <li class="active"><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li>[<a href="#"> Next>>></a >]</li>
                </ul></p>
            </div>
            <div class="clear"></div>
        </div>
        <div class="section group">
            <?php $id = 1; foreach($this->indexProducts['featuredProducts'] as $featuredProduct): ?>
            <div class="grid_1_of_4 images_1_of_4">
                <a href="/products/details/<?=$featuredProduct['id']?>"><img src="/images/feature-pic<?=$id?>.png" alt="" /></a>
                <h2><?=htmlspecialchars($featuredProduct['name'])?></h2>
                <p><?=htmlspecialchars($featuredProduct['model'])?></p>
                <?= $featuredProduct['discount'] > 0
                    ? '<p><span class="strike">$'.number_format($featuredProduct['price'], 2).
                    '</span><span class="price">$'.number_format(($featuredProduct['price'] - ($featuredProduct['price'] * $featuredProduct['discount'] / 100)), 2).'</span></p>'
                    : '<p><span class="price">$'.number_format($featuredProduct['price'], 2).'</span></p>'?>
                <div class="button"><span><img src="/images/cart.jpg" alt="" /><a href="/products/buy/<?=$featuredProduct['id']?>/<?=$this->csrf?>" class="cart-button">Add to Cart</a></span> </div>
                <div class="button"><span><a href="/products/details/<?=$featuredProduct['id']?>" class="details">Details</a></span></div>
            </div>
            <?php $id++; endforeach; ?>
        </div>
        <div class="content_bottom">
            <div class="heading">
                <h3>New Products</h3>
            </div>
            <div class="sort">
                <p>Sort by:
                    <select>
                        <option>Lowest Price</option>
                        <option>Highest Price</option>
                        <option>Lowest Price</option>
                        <option>Lowest Price</option>
                        <option>Lowest Price</option>
                        <option>In Stock</option>
                    </select>
                </p>
            </div>
            <div class="show">
                <p>Show:
                    <select>
                        <option>4</option>
                        <option>8</option>
                        <option>12</option>
                        <option>16</option>
                        <option>20</option>
                        <option>In Stock</option>
                    </select>
                </p>
            </div>
            <div class="page-no">
                <p>Result Pages:<ul>
                    <li><a href="#">1</a></li>
                    <li class="active"><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li>[<a href="#"> Next>>></a >]</li>
                </ul></p>
            </div>
            <div class="clear"></div>
        </div>
        <div class="section group">
            <?php $id = 1; foreach($this->indexProducts['newProducts'] as $newProduct): ?>
            <div class="grid_1_of_4 images_1_of_4">
                <a href="/products/details/<?=$newProduct['id']?>"><img src="/images/feature-pic<?=$id?>.png" alt="" /></a>
                <?= $newProduct['discount'] > 0 ? '<div class="discount">
                    <span class="percentage">'.$newProduct['discount'].'%</span>
                </div>' : ''?>
                <h2><?=htmlspecialchars($newProduct['name'])?></h2>
                <p><?=htmlspecialchars($newProduct['model'])?></p>
                <?= $newProduct['discount'] > 0
                    ? '<p><span class="strike">$'.number_format($newProduct['price'], 2).
                    '</span><span class="price">$'.number_format(($newProduct['price'] - ($newProduct['price'] * $newProduct['discount'] / 100)), 2).'</span></p>'
                    : '<p><span class="price">$'.number_format($newProduct['price'], 2).'</span></p>'?>
                <div class="button"><span><img src="/images/cart.jpg" alt="" /><a href="/products/buy/<?=$newProduct['id']?>/<?=$this->csrf?>" class="cart-button">Add to Cart</a></span> </div>
                <div class="button"><span><a href="/products/details/<?=$newProduct['id']?>" class="details">Details</a></span></div>
            </div>
            <?php $id++; endforeach; ?>
        </div>
    </div>
</div>