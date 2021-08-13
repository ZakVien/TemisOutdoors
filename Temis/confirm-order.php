<?php
//Start the session
session_start();

require_once("connect-db.php");

    
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$shippingFirstName = test_input($_POST["shippingFirstName"]);
$shippingLastName = test_input($_POST["shippingLastName"]);
$shippingAddr = test_input($_POST["shippingAddr"]);
$shippingAddr2 = test_input($_POST["shippingAddr2"]);
$shippingcity = test_input($_POST["shippingcity"]);
$shippingstate = test_input($_POST["shippingstate"]);
$shippingzip = test_input($_POST["shippingzip"]);
$billingFirstName = $_SESSION["billingFirstName"];
$billingLastName = $_SESSION["billingLastName"];
$billingAddr = $_SESSION["billingAddr"];
$billingAddr2 = $_SESSION["billingAddr2"];
$billingCity = $_SESSION["billingCity"];
$billingState = $_SESSION["billingState"];
$billingZip = $_SESSION["billingZip"];
$email = $_SESSION["email"];
$ccNum = $ccExpMonth = $ccExpYear = $cvc = $bitcoinAddress = $paymentMethod = "";
$shipname = $shippingFirstName." ".$shippingLastName;
if($shippingAddr2 != ""){
    $shipaddr = $shippingAddr."<br>".$shippingAddr2."<br>".$shippingcity.", ".$shippingstate." ".$shippingzip;
}else{
    $shipaddr = $shippingAddr."<br>".$shippingcity.", ".$shippingstate." ".$shippingzip;
}
$billname = $billingFirstName." ".$billingLastName;
if($billingAddr2 != ""){
    $billaddr = $billingAddr."<br>".$billingAddr2."<br>".$billingCity.", ".$billingState." ".$billingZip;
}else{
    $billaddr = $billingAddr."<br>".$billingCity.", ".$billingState." ".$billingZip;
}

if(isset($_SESSION["ccNum"])){
    $paymentMethod = "Credit/Debit";
    $ccNum = $_SESSION["ccNum"];
    $ccExpMonth = $_SESSION["ccExpMonth"];
    $ccExpYear = $_SESSION["ccExpYear"];
    $cvc = $_SESSION["cvc"];
}else if(isset($_SESSION["bitcoinAddress"])){
    $paymentMethod = "Bitcoin";
    $bitcoinAddress = $_SESSION["bitcoinAddress"];
}else{
    $paymentMethod = "Cash";
}
?>
<!DOCTYPE html>
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
    <title>Check Out - Confirm | Temis Outdoors - Hobby &amp; Supply</title>
    <meta name='description' content='Temis offers free shipping and warranties on all items! - FREE shipping and returns on everything'>
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
                    <h2>Checkout (Step 3 of 3)</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <div class="shippingInfo">
                    <h4>Shipping Information</h4>
                        <div class="d-flex justify-content-start">
                            <p><b>Name:</b> <?php echo $shippingFirstName." ".$shippingLastName;?></p>
                        </div>
                        <div class="d-flex justify-content-start">
                            <p><b>Address:</b> <?php echo $shipaddr;?></p>
                        </div>
                    </div>
                    <br>
                    <div class="billingInfo">
                    <h4>Billing Information</h4>
                        <div class="d-flex justify-content-start">
                            <p><b>Name:</b> <?php echo $billingFirstName." ".$billingLastName;?></p>
                        </div>
                        <div class="d-flex justify-content-start">
                            <p><b>Address:</b> <?php echo $billaddr;?></p>
                        </div>
                        <div class="d-flex justify-content-start">
                            <p><b>Payment Method:</b> <?php echo $paymentMethod;?></p>
                        </div>
                        <div class="d-flex justify-content-start">
                            <p><b>Email Address: </b><?php echo $email;?></p>
                        </div>
                        <?php
                            if($paymentMethod == "Credit/Debit"){?>
                            <div class="d-flex justify-content-start">
                                <p><b>Card Number: ****-****-****-</b><?php echo substr($ccNum, -4);?></p>
                            </div>
                            <div class="d-flex justify-content-start">
                                <p><b>Expiration: </b> <?php echo $ccExpMonth."/".$ccExpYear;?></p>
                            </div>
                        <?php }else if($paymentMethod == "Bitcoin"){?>
                            <div class="d-flex justify-content-start">
                                <p><b>Bitcoin Wallet Address:</b> Ending in "<?php echo substr($bitcoinAddress, -7);?>"</p>
                            </div><?php 
                        }?>
                    </div>
                </div>
                <div class="col-lg-7 table-responsive">
                    <h3>Order Details</h3>
                    <table class="table table-hover cartTable">
                        <tr>
                            <th colspan="2">Item</th>
                            <th class="text-center quantColumn">Quantity</th>
                            <th class="text-center">Item Total</th>
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
                                    <input class="confirmItemQuantity" name="quantity" value="<?php echo $value['quantity']; ?>" type='readonly'>
                                </td>
                                <td class="text-center" id="<?php echo "itemTotalId" . $value["productId"];?>">$<?php echo number_format($value["quantity"] * $value["price"], 2); ?></td>
                            </tr>
                        <?php           }
                                    }
                                }?>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col d-flex flex-column align-items-end ">
                    <p><b>Total: </b>$<?php echo $_SESSION["total"];?></p>
                    <br>
                    <p><b>Tax: </b>$<?php echo $_SESSION["tax"];?></p>
                    <br>
                    <p><b>Subtotal: </b>$<?php echo $_SESSION["subtotal"];?></p>
                    <br>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col text-right">
                    <a href="process-order.php"><button class="btn btn-success text-right">Confirm Order</button></a>
                </div>
            </div>
        <div class="spacer"></div>
        </div>
    <?php include("footer.html");?>
</body>

</html>
