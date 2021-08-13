<?php
//Start the session
session_start();
if(empty($_SESSION["userLogin"])){
    ?>
<script>
    window.location.replace("login.php");

</script>
<?php };?>

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
    <title>Previous Orders | Temis Outdoors - Hobby &amp; Supply</title>
    <meta name='description' content='View previous purchases in a centralized location at Temis, where everything is covered by our No Hassle Return Policy - FREE shipping and returns on everything'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet.css" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="icon" href="images/favicon.png" type="image/x-icon" size="64x64">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
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
                <h2>Previous Orders</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <?php
                require_once("connect-db.php");
                $success = $error = $empty = $loopedOrderId = "";
                
                $sqlemail = "select email from users where userId = :userId";
                $emailstmt = $db->prepare($sqlemail);
                $emailstmt->bindValue(":userId", $_SESSION["userLogin"]);
                if($emailstmt->execute()){
                    $users = $emailstmt->fetchAll();
                    $emailstmt->closeCursor();
                    $userEmail = $users[0]["email"];
                    
                    $sql = "select * from ordersproducts
                    inner join orders
                    on ordersproducts.orderId = orders.orderId
                    inner join products
                    on ordersproducts.productId = products.productId
                    where email = :userEmail
                    order by ordersproducts.orderId";
                    $stmt1 = $db->prepare($sql);
                    $stmt1->bindValue(":userEmail", $userEmail);
                    if($stmt1->execute()){
                        $orders = $stmt1->fetchAll();
                        $stmt1->closeCursor();
                        if($stmt1->rowCount() == 0){
                            $empty = "You don't have any previous orders.";
                        }?>
                <div id='accordion'>
                    <?php foreach($orders as $o){
                            if($o["orderId"] != $loopedOrderId){ 
                    ?>
                    <h3><?php echo date("F d, Y", strtotime($o["date"]));?></h3>
                    <div>
                        <table class="table">
                            <tr>
                                <th>Item</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Item Total</th>
                            </tr><?php
                                        $orderId = $o["orderId"];
                                        foreach($orders as $ord){
                                            if($orderId == $ord["orderId"]){ ?>
                            <tr>
                                <td><a href="<?php echo $ord['url'];?>"><img class="cartProductImage" src="<?php echo $ord['image'];?>" alt="<?php echo $o['alt'];?>"></a></td>
                                <td><?php echo $ord['manufacturer']." ".$ord['name'];?></td>
                                <td><?php echo $ord['quantity'];?></td>
                                <td>$<?php echo number_format($ord["quantity"] * $ord["price"], 2); ?></td>
                            </tr>
                            <?php
                                            }  } ?>
                        </table>
                    </div>
                    <?php $loopedOrderId = $o["orderId"];
                              }
                            } ?>
                </div>
                <?php }

                }else{
                    $error = "We're sorry, but there was an issue finding your order history.";
                }
                if($error != ""){
                    echo $error;
                }
                if($empty != ""){
                    echo $empty;
                }
                ?>
            </div>
        </div>
    </div>
    <?php include("footer.html");?>
</body>
<script src="js/accordion.js"></script>

</html>
