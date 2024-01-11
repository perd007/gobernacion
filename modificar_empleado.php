<?php require_once('Connections/BD.php'); ?>
<?
include("login.php");
?>
<?php 
if($validacion==true){
	if($modi==0){
	echo "<script type=\"text/javascript\">alert ('Usted no posee permisos para realizar Modificaciones'); location.href='fondo.php' </script>";
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
mysql_select_db($database_BD, $BD);
$query_validar = "SELECT * FROM empleado where cedula='$_POST[cedula]' and id_empleado!='$_POST[id_empleado]'";
$validar = mysql_query($query_validar, $BD) or die(mysql_error());
$row_validar = mysql_fetch_assoc($validar);
$totalRows_validar = mysql_num_rows($validar);

if($totalRows_validar>0){
	echo "<script type=\"text/javascript\">alert ('Ya otro Empleado Posee esta cedula');  location.href='modificar_empleado.php?cedula=$_POST[valor]' </script>";
	exit;
}
	
  $updateSQL = sprintf("UPDATE empleado SET nombres=%s, cedula=%s, nomina=%s, cargo=%s, departamento=%s, fecha_ingreso=%s, salario=%s, telefono=%s, direccion=%s, observaciones=%s WHERE id_empleado=%s",
                       GetSQLValueString($_POST['nombres'], "text"),
                       GetSQLValueString($_POST['cedula'], "int"),
                       GetSQLValueString($_POST['nomina'], "text"),
                       GetSQLValueString($_POST['cargo'], "text"),
                       GetSQLValueString($_POST['departamento'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "date"),
					    GetSQLValueString($_POST['salario'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['direccion'], "text"),
                       GetSQLValueString($_POST['observaciones'], "text"),
                       GetSQLValueString($_POST['id_empleado'], "int"));

  mysql_select_db($database_BD, $BD);
  $Result1 = mysql_query($updateSQL, $BD) or die(mysql_error());
   if($Result1){
  echo "<script type=\"text/javascript\">alert ('Datos Actualizados');  location.href='fondo.php' </script>";
  }else{
  echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='fondo.php' </script>";
  exit;
  }
}

$cedula=$_GET["cedula"];
mysql_select_db($database_BD, $BD);
$query_empleado = "SELECT * FROM empleado where cedula=$cedula";
$empleado = mysql_query($query_empleado, $BD) or die(mysql_error());
$row_empleado = mysql_fetch_assoc($empleado);
$totalRows_empleado = mysql_num_rows($empleado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
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
<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center" class="bordes">
    <tr valign="baseline">
      <td colspan="2" align="center" bgcolor="#a4e237" class="negrita">Modificar Datos  del Empleados</td>
    </tr>
    <tr valign="baseline">
      <td width="162" align="right" nowrap="nowrap">Nombres y Apellidos:</td>
      <td width="314"><input name="nombres" type="text" value="<?php echo $row_empleado['nombres']; ?>" size="50" maxlength="50" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cedula:</td>
      <td><input name="cedula" type="text" value="<?php echo $row_empleado['cedula']; ?>" size="15" maxlength="8" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nomina:</td>
      <td><label for="nomina">
        <select name="nomina" id="nomina">
          <option value="Empleado Fijo" <?php if (!(strcmp("Empleado Fijo", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Empleado Fijo</option>
          <option value="Empleado Contratado" <?php if (!(strcmp("Empleado Contratado", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Empleado Contratado</option>
          <option value="Obrero DIE" <?php if (!(strcmp("Obrero DIE", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Obrero DIE</option>
          <option value="Obrero Educacion" <?php if (!(strcmp("Obrero Educacion", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Obrero Educacion</option>
          <option value="Obrero Salud" <?php if (!(strcmp("Obrero Salud", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Obrero Salud</option>
          <option value="Jubilados Educacion" <?php if (!(strcmp("Jubilados Educacion", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Jubilados Educacion</option>
          <option value="Jubilados Gobernacion" <?php if (!(strcmp("Jubilados Gobernacion", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Jubilados Gobernacion</option>
          <option value="Pensionados Educacion" <?php if (!(strcmp("Pensionados Educacion", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Pensionados Educacion</option>
          <option value="Pensionados Gobernacion" <?php if (!(strcmp("Pensionados Gobernacion", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Pensionados Gobernacion</option>
          <option value="Personal de Confianza" <?php if (!(strcmp("Personal de Confianza", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Personal de Confianza</option>
          <option value="Policias" <?php if (!(strcmp("Policias", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Policias</option>
          <option value="Bomberos" <?php if (!(strcmp("Bomberos", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Bomberos</option>
          <option value="Obreros Contratados Gobernacion" <?php if (!(strcmp("Obreros Contratados Gobernacion", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Obreros Contratados Gobernacion</option>
          <option value="Contratados de Educacion" <?php if (!(strcmp("Contratados de Educacion", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Contratados de Educacion</option>
          <option value="Beca Salario" <?php if (!(strcmp("Beca Salario", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Beca Salario</option>
          <option value="Docente Interino" <?php if (!(strcmp("Docente Interino", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Docente Interino</option>
          <option value="Docente Ordinario" <?php if (!(strcmp("Docente Ordinario", $row_empleado['nomina']))) {echo "selected=\"selected\"";} ?>>Docente Ordinario</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cargo:</td>
      <td><input name="cargo" type="text" id="cargo" value="<?php echo $row_empleado['cargo']; ?>" size="32" maxlength="20" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Departamento:</td>
      <td><label for="departamento"></label>
        <select name="departamento" id="departamento" >
          <option value="Informatica" <?php if (!(strcmp("Informatica", $row_empleado['departamento']))) {echo "selected=\"selected\"";} ?>>Informatica</option>
          <option value="Recursos Humanos" <?php if (!(strcmp("Recursos Humanos", $row_empleado['departamento']))) {echo "selected=\"selected\"";} ?>>Recursos Humanos</option>
          <option value="Tesoreria" <?php if (!(strcmp("Tesoreria", $row_empleado['departamento']))) {echo "selected=\"selected\"";} ?>>Tesoreria</option>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fecha de Ingreso:</td>
      <td><input name="fecha_ingreso" type="text" id="fecha_ingreso" value="<?php echo $row_empleado['fecha_ingreso']; ?>" size="20" maxlength="10" readonly="readonly" />
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
      <td><input name="salario" id="telefono" type="text"  value="<?php echo $row_empleado['salario']; ?>" maxlength="10" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefono:</td>
      <td><input name="telefono" type="text" value="<?php echo $row_empleado['telefono']; ?>" size="20" maxlength="11" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" valign="middle" align="right">Direccion:</td>
      <td><textarea name="direccion" cols="50" rows="5" onkeydown="if(this.value.length &gt;= 300){ alert('Has superado el numero de caracteres permitido de este campo'); return false; }"><?php echo $row_empleado['direccion']; ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="middle">Observaciones:</td>
      <td><textarea name="observaciones" cols="50" rows="5" onkeydown="if(this.value.length &gt;= 300){ alert('Has superado el numero de caracteres permitido de este campo'); return false; }"><?php echo $row_empleado['observaciones']; ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#a4e237"><input type="submit" class="negrita" value="Modificar Empleado" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_empleado" value="<?php echo $row_empleado['id_empleado']; ?>" />
   <input type="hidden" name="valor" value="<?php echo $cedula; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($empleado);
?>
