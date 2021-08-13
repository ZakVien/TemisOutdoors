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
    <title>My Account | Temis Outdoors - Hobby &amp; Supply</title>
    <meta name='description' content='View my account details at Temis - the #1 outdoor lifestyle seller - FREE shipping and returns on everything'>
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
                <h2>My Account Page</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form method="POST" action="update-account.php">
                    <input type="hidden" value="">
                    <button type="submit" class="btn btn-primary">Update Account</button>
                </form>
            </div>
        </div>
        <div class="spacer"></div>
        <div class="row">
            <div class="col">
                <a href="previous-orders.php"><button type="submit" class="btn btn-primary">Previous Orders</button></a>
            </div>
        </div>
        <div class="spacer"></div>
        <div class="row">
            <div class="col">
                <a href="signout.php"><button class="btn btn-warning">Sign Out</button></a>
            </div>
        </div>
        <div class="spacer"></div>
        <div class="row">
            <div class="col">
                <a href="#"><button class="btn btn-danger">Delete Account</button></a>
            </div>
        </div>
        <div class="spacer"></div>
    </div>
    <?php include("footer.html");?>
</body>

</html>
