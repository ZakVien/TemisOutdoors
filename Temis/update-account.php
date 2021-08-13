<?php
//Start the session
session_start();
if(empty($_SESSION["userLogin"])){
    ?>
<script>
    window.location.replace("login.php");

</script>
<?php
    }else{
        $userId = $_SESSION["userLogin"];
    }
require_once("connect-db.php");
    $error = $success = $useremail = $userpassword = $useraddress = $usercity = $userzip = "";
    if(isset($_POST["updateaccount"])){
        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $userId = test_input($_POST["userId"]);
        $useremail = test_input($_POST["useremail"]);
        $userpassword = test_input($_POST["userpassword"]);
        $userfirstName = test_input($_POST["userfirstName"]);
        $userlastName = test_input($_POST["userlastName"]);
        $userphone = test_input($_POST["userphone"]);
        $useraddress = test_input($_POST["useraddress"]);
        $useraddress2 = test_input($_POST["useraddress2"]);
        $usercity = test_input($_POST["usercity"]);
        $userstate = $_POST["userstate"];
        $userzip = test_input($_POST["userzip"]);

        $sql = "update users
                set email = :useremail,
                password = :userpassword,
                firstName = :userfirstName,
                lastName = :userlastName,
                address = :useraddress,
                address2 = :useraddress2,
                city = :usercity,
                state = :userstate,
                zip = :userzip,
                phone = :userphone
                where userId = :userId";

        $statement1 = $db->prepare($sql);

        $statement1->bindValue(':userId', $userId);
        $statement1->bindValue(':useremail', $useremail);
        $statement1->bindValue(':userpassword', $userpassword);
        $statement1->bindValue(':userfirstName', $userfirstName);
        $statement1->bindValue(':userlastName', $userlastName);
        $statement1->bindValue(':userphone', $userphone);
        $statement1->bindValue(':useraddress', $useraddress);
        $statement1->bindValue(':useraddress2', $useraddress2);
        $statement1->bindValue(':usercity', $usercity);
        $statement1->bindValue(':userstate', $userstate);
        $statement1->bindValue(':userzip', $userzip);
        
        if($statement1->execute()){
            $statement1->closeCursor();
            $success = "Your account information has been updated.";
        }else{
            $error = "Error updating your account.";
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
    <title>Update Account | Temis Outdoors - Hobby &amp; Supply</title>
    <meta name='description' content='Update your account to ensure your products get to your front door without issue! - FREE shipping and returns on everything'>
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
                <h2>Update Account Information</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <?php
                            if($error != ""){?>
                <div class="alert alert-danger" role="alert">
                    <?php echo "$error";?>
                </div><?php
                            }
                            if($success != ""){?>
                <div class="alert alert-success" role="alert">
                    <?php echo "$success";?>
                </div><?php
                            }
                        ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col">
                <?php
                                $error = $success = $manufacturerName = "";
                                
                                $sql = "select * from users where userId = :userId";
                                $statement1 = $db->prepare($sql);
                                $statement1->bindValue(":userId", $userId);
                                if($statement1->execute()){
                                    $userInfo = $statement1->fetchAll();
                                    $statement1->closeCursor();
                                }else{
                                    $error = "Error finding database.";
                                }
                        
                            foreach($userInfo as $u){
                        ?>
                <form id="updateaccount" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                    <div class="form-group">
                        <label for="useremail">Email Address <span class="req">*</span></label>
                        <input type="text" class="form-control" name="useremail" value="<?php echo $u['email'] ?>" placeholder="email@address.com" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="userpassword">Password <span class="req">*</span></label>
                            <input type="password" class="form-control" name="userpassword" value="<?php echo $u['password'] ?>" placeholder="Password" required>
                        </div>
                        <div class="form-group col">
                            <label for="confiruserpassword">Confirm Password</label>
                            <input type="password" class="form-control" name="confirmuserpassword" value="" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="userfirstName">First <span class="req">*</span></label>
                            <input type="text" class="form-control" name="userfirstName" value="<?php echo $u['firstName']?>" placeholder="First Name" required>
                        </div>
                        <div class="form-group col">
                            <label for="userfirstName">Last <span class="req">*</span></label>
                            <input type="text" class="form-control" name="userlastName" value="<?php echo $u['lastName']?>" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="userphone">Phone Number</label>
                            <input type="tel" class="form-control" name="userphone" value="<?php echo $u['phone']?>" placeholder="(888) 555-1234">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="useraddress">Street Address <span class="req">*</span></label>
                            <input type="text" class="form-control" name="useraddress" value="<?php echo $u['address'] ?>" placeholder="Street Address" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="useraddress2">Address 2</label>
                            <input type="text" class="form-control" name="useraddress2" value="<?php echo $u['address2']?>" placeholder="Apartment, studio, or floor">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="usercity">City <span class="req">*</span></label>
                            <input type="text" class="form-control" name="usercity" value="<?php echo $u["city"] ?>" placeholder="City" required>
                        </div>
                        <div class="form-group col-2">
                            <label for="userstate">State <span class="req">*</span></label>
                            <select class="form-control" name="userstate" required>
                                <?php if(isset($u["state"])){?>
                                <option value="<?php echo $u["state"]; ?>" selected="selected"><?php echo $u["state"]; ?></option>
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
                        <div class="form-group col-2">
                            <label for="userzip">ZIP <span class="req">*</span></label>
                            <input type="num" class="form-control" name="userzip" value="<?php echo $u["zip"] ?>" required>
                        </div>
                    </div>
                    <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                    <div class="form-row">
                        <div class="col"></div>
                        <div class="col-3 text-center">
                            <button class="btn btn-primary w-100" name="updateaccount" type="submit">Submit</button>
                        </div>
                        <div class="col"></div>
                    </div>
                </form>
                <?php } //end foreach 
                        if($error != ""){
                            echo "<h5>$error</h5>";
                        }
                        ?>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <?php include("footer.html");?>
</body>

</html>

<script src="js/form-validation.js"></script>