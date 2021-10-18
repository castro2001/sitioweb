<?php 
session_start();
if(!isset($_SESSION['usuario'])){
  header('location:../index.php');
}else{

    if ($_SESSION['usuario']=="ok") {
      $nombreUsuario=$_SESSION['nombreUsuario'];

    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Administrador</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
  <body>
   
  <?php $url="http://".$_SERVER['HTTP_HOST']."/sitioweb"?>
 

  <nav class="navbar navbar-dark bg-secondary">
        <a href="#"class="navbar-brand" >Administrador del sitio</a>
        <ul class="nav justify-content-center|justify-content-end">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $url;?>/admin/inicio.php">inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $url;?>/admin/seccion/productos.php">Libros</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $url;?>/admin/seccion/cerrar.php">cerrar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="<?php echo $url;?>">ir al sitio web</a>
            </li>
        </ul>
  </nav>
    <br>

    <!-- contenedor -->
 <div class="container">
   <div class="row">
