<?php
session_start();
unset($_SESSION["userLogin"]);
unset($_SESSION["phone"]);
header('Location: index.php');
exit;
?>