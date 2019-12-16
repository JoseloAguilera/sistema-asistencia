<html>
<head>
    <title>Subir Imagen</title>
</head>
<body>
<?php if ((isset($_POST["enviar"])) && ($_POST["enviar"] == "frmImagen")) {
    // recoge los valores enviados por GET
    $name = $_GET['name'];
    $input = $_GET['input'];
    $carpeta = $_GET['carpeta'];
    $evento = $_GET['evento'];
    // obtener extencion de la imagen
    $extension = substr(strrchr($_FILES['userfile']['name'], "."), 1);
    // random 5 digitos
    $random = strtotime("now");
    // renombra la imagen
    $nuevo_nombre = $input . '_' . $random . '.' . $extension;
    // directorio
    $directorio = "img/". $carpeta ."/";
    // guarda el archivo en el directorio
    move_uploaded_file($_FILES["userfile"]["tmp_name"], $directorio . $nuevo_nombre);
    //var_dump($input);
    if ($evento=='add') {
      ?>
    <script>
        opener.document.form1.<?php echo $input ?>.value="<?php echo $nuevo_nombre; ?>";
        self.close();
    </script>
<?php
  }
  elseif ($evento=='alt') {
?>
    <script>
        opener.document.form.<?php echo $input ?>.value="<?php echo $nuevo_nombre; ?>";
        self.close();
    </script>

<?php
  }

} else { ?>
    <form  method="post" enctype="multipart/form-data" id="frmImagen">
        <p> <input name="userfile" type="file" /> </p>
        <p> <input type="submit" name="button" id="button" value="Subir Imagen" /></p>
        <input type="hidden" name="enviar" value="frmImagen" />
    </form>
<?php
} ?>
</body>
</html>
