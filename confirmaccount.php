<?php
require 'configdb.php';

if(isset($_GET["useremail"]) && isset($_GET["confirm_code"]) ){
    $sql = "UPDATE Usuarios SET confirmed = 1 WHERE email ='".$_GET["useremail"]."' AND confirmation_code='".$_GET["confirm_code"]."'";

    $conn->query($sql);
}
?>