<?php
// crearmos unas variables para la conexio
$host="localhost";
$bd="sitio";
$usuario="root";
$contraseña="";
// usamos try y creamos una variable y usamos el new y PDO que nos permite conectarnos  con la bd
try {
    $conexion=new PDO("mysql:host=$host;dbname=$bd", $usuario,$contraseña);
    //  if ($conexion) {echo "Conectado... a sistema";}

} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>