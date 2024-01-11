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
?>
<?php 
//validar usuario
if($validacion==true){
	if($Admi==0){
	echo "<script type=\"text/javascript\">alert ('Usted no posee permisos para modificar Usuarios Registros');location.href='fondo.php' </script>";
    exit;
	}
}
else{
echo "<script type=\"text/javascript\">alert ('Error usuario invalido'); location.href='principal.php' </script>";
 exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

$m=$_POST["modificar"];
$c=$_POST["consultar"];
$e=$_POST["eliminar"];
$r=$_POST["registrar"];
$a=$_POST["administrar"];

//validar permisos
if($m!=""){
$m=1;
}
else{
$m=0;
}
//
if($c!=""){
$c=1;
}
else{
$c=0;
}
//
if($e!=""){
$e=1;
}
else{
$e=0;
}
//
if($r!=""){
$r=1;
}
else{
$r=0;
}
//
if($a!=""){
$a=1;
}
else{
$a=0;
}
//chequear usuario

mysql_select_db($database_BD, $BD);
$sqlV="select usuario from usuario where usuario='$_POST[login]' and idUsuario!='$_POST[id_seg]'";
$resultadoV=mysql_query($sqlV, $BD) or die(mysql_error());
$verificar=mysql_fetch_assoc($resultadoV);


if($verificar["usuario"]==$_POST['login']){
echo "<script type=\"text/javascript\">alert ('Usuario ya Registrado'); location.href='consultaUsuarios.php' </script>";
 exit;

}



  $updateSQL = sprintf("UPDATE usuario SET usuario=%s, clave=%s, modificar=%s, consultar=%s, registrar=%s, eliminar=%s, nombre=%s, apellido=%s, cedula=%s, administrar=%s WHERE idUsuario=%s",
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['clave'], "text"),
                       GetSQLValueString($m, "int"),
                       GetSQLValueString($c, "int"),
                       GetSQLValueString($r, "int"),
                       GetSQLValueString($e, "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['cedula'], "int"),
                       GetSQLValueString($a, "int"),
                       GetSQLValueString($_POST['id_seg'], "int"));

  mysql_select_db($database_BD, $BD);
  $Result1 = mysql_query($updateSQL, $BD) or die(mysql_error());
  if($Result1){
	  if($_COOKIE["usr"]==$_POST["usua"]){
 echo "<script type=\"text/javascript\">alert ('INICIE SESION NUEVAMENTE');  location.href='cerrarSesion.php' </script>";		
 }else{
  echo "<script type=\"text/javascript\">alert ('Datos Guardados');  location.href='consultaUsuarios.php' </script>";
 }
 }else{
  echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='consultaUsuarios.php' </script>";
  exit;
  }
}

//recibimos codigo
$cod=$_GET["cod"];
mysql_select_db($database_BD, $BD);
$query_usuarios = "SELECT * FROM usuario where idUsuario='$cod'";
$usuarios = mysql_query($query_usuarios, $BD) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
</head>

<script language="javascript">
<!--
function validar(){

if(document.form1.cedula.value!=""){
			 var filtro = /^(\d)+$/i;
		      if (!filtro.test(document.getElementById('cedula').value)){
				alert('Solo puede ingresar numeros en la cedula de alumno!!!');
				return false;
		   		}
				}

		   if(document.form1.login.value==""){
		   alert("DEBE INGRESAR UN LOGIN");
		   return false;
		   }
		    if(document.form1.clave.value==""){
		   alert("DEBE INGRESAR UNA CLAVE");
		   return false;
		   }
		   if(document.form1.cedula.value==""){
		   alert("DEBE INGRESAR LA CEDULA");
		   return false;
		   }
		   if(document.form1.nombre.value==""){
		   alert("DEBE INGRESAR EL NOMBRE DEL USUARIO");
		   return false;
		   }
		   if(document.form1.apellido.value==""){
		   alert("DEBE INGRESAR EL APELLIDO DEL USUARIO");
		   return false;
		   }
		  
		 	  if(document.form1.modificaciones.checked==false) { 
			 	
			  		if(document.form1.eliminaciones.checked==false){
						
			 				if(document.form1.consultas.checked==false){ 
							
								if(document.form1.registros.checked==false){ 
			 					
		   						alert("DEBE INGRESAR ALGUN PERMISO PARA ESTE USUARIO");
		   						return false;
									}
								}
							
						}
					
				
			}
   }
   
//-->
</script>

<body>
<form method="post" name="form1" onSubmit="return validar()" action="<?php echo $editFormAction; ?>">
  <p>&nbsp;</p>
  <table align="center">
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap bgcolor="#a4e237"><div align="center" class="Estilo1">MODIFICAR USUARIOS </div></td>
    </tr>
    <tr valign="baseline">
      <td width="132" align="right" nowrap>Usuario:</td>
      <td width="358"><input name="login" type="text" id="login" value="<?php echo $row_usuarios['usuario']; ?>" size="32" maxlength="10"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Clave:</td>
      <td><input name="clave" type="text" value="<?php echo $row_usuarios['clave']; ?>" size="32" maxlength="10"></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap align="right">Nombre:</td>
      <td><input name="nombre" type="text" value="<?php echo $row_usuarios['nombre']; ?>" size="32" maxlength="20"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Apellido:</td>
      <td><input name="apellido" type="text" value="<?php echo $row_usuarios['apellido']; ?>" size="32" maxlength="20"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Cedula:</td>
      <td><input name="cedula" type="text" value="<?php echo $row_usuarios['cedula']; ?>" size="32" maxlength="9"></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap bgcolor="#a4e237"><div align="center">Permisos</div></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap>
	 <?php $seleccion="checked='checked'"; ?>
	  <input name="modificar" type="checkbox"  <?php if($row_usuarios['modificar']==1) echo $seleccion; ?> id="modificar" value="modificaciones" />
Modificaciones

  <input name="registrar" type="checkbox" <?php if($row_usuarios['registrar']==1) echo $seleccion; ?> id="registrar" value="registros" />
Registros

<input name="eliminar" type="checkbox" <?php if($row_usuarios['eliminar']==1) echo $seleccion; ?> id="eliminar" value="eliminaciones" />
Eliminaciones

<input name="consultar" type="checkbox" <?php if($row_usuarios['consultar']==1) echo $seleccion; ?> id="consultar" value="consultas" />
Consultas
<input name="administrar" type="checkbox" <?php if($row_usuarios['administrar']==1) echo $seleccion; ?> id="administrar" value="administar" />
Administar </td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap bgcolor="#a4e237"><div align="center">
        <input type="submit" value="Modificar Datos">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_seg" value="<?php echo $row_usuarios['idUsuario']; ?>">
   <input type="hidden" name="cod" value="<?php echo $cod; ?>" />
    <input type="hidden" name="usua" value="<?php echo $row_usuarios['usuario']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($usuarios);
?>
