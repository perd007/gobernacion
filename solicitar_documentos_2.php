<?php require_once('Connections/BD.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
	
	
mysql_select_db($database_BD, $BD);
$query_solicitudes = "SELECT * FROM solicitud where empleado='$_POST[cedula]' and fecha='$_POST[fecha]' and tipo='$_POST[tipo]'";
$solicitudes = mysql_query($query_solicitudes, $BD) or die(mysql_error());
$row_solicitudes = mysql_fetch_assoc($solicitudes);
$totalRows_solicitudes = mysql_num_rows($solicitudes);

	if($totalRows_solicitudes>=1){
	echo "<script type=\"text/javascript\">alert ('Ya posee una solicitud para esta fecha ');  location.href='solicitar_documentos.php' </script>";
	exit;
}

	
  $insertSQL = sprintf("INSERT INTO solicitud (tipo, fecha, empleado, estado, usuario) VALUES ( %s, %s, %s, %s, %s)",
                    
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['cedula'], "int"),
					   GetSQLValueString(0, "int"),
					   GetSQLValueString($_COOKIE["usced"], "int"));

  mysql_select_db($database_BD, $BD);
  $Result1 = mysql_query($insertSQL, $BD) or die(mysql_error());
    if($Result1){
		echo "<script type=\"text/javascript\">alert ('Solicitud realizada');  location.href='fondo.php' </script>";
 
  }else{
   echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='fondo.php' </script>";
  exit;
  }
}

mysql_select_db($database_BD, $BD);
$query_empleado = "SELECT * FROM empleado where cedula='$_POST[cedula]'";
$empleado = mysql_query($query_empleado, $BD) or die(mysql_error());
$row_empleado = mysql_fetch_assoc($empleado);
$totalRows_empleado = mysql_num_rows($empleado);

include("login.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
 @import url("jscalendar-1.0/calendar-win2k-cold-1.css");
</style>

</head>
<script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
<script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>
<link href="css.css" rel="stylesheet" type="text/css" />
<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <table align="center" class="bordes">
    <tr valign="baseline">
      <td colspan="2" align="center" bgcolor="#a4e237" class="negrita">Realizar Solicitud de Documentos</td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" bgcolor="#a4e237" class="negrita">Datos del Empleados</td>
    </tr>
    <tr valign="baseline">
      <td width="198" align="right" nowrap="nowrap">Nombres y Apellidos:</td>
      <td width="350"><input name="nombres" type="text" value="<?php echo $row_empleado['nombres']; ?>" size="50" maxlength="50" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cedula:</td>
      <td><input name="cedula" type="text" value="<?php echo $row_empleado['cedula']; ?>" size="15" maxlength="8" readonly="readonly"/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nomina:</td>
      <td><label for="nomina"></label>
        <select name="nomina" id="nomina" readonly="readonly">
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
        </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cargo:</td>
      <td><input name="cargo" type="text" id="cargo" value="<?php echo $row_empleado['cargo']; ?>" size="32" maxlength="20" readonly="readonly"/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Departamento:</td>
      <td><label for="departamento"></label>
        <select name="departamento" id="departamento" readonly="readonly" >
          <option value="Informatica" <?php if (!(strcmp("Informatica", $row_empleado['departamento']))) {echo "selected=\"selected\"";} ?>>Informatica</option>
          <option value="Recursos Humanos" <?php if (!(strcmp("Recursos Humanos", $row_empleado['departamento']))) {echo "selected=\"selected\"";} ?>>Recursos Humanos</option>
          <option value="Tesoreria" <?php if (!(strcmp("Tesoreria", $row_empleado['departamento']))) {echo "selected=\"selected\"";} ?>>Tesoreria</option>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fecha de Ingreso:</td>
      <td><input name="fecha_ingreso" type="text" id="fecha_ingreso" value="<?php echo $row_empleado['fecha_ingreso']; ?>" size="20" maxlength="10" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefono:</td>
      <td><input name="telefono" type="text" value="<?php echo $row_empleado['telefono']; ?>" size="20" maxlength="11" readonly="readonly"/></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#a4e237" class="negrita">Documentos a Solicitar</td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFFF"><input type="radio" checked="checked" name="tipo" id="radio" value="Constancia de Trabajo" />
        Constancia de Trabajo
          <input type="radio" name="tipo" id="tipo" value="Carnet de Carga Familiar" />
Carnet de Carga Familiar</td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFFF"><table width="339" align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Fecha de Solicitud::</td>
          <td><input name="fecha" type="text" id="fecha" value="<? echo date("Y")."-".date("m")."-".date("d"); ?>" size="20" maxlength="10" readonly="readonly" /></td>
        </tr>
      </table></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFFF" class="negrita">Datos de Quien Realiza la Solicitud</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#FFFFFF" >Nombre del Usuario:</td>
      <td align="left" nowrap="nowrap" bgcolor="#FFFFFF"><?=$_COOKIE["usnom"]?>&nbsp;<?=$_COOKIE["usape"]?></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#FFFFFF" >Cedula del Usuario:</td>
      <td align="left" nowrap="nowrap" bgcolor="#FFFFFF"><?=$_COOKIE["usced"]?></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#a4e237"><input name="button" type="submit" class="negrita" id="button" value="Procesar Solicitud" /></td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form2" />
  </p>
</form>
<p>&nbsp;</p>
</body>
</html>
