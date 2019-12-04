<?php
  //include 'includes/head.php';
require_once __DIR__ . '/vendor/autoload.php';
require 'server/conn.php';

//var_dump($_GET["id"]);
if (isset($_GET["id"])) {


  $sql = "SELECT matricula.*, alumnos.*, cursos.nombre AS curso, cursos.duracion_meses AS duracion, grupos.descripcion AS grupo, grupos.id AS grupo_codigo FROM `matricula` INNER JOIN alumnos ON `id_alumnos` = alumnos.id INNER JOIN grupos ON grupo_id = grupos.id INNER JOIN cursos ON grupos.cursos_id = cursos.id WHERE
  matricula.id=".$_GET["id"];
  $query = $connection->prepare($sql);
  $query->execute();
  $result= $query->fetchAll();
$codigo='';
  foreach ($result as $value) {
    $fechainicio = substr($value['fecha_inicio'], 8,2)."/".substr($value['fecha_inicio'], 5,2)."/".substr($value['fecha_inicio'], 0,4);
    $valmatricula = number_format($value['valor_matricula'], 0, ",", ".");
    $valcuota = number_format($value['valor_cuota'], 0, ",", ".");

    $codigo='
    <header class="clearfix">
      <div id="logo">
        <img src="img/logo.png" width="180px" height="70.4px">
      </div>
      <h1>FICHA DE INSCRIPCIÓN</h1>
      </header>
    <main>
      <table>
        <thead>
        </thead>
        <tbody>
          <tr>
            <td class="desc"><b>Nombre: </b>'.$value["nombre"].'</td>
            <td class="desc"><b>Apellido: </b>'.$value["apellido"].'</td>
          </tr>
          <tr>
            <td class="desc"><b>Cédula N°: </b>'.$value["cedula"].'</td>
            <td class="desc"><b>Fecha de Nacimiento: </b>'.$value["fecha_nac"].'</td>
          </tr>
          <tr>
            <td class="desc"><b>Telefono: </b>'.$value["telefono_alumno"].'</td>
            <td class="desc"><b>Correo: </b>'.$value["email"].'</td>
          </tr>
          <tr>
            <td class="desc"><b>Dirección: </b>'.$value["direccion"].'</td>
            <td class="desc"><b>Ciudad: </b>'.$value["ciudad"].'</td>
          </tr>
          <tr>
            <td class="desc"><b>Ruc: </b>'.$value["ruc"].'</td>
            <td class="desc"><b>Razón social: </b>'.$value["razon_social"].'</td>
          </tr>
          <tr>
            <td class="desc"><b>Referencia: </b>'.$value["nombre_ref"].'</td>
            <td class="desc"><b>Teléfono: </b>'.$value["telefono_ref"].'</td>
          </tr>
          <tr>
            <td class="desc"><b>Nombre Madre: </b>'.$value["mama"].'</td>
            <td class="desc"><b>Teléfono: </b>'.$value["telefono_mama"].'</td>
          </tr>
          <tr>
            <td class="desc"><b>Nombre Padre: </b>'.$value["papa"].'</td>
            <td class="desc"><b>Teléfono: </b>'.$value["telefono_papa"].'</td>
          </tr>
        </tbody>
      </table>

      <h1>Matrícula</h1>
      <table>
        <thead>
        </thead>
        <tbody>
          <tr>
            <td class="desc"><b>Curso: </b>'.$value["curso"].'</td>
            <td class="desc"><b>Duración: </b>'.$value["duracion"].' meses</td>
          </tr>
          <tr>
            <td class="desc"><b>Fecha de Inicio: </b>'.$fechainicio.'</td>
          </tr>
          <tr>
            <td class="desc"><b>Matricula: </b>'.$value['valor_matricula'].' gs.</td>
            <td class="desc"><b>Cuota: </b>'.$value['valor_cuota'].' gs.</td>
          </tr>
        </tbody>
      </table>
      <h5>Horario de Clases</h5>
      <table>
        <tbody>';
        $sql2 = "SELECT * FROM horarios  WHERE grupos_id =".$value['grupo_codigo'];
        $query2 = $connection->prepare($sql2);
        $query2->execute();
        $result2= $query2->fetchAll();
        //var_dump($result2);
        foreach ($result2 as $value2) {
          $horainicio = substr($value2['hora_inicio'], 0,5);
          $horafin = substr($value2['hora_fin'], 0,5);
          $codigo=$codigo.'
            <tr>
            <td class="desc"><b>Dia: </b>'.$value2['dia'].'</td>
            <td class="desc"><b>Hora: </b>'.$horainicio.' - '.$horafin.'</td>
            </tr>';
        }
        $codigo=$codigo.'
        </tbody>
      </table>
      <table>
        <tbody>
          <tr class="grand total">
            <td class="grand total">_____________________<br> <br>Alumno</td>
            <td class="grand total">_____________________<br> <br>Asesor</td>
            <td class="grand total">_____________________<br> <br>Director</td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div>Obs:</div>
        <div class="notice">__________________________________________________________________________</div>
      </div>
    </main>';

  }

$stylesheet =file_get_contents('css/pdf.css');
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($codigo,2);
//$mpdf->WriteHTML('<h1>José</h1>');
$mpdf->Output();
}
else {
  echo "Error, contacte al administrador de Sistema";

}

?>
