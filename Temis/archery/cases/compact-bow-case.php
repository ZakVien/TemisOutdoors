<?php
//Start the session
session_start();

if(isset($_SESSION["cart"])){
    if(is_null($_SESSION["cart"])){
        $_SESSION["cart"] = array();
    }
}else{
    $_SESSION["cart"] = array();
}
?>
<?php
	$error = $success = $manufacturerName = "";
    require_once("../../connect-db.php");

    $productId = $_POST["productId"];
    //add to cart
    if(isset($_POST["addtocart"])){
        $addToCartError = $addToCartSuccess = $alreadyInCart = "";
        
        $productId = $_POST["productId"];
        $name = $_POST["name"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        
        $cartArray = array(
            'productId' => $productId,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
        );
        
        $productArrayId = array_column($_SESSION["cart"], "productId");
        if(!in_array($productId, $productArrayId)){
            $count = count($_SESSION["cart"]);
            $_SESSION["cart"][$count] = $cartArray;
            $addToCartSuccess = "$name was added to your <a href='../../my-cart.php'>cart</a>.";
        }else if(in_array($productId, $productArrayId)){
            $alreadyInCart = $name . " is already in  your <a href='../../my-cart.php' class='alert-link'>cart</a>. Please go to your <a href='../../my-cart.php' class='alert-link'>cart</a> to update your quantity.";
        }else{
            $addToCartError = "We're sorry. There was an issue adding this item to your cart. Please try again later.";
        }
    }
?>
<html>

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WKWHERESMP"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-WKWHERESMP');

    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Compact Bow Case| Temis - Outdoor Hobby Supply Store</title><meta name='description' content='The Temis Polycarbonate Compact Bow Case is lockable, and airline-approved ensuring you can hunt anywhere - FREE shipping and returns on everything'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../../stylesheet.css" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="icon" href="../../images/favicon.png" type="image/x-icon" size="64x64">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
</head>

<body>
    <div class="container-fluid">
        <?php 
        include("../../nav-sub-subfolder.php");
        if(isset($_SESSION["userLogin"]) && ($_SESSION["userLogin"] != "")){?>
        <script>
            $(document).ready(function() {

                $(".accIcon").removeClass('fa-user');
                $(".accIcon").addClass('fa-user-alt');
            })

        </script>
        <?php
            }
        ?>
    </div>
    <div class="container products">
        <div class="container">
            <div class="spacer"></div>
            <?php 
            if(!empty($addToCartSuccess)){ ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $addToCartSuccess; ?>
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div><?php
            }else if(!empty($alreadyInCart)){?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $alreadyInCart;?>
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div><?php
            }else if(!empty($addToCartError)){?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $addToCartError;?>
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div><?php
            }
            ?>
            <div class="spacer"></div>
            <div class="row">
                <?php
                    $sql = "select * from products where productId = :productId";
                    
                    $stmt = $db->prepare($sql);
                    $stmt->bindValue(":productId", $productId);
                    if($stmt->execute()){
                        $product = $stmt->fetchAll();
                        $stmt->closeCursor();
                        
                        foreach($product as $p){ ?>
                            <div class="col-lg-8 col-sm productPageImage d-flex justify-content-center">
                                <img src="../../<?php echo $p['image'];?>" alt="<?php echo $p['alt'];?>">
                            </div>
                            <div class="col-lg-4 col-sm">
                            <h4><b><?php echo $p["name"];?></b></h4>
                            <h4><b>$<?php echo $p["price"];?></b></h4>
                            <h6>Item SKU#: T3M151300<?php echo $p["productId"];?></h6>
                            <h6 class="greenText">This item ships for FREE!</h6>
                            <br>
                            <form class="text-center" id="addtocart" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="productId" value="<?php echo $p["productId"];?>">
                                <input type="hidden" name="name" value="<?php echo $p["name"];?>">
                                <input type="hidden" name="price" value="<?php echo $p["price"];?>">
                                <input type="hidden" name="quantity" value="1">
                                <button name="addtocart" class="btn btn-success">Add to Cart</button>
                            </form>
                            <br>
                            <h6><b>Description: </b></h6><p><?php echo $p["description"];?></p>
                        <?php }
                    }else{
                        $error = "<h5>We're sorry, but we can't find the product you were looking for.</h5>";
                    }
                    
                    if($error != ""){
                        echo $error;
                    }
                ?>
                </div>
            </div>
            <div class="spacer"></div>
        </div>
    </div>
        <?php include("../../footer-sub-subfolder.html");?>
</body></html>
