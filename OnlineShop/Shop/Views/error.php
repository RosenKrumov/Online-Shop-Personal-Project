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
                <?php if($this->isLogged) {
                    echo '<div class="shopping_cart">
                    <div class="cart">
                        <a href="#" title="View my shopping cart" rel="nofollow">
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
                <li><a href="products.html">Products</a>
                    <ul>
                        <li><a href="products.html">Mobile Phones</a>
                            <ul>
                                <li><a href="preview-2.html">Product 1</a></li>
                                <li><a href="preview-3.html">Product 2</a></li>
                                <li><a href="#">Product 3</a></li>
                                <li><a href="#">Product 4</a></li>
                                <li><a href="preview-6.html">Product 5</a></li>
                                <li><a href="#">Product 6</a></li>
                            </ul>
                        </li>
                        <li><a href="products.html">Desktop</a>
                            <ul>
                                <li><a href="preview.html">Product 1</a></li>
                                <li><a href="preview-5.html">Product 2</a></li>
                                <li><a href="preview-3.html">Product 3</a></li>
                                <li><a href="#">Product 4</a></li>
                                <li><a href="#">Product 5</a></li>
                                <li><a href="#">Product 6</a></li>
                            </ul>
                        </li>
                        <li><a href="products.html">Laptop</a>
                            <ul>
                                <li><a href="preview-2.html">Product 10</a></li>
                                <li><a href="preview-5.html">Product 11</a></li>
                                <li><a href="#">Product 12</a></li>
                                <li><a href="#">Product 13</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Accessories</a>
                            <ul>
                                <li><a href="#">Product 14</a></li>
                                <li><a href="#">Product 15</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Software</a>
                            <ul>
                                <li><a href="#">Product 16</a></li>
                                <li><a href="#">Product 17</a></li>
                                <li><a href="#">Product 18</a></li>
                                <li><a href="#">Product 19</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Sports & Fitness</a>
                            <ul>
                                <li><a href="#">Product 16</a></li>
                                <li><a href="#">Product 17</a></li>
                                <li><a href="#">Product 18</a></li>
                                <li><a href="#">Product 19</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Footwear</a>
                            <ul>
                                <li><a href="#">Product 16</a></li>
                                <li><a href="#">Product 17</a></li>
                                <li><a href="#">Product 18</a></li>
                                <li><a href="#">Product 19</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Jewellery</a>
                            <ul>
                                <li><a href="#">Product 16</a></li>
                                <li><a href="#">Product 17</a></li>
                                <li><a href="#">Product 18</a></li>
                                <li><a href="#">Product 19</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Clothing</a>
                            <ul>
                                <li><a href="#">Product 16</a></li>
                                <li><a href="#">Product 17</a></li>
                                <li><a href="#">Product 18</a></li>
                                <li><a href="#">Product 19</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Home Decor & Kitchen</a>
                            <ul>
                                <li><a href="#">Product 16</a></li>
                                <li><a href="#">Product 17</a></li>
                                <li><a href="#">Product 18</a></li>
                                <li><a href="#">Product 19</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Beauty & Healthcare</a>
                            <ul>
                                <li><a href="#">Product 16</a></li>
                                <li><a href="#">Product 17</a></li>
                                <li><a href="#">Product 18</a></li>
                                <li><a href="#">Product 19</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Toys, Kids & Babies</a>
                            <ul>
                                <li><a href="#">Product 16</a></li>
                                <li><a href="#">Product 17</a></li>
                                <li><a href="#">Product 18</a></li>
                                <li><a href="#">Product 19</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="products.html">Top Brands</a>
                    <ul>
                        <li><a href="products.html">Brand Name 1</a></li>
                        <li><a href="products.html">Brand Name 2</a></li>
                        <li><a href="products.html">Brand Name 3</a></li>
                        <li><a href="#">Brand Name 4</a></li>
                        <li><a href="#">Brand Name 5</a></li>
                        <li><a href="#">Brand Name 6</a></li>
                        <li><a href="#">Brand Name 7</a></li>
                        <li><a href="#">Brand Name 8</a></li>
                        <li><a href="#">Brand Name 9</a></li>
                        <li><a href="#">Brand Name 10</a></li>
                    </ul>
                </li>
                <li><a href="contact.html">Contact</a></li>
                <?= $this->isLogged ? '' : '<li><a href="/users/login">Login</a></li>' ?>
                <?= $this->isLogged ? '' : '<li><a href="/users/register">Register</a></li>' ?>
                <?= $this->isLogged ? '<li><a href="/users/logout">Logout</a></li>' : '' ?>
                <div class="clear"></div>
            </ul>
        </div>

    </div>
    <p style="color: red; font-size: 50px;"><?=$this->error?></p>
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