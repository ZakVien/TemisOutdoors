<?php
//Start the session
session_start();
unset($_SESSION["userLogin"]);
?>
<?php
    $error = $success = $emptyFields = $_SESSION["userLogin"] = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require_once("connect-db.php");
        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $useremail = test_input($_POST["useremail"]);
        $userpassword = test_input($_POST["userpassword"]);
        if(empty($useremail) || empty($userpassword)){
            $emptyFields = "Please fill in all fields properly.";
        }else{
            $sql = "select * from users where email = :useremail and password = :userpassword";

            $statement1 = $db->prepare($sql);
            $statement1->bindValue(":useremail", $useremail);
            $statement1->bindValue(":userpassword", $userpassword);

            if($statement1->execute()){
                $usersFound = $statement1->fetchAll();
                $statement1->closeCursor();
                foreach($usersFound as $u){
                    $_SESSION["userLogin"] = $u["userId"];
                    ?>
<script>
    window.location.replace("my-account.php");

</script>
<?php
                }
            }
            $error = "Incorrect username or password. <br><br>
                Please try again or <a href='create-account.php'>create an account.</a>";
        }
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
    <title>Login | Temis Outdoors - Hobby &amp; Supply</title>
    <meta name='description' content='Log in to Temis to begin your next affordable experience here - FREE shipping and returns on everything'>
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
                    <h2>Log in</h2>
                </div>
            </div>
            <div class="row"><?php
                    //alert if sent from login/sign up page
                    if(isset($_SESSION['accountcreated'])){ ?>
                <div class="alert alert-success alert-dismissible fade show mx-auto text-center" role="alert">
                    <?php $createAccSuccess = $_SESSION["accountcreated"];
                            echo $createAccSuccess;
                            unset($_SESSION["accountcreated"]);?>
                </div><?php
                    }?>
            </div>
            <div class="row">
                <div class="col-5 mx-auto text-left">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <div class="form-row">
                            <div class="col">
                                <label for="useremail">Email:<span class="req">*</span></label>
                                <input class="form-control" type="text" name="useremail" value="<?php if(isset($_POST["useremail"])) echo $_POST["useremail"];?>" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="userpassword">Password:<span class="req">*</span></label>
                                <input class="form-control" type="password" name="userpassword" value="<?php if(isset($_POST["userpassword"])) echo $_POST["userpassword"];?>" required>
                            </div>
                        </div>
                        <br>
                        <div class="d-lg-flex text-center">
                            <span class="mx-auto ml-lg-0 mr-lg-auto"><button type="submit" class="btn btn-primary">Log In</button></span>
                            <div class="d-lg-none"><br></div>
                            <span class="mx-auto mr-lg-0 ml-lg-auto"><a href="create-account.php"><button type="button" class="btn btn-warning">Create an account</button></a></span>
                        </div>
                    </form>
                    <h5 class="text-center">
                        <?php if($emptyFields != ""){
                            echo "<div class='alert alert-warning'>" . $emptyFields . "</div>";
                        }else if($error != ""){
                            echo "<div class='alert alert-danger'>" . $error . "</div>";
                        }else if($success != ""){
                            echo "<div class='alert alert-success'>" . $success . "</div>";
                        }
                    ?>
                    </h5>
                </div>
            </div>
        </div>
    <?php include("footer.html");?>
</body>

</html>
