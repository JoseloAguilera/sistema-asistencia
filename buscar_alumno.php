<?php	if (isset($_GET['id']) && $_GET['id'] > 0) {
	     $sql= "SELECT * FROM alumnos WHERE id =". $_GET['id'];
	     $query = $connection->prepare($sql);
	     $query->execute();
	     $total= $query->rowCount();
}
   ?>
