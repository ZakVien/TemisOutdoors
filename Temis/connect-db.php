<?php

//localhost
$dsn="mysql:host=localhost;dbname=pplwytue_temisoutdoors";
$username="pplwytue_temisoutdoors";
$password="temisoutdoors";

//domain
/*
$dsn="mysql:host=localhost;dbname=pplwytue_temisoutdoors";
$username="pplwytue_temisoutdoors";
$password="temisoutdoors";
*/
try{
    $db=new PDO($dsn, $username, $password);
}catch(Exception $e){
    $error = $e->getMessage();
    echo $error;
    exit();    
}
?>
