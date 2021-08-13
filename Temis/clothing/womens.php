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

$error = $success = $manufacturerName = "";
require_once("../connect-db.php");

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
        $addToCartSuccess = "$name was added to your <a href='../my-cart.php'>cart</a>.";
    }else if(in_array($productId, $productArrayId)){
        $alreadyInCart = $name . " is already in  your <a href='../my-cart.php' class='alert-link'>cart</a>. Please go to your <a href='../my-cart.php' class='alert-link'>cart</a> to update your quantity.";
    }else{
        $addToCartError = "We're sorry. There was an issue adding this item to your cart. Please try again later.";
    }
}

//set minPrice & maxPrice
if(isset($_POST["minPrice"])){
    $minPrice = $_POST["minPrice"] - 1;
}else{
    $minPrice = 0;
}
if(isset($_POST["maxPrice"])){
    $maxPrice = $_POST["maxPrice"];
    if($maxPrice == $minPrice){
        $maxPrice = $maxPrice + 1;  //max != min
        $minPrice = $minPrice - 0.01;
    }
}else{
    $maxPrice = 1000;
}

//different sql query if filter by manufacturer
if(!empty($_POST["manufacturers"])){
    $manufacturerName = $_POST["manufacturers"];
}else{
    $manufacturerName = "%";
}
$sql = "select * from products where category = 'womens' and 
manufacturerNoSpaces like :manufacturerName and 
price <= :maxPrice and price >= :minPrice
order by manufacturer, name";

//prepare statement with/without manufacturer filter
$stmt1 = $db->prepare($sql);
$stmt1->bindValue(":manufacturerName", $manufacturerName);
$stmt1->bindValue(":minPrice", $minPrice);
$stmt1->bindValue(":maxPrice", $maxPrice);

//reset filters button
if(isset($_POST["reset"])){
    $_POST['manufacturers'] = "";
    $minPrice = 0;
    $maxPrice = 1000;
    $sql = "select * from products where category = 'womens'
    order by manufacturer, name";
    $stmt1 = $db->prepare($sql);
}

//set min/max values for priceSlider
if($stmt1->execute()){
    $productArray = $stmt1->fetchAll();
    $stmt1->closeCursor();
    $maximumValue = 0;
    $minimumValue = 10000;
    foreach($productArray as $pa){
        if($minimumValue > $pa["price"]){
            $minimumValue = round($pa["price"]);
        }
        if($maximumValue < $pa["price"]){
            $maximumValue = round($pa["price"]);
        }
    }
    if($minimumValue == $maximumValue){
        $minimumValue--;
        $minPrice = floor($minPrice);
    }
    if(empty($productArray)){
        $error = "We're sorry, but there were no results that matched your criteria.";
        $minimumValue = 0;
        $maximumValue = 1000;
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
    <title>Womens Clothing | Temis Outdoors - Hobby &amp; Supply</title>
    <meta name='description' content='Temis is proud to offer affordable, high-quality womens clothing for your outdoor lifestyle - FREE shipping and returns on everything'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../stylesheet.css" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="icon" href="../images/favicon.png" type="image/x-icon" size="64x64">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
</head>

<body>
    <div class="container-fluid">
        <?php 
        include("../nav-subfolder.php");
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
            <div class="row">
                <div class="col">
                    <h1>Womens Clothing</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="../clothing.php">Clothing</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Womens</li>
                        </ol>
                    </nav>
                </div>
            </div>
        <div class="container w-20 float-left d-none d-lg-block">
            <div class="filterSidebar">
                <form id="clothingFilters" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <h3>Refine Results</h3>
                    <br>
                    <label for="category">Category</label>
                    <br>
                    <?php
                        $sql_category = "select subcategory from products where category = 'womens' order by subcategory";
                        $sql_category = $db->prepare($sql_category);
                        
                        if($sql_category->execute()){
                            $categoryitem = $sql_category->fetchAll();
                            $sql_category->closeCursor();
                            $categoryArray = [];
                            foreach($categoryitem as $c){
                                array_push($categoryArray, $c["subcategory"]);
                        ?>
                    <?php
                            }
                            $categoryArray = array_unique($categoryArray);
                            foreach($categoryArray as $uc){?>
                    <a href="../clothing/womens/<?php echo strtolower($uc) . ".php";?>"><?php echo $uc; ?></a><br>
                    <?php }
                        };
                        ?>
                    <br>
                    <label for="manufacturers">Filter by manufacturer:</label>
                    <br>
                    <select name="manufacturers" class="w-100">
                        <option value="" selected disabled>Chose one...</option>
                        <?php
                        if($stmt1->execute()){
                            $productArray = $stmt1->fetchAll();
                            $stmt1->closeCursor();
                            $manufactureArray = [];
                            $manNameNoSpaces = "";
                            foreach($productArray as $pa){
                                array_push($manufactureArray, $pa["manufacturer"]);
                            }
                            $manufactureArray = array_unique($manufactureArray);
                            
                            foreach($manufactureArray as $um){
                                $manNameNoSpaces = str_replace('&amp;', 'and', $um);
                                $manNameNoSpaces = str_replace(' ', '', $manNameNoSpaces);?>
                        <option value="<?php echo $manNameNoSpaces;?>" <?php 
                                if(isset($_POST["reset"])){
                                    echo "";
                                }else if(isset($_POST["manufacturers"]) && $_POST["manufacturers"] == $manNameNoSpaces) {
                                    echo "selected";
                                }
                                        ?>><?php echo $um;?></option>
                        <?php }
                        };
                        ?>
                    </select>
                    <br>
                    <label for="amount">Price Range:</label>
                    <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                    <div id="slider-range"></div>
                    <input type="hidden" id="minPrice" name="minPrice" value="<?php echo $minPrice;?>">
                    <input type="hidden" id="maxPrice" name="maxPrice" value="<?php echo $maxPrice;?>">
                    <input type="hidden" id="minimumValue" value="<?php echo $minimumValue;?>">
                    <input type="hidden" id="maximumValue" value="<?php echo $maximumValue;?>">
                    <br>
                    <button type="submit" name="submit" id="updateButton" class="btn btn-warning">Update changes</button>
                    <br>
                    <br>
                    <button type="submit" value="reset" name="reset" class="btn btn-secondary">Reset filters</button>
                </form>
            </div>
        </div>
        <div class="container w-80 float-right">
            <div class="row d-lg-none">
                <div class="col text-center">
                    <button class="btn btn-primary mobileRefineBtn">Button to toggle category options</button>
                </div>
            </div>
            <div class="row">
                <div class="col">
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
                </div>
            </div>
            <div class="row">
                <?php
            if($error != ""){?>
                <div class=" w-100 alert alert-warning alert-dismissible fade show" role="alert">
                    <?php echo $error;?>
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
                <?php
            }else if($stmt1->execute()){
            $products = $stmt1->fetchAll();
            $stmt1->closeCursor();
            $filteredProducts = "";
            foreach($products as $p){ ?>
                <div class="col-6 col-md-4 col-lg-4 col-xl-3 align-items-stretch mb-3 productCard">
                    <div class="card h-100 mb-3">
                        <img class="card-img-top" src="../<?php echo $p["image"];?>" alt="<?php echo $p["alt"];?>">
                        <div class="card-body pb-0 d-flex align-items-end">
                            <h5 class="card-title"><?php echo $p["manufacturer"] . " " . $p["name"];?></h5>
                        </div>
                        <div class="card-body pb-0 pt-0 productPrice d-flex align-items-end">
                            <div class="text-center w-100">
                                <h5><b>$<?php echo $p["price"];?></b></h5>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="mb-sm-2 mb-lg-2">
                                <form id="view<?php echo $p['productId'];?>" method="POST" action="<?php echo "../../Temis/".$p["url"]; ?>">
                                    <input type="hidden" name="productId" value="<?php echo $p["productId"];?>">
                                    <button name="view<?php echo $p['productId'];?>" class="btn btn-primary w-75">View</button>
                                </form>
                            </div>
                            <span class="d-lg-none"><br></span>
                            <span class="mb-sm-2 mb-lg-5">
                                <form id="addtocart" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="productId" value="<?php echo $p["productId"];?>">
                                    <input type="hidden" name="name" value="<?php echo $p["manufacturer"] . " " . $p["name"]; ?>">
                                    <input type="hidden" name="price" value="<?php if(empty($cPrice)){echo $p["price"];}else{echo $cPrice;} ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button name="addtocart" class="btn btn-success w-75">Add</button>
                                </form>
                            </span>
                        </div>
                    </div>
                </div>
                <?php
        }
    }?>
            </div>
        </div>
    </div>
    <?php include("../footer-subfolder.html");?>
</body>

<script src="../js/priceSlider.js"></script>


</html>
