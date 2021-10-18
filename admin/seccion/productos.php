<?php
include('../template/cabecera.php');
?>
<?php
// validamos por el method post usamos el name de l input antes usamos print_r()para ver si funcionaba
$txtID =(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre =(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen =(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$txtPdf=(isset($_POST['txtPdf']['name']))?['txtPdf']['name']:"";
$accion =(isset($_POST['accion']))?$_POST['accion']:"";
// carga de archivos pdf , documentos.


// $nombrePdf= $_FILES['archivo']['name'];
// $tipoPdf= $_FILES['archivo']['type'];
// $tamañoPdf= $_FILES['archivo']['size'];
// $rutaPdf= $_FILES['archivo']['tmp_name'];
// $destino =  'archivos/'.$nombrePdf;


include('../config/bd.php');

switch ($accion) {
    case 'agregar':
        // INSERT INTO `libros` (`id`, `nombre`, `imagen`) VALUES (NULL, 'libro de sql', 'imagen.jpg'); y cambiamos :nombre esos son parametros quie vamos a usar 
        $sentenciaSQL=$conexion->prepare("INSERT INTO libros ( nombre , imagen) VALUES (:nombre,:imagen);");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        // instruccion de subida usamos datetime;con../../img/ primero salimos de la carpeta seccion
        //  y despues salidmos de admin y luego enter img
        $fecha= new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        if ($tmpImagen!=""){
             move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        }   

    
        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->execute();
        header("location:productos.php");
        break;

    case "modificar":
        // echo "presionado boton Modificar";// second codigo
        $sentenciaSQL=$conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        
        if($txtImagen!=""){
            $fecha= new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
                $sentenciaSQL=$conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
                $sentenciaSQL->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
                $Book=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($Book['imagen']) &&($Book['imagen']!="imagen.jpg")){
                        if (file_exists("../../img/".$Book['imagen'])){
                            unlink("../../img/".$Book['imagen']);
                        } 
                    }
                        $sentenciaSQL=$conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
                        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
                        $sentenciaSQL->bindParam(':id',$txtID);
                        $sentenciaSQL->execute();     // primero codigo
        }
         header("location:productos.php");
       break;   
       
    case "cancelar":
        header("location:productos.php");
       break;       
    
    case "Seleccionar":
        // echo "presionado boton seleccionar"; book-libro
        $sentenciaSQL=$conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
            $Book=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $txtNombre= $Book['nombre'];
            $txtImagen= $Book['imagen'];
       break;       
    
    case "Borrar":
        // este codigo sirve para boorar la imagen en la carepta 
        $sentenciaSQL=$conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $Book=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($Book['imagen']) &&($Book['imagen']!="imagen.jpg")){
                if (file_exists("../../img/".$Book['imagen'])){
                    unlink("../../img/".$Book['imagen']);
                } 
            }

            $sentenciaSQL=$conexion->prepare("DELETE FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            header("location:productos.php");
        break;       
    
    default:
        # code...
        break;
}

$sentenciaSQL=$conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="col-md-5">
    
    <div class="card">
        <div class="card-header">
            Datos del Libro
        </div>
        <div class="card-body">
          <form method="POST"  enctype="multipart/form-data">
            <div class = "form-group">
                <label for="txtID">ID</label>
                <input type="txt" required readonly class="form-control"  value="<?php echo $txtID;?>" name="txtID" id="txtID"  placeholder="Enter ID">
                </div>

            <div class = "form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="txt" required class="form-control" value="<?php echo $txtNombre;?>" name="txtNombre" id="txtNombre"  placeholder="nombre">
            </div>

            <div class = "form-group">
                <label for="txtImagen">Imagen:</label>
                <br/>
                <?php if ($txtImagen!=""){ ?>
                    <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen; ?>"  width="100" alt="" srcset="">
                <?php }?>
                <input type="file"  class="form-control"name="txtImagen" id="txtImagen"   placeholder="imagen">
            </div>

            <div class="btn-group" role="group" aria-label="">
                <button type="submit" name="accion"<?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="agregar" class="btn btn-success">Agregar</button>
                <button type="submit" name="accion"  <?php echo($accion!="Seleccionar")?"disabled":"";?> value="modificar" class="btn btn-warning">Modificar</button>
                <button type="submit"name="accion" <?php echo($accion!="Seleccionar")?"disabled":"";?> value="cancelar" class="btn btn-info">Cancelar</button>
            </div>
          </form>
        </div>
    </div>
</div>

<div class="col-md-7">
  <!-- tabla de libros(mostrar los datos de los libros) -->
  <table class="table table-border  table-hover">
      <thead class="table-dark">
          <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Imagen</th>
              <th>Acciones</th>
          </tr>
      </thead>
      <tbody>
          <!-- todo eso tiene que coincidir con la base de datos insertada -->
          <?php foreach ($listaLibros as $libro ){ ?>
            <tr>
                <td> <?php echo $libro['id']; ?></td>
                <td> <?php echo $libro['nombre']; ?></td>
                <td> 
                    <img src="../../img/<?php echo $libro['imagen']; ?>" width="50"  alt="" srcset="">
                
                </td>
                <td>
                    <form  method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>">

                        <input type="submit"  name="accion" value="Seleccionar" class="btn btn-primary"/>

                        <input type="submit"  name="accion" value="Borrar" class="btn btn-danger"/>
                    </form>
                </td>
            </tr>
          <?php } ?>
      </tbody>
  </table>
</div>

<?php
include('../template/pie.php');
?>