<?php
//Start the session
session_start();
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
    <title>Contact Us | Temis Outdoors - Hobby &amp; Supply</title>
    <meta name='description' content='Temis is more than happy to respond to your questions, comments, or concerns - FREE shipping and returns on everything'>
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
                <h1>Contact Us</h1>
            </div>
        </div>
        <?php 
            if(isset($_POST["submit"])){
                $formSuccess = "Thank you for your feedback. Please expect a response within 36 hours.<br><br>Thanks for shopping Temis!"
        ?>
        <div class="row">
            <div class="col">
                <div class="alert alert-success alert-dismissible text-center fade show" role="alert">
                    <?php echo $formSuccess; ?>
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-6 mx-auto">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-row">
                        <div class="col">
                            <label for="contactemail">Email Address<span class="req">*</span></label>
                            <input type="email" class="form-control" name="useremail" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="contactTextarea">Enter your questions, comments, or concerns below<span class="req">*</span></label>
                        <textarea class="form-control" id="contactTextarea" rows="5" required></textarea>
                    </div>
                    <br>
                    <div class="text-center">
                        <button class="btn btn-primary w-100" name="submit" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <?php include("footer.html");?>
    </div>
</body>

</html>
