<?php require_once('Connections/BD.php'); ?>
<?
include("login.php");
?>
<?php 
//validar usuario

if($validacion==true){
	if($reg==0){
	echo "<script type=\"text/javascript\">alert ('Usted no posee permisos para realizar Registros');location.href='fondo.php' </script>";
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
	
	
mysql_select_db($database_BD, $BD);
$query_validar = "SELECT * FROM empleado where cedula='$_POST[cedula]'";
$validar = mysql_query($query_validar, $BD) or die(mysql_error());
$row_validar = mysql_fetch_assoc($validar);
$totalRows_validar = mysql_num_rows($validar);

if($totalRows_validar>0){
	echo "<script type=\"text/javascript\">alert ('Ya otro Empleado Posee esta cedula');  location.href='registro_empleado.php' </script>";
	exit;
}
		
		
  $insertSQL = sprintf("INSERT INTO empleado (nombres, cedula, nomina, cargo, departamento, fecha_ingreso, salario, telefono, direccion, observaciones) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombres'], "text"),
                       GetSQLValueString($_POST['cedula'], "int"),
                       GetSQLValueString($_POST['nomina'], "text"),
                       GetSQLValueString($_POST['cargo'], "text"),
                       GetSQLValueString($_POST['departamento'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "date"),
					   GetSQLValueString($_POST['salario'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['direccion'], "text"),
                       GetSQLValueString($_POST['observaciones'], "text"));

  mysql_select_db($database_BD, $BD);
  $Result1 = mysql_query($insertSQL, $BD) or die(mysql_error());
  if($Result1){
  echo "<script type=\"text/javascript\">alert ('Datos Guardados');  location.href='fondo.php' </script>";
  }else{
  echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='fondo.php' </script>";
  exit;
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
 @import url("jscalendar-1.0/calendar-win2k-cold-1.css");
</style>

</head>
<script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
<script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>
<script language="javascript">

function validar(){

		
	if(document.form1.cedula.value!=""){
			 var filtro = /^(\d)+$/i;
		      if (!filtro.test(document.getElementById('cedula').value)){
				alert('SOLO PUEDE INGRESAR NUMEROS EN LA CEDULA DEL EMPLEADO');
				return false;
		   		}
				}
				
				if(document.form1.telefono.value!=""){
			 var filtro = /^(\d)+$/i;
		      if (!filtro.test(document.getElementById('telefono').value)){
				alert('SOLO PUEDE INGRESAR NUMEROS EN TELEFONO DEL EMPLEADO');
				return false;
		   		}
				}
			
				if(document.form1.nombres.value==""){
						alert("Ingrese el nombre y el apellido del empleado");
						return false;
				}
				
				if(document.form1.cedula.value==""){
						alert("Ingrese la cedula del empleado");
						return false;
				}
				
				
				if(document.form1.cargo.value==""){
						alert("Ingrese el cargo del empleado");
						return false;
				}
				if(document.form1.fecha_ingreso.value==""){
						alert("Ingrese la fecha de ingreso del empleado");
						return false;
				}
				if(document.form1.telefono.value==""){
						alert("Ingrese el telefono del empleado");
						return false;
				}
				
				if(document.form1.direccion.value==""){
						alert("Ingrese la direccion del empleado");
						return false;
				}
				if(document.form1.salario.value==""){
						alert("Ingrese el Salario del Empleado");
						return false;
				}
		
				
				

				
				
		}
</script>
<body >
<form action="<?php echo $editFormAction; ?>" onsubmit="return validar()" method="post" name="form1" id="form1">
  <table align="center" class="bordes">
    <tr valign="baseline">
      <td colspan="2" align="center" bgcolor="#a4e237" class="negrita">Ingreso de Empleados</td>
    </tr>
    <tr valign="baseline">
      <td width="162" align="right" nowrap="nowrap">Nombres y Apellidos:</td>
      <td width="314"><input name="nombres" type="text" value="" size="50" maxlength="50" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cedula:</td>
      <td><input name="cedula" id="cedula" type="text" value="" size="15" maxlength="8" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nomina:</td>
      <td><label for="nomina"></label>
        <select name="nomina" id="nomina">
          <option value="Empleado Fijo">Empleado Fijo</option>
          <option value="Empleado Contratado">Empleado Contratado</option>
          <option value="Obrero DIE">Obrero DIE</option>
          <option value="Obrero Educacion">Obrero Educacion</option>
          <option value="Obrero Salud">Obrero Salud</option>
          <option value="Jubilados Educacion">Jubilados Educacion</option>
          <option value="Jubilados Gobernacion">Jubilados Gobernacion</option>
          <option value="Pensionados Educacion">Pensionados Educacion</option>
          <option value="Pensionados Gobernacion">Pensionados Gobernacion</option>
          <option value="Personal de Confianza">Personal de Confianza</option>
          <option value="Policias">Policias</option>
          <option value="Bomberos">Bomberos</option>
          <option value="Obreros Contratados Gobernacion">Obreros Contratados Gobernacion</option>
          <option value="Contratados de Educacion">Contratados de Educacion</option>
          <option value="Beca Salario">Beca Salario</option>
          <option value="Docente Interino">Docente Interino</option>
          <option value="Docente Ordinario">Docente Ordinario</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cargo:</td>
      <td><input name="cargo" type="text" id="cargo" value="" size="32" maxlength="20" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Departamento:</td>
      <td><label for="departamento"></label>
        <select name="departamento" id="departamento" >
          <option value="Informatica">Informatica</option>
          <option value="Recursos Humanos">Recursos Humanos</option>
          <option value="Tesoreria">Tesoreria</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fecha de Ingreso:</td>
      <td><input name="fecha_ingreso" type="text" id="fecha_ingreso" value="" size="20" maxlength="10" readonly="readonly" />
        <button type="submit" id="cal-button-1" title="Clic Para Escoger la fecha">Fecha</button>
      <script type="text/javascript">
							Calendar.setup({
							  inputField    : "fecha_ingreso",
							  ifFormat   : "%Y-%m-%d",
							  button        : "cal-button-1",
							  align         : "Tr"
							});
						  </script></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Salario semanal:</td>
      <td><label>
        <input name="salario" type="text" id="salario" maxlength="10" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefono:</td>
      <td><input name="telefono" id="telefono" type="text" value="" size="20" maxlength="11" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" valign="middle" align="right">Direccion:</td>
      <td><textarea name="direccion" cols="50" rows="5" onKeyDown="if(this.value.length &gt;= 300){ alert('Has superado el numero de caracteres permitido de este campo'); return false; }"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="middle">Observaciones:</td>
      <td><textarea name="observaciones" cols="50" rows="5" onKeyDown="if(this.value.length &gt;= 300){ alert('Has superado el numero de caracteres permitido de este campo'); return false; }"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#a4e237"><input type="submit" class="negrita" value="Guardar Empleado" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($validar);
?>
