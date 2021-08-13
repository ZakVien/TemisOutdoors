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
    require_once("connect-db.php");
    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

if(isset($_POST["update"])){
    $productId = $_POST["productId"];
    $product = $_POST["product"];
    $price = $_POST["price"];
    $quantity = test_input($_POST["quantity"]);
    $cartArrayId = $_POST["productArrayId"];

    $cartArray = array(         
        'productId' => $productId,
        'name' => $product,
        'price' => $price,
        'quantity' => $quantity
    );
    $_SESSION["cart"][$cartArrayId] = $cartArray;
}
if(isset($_POST["remove"])){
    $cartArrayId = $_POST["productArrayId"];
    $deletedItem = $_SESSION["cart"][$cartArrayId]['name'];
    unset($_SESSION["cart"][$cartArrayId]);
    $_SESSION["cart"] = array_values($_SESSION["cart"]);
    $removeSuccess = $deletedItem . " was successfully removed from your cart.";
    $deletedItem = "";
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
    <title>My Cart | Temis Outdoors - Hobby &amp; Supply</title>
    <meta name='description' content='View my cart at Temis - where prices are affordable and quality is top-notch - FREE shipping and returns on everything'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet.css" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="icon" href="images/favicon.png" type="image/x-icon" size="64x64">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet.css" type="text/css">
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
    <div class="container">
        <div class="row">
            <div class="col">
                <h2>Your Cart</h2>
            </div>
        </div>
        <?php
            if(!empty($removeSuccess)){?>
                <div class="row">
                    <div class="text-center w-100 alert alert-danger"><?php echo $removeSuccess;?></div>
                </div>
            <?php $removeSuccess = "";}
        ?>
        <?php 
                if(!empty($_SESSION["cart"])){?>
        <div class="row">
            <div class="col table-responsive">
                <table class="table table-hover cartTable">
                    <tr>
                        <th colspan="2">Item</th>
                        <th class="text-center quantColumn">Quantity</th>
                        <th class="text-center">Item Total</th>
                        <th class="d-none">Update</th>
                        <th class="text-right">Remove</th>
                    </tr>
                    <?php
                                $total = 0;
                                foreach($_SESSION["cart"] as $key => $value){
                                    $productId = $value["productId"];
                                    $sql = "select * from products where productId = :productId";
                                    $stmt1 = $db->prepare($sql);
                                    $stmt1->bindValue(":productId", $productId);
                                    if($stmt1->execute()){
                                        $productInfo = $stmt1->fetchAll();
                                        $stmt1->closeCursor();
                                        foreach($productInfo as $pi){?>
                    <tr>
                        <td>
                            <form id="viewform" method="POST" action="<?php echo $pi["url"];?>">
                                <input name="submit" type="image" class="cartProductImage" src="<?php echo $pi["image"];?>" alt="Submit">
                                <input type="hidden" name="productId" value="<?php echo $pi['productId'];?>">
                            </form>
                        </td>
                        <td><?php echo $value["name"]; ?></td>
                        <td class="text-center quantColumn">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                <i id="<?php echo "minus" . $value["productId"];?>" onClick="updateQuant(this.id)" class="fas fa-minus-circle"></i>
                                <input id="inputQty<?php echo $value["productId"];?>" onClick="updateQuant(this.id)" class="cartItemQuantity" name="quantity" value="<?php echo $value['quantity']; ?>">
                                <i id="<?php echo "add" . $value["productId"];?>" onClick="updateQuant(this.id)" class="fas fa-plus-circle"></i>
                                <input type="hidden" name="productId" value="<?php echo $value["productId"]; ?>">
                                <input type="hidden" name="product" value="<?php echo $value["name"]; ?>">
                                <input type="hidden" name="price" value="<?php echo $value["price"];?>">
                                <input type="hidden" name="productArrayId" value="<?php echo $key; ?>">
                                <button name="update" id="update<?php echo $value["productId"];?>" onclick="updateQuant(this.id)">Update Qty</button>
                            </form>
                        </td>
                        <td class="text-center" id="<?php echo "itemTotalId" . $value["productId"];?>">$<?php echo number_format($value["quantity"] * $value["price"], 2); ?></td>
                        <td class="text-center d-none">
                        </td>
                        <td class="text-right">
                            <form id="remove" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                <input name="productArrayId" type="hidden" value="<?php echo $key; ?>">
                                <button id="prodArrId<?php echo $key; ?>" name="remove" type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr><?php
                                            
                                        }
                                    }
                                    ?>
                    <?php
                                $total = $total + number_format(($value["quantity"] * $value["price"]), 2, '.', '');
                                }//end foreach
                                $_SESSION["tax"] = number_format(($total * 0.065), 2, '.', '');
                                $_SESSION["subtotal"] = number_format(($total + $_SESSION["tax"]), 2, '.', '');
                                $_SESSION["total"] = $total;
                            ?>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col text-right">
                <p>Total:<input type="readonly" id="total" value="$<?php echo number_format($total, 2); ?>" class="text-right cartTotals"></p>
                <p>Tax 6.50%:<input type="readonly" id="tax" value="$<?php echo number_format($_SESSION["tax"], 2); ?>" class="text-right cartTotals"></p>
                <p>Subtotal:<input type="readonly" id="subtotal" value="$<?php echo number_format($_SESSION["subtotal"], 2); ?>" class="text-right cartTotals"></p>
            </div>
        </div>
        <form id="billingInfo" method="post" action="billing-information.php">
            <div class="row">
                <div class="col text-right">
                    <button class="btn btn-success text-right">Begin Checkout</button>
                </div>
            </div>
        </form>
        <?php }else{
                    $error = "Your shopping cart is empty. Check out our <a href='clearance.php'>clearance items</a> and start filling your cart.";?>
        <div class="row">
            <div class="text-center w-100 alert alert-warning"><?php echo $error;?></div>
        </div><?php
                }?>
    </div>
    <?php include("footer.html");?>
    <script src="js/quantity.js"></script>
</body>

</html>
