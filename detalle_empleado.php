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
<link href="css.css" rel="stylesheet" type="text/css" />
<title>Documento sin título</title>
</head>

<body>
<table align="center" class="bordes">
  <tr valign="baseline">
    <td colspan="2" align="center" bgcolor="#a4e237" class="negrita">Detalles del Empleados</td>
  </tr>
  <tr valign="baseline">
    <td width="198" align="right" nowrap="nowrap" class="negrita">Nombres y Apellidos:</td>
    <td width="278"><?php echo $row_empleado['nombres']; ?></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="negrita">Cedula:</td>
    <td><?php echo $row_empleado['cedula']; ?></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="negrita">Nomina:</td>
    <td><?php echo $row_empleado['nomina']; ?></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="negrita">Cargo:</td>
    <td><?php echo $row_empleado['cargo']; ?></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="negrita">Departamento:</td>
    <td><?php echo $row_empleado['departamento']; ?></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="negrita">Fecha de Ingreso:</td>
    <td><?php echo $row_empleado['fecha_ingreso']; ?></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="negrita">Telefono:</td>
    <td><?php echo $row_empleado['telefono']; ?></td>
  </tr>
  <tr valign="baseline">
    <td align="right" valign="middle" nowrap="nowrap" class="negrita">Direccion:</td>
    <td><?php echo $row_empleado['direccion']; ?></td>
  </tr>
  <tr valign="baseline">
    <td align="right" valign="middle" nowrap="nowrap" class="negrita">Observaciones:</td>
    <td><?php echo $row_empleado['observaciones']; ?></td>
  </tr>
  <tr valign="baseline">
    <td colspan="2" align="center" nowrap="nowrap" bgcolor="#a4e237"><a href="consulta_empleados.php"><input type="button" class="negrita" value="Volver" /></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($empleado);
?>
