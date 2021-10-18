<?php
session_start();
if ($_POST) {
  if(($_POST['usuario']=='Alexbook')&&($_POST['contraseña']=='sistema')){
        
      $_SESSION['usuario']='ok';
      $_SESSION['nombreUsuario']='Alexbook'; 
      header('location:inicio.php');
  }else{
      $mensaje='el usuario o contraseña son incorretos';
    }
  
}
?>
<!doctype html>
<html lang="en">
<head>
  <title>Alexbook</title>
    <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS v5.0.2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <br>
  <br>
  <br>
<div class="container ">
  <div class="row ">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
      <div class="card ">
         <div class="card-header">
          <h2 class="text-center text-uppercase">login</h2>
         </div>
         <div class="card-body">
          <?php if(isset ($mensaje)) { ?>
          <div class="alert alert-danger" role="alert">
              <?php echo $mensaje;?>
          </div>
          <?php } ?> 
          <form method="POST">
            <div class = "form-group">
              <label class="text-capitalize" >Usuario:</label><br>
              <input type="txt" class="form-control" name="usuario"  placeholder="ingrese su usuario">
            </div>
              <br>
            <div class="form-group">
              <label class="text-capitalize " >contraseña:</label>
              <input type="password" class="form-control" name="contraseña" placeholder="ingrese su contraseña">
            </div>   
              <br>
            <button type="submit" class="btn btn-primary text-uppercase">Entrar al Administrador</button>
          </form>
      </div>
    </div>
    </div>
  </div>
</div>
</body>
</html>