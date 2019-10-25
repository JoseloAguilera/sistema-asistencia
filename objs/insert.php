<?php
require '../server/conn.php';
  //Validar si existe un post

if(isset($_POST['accion'])){
switch ($_POST['accion']){
      //VALIDAR EXISTENCIA DE UN POST// SI EXISTE VALIDAR CAMPOS
      case ('guardar' ):
      /*== 'guardar'
        && $_POST['nombre'] != ''
        && $_POST['apellido'] != ''
        && $_POST['cedula'] != ''
        && $_POST['telefono'] != ''*/
      //INICIAMOS LA TRANSACCION
          /*$datedmy= $_POST['fecha_nac'];
          $dateymd= date("Y/m/d", strtotime($datedmy));*/
          $sql = 'INSERT INTO alumnos(nombre, apellido, cedula, telefono, fecha_nac, email, ruc, razon_social, ciudad, direccion,
            nombre_ref, telefono_ref, estado, password, foto,  fecha_add ) VALUES (:nombre, :apellido, :cedula, :telefono, :fecha_nac, :email, :ruc,
            :razonsocial, :ciudad, :direccion, :nombreref, :telefonoref, :estado, :password, :foto,  NOW() )';
          $data = array(
              'nombre' => $_POST['nombre'],
              'apellido' => $_POST['apellido'],
              'cedula' => $_POST['cedula'],
              'telefono' => $_POST['telefono'],
              'fecha_nac' => $_POST['nascimiento'],
              'email' => $_POST['email'],
              'direccion' => $_POST['direcion'],
              'ciudad' => $_POST['ciudad'],
              'ruc' => $_POST['ruc'],
              'razonsocial' => $_POST['razonsocial'],
              'nombreref' => $_POST['nombreref'],
              'telefonoref' => $_POST['telefonoref'],
              'password' => $_POST['contrasena'],
              'estado' => $_POST['estado'],
              'foto' => $_POST['foto']
          );
         $query = $connection->prepare($sql);
          try {
              $query->execute($data);
              $mensaje= "<p class="alert alert-success">Registro guardado correctamente :)</p>";
            echo '<script> window.location = "../alumno.php"; </script>';
          } catch (PDOException $e) {
              //print_r($e);
               //$connection->rollback();
              $mensaje= '<p class="alert alert-danger">'. $e .'</p>';
          }
          break;
      case('actualizar'):
                    if($_POST['codigo'] > 0){
                         $sql = 'UPDATE alumnos set nombre=:nombre, apellido=:apellido, cedula=:cedula, telefono=:telefono, fecha_nac=:fecha_nac, email=:email,
                         ruc=:ruc, razon_social=:razonsocial, ciudad=:ciudad, dirección=:direccion, nombre_ref=:nombreref, telefono_ref=:telefonoref,
                         estado=:estado, password=:password, fecha_update=NOW() WHERE id = ' . $_POST['codigo'];
                         //$datedmy= $_POST['fecha_nac'];
                         //$dateymd= date("Y/m/d", strtotime($datedmy));
                         $data = array(
                             'nombre' => $_POST['nombre'],
                             'apellido' => $_POST['apellido'],
                             'cedula' => $_POST['cedula'],
                             'telefono' => $_POST['telefono'],
                             'fecha_nac' => $_POST['nascimiento'],
                             'email' => $_POST['email'],
                             'direccion' => $_POST['direcion'],
                             'ciudad' => $_POST['ciudad'],
                             'ruc' => $_POST['ruc'],
                             'razonsocial' => $_POST['razonsocial'],
                             'nombreref' => $_POST['nombreref'],
                             'telefonoref' => $_POST['telefonoref'],
                             'password' => $_POST['contrasena'],
                             'estado' => $_POST['estado'],
                             'foto' => $_POST['foto']
                         );
                         $query2 = $connection->prepare($sql);
                        try{
                          $query2->execute($data);
                      //  $id = $_GET['id'];
                        //include 'includes/mensaje.php';
                        //$mensaje = '<p class="alert alert-success">Registro actualizado correctamente :)</p>';
                         echo '<script> window.location="../alumno.php"; </script>';
                          }catch(Exception $e){
                             echo '<p class="alert alert-danger">'. $e .'</p>';
                       }
                       }
                      break;
}
}


?>
