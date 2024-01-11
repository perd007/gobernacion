<?php require_once('Connections/BD.php'); ?>
<?
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
$cedula=$_GET["empleado"];

$sql="delete from familiar where id_familiares='$id'";
$verificar=mysql_query($sql,$BD) or die(mysql_error());


if($verificar){
	echo"<script type=\"text/javascript\">alert ('Familiar Eliminado'); location.href='consulta_familiar_2.php?cedula=$cedula' </script>";
}
else{
	echo"<script type=\"text/javascript\">alert ('Error'); location.href='consulta_familiar_2.php?cedula=$cedula' </script>";
	
}
?>