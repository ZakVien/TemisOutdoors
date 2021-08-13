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
    <title>About Us | Temis Outdoors - Hobby &amp; Supply</title>
    <meta name='description' content='Temis is your one-stop shop for affordable outdoor lifestyle supplies - FREE shipping and returns on everything'>
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
                <h1>About Us</h1>
            </div>
        </div>
        <div class="aboutspacer"></div>
        <div class="row">
            <div class="aboutspacer"></div>
            <div class="col">
                <h2 class="d-flex justify-content-center">Our Mission Statement</h2>
                <p>At Temis, our mission is to provide our customers with quality products they need at prices that are affordable. But this is not our only design; we desire to be a brand that our customers can place their trust in. Allowing the formation of lasting bonds with our customers. Through this bond we hope to aid our customers in the fostering of a love and continued enjoyment for the outdoors, that we ourselves have cultivated.</p>
            </div>
            <div class="d-flex align-items-center text-center col-md-6 col-lg-5">
                <div class="aboutusImages">
                    <img src="images/archer.jpg" alt="Archer">
                </div>
            </div>
        </div>
        <div class="aboutspacer"></div>
        <div class="aboutspacer"></div>
        <div class="row">
            <div class="d-none d-md-block w-100" id="gardenerImage">
            </div>
        </div>
        <div class="aboutspacer d-none d-md-block"></div>
        <div class="aboutspacer d-none d-md-block"></div>
        <div class="row d-flex flex-wrap-reverse">
            <div class="aboutspacer"></div>
            <div class="d-flex align-items-center text-center col-md-6 col-lg-5">
                <div class="aboutusImages">
                    <img src="images/fisher.jpg" alt="Fisherman">
                </div>
            </div>
            <div class="col">
                <h2 class="d-flex justify-content-center">What Makes Us Special</h2>
                <p>At Temis we want to assist our customers in as many ways as possible. One of the ways that we have found that we can aid our customers is through our <span class="greenText">No Hassle Return Policy&#8482;</span>. This policy allows us to come alongside our customers and make their shopping experience better. </p>
                <br>
                <p>Some of the features included in our <span class="greenText">No Hassle Return Policy&#8482;</span> are:</p>
                <ul>
                    <li>Free Shipping &amp; Returns</li>
                    <li>Free 2 Year Warranty on <b>all</b> items</li>
                </ul>
            </div>
        </div>
        <div class="aboutspacer"></div>
    </div>
    <div class="container-fluid">
        <?php include("footer.html");?>
    </div>
</body>

</html>
