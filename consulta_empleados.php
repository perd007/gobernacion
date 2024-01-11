<?php require_once('Connections/BD.php'); ?>
<?
include("login.php");
?>
<?php 
//validar usuario
if($validacion==true){
	if($cons==0){
	echo "<script type=\"text/javascript\">alert ('Usted no posee permisos para realizar Consultas'); location.href='fondo.php' </script>";
    exit;
	}
}
else{
echo "<script type=\"text/javascript\">alert ('Error usuario invalido');  location.href='fondo.php'  </script>";
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_empleados = 10;
$pageNum_empleados = 0;
if (isset($_GET['pageNum_empleados'])) {
  $pageNum_empleados = $_GET['pageNum_empleados'];
}
$startRow_empleados = $pageNum_empleados * $maxRows_empleados;

mysql_select_db($database_BD, $BD);
$query_empleados = "SELECT * FROM empleado";
$query_limit_empleados = sprintf("%s LIMIT %d, %d", $query_empleados, $startRow_empleados, $maxRows_empleados);
$empleados = mysql_query($query_limit_empleados, $BD) or die(mysql_error());
$row_empleados = mysql_fetch_assoc($empleados);

if (isset($_GET['totalRows_empleados'])) {
  $totalRows_empleados = $_GET['totalRows_empleados'];
} else {
  $all_empleados = mysql_query($query_empleados);
  $totalRows_empleados = mysql_num_rows($all_empleados);
}
$totalPages_empleados = ceil($totalRows_empleados/$maxRows_empleados)-1;

$queryString_empleados = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_empleados") == false && 
        stristr($param, "totalRows_empleados") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_empleados = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_empleados = sprintf("&totalRows_empleados=%d%s", $totalRows_empleados, $queryString_empleados);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
.Estilo2 {color: #000000}
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
</head>
<script language="javascript">
<!--

function validar(){

			var valor=confirm('¿Esta seguro de Eliminar este Empleado?');
			if(valor==false){
			return false;
			}
			else{
			return true;
			}
		
}
//-->
</script>
<body>
<table width="640" class="bordes" border="0" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <th colspan="6" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">CONSULTA DE EMPLEADOS</th>
  </tr>
  <tr>
    <th width="223" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">Nombres y Apellidos</th>
    <th width="130" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">Cedula</th>
    <th width="157" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">Nomina </th>
    <th width="35" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">M</th>
    <th width="38" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">E</th>
    <th width="23" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">D</th>
  </tr>
 
  <?php do { ?>
    <tr>
      <td align="center" valign="middle" bgcolor="#f2f0f0"><?php echo $row_empleados['nombres']; ?></td>
      <td align="center" valign="middle" bgcolor="#f2f0f0"><?php echo $row_empleados['cedula']; ?></td>
      <td align="center" valign="middle" bgcolor="#f2f0f0"><?php echo $row_empleados['nomina']; ?></td>
      <td align="center" bgcolor="#f2f0f0"><div align="center"><? echo "<a href='modificar_empleado.php?cedula=$row_empleados[cedula]'>IR</a>" ?></div></td>
      <td align="center" bgcolor="#f2f0f0"><div align="center"><? echo "<a onClick='return validar()' href='eliminar_empleado.php?cedula=$row_empleados[cedula]'>IR</a>" ?></div></td>
      <td align="center" bgcolor="#f2f0f0"><div align="center"><? echo "<a  href='detalle_empleado.php?cedula=$row_empleados[cedula]'>IR</a>" ?></div></td>
    </tr>
    <?php } while ($row_empleados = mysql_fetch_assoc($empleados)); ?>  
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_empleados > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_empleados=%d%s", $currentPage, 0, $queryString_empleados); ?>">Primero</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_empleados > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_empleados=%d%s", $currentPage, max(0, $pageNum_empleados - 1), $queryString_empleados); ?>">Anterior</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_empleados < $totalPages_empleados) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_empleados=%d%s", $currentPage, min($totalPages_empleados, $pageNum_empleados + 1), $queryString_empleados); ?>">Siguiente</a>
      <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_empleados < $totalPages_empleados) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_empleados=%d%s", $currentPage, $totalPages_empleados, $queryString_empleados); ?>">&Uacute;ltimo</a>
      <?php } // Show if not last page ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($empleados);
?>
