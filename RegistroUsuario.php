<?php require_once('Connections/BD.php'); ?>
<?
include("login.php");
?>
<?php 
//validar usuario
if($validacion==true){
	if($Admi==0){
	echo "<script type=\"text/javascript\">alert ('Usted no posee permisos para registrar usuarios Registros');location.href='fondo.php' </script>";
    exit;
	}
}
else{
echo "<script type=\"text/javascript\">alert ('Error usuario invalido'); location.href='fondo.php' </script>";
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {



$m=$_POST["modificaciones"];
$c=$_POST["consultas"];
$e=$_POST["eliminaciones"];
$r=$_POST["registros"];
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
$sql="select usuario from usuario where usuario='$_POST[login]'";
$resultado=mysql_query($sql, $BD) or die(mysql_error());
$verificar=mysql_fetch_assoc($resultado);



if($verificar["usuario"]==$_POST['login']){
echo "<script type=\"text/javascript\">alert ('Usuario ya Registrado'); location.href='fondo.php' </script>";
 exit;

}



  $insertSQL = sprintf("INSERT INTO usuario ( usuario, clave, modificar, consultar, registrar, eliminar, administrar, nombre, apellido, cedula) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['login'], "text"),
                       GetSQLValueString($_POST['clave'], "text"),
                       GetSQLValueString($m, "int"),
                       GetSQLValueString($c, "int"),
                       GetSQLValueString($r, "int"),
                       GetSQLValueString($e, "int"),
					   GetSQLValueString($a, "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['cedula'], "int"));

 mysql_select_db($database_BD, $BD);
  $Result1 = mysql_query($insertSQL, $BD) or die(mysql_error());
   if($Result1){
  echo "<script type=\"text/javascript\">alert ('Datos Guardados');  location.href='fondo.php' </script>";
  }else{
  echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='fondo.php' </script>";
  exit;
  }
}


?><html>
<head>

<title>Registro Usuarios</title>

<style type="text/css">
<!--
.Estilo3 {
	color: #000000;
	font-weight: bold;
}
-->
</style>
</head>
<script language="javascript">
<!--
function validar(){

if(document.form1.cedula.value!=""){
			 var filtro = /^(\d)+$/i;
		      if (!filtro.test(document.getElementById('cedula').value)){
				alert('Solo puede ingresar numeros en la cedula del usuario!!!');
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
<form id="form1" name="form1" method="post" onSubmit="return validar()"  action="<?php echo $editFormAction; ?>">
  <p>&nbsp;</p>
  <table width="577" border="0" align="center" cellspacing="0">
    <tr bgcolor="#00CCFF" >
      <td colspan="2" bgcolor="#a4e237" scope="row"><div align="center" class="Estilo3">REGISTRO USARIOS </div></td>
    </tr>
    <tr bgcolor="#00CCFF" >
      <td width="219" bgcolor="#FFFFFF" scope="row"><div align="right">Login</div></td>
      <td width="354" bgcolor="#FFFFFF"><label>
        <input name="login" type="text"  id="login" maxlength="10" />
      </label></td>
    </tr>
    <tr>
      <td scope="row"><div align="right">Clave</div></td>
      <td><input name="clave" type="text"  id="clave" maxlength="10" /></td>
    </tr>
    <tr>
      <td scope="row"><div align="right">Nombre del Usuario: </div></td>
      <td><label>
        <input name="nombre" type="text"  id="nombre" maxlength="20" />
      </label></td>
    </tr>
    <tr>
      <td scope="row"><div align="right">Apellido del Usuario:</div></td>
      <td><input name="apellido" type="text"  id="apellido" maxlength="20" /></td>
    </tr>
    <tr>
      <td scope="row"><div align="right">Cedula del Usuario:</div></td>
      <td><input name="cedula" type="text"  id="cedula" maxlength="9" /></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#a4e237" scope="row"><div align="right">
        <div align="center" class="Estilo3">Permisos</div>
      </div></td>
    </tr>
    <tr >
      <td colspan="2"  scope="row"><label>
        <input type="checkbox" name="modificaciones" value="modificaciones" />
         Modificaciones
          <input type="checkbox" name="registros" value="registros" />
          Registros
          <input type="checkbox" name="eliminaciones" value="eliminaciones" />
          Eliminaciones
          <input type="checkbox" name="consultas" value="consultas" />
      Consultas 
      <input name="administrar" type="checkbox" id="administrar" value="administar" /> 
      Administar
</label></td>
    </tr>
    <tr>
      <th colspan="2" bgcolor="#a4e237" scope="row"><label>
        <input name="Submit" type="submit" value="Guardar" />
      </label></th>
    </tr>
  </table>
  <p>&nbsp;  </p>
   <p>
     <input type="hidden" name="MM_insert" value="form1" />
	 
  </p>
</form>

<p>&nbsp;</p>
</body>
</html>
