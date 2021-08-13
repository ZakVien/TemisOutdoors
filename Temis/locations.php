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
    <title>Our Locations | Temis Outdoors - Hobby &amp; Supply</title>
    <meta name='description' content='Temis ships all orders from our central Vermont location - FREE shipping and returns on everything'>
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
                <h1>Our Location</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h2>A small store with a big heart</h2>
                <p>Temis Outdoors is based in Central Vermont because we know that's where our customers love to hunt. By being in a central location, we can ensure our customers receive their orders within two days!</p>
                <p>Our out-of-state customers might have to wait an extra day or two, but you can still get a <b>brand new</b> trowel, hunting blind, or any of our outdoor hobby products (which always ship for free!) within 3-4 days, guaranteed!</p>
                <p>Since we do not have a central location, we don't have any hours to post. However, if you'd like to send us letters or gifts, our address is:</p>
                <p>2393 Rood Pond Rd<br>Williamstown, VT 05679</p>
            </div>
            <div class="col-md-6 col-lg-4">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3604.7055433139208!2d-72.58037239900936!3d44.08639139261387!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cb51b6a77bdddfd%3A0xc40f156e88cf9bec!2s2393%20Rood%20Pond%20Rd%2C%20Williamstown%2C%20VT%2005679!5e1!3m2!1sen!2sus!4v1605137849607!5m2!1sen!2sus" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
        <div class="aboutspacer"></div>
    </div>
    <div class="container-fluid">
        <?php include("footer.html");?>
    </div>
</body>

</html>
