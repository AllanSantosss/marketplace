 
<?php

 
$db_host = "localhost";
 
$db_user = "root";
 
$db_pass = "";
 
$db_name = "marketplace";
 
$db_port = 3306;
 

try{
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
}catch( mysqli_sql_exception $e ){
    header("Location: /400.php");
}catch(Exception $e){
    echo $e;
}

?>