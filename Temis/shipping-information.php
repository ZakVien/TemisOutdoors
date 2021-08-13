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

$billingFirstName = $_SESSION["billingFirstName"] = test_input($_POST["firstName"]);
$billingLastName = $_SESSION["billingLastName"] = test_input($_POST["lastName"]);
$billingAddr = $_SESSION["billingAddr"] = test_input($_POST["billingAddr"]);
$billingAddr2 = $_SESSION["billingAddr2"] = test_input($_POST["billingAddr2"]);
$billingCity = $_SESSION["billingCity"] = test_input($_POST["city"]);
$billingState = $_SESSION["billingState"] = test_input($_POST["state"]);
$billingZip = $_SESSION["billingZip"] = test_input($_POST["zip"]);
$billingZip = test_input($_POST["zip"]);
$email = test_input($_POST["email"]);
$_SESSION["email"] = test_input($_POST["email"]);
$ccNum = $ccExpMonth = $ccExpYear = $cvc = $bitcoinAddress = $email = "";

if($_POST["paymentMethod"] == "creditDebit"){
    $ccNum = $_SESSION["ccNum"] = test_input($_POST["ccNum"]);
    $ccExpMonth = $_SESSION["ccExpMonth"] = test_input($_POST["ccExpMonth"]);
    $ccExpYear = $_SESSION["ccExpYear"] = test_input($_POST["ccExpYear"]);
    $cvc = $_SESSION["cvc"] = test_input($_POST["cvc"]);
}else if($_POST["paymentMethod"] == "bitcoin"){
    $bitcoinAddress = $_SESSION["bitcoinAddress"] = test_input($_POST["bitcoinAddress"]);
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
    <title>Check Out - Shipping Info | Temis Outdoors - Hobby &amp; Supply</title>
    <meta name='description' content='Temis is proud to offer a safe checkout process to ensure your data is never stolen - FREE shipping and returns on everything'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet.css" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="icon" href="images/favicon.png" type="image/x-icon" size="64x64">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
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
                    <h2>Checkout (Step 2 of 3)</h2>
                </div>
            </div>
            <input type="hidden" value="<?php echo $billingFirstName;?>" id="billFirstName">
            <input type="hidden" value="<?php echo $billingLastName;?>" id="billLastName">
            <input type="hidden" value="<?php echo $billingAddr;?>" id="billAddr">
            <input type="hidden" value="<?php echo $billingAddr2;?>" id="billAddr2">
            <input type="hidden" value="<?php echo $billingCity;?>" id="billCity">
            <input type="hidden" value="<?php echo $billingState;?>" id="billState">
            <input type="hidden" value="<?php echo $billingZip;?>" id="billZip">
            <form method="post" action="confirm-order.php" id="shippingInfoForm">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <h3>Shipping Information</h3>
                        <input type="checkbox" name="shippingIsBilling" id="shippingIsBilling" onclick="shipping(this.id)">
                        <label for="shippingIsBilling">Shipping Address is the same as Billing Address</label>
                        <div class="form-row">
                            <div class="col">
                                <label for="shippingFirstName">First Name<span class="req">*</span></label>
                                <input type="text" class="form-control" id="shippingFirstName" name="shippingFirstName" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="shippingLastName">Last Name<span class="req">*</span></label>
                                <input type="text" class="form-control" id="shippingLastName" name="shippingLastName" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="shippingAddr">Shipping Address<span class="req">*</span></label>
                                <input type="text" class="form-control" id="shippingAddr" name="shippingAddr" placeholder="Shipping Address" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="shippingAddr2">Shipping Address 2</label>
                                <input type="text" class="form-control" id="shippingAddr2" name="shippingAddr2" placeholder="Shipping Address 2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="shippingcity">City<span class="req">*</span></label>
                                <input type="text" class="form-control" id="shippingcity" name="shippingcity" placeholder="City" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="shippingstate">State<span class="req">*</span></label>
                                <input type="text" class="form-control" id="shippingstate" name="shippingstate" placeholder="State" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="shippingzip">Zip<span class="req">*</span></label>
                                <input type="text" class="form-control" id="shippingzip" name="shippingzip" placeholder="Zip" required>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col d-flex justify-content-lg-center">
                        <button type="submit" class="btn btn-success" id="checkoutButton">Continue Checkout</button>
                    </div>
                </div>
            </form>
            <div class="row">
            </div>
        </div>
    <?php include("footer.html");?>
</body>
<script src="js/checkout.js"></script>
<script src="js/form-validation.js"></script>
</html>
