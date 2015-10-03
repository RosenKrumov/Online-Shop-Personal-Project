<div class="main">
    <div class="content">
        <div class="section group">
            <div class="cont-desc span_1_of_2">
                <div class="grid images_3_of_2">
                    <img src="/images/preview-img.jpg" alt="" />
                </div>
                <div class="desc span_3_of_2">
                    <h2><?=htmlspecialchars($this->product['product']['name'])?> <?=htmlspecialchars($this->product['product']['model'])?></h2>
                    <div class="price">
                        <p>Price: <span><?=number_format($this->product['product']['price'], 2).'$'?></span></p>
                    </div>
                    <div class="add-cart">
                        <div class="button"><span><a href="/products/buy/<?=$this->product['product']['id']?>/<?=$this->csrf?>">Add to Cart</a></span></div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="product-desc">
                    <h2>Product Details</h2>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                </div>
            </div>
            <div class="rightsidebar span_3_of_1">
                <h2>CATEGORIES</h2>
                <ul>
                    <?php foreach($this->brandsCategories['categories'] as $category): ?>
                        <li><a href="/products/category/<?=$category['name']?>"><?=htmlspecialchars(ucfirst($category['name']))?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>