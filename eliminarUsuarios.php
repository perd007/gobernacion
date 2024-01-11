<?php require_once('Connections/BD.php'); ?>
<?
include("login.php");
?>
<?php
if($validacion==true){
	if($Admi==0){
	echo "<script type=\"text/javascript\">alert ('Usted no posee permisos Administrativos'); location.href='fondo.php' </script>";
 exit;
	}
}
else{
echo "<script type=\"text/javascript\">alert ('Error usuario invalido'); location.href='fondo.php' </script>";
 exit;
 }

//recibimos la id
$id=$_GET["id"];
mysql_select_db($database_BD, $BD);
$sql2="select * from usuario where idUsuario='$id'";
$verificar2=mysql_query($sql2,$BD) or die(mysql_error());
$row_verificar2=mysql_fetch_assoc($verificar2);

$sql="delete from usuario where idUsuario='$id'";
$verificar=mysql_query($sql,$BD) or die(mysql_error());

if($verificar){
	  if($_COOKIE["usr"]==$row_verificar2['usuario']){
 echo "<script type=\"text/javascript\">alert ('INICIE SESION NUEVAMENTE');  location.href='cerrarSesion.php' </script>";

 } else{
	echo"<script type=\"text/javascript\">alert ('usuario Eliminado'); location.href='consultaUsuarios.php' </script>";
}}
else{
	echo"<script type=\"text/javascript\">alert ('Error'); location.href='consultaUsuarios.php' </script>";
	
}//fin de l primer else


?>