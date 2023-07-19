<?php 
//conectamos la base de datos
$hostname = "localhost"; //nombre del host
$dbUser="root"; //usuario de la base de datos
$dbPassword=""; //ninguna contraseña establecida
$dbName="login-register";
$conn = mysqli_connect($hostname, $dbUser , $dbPassword ,$dbName);
if (!$conn){
    die("Connection went wrong;");
}
?>
