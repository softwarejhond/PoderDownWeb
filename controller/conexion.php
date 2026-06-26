<?php
//datos local
$server = "db";
$username = "root";
$password = "root";
$bd = "tienda_virtual";

// $server = "148.113.221.17";
// $username = "poderdow_34Gl3s0Ftw4r3";
// $password = "P@Kg[z%u[jalmte%";
// $bd = "poderdow_3C0M3rs";


//creamos una conexión
$conn = mysqli_connect($server, $username, $password, $bd);
//Chequeamos la conexión
if (!$conn) {
    die("Conexión fallida:" . mysqli_connect_error());
}
// Set the character set to UTF-8
mysqli_set_charset($conn, "utf8");
// Set the collation to utf8_general_ci
mysqli_query($conn, "SET NAMES 'utf8'");
mysqli_query($conn, "SET CHARACTER SET 'utf8'");
mysqli_query($conn, "SET COLLATION_CONNECTION = 'utf8_general_ci'");