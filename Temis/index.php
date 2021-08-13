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
        $addToCartSuccess = "$name was added to your <a href='my-cart.php'>cart</a>.";
    }else if(in_array($productId, $productArrayId)){
        $alreadyInCart = $name . " is already in  your <a href='my-cart.php' class='alert-link'>cart</a>. Please go to your <a href='my-cart.php' class='alert-link'>cart</a> to update your quantity.";
    }else{
        $addToCartError = "We're sorry. There was an issue adding this item to your cart. Please try again later.";
    }
}

$clearanceItems = "";

if(require_once("connect-db.php")){
    $sql = "select * from clearance
    inner join products
    on clearance.productId = products.productId";
    
    $stmt1 = $db->prepare($sql);
    if($stmt1->execute()){
        $clearanceItems = $stmt1->fetchAll();
        $stmt1->closeCursor();
    }
}


?>
<html>

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-M0ZGGV6DXR"></script>
    <script>
     window.dataLayer = window.dataLayer || [];
    
     function gtag() {
       dataLayer.push(arguments);
     }
     gtag('js', new Date());
    
     gtag('config', 'G-M0ZGGV6DXR');
    
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>The Great Midweek Sale | Temis Outdoors - Hobby &amp; Supply</title>
    <meta name='description' content='Temis supplies quality products at affordable prices for everything related to your outdoor lifestyle - FREE shipping and returns on everything'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet.css" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="icon" href="images/favicon.png" type="image/x-icon" size="64x64">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
</head>

<body>
    <div class="container-fluid">
        <?php 
        include("nav.php");
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
    <div class="container-fluid">
        <div class="bg">
            <div class="row">
                <div class="col d-flex justify-content-lg-end">
                    <h1>Temis Outdoors</h1>
                </div>
                <div class="d-none d-md-block col-md-1 col-lg-2"></div>
            </div>
            <div class="spacer"></div>
            <div class="row">
                <div class="col d-flex justify-content-center justify-content-md-end">
                    <h2>The <b>Great</b> Midweek Sale</h2>
                </div>
                <div class="d-none d-md-block col-md-2 col-lg-2"></div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <a href="clearance.php"><button id="shopnowbutton" class="btn btn-warning">Shop Now</button></a>
                </div>
                <div class="col-2"></div>
            </div>
            <?php 
            if(!empty($clearanceItems)){ ?>
            <div class="spacer"></div>
            <div class="row justify-content-center">
                <div class="d-none d-md-block col-md-1 col-xl-3"></div>
                <?php for($i = 0; $i < 3; $i++){ ?>
                <div class="col-12 col-sm-10 col-md-3 col-xl-2 align-items-stretch mb-3 productCard">
                    <div class="card h-100 mb-3">
                        <img class="index-card-img-top" src="<?php echo $clearanceItems[$i]["image"];?>" alt="<?php echo $clearanceItems[$i]["alt"];?>">
                        <div class="card-body pb-0 d-flex align-items-end">
                            <h5 class="card-title"><?php echo $clearanceItems[$i]["manufacturer"] . " " . $clearanceItems[$i]["name"];?></h5>
                        </div>
                        <div class="card-body pb-0 pt-0 productPrice d-flex align-items-end">
                            <div class="text-center w-100">
                                <h5><b>$<?php echo $clearanceItems[$i]["price"];?></b></h5>
                                <h6><b class="strikethrough">$<?php echo round($clearanceItems[$i]["price"] * 1.17, 2); ?></b></h6>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="mb-sm-2 mb-lg-2">
                                <form id="view<?php echo $clearanceItems[$i]['productId'];?>" method="POST" action="<?php echo $clearanceItems[$i]["url"]; ?>">
                                    <input type="hidden" name="productId" value="<?php echo $clearanceItems[$i]["productId"];?>">
                                    <button name="view<?php echo $clearanceItems[$i]['productId'];?>" class="btn btn-primary w-75">View</button>
                                </form>
                            </div>
                            <span class="d-lg-none"><br></span>
                            <span class="mb-sm-2 mb-lg-5">
                                <form id="addtocart" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="productId" value="<?php echo $clearanceItems[$i]["productId"];?>">
                                    <input type="hidden" name="name" value="<?php echo $clearanceItems[$i]["manufacturer"] . " " . $clearanceItems[$i]["name"]; ?>">
                                    <input type="hidden" name="price" value="<?php echo $clearanceItems[$i]["price"]; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button name="addtocart" class="btn btn-success w-75">Add</button>
                                </form>
                            </span>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="col-3"></div>
            </div>
            <?php }?>
        </div>
    </div>
    <div class="container-fluid">
        <?php include("footer.html");?>
    </div>
</body>
<?php
    if(!empty($addToCartSuccess)){
        ?><script>alert('<?php echo $name;?> was added to your cart.')</script><?php
    }else if(!empty($alreadyInCart)){
        ?><script>alert('<?php echo $name;?> is already in your cart.')</script><?php
    }else if(!empty($addToCartError)){
        ?><script>alert('There was an error adding <?php echo $name;?> to your cart.')</script><?php
    }
        
?>
</html>
