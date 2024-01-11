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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_solicitudes = 10;
$pageNum_solicitudes = 0;
if (isset($_GET['pageNum_solicitudes'])) {
  $pageNum_solicitudes = $_GET['pageNum_solicitudes'];
}
$startRow_solicitudes = $pageNum_solicitudes * $maxRows_solicitudes;

mysql_select_db($database_BD, $BD);
$query_solicitudes = "SELECT * FROM solicitud where estado=0";
$query_limit_solicitudes = sprintf("%s LIMIT %d, %d", $query_solicitudes, $startRow_solicitudes, $maxRows_solicitudes);
$solicitudes = mysql_query($query_limit_solicitudes, $BD) or die(mysql_error());
$row_solicitudes = mysql_fetch_assoc($solicitudes);

if (isset($_GET['totalRows_solicitudes'])) {
  $totalRows_solicitudes = $_GET['totalRows_solicitudes'];
} else {
  $all_solicitudes = mysql_query($query_solicitudes);
  $totalRows_solicitudes = mysql_num_rows($all_solicitudes);
}
$totalPages_solicitudes = ceil($totalRows_solicitudes/$maxRows_solicitudes)-1;

$queryString_solicitudes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_solicitudes") == false && 
        stristr($param, "totalRows_solicitudes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_solicitudes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_solicitudes = sprintf("&totalRows_solicitudes=%d%s", $totalRows_solicitudes, $queryString_solicitudes);


if($totalRows_solicitudes==0){
	echo "<script type=\"text/javascript\">alert ('No existen Solicitudes ');  location.href='fondo.php' </script>";
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
.Estilo2 {color: #000000}
</style>
</head>

<body>
<table width="482" class="bordes" border="0" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <th colspan="3" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">CONSULTA DE SOLICITUDES PENDIENTES</th>
  </tr>
  <tr>
    <th width="257" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">Nombre</th>
    <th width="141" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">Fecha</th>
    <th width="39" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">Procesar</th>
  </tr>
 
  <?php do { ?>
    <tr>
      <td align="center" valign="middle" bgcolor="#f2f0f0"><?php echo $row_solicitudes['tipo']; ?></td>
      <td align="center" valign="middle" bgcolor="#f2f0f0"><?php echo $row_solicitudes['fecha']; ?></td>
      <td align="center" bgcolor="#f2f0f0"><div align="center"><? echo "<a href='procesar_solicitud_2.php?cedula=$row_solicitudes[empleado]&id=$row_solicitudes[id_solicitud]'>IR</a>" ?></div></td>
    </tr>
    <?php } while ($row_solicitudes = mysql_fetch_assoc($solicitudes)); ?>
 
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_solicitudes > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_solicitudes=%d%s", $currentPage, 0, $queryString_solicitudes); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_solicitudes > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_solicitudes=%d%s", $currentPage, max(0, $pageNum_solicitudes - 1), $queryString_solicitudes); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_solicitudes < $totalPages_solicitudes) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_solicitudes=%d%s", $currentPage, min($totalPages_solicitudes, $pageNum_solicitudes + 1), $queryString_solicitudes); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_solicitudes < $totalPages_solicitudes) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_solicitudes=%d%s", $currentPage, $totalPages_solicitudes, $queryString_solicitudes); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($solicitudes);
?>
