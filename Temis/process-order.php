<?php
//Start the session
session_start();
date_default_timezone_set("America/New_York");
require_once("connect-db.php");

    
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$ccNum = $ccExpMonth = $ccExpYear = $cvc = $bitcoinAddress = $paymentMethod = "";
$email = $_SESSION["email"];
$total = $_SESSION["total"];

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
    <title>Check Out - Process Order | Temis Outdoors - Hobby &amp; Supply</title>
    <meta name='description' content='Temis has an efficient checkout process to ensure you spend more time on your outdoor lifestyle - FREE shipping and returns on everything'>
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
    <div class="container">
            <div class="row">
                <div class="col">
                    <?php
                    $error = $success = $paymentError = $paymentSuccess = "";
                    $sql = "insert into orders (email, total) values (:email, :total)";
                    $stmt_sql = $db->prepare($sql);
                    $stmt_sql->bindValue(":email", $email);
                    $stmt_sql->bindValue(":total", $total);
                    
                    if($stmt_sql->execute()){
                        //get orderId number
                        $sql_orderid = "select orderId from orders where email = :email";
                        $stmt_orderid = $db->prepare($sql_orderid);
                        $stmt_orderid->bindValue(":email", $email);
                        
                        if($stmt_orderid->execute()){
                            $orders = $stmt_orderid->fetchAll();
                            $stmt_orderid->closeCursor();
                            
                            //get most recent orderId
                            $orderArrayId = array_key_last($orders);
                            $orderId = array_column($orders, 'orderId');
                            $orderId = end($orderId);
                            $date=date("Y/n/j");
                            
                            $sql_products = "insert into ordersproducts (orderId, productId, quantity, price, date) VALUES (:orderId, :productId, :quantity, :price, :date)";
                            
                            $stmt_sqlproducts = $db->prepare($sql_products);
                            
                            foreach($_SESSION["cart"] as $key => $value){
                                $productId = $value["productId"];
                                $quantity = $value["quantity"];
                                $price = $value["price"];
                                
                                $stmt_sqlproducts->bindValue(":orderId", $orderId);
                                $stmt_sqlproducts->bindValue(":productId", $productId);
                                $stmt_sqlproducts->bindValue(":quantity", $quantity);
                                $stmt_sqlproducts->bindValue(":price", $price);
                                $stmt_sqlproducts->bindValue(":date", $date);
                                
                                if($stmt_sqlproducts->execute()){
                                    $success = "Order successfully placed.";
                                    unset($_SESSION["cart"]);
                                }else{
                                    $error = "Error submitting order.";
                                }
                            }
                            $sqlTransaction = "insert into transactions (orderId) values (:orderId)";
                            $stmt_trans = $db->prepare($sqlTransaction);
                            $stmt_trans->bindValue(":orderId", $orderId);
                            if($stmt_trans->execute()){
                                $sqlGetTrxId = "select transactionId from transactions where orderId = :orderId";
                                $stmt_getTrxId = $db->prepare($sqlGetTrxId);
                                $stmt_getTrxId->bindValue(":orderId", $orderId);
                                if($stmt_getTrxId->execute()){
                                    $transactions = $stmt_getTrxId->fetchAll();
                                    $stmt_getTrxId->closeCursor();

                                    //get most recent orderId
                                    $transactionArrayId = array_key_last($transactions);
                                    $transactionId = array_column($transactions, 'transactionId');
                                    $transactionId = end($transactionId);

                                    if(isset($_SESSION["ccNum"])){
                                        $ccNum = $_SESSION["ccNum"];
                                        $ccExpMonth = $_SESSION["ccExpMonth"];
                                        $ccExpYear = $_SESSION["ccExpYear"];
                                        $cvc = $_SESSION["cvc"];
                                        $sql_credit = "insert into credittransactions (transactionId, orderId, cardnumber, expmonth, expyear, cvc) values (:transactionId, :orderId, :cardnumber, :expmonth, :expyear, :cvc)";
                                        $stmt_credit = $db->prepare($sql_credit);
                                        $stmt_credit->bindValue(":transactionId", $transactionId);
                                        $stmt_credit->bindValue(":orderId", $orderId);
                                        $stmt_credit->bindValue(":cardnumber", $ccNum);
                                        $stmt_credit->bindValue(":expmonth", $ccExpMonth);
                                        $stmt_credit->bindValue(":expyear", $ccExpYear);
                                        $stmt_credit->bindValue(":cvc", $cvc);

                                        if($stmt_credit->execute()){
                                            $paymentSuccess = "Credit card payment was sucessful.";
                                        }else{
                                            $paymentError = "Error submitting credit card payment.";
                                        }
                                    }else if(isset($_SESSION["bitcoinAddress"])){
                                        $bitcoinAddress = $_SESSION["bitcoinAddress"];
                                        $sql_bitcoin = "insert into bitcointransactions (transactionId, orderId, bitcoinaddress) values (:transactionId, :orderId, :bitcoinaddress)";
                                        $stmt_bitcoin = $db->prepare($sql_bitcoin);
                                        $stmt_bitcoin->bindValue(":transactionId", $transactionId);
                                        $stmt_bitcoin->bindValue(":orderId", $orderId);
                                        $stmt_bitcoin->bindValue(":bitcoinaddress", $bitcoinAddress);?>
                                        <script><?php print_r($stmt_bitcoin);?></script><?php
                                        if($stmt_bitcoin->execute()){
                                            $paymentSuccess = "Bitcoin payment was sucessful.";
                                        }else{
                                            $paymentError = "Error submitting bitcoin payment.";
                                        }
                                    }
                                }
                            }
                        }else{
                            $error = "Error connecting to database.";
                        }
                    }else{
                        $error = "Error connecting to database.";
                    }
                    
                    
                    if($error != ""){?>
                        <div class="text-center w-100 alert alert-warning"><?php echo $error;?></div>
                    <?php }else{?>
                        <div class="text-center w-100 alert alert-success"><?php echo $success;?></div>
                    <?php }
                    if($paymentError != ""){?>
                        <div class="text-center w-100 alert alert-warning"><?php echo $paymentError;?></div>
                    <?php }else{?>
                        <div class="text-center w-100 alert alert-success"><?php echo $paymentSuccess;?></div>
                    <?php }?>
                </div>
            </div>
        </div>
    <?php include("footer.html");?>
</body>

</html>
