<?php
$servidor = "localhost";
$usuario = "root";             
$password = "";                 
$base_de_datos = "volumenDeHierro"; 


$conn = new mysqli($servidor, $usuario, $password, $base_de_datos);



if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


$conn->set_charset("utf8");

?>