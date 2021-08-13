<?php
if(isset($_SESSION["cart"])){
    if(is_null($_SESSION["cart"])){
        $_SESSION["cart"] = array();
    }
}else{
    $_SESSION["cart"] = array();
}
$cartSize = 0;
foreach($_SESSION["cart"] as $key => $value){
    $cartSize = $cartSize + $value['quantity'];
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-faded">
    <script src="https://kit.fontawesome.com/f69cd1f33b.js" crossorigin="anonymous"></script>
    <a class="navbar-brand my-auto" href="../index.php"><img src="../images/temislogo1.png" id="temisLogo"></a>
    <div class="d-flex flex-row p-1 d-lg-none" id="mobileTopRow">
        <a href="../my-cart.php"><i class="fa fa-2x fa-shopping-cart"></i><?php if(!empty($cartSize)){ ?><span class="badge badge-warning"><?php echo $cartSize; ?></span><?php }?> </a>
        <a href="../my-account.php"><i class="accIcon far fa-2x fa-user"></i></a>
        <a href="../locations.php"><i class="fas fa-2x fa-map-marked-alt"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
            <i class="fas fa-2x fa-bars"></i>
        </button>
    </div>
    <div class="navbar-collapse flex-md-column collapse" id="navbarCollapse">
        <div id="topRow" class="d-flex w-100">
            <!-- searchbox for LG+XL displays-->
            <form id="searchbox" method="POST" action="../search-results.php" class="search-container form-inline ml-auto searchbox d-none d-lg-block">
                <input type="text" placeholder="Search.." name="search" class="searchbox-input">
            </form>
            
            <!--searchbox for displays smaller than lg-->
            <form method="POST" action="../search-results.php" class="search-container form-inline mx-auto searchbox d-lg-none searchbox-open">
                <input type="text" placeholder="Search.." name="search" class="searchbox-input justify-content-center">
            </form>
            <i id="searchIcon" class="fa fa-2x fa-search d-none d-lg-block"><span class="navCaption navCapSearch">Search</span></i>
            <a href="../my-cart.php" class="d-none d-lg-block"><i class="far fa-2x fa-shopping-cart"></i><span class="navCaption"><?php if(!empty($cartSize)){ ?><span class="badge badge-warning"><?php echo $cartSize; ?></span><?php }?> Cart</span></a>
            <a href="../my-account.php" class="d-none d-lg-block"><i class="accIcon far fa-2x fa-user"></i><span class="navCaption"><?php if(!isset($_SESSION["userLogin"])){echo 'Log In';}else{echo 'My Account';} ?></span></a>
            <a href="../locations.php" class="d-none d-lg-block"><i class="fas fa-2x fa-map-marked-alt"></i><span class="navCaption">Locations</span></a>
        </div>
        <span class="yellowbar w-100"></span>
        <?php include("../nav-items-subfolder.html");?>
    </div>
</nav>