<?php /** @var Models\ViewModels\ProfileViewModel */ ?>
<!DOCTYPE HTML>
<head>
    <title>Free Smart Store Website Template | Home :: w3layouts</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="/css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="/css/menu.css" rel="stylesheet" type="text/css" media="all"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="/js/script.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/js/nav.js"></script>
    <script type="text/javascript" src="/js/move-top.js"></script>
    <script type="text/javascript" src="/js/easing.js"></script>
    <script type="text/javascript" src="/js/nav-hover.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
    <script type="text/javascript">
        $(document).ready(function($){
            $('#dc_mega-menu-orange').dcMegaMenu({rowItems:'4',speed:'fast',effect:'fade'});
        });
    </script>
</head>
<body>
<div class="wrap">
    <div class="header">
        <div class="header_top">
            <div class="logo">
                <a href="/"><img src="/images/logo.png" alt="" /></a>
            </div>

            <div class="header_top_right">
                <?php if($this->data->isLogged()) {
                    echo '<div class="shopping_cart">
                    <div class="cart">
                        <a href="/users/cart" title="View my shopping cart" rel="nofollow">
                            <strong class="opencart"> </strong>
                            <span class="cart_title">Cart</span>
                            <span class="no_product">(empty)</span>
                        </a>
                    </div>
                  </div>
                <div class="login">
                    <span><a href="/users/profile"><img src="/images/login.png" alt="" title="view profile"/></a></span>
                </div>';
                } ?>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="menu">
            <ul id="dc_mega-menu-orange" class="dc_mm-orange">
                <li><a href="/">Home</a></li>
                <li><a href="#">Categories</a>
                    <ul>
                        <?php foreach($this->data->getNavbarData()['categories'] as $category): ?>
                            <li><a href="/products/brands/<?=$category['name']?>"><?=htmlspecialchars($category['name'])?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li><a href="#">Top Brands</a>
                    <ul>
                        <?php foreach($this->data->getNavbarData()['brands'] as $brand): ?>
                            <li><a href="/products/brands/<?=$brand['name']?>"><?=htmlspecialchars($brand['name'])?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li><a href="/index/contact">Contact</a></li>
                <?= $this->data->isLogged() ? '' : '<li><a href="/users/login">Login</a></li>' ?>
                <?= $this->data->isLogged() ? '' : '<li><a href="/users/register">Register</a></li>' ?>
                <?= $this->data->isLogged() ? '<li><a href="/users/logout">Logout</a></li>' : '' ?>
                <div class="clear"></div>
            </ul>
        </div>
<div class="main">
    <div class="content">
        <div class="login_panel">
            <h3>Change Password</h3>
            <?= \Framework\ViewHelpers\FormViewHelper::init()
                ->setAttribute("id", "member")
                ->setMethod("post")
                ->setAction("/users/editprofile")
                ->initPasswordField()
                ->setName("OldPass")
                ->setAttribute("placeholder", "Old password")
                ->setClasses("field")
                ->create()
                ->initPasswordField()
                ->setName("NewPass")
                ->setAttribute("placeholder", "New password")
                ->setClasses("field")
                ->create()
                ->initPasswordField()
                ->setName("ConfirmPass")
                ->setAttribute("placeholder", "Confirm new password")
                ->setClasses("field")
                ->create()
                ->initSubmit()
                ->setClasses("grey")
                ->setValue("Change password")
                ->create()
                ->initHiddenField()
                ->setName("CsrfToken")
                ->setValue($this->data->getCsrfToken())
                ->create()
                ->render()?>
        </div>
        <p style="font-size: 25px;">Welcome, <?= $this->data->getUsername(true) ?></p>
        <p style="font-size: 25px;">Cash:  <?= $this->data->getCash() ?>$</p>
        <p style="font-size: 25px;">Role: <?= $this->data->getRole() ?></p>

        <div class="login_panel" style="float: right; margin-top: -88px;">
            <h3>Change cash</h3>
            <?= \Framework\ViewHelpers\FormViewHelper::init()
                ->setAttribute("id", "member")
                ->setMethod("post")
                ->setAction("/users/editcash")
                ->initTextField()
                ->setName("Cash")
                ->setAttribute("placeholder", "Cash")
                ->setClasses("field")
                ->create()
                ->initTextField()
                ->setName("Confirm")
                ->setAttribute("placeholder", "Confirm  Cash")
                ->setClasses("field")
                ->create()
                ->initSubmit()
                ->setClasses("grey")
                ->setValue("Change cash")
                ->create()
                ->initHiddenField()
                ->setName("CsrfToken")
                ->setValue($this->data->getCsrfToken())
                ->create()
                ->render()?>
        </div>

        <div class="clear"></div>
        <p style="font-size: 25px;">Products: <?= count($this->data->getProducts()) === 0 ? 'You have no products yet' : '' ?> </p>

        <?php foreach($this->data->getProducts() as $product):?>
            <p>Name: <?= htmlspecialchars($product['name'])?></p>
            <p>Model: <?= htmlspecialchars($product['model'])?></p>
            <p>Quantity: <?= $product['count']?></p>
        <?php endforeach; ?>
    </div>
</div>
<div class="footer">
    <div class="wrapper">
        <div class="section group">
            <div class="col_1_of_4 span_1_of_4">
                <h4>Information</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Customer Service</a></li>
                    <li><a href="#"><span>Advanced Search</span></a></li>
                    <li><a href="#">Orders and Returns</a></li>
                    <li><a href="#"><span>Contact Us</span></a></li>
                </ul>
            </div>
            <div class="col_1_of_4 span_1_of_4">
                <h4>Why buy from us</h4>
                <ul>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="faq.html">Customer Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="contact.html"><span>Site Map</span></a></li>
                    <li><a href="preview-2.html"><span>Search Terms</span></a></li>
                </ul>
            </div>
            <div class="col_1_of_4 span_1_of_4">
                <h4>My account</h4>
                <ul>
                    <li><a href="contact.html">Sign In</a></li>
                    <li><a href="index.html">View Cart</a></li>
                    <li><a href="#">My Wishlist</a></li>
                    <li><a href="#">Track My Order</a></li>
                    <li><a href="faq.html">Help</a></li>
                </ul>
            </div>
            <div class="col_1_of_4 span_1_of_4">
                <h4>Contact</h4>
                <ul>
                    <li><span>+91-123-456789</span></li>
                    <li><span>+00-123-000000</span></li>
                </ul>
                <div class="social-icons">
                    <h4>Follow Us</h4>
                    <ul>
                        <li class="facebook"><a href="#" target="_blank"> </a></li>
                        <li class="twitter"><a href="#" target="_blank"> </a></li>
                        <li class="googleplus"><a href="#" target="_blank"> </a></li>
                        <li class="contact"><a href="#" target="_blank"> </a></li>
                        <div class="clear"></div>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copy_right">
            <p>Compant Name © All rights Reseverd | Design by  <a href="http://w3layouts.com">W3Layouts</a> </p>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        /*
         var defaults = {
         containerID: 'toTop', // fading element id
         containerHoverID: 'toTopHover', // fading element hover id
         scrollSpeed: 1200,
         easingType: 'linear'
         };
         */

        $().UItoTop({ easingType: 'easeOutQuart' });

    });
</script>
<a href="#" id="toTop" style="display: block;"><span id="toTopHover" style="opacity: 1;"></span></a>
<link href="/css/flexslider.css" rel='stylesheet' type='text/css' />
<script defer src="/js/jquery.flexslider.js"></script>
<script type="text/javascript">
    $(function(){
        SyntaxHighlighter.all();
    });
    $(window).load(function(){
        $('.flexslider').flexslider({
            animation: "slide",
            start: function(slider){
                $('body').removeClass('loading');
            }
        });
    });
</script>
</body>
</html>