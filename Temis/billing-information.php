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
if(isset($_SESSION["email"])){
    unset($_SESSION["email"]);
}
if(isset($_SESSION["ccNum"])){
    unset($_SESSION["ccNum"]);
}
if(isset($_SESSION["bitcoinAddress"])){
    unset($_SESSION["bitcoinAddress"]);
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
    <title>Check Out - Billing Info | Temis Outdoors - Hobby &amp; Supply</title>
    <meta name='description' content='Temis protects your privacy by not sharing your data with third parties - FREE shipping and returns on everything'>
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
                    <h2>Checkout (Step 1 of 3)</h2>
                </div>
            </div>
            <form method="post" action="shipping-information.php" id="billingInfoForm">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <h3>Billing Information</h3>
                        <?php
                        $error = $success = $userid = "";
                        if(!empty($_SESSION["userLogin"])){
                            $userid = $_SESSION["userLogin"];
                            $sql = "select * from users where userId = :userid";
                            $statement1 = $db->prepare($sql);
                            $statement1->bindValue(":userid", $userid);

                            if($statement1->execute()){
                            $userInfo = $statement1->fetchAll();
                            $statement1->closeCursor();

                                    foreach($userInfo as $u){ 
                        $_SESSION["email"] = $u["email"];?>

                            
                            <div class="form-row">
                                <div class="col">
                                    <label for="email">Email Address<span class="req">*</span></label>
                                    <input id="emailInput" type="email" class="form-control cashDiv" name="email" placeholder="email@address.com" value="<?php echo $_SESSION["email"]; ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="firstName">First Name<span class="req">*</span></label>
                                    <input type="text" class="form-control" name="firstName" placeholder="First Name" value="<?php echo $u["firstName"];?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="lastName">Last Name<span class="req">*</span></label>
                                    <input type="text" class="form-control" name="lastName" placeholder="Last Name" value="<?php echo $u["lastName"];?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="billingAddr">Billing Address<span class="req">*</span></label>
                                    <input type="text" class="form-control" name="billingAddr" placeholder="Billing Address" value="<?php echo $u["address"]; ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="billingAddr2">Billing Address 2</label>
                                    <input type="text" class="form-control" name="billingAddr2" placeholder="Billing Address 2" value="<?php echo $u["address2"]; ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="city">City<span class="req">*</span></label>
                                    <input type="text" class="form-control" name="city" placeholder="City" value="<?php echo $u["city"]; ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="state">State<span class="req">*</span></label>
                                    <input type="text" class="form-control" name="state" placeholder="State" value="<?php echo $u["state"]; ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="zip">Zip<span class="req">*</span></label>
                                    <input type="text" class="form-control" name="zip" placeholder="Zip" value="<?php echo $u["zip"]; ?>" required>
                                </div>
                            </div>
                        <?php
                                    }
                                }
                            }else{?>
                        <div class="form-row">
                            <div class="col">
                                <label for="email">Email Address<span class="req">*</span></label>
                                <input id="emailInput" type="email" class="form-control cashDiv" name="email" placeholder="email@address.com" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="firstName">First Name<span class="req">*</span></label>
                                <input type="text" class="form-control" name="firstName" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="lastName">Last Name<span class="req">*</span></label>
                                <input type="text" class="form-control" name="lastName" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="billingAddr">Billing Address<span class="req">*</span></label>
                                <input type="text" class="form-control" name="billingAddr" placeholder="Billing Address" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="billingAddr2">Billing Address 2</label>
                                <input type="text" class="form-control" name="billingAddr2" placeholder="Billing Address 2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="city">City<span class="req">*</span></label>
                                <input type="text" class="form-control" name="city" placeholder="City" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="state">State<span class="req">*</span></label>
                                <input type="text" class="form-control" name="state" placeholder="State" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="zip">Zip<span class="req">*</span></label>
                                <input type="text" class="form-control" name="zip" placeholder="Zip" required>
                            </div>
                        </div>
                    <?php
                            }
                        ?>
                        <br>
                        <h3>Payment Method</h3>
                        <div class="text-center d-flex w-100 d-flex justify-content-between">
                            <button type="button" name="paymentMethod" id="creditDebit" class="btn btn-primary" onclick="changePaymentMethod(this.id)">Credit/Debit</button>
                            <button type="button" name="paymentMethod" id="bitcoin" class="btn btn-primary" onclick="changePaymentMethod(this.id)">Bitcoin</button>
                        </div>
                            <br>
                        <div id="creditDiv" class="d-none">
                            <div class="form-row">
                                <div class="col">
                                    <label for="ccNum">Card Number (no spaces or dashes)<span class="req">*</span></label>
                                    <input type="num" class="form-control creditDiv" name="ccNum" placeholder="0000-0000-0000-0000" id="ccNumInput">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <label for="ccNum">Expiration Month<span class="req">*</span></label>
                                    <input type="num" class="form-control creditDiv" name="ccExpMonth" placeholder="MM" id="ccMonthInput">
                                </div>
                                <div class="col">
                                    <label for="ccNum">Expiration Year<span class="req">*</span></label>
                                    <input type="num" class="form-control creditDiv" name="ccExpYear" placeholder="YYYY" id="ccYearInput">
                                    </div>
                                <div class="col">
                                    <label for="cvc">CVC<span class="req">*</span></label>
                                    <input type="password" class="form-control creditDiv" name="cvc" placeholder="***" id="cvcInput">
                                </div>
                            </div>
                        </div>
                        <div id="bitcoinDiv" class="d-none">
                            <div class="form-row">
                                <label for="bitcoinAddress">Bitcoin Address <span class="req">*</span></label>
                                <input class="form-control bitcoinDiv" name="bitcoinAddress" type="text" placeholder="1GoBTCTiC8TEVoLmrGk4CQFXiVbRr7ktoz" id="bitcoinAddressInput">
                            </div>
                            <div class="form-row">
                                <label for="USDtotal">Total ($USD)</label>
                                <input class="form-control" name="USDtotal" type="num" value="$<?php echo $_SESSION["total"];?>" readonly>
                            </div>
                            <div class="form-row">
                                <label for="USDtoBTC">USD/Bitcoin Conversion</label>
                                <input class="form-control" name="bitcoinAmount" type="num" value="<?php $USDtoBTC = ($_SESSION["total"] / 15300); echo $USDtoBTC." BTC";?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col d-flex justify-content-lg-center">
                        <input type="hidden" id="paymentMethod" name="paymentMethod" value="">
                        <button type="submit" class="btn btn-success d-none">Continue Checkout</button>
                    </div>
                </div>
            </form>
            <div class="row">
            </div>
        </div>
    <?php include("footer.html");?>
</body>
</html>
<script src="js/form-validation.js"></script>
<script src="js/checkout.js"></script>
