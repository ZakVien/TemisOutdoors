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
    <title>Create Account | Temis Outdoors - Hobby &amp; Supply</title>
    <meta name='description' content='Create an account with Temis to expedite your next checkout experience! - FREE shipping and returns on everything'>
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
                <h2>Create Account Page</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-6 mx-auto">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="createAccountForm">
                    <div class="form-row">
                        <div class="col">
                            <label for="useremail">Email Address<span class="req">*</span></label>
                            <input type="email" class="form-control" name="useremail" value="<?php if(isset($_POST["useremail"])) echo $_POST["useremail"]; ?>" placeholder="email@address.com" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="userpassword">Password (minimum 6 characters)<span class="req">*</span></label>
                            <input type="password" class="form-control" name="userpassword" value="<?php if(isset($_POST["userpassword"])) echo $_POST["userpassword"]; ?>" placeholder="********" required>
                        </div>
                        <div class="col">
                            <label for="userpasswordconfirm">Confirm Password<span class="req">*</span></label>
                            <input type="password" class="form-control" name="userpasswordconfirm" value="<?php if(isset($_POST["userpasswordconfirm"])) echo $_POST["userpasswordconfirm"]; ?>" placeholder="********" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="userfirst">First Name<span class="req">*</span></label>
                            <input type="text" class="form-control" name="userfirst" value="<?php if(isset($_POST["userfirst"])) echo $_POST["userfirst"]; ?>" placeholder="Jane" required>
                        </div>
                        <div class="col">
                            <label for="userlast">Last Name<span class="req">*</span></label>
                            <input type="text" class="form-control" name="userlast" value="<?php if(isset($_POST["userlast"])) echo $_POST["userlast"]; ?>" placeholder="Doe" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="useraddress">Street Address<span class="req">*</span></label>
                            <input type="text" class="form-control" name="useraddress" value="<?php if(isset($_POST["useraddress"])) echo $_POST["useraddress"]; ?>" placeholder="1234 Business Avenue" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="useraddress2">Address 2</label>
                            <input type="text" class="form-control" name="useraddress2" value="<?php if(isset($_POST["useraddress2"])) echo $_POST["useraddress2"]; ?>" placeholder="Apt, Suite, etc.">
                        </div>
                        <div class="col">
                            <label for="usercity">City<span class="req">*</span></label>
                            <input type="text" class="form-control" name="usercity" value="<?php if(isset($_POST["usercity"])) echo $_POST["usercity"]; ?>" placeholder="City" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="userstate">State<span class="req">*</span></label>
                            <select class="form-control" name="userstate" required>
                                <?php if(isset($_POST["userstate"])){?>
                                <option value="<?php echo $_POST["userstate"]; ?>" selected="selected"><?php echo $_POST["userstate"]; ?></option>
                                <?php }else{ ?>
                                <option value="" disabled selected>Choose...</option>
                                <?php }?>
                                <option value="AL">AL</option>
                                <option value="AK">AK</option>
                                <option value="AZ">AZ</option>
                                <option value="AR">AR</option>
                                <option value="CA">CA</option>
                                <option value="CO">CO</option>
                                <option value="CT">CT</option>
                                <option value="DE">DE</option>
                                <option value="DC">DC</option>
                                <option value="FL">FL</option>
                                <option value="GA">GA</option>
                                <option value="HI">HI</option>
                                <option value="ID">ID</option>
                                <option value="IL">IL</option>
                                <option value="IN">IN</option>
                                <option value="IA">IA</option>
                                <option value="KS">KS</option>
                                <option value="KY">KY</option>
                                <option value="LA">LA</option>
                                <option value="ME">ME</option>
                                <option value="MD">MD</option>
                                <option value="MA">MA</option>
                                <option value="MI">MI</option>
                                <option value="MN">MN</option>
                                <option value="MS">MS</option>
                                <option value="MO">MO</option>
                                <option value="MT">MT</option>
                                <option value="NE">NE</option>
                                <option value="NV">NV</option>
                                <option value="NH">NH</option>
                                <option value="NJ">NJ</option>
                                <option value="NM">NM</option>
                                <option value="NY">NY</option>
                                <option value="NC">NC</option>
                                <option value="ND">ND</option>
                                <option value="OH">OH</option>
                                <option value="OK">OK</option>
                                <option value="OR">OR</option>
                                <option value="PA">PA</option>
                                <option value="RI">RI</option>
                                <option value="SC">SC</option>
                                <option value="SD">SD</option>
                                <option value="TN">TN</option>
                                <option value="TX">TX</option>
                                <option value="UT">UT</option>
                                <option value="VT">VT</option>
                                <option value="VA">VA</option>
                                <option value="WA">WA</option>
                                <option value="WV">WV</option>
                                <option value="WI">WI</option>
                                <option value="WY">WY</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="userzip">ZIP<span class="req">*</span></label>
                            <input type="num" class="form-control" name="userzip" value="<?php if(isset($_POST["userzip"])) echo $_POST["userzip"]; ?>" placeholder="12345" required>
                        </div>
                        <div class="col">
                            <label for="userphone">Phone<span class="req">*</span></label>
                            <input type="tel" class="form-control" name="userphone" value="<?php if(isset($_POST["userphone"])) echo $_POST["userphone"]; ?>" placeholder="9201234567" required>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button class="btn btn-primary w-100" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <?php
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $error = $success = $manufacturerName = "";
                    require_once("connect-db.php");
                    function test_input($data){
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                    }

                    $useremail = test_input($_POST["useremail"]);
                    $userpassword = test_input($_POST["userpassword"]);
                    $userpasswordconfirm = test_input($_POST["userpasswordconfirm"]);
                    $userfirst = test_input($_POST["userfirst"]);
                    $userlast = test_input($_POST["userlast"]);
                    $useraddress = test_input($_POST["useraddress"]);
                    $useraddress2 = test_input($_POST["useraddress2"]);
                    $usercity = test_input($_POST["usercity"]);
                    $userstate = $_POST["userstate"];
                    $userzip = test_input($_POST["userzip"]);
                    $userphone = test_input($_POST["userphone"]);

                    if($userpassword === $userpasswordconfirm){

                        $sql = "insert into users 
                        (email, password, firstName, lastName, address, address2, city, state, zip, phone) 
                        values 
                        (:useremail, :userpassword, :userfirst, :userlast, :useraddress, :useraddress2, :usercity, :userstate, :userzip, :userphone)";

                        $statement1 = $db->prepare($sql);

                        $statement1->bindValue(":useremail", $useremail);
                        $statement1->bindValue(":userpassword", $userpassword);
                        $statement1->bindValue(":userfirst", $userfirst);
                        $statement1->bindValue(":userlast", $userlast);
                        $statement1->bindValue(":useraddress", $useraddress);
                        $statement1->bindValue(":useraddress2", $useraddress2);
                        $statement1->bindValue(":usercity", $usercity);
                        $statement1->bindValue(":userstate", $userstate);
                        $statement1->bindValue(":userzip", $userzip);
                        $statement1->bindValue(":userphone", $userphone);

                        if($statement1->execute()){
                            $success = "Account successfully created. <br>Please log in below using the email and password you signed up with.";
                            $_SESSION["accountcreated"] = $success;?>
                <script>
                    window.location.replace("login.php");

                </script><?php
                            }else{
                                $error = "Error creating account.";
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <?php include("footer.html");?>
</body>

</html>
<script src="js/form-validation.js"></script>