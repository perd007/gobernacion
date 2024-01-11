<?php require_once('Connections/BD.php'); ?>
<?php
include("login.php");
?>
<?php

 
//validar usuario

if($validacion==true){
	if($eli==0){
	echo "<script type=\"text/javascript\">alert ('Usted no posee permisos para realizar Eliminaciones'); location.href='fondo.php' </script>";
    exit;
	}
}
else{
echo "<script type=\"text/javascript\">alert ('Error usuario invalido');  location.href='fondo.php'  </script>";
 exit;
}

$id=$_GET["id"];
$cedula=$_GET["cedula"];


mysql_select_db($database_BD, $BD);
$query_solictud = "SELECT * FROM solicitud where id_solicitud='$id'";
$solictud = mysql_query($query_solictud, $BD) or die(mysql_error());
$row_solictud = mysql_fetch_assoc($solictud);
$totalRows_solictud = mysql_num_rows($solictud);


if($row_solictud["estado"]==0){

	
	$sql="delete from  solicitud where id_solicitud='$id' and estado=0";
	$verificar=mysql_query($sql,$BD) or die(mysql_error());
	
	$sql2="delete from documentos where solicitud='$id'";
	$verificar2=mysql_query($sql2,$BD) or die(mysql_error());

	if($verificar==true and $verificar2==true){
		echo"<script type=\"text/javascript\">alert ('Datos Eliminado'); 	location.href='consultar_solicitud.php?cedula=$cedula' </script>";
	}
	else{
		echo"<script type=\"text/javascript\">alert ('Error'); location.href='consultar_solicitud.php?cedula=$cedula' </script>";
	}
}//fin del if

if($row_solictud["estado"]==1){
echo"<script type=\"text/javascript\">alert ('No se puede Eliminar una solicitud procesada'); location.href='consultar_solicitud.php?cedula=$cedula' </script>";
}



?>