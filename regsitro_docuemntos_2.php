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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_solicitudes = 10;
$pageNum_solicitudes = 0;
if (isset($_GET['pageNum_solicitudes'])) {
  $pageNum_solicitudes = $_GET['pageNum_solicitudes'];
}
$startRow_solicitudes = $pageNum_solicitudes * $maxRows_solicitudes;

mysql_select_db($database_BD, $BD);
$query_solicitudes = "SELECT * FROM solicitud where empleado='$_POST[cedula]'";
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

  mysql_select_db($database_BD, $BD);
$query_Recordset1 = "SELECT * FROM empleado where cedula='$_POST[cedula]'";
$Recordset1 = mysql_query($query_Recordset1, $BD) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
<table width="640" class="bordes" border="1" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <th colspan="3" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">Solicitudes Realizadas por:<?php echo $row_Recordset1['nombres']; ?></th>
  </tr>
  <tr>
    <th width="327" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">Tipo</th>
    <th width="200" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">Fecha</th>
    <th width="99" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">Añadir</th>
  </tr>
 
  <?php do { 
  

  ?>
    <tr>
      <td align="center" valign="middle" bgcolor="#f2f0f0"><?php echo $row_solicitudes['tipo']; ?></td>
      <td align="center" valign="middle" bgcolor="#f2f0f0"><?php echo $row_solicitudes['fecha']; ?></td>
      <td align="center" bgcolor="#f2f0f0"><div align="center"><? echo "<a href='agregar_documento.php?empleado=$_POST[cedula]&id=$row_solicitudes[id_solicitud]'>IR</a>" ?></div></td>
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

mysql_free_result($Recordset1);
?>
