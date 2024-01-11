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

if($_POST['cedula']!=" "){
$cedula=$_POST['cedula'];	
}else{
if($_GET['cedula']!=" "){
$cedula=$_GET['cedula'];	
}	
	
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_fam = 10;
$pageNum_fam = 0;
if (isset($_GET['pageNum_fam'])) {
  $pageNum_fam = $_GET['pageNum_fam'];
}
$startRow_fam = $pageNum_fam * $maxRows_fam;

mysql_select_db($database_BD, $BD);
$query_fam = "SELECT * FROM familiares where empleado='$cedula'";
$query_limit_fam = sprintf("%s LIMIT %d, %d", $query_fam, $startRow_fam, $maxRows_fam);
$fam = mysql_query($query_limit_fam, $BD) or die(mysql_error());
$row_fam = mysql_fetch_assoc($fam);

if (isset($_GET['totalRows_fam'])) {
  $totalRows_fam = $_GET['totalRows_fam'];
} else {
  $all_fam = mysql_query($query_fam);
  $totalRows_fam = mysql_num_rows($all_fam);
}
$totalPages_fam = ceil($totalRows_fam/$maxRows_fam)-1;

$queryString_fam = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_fam") == false && 
        stristr($param, "totalRows_fam") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_fam = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_fam = sprintf("&totalRows_fam=%d%s", $totalRows_fam, $queryString_fam);

if($totalRows_fam<=0){
	echo "<script type=\"text/javascript\">alert ('Este empleado no tiene familiares registrados ');  location.href='registrar_familiar.php' </script>";
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
<link href="css.css" rel="stylesheet" type="text/css" />
</head>
<script language="javascript">
<!--

function validar(){

			var valor=confirm('¿Esta seguro de Eliminar este Familiar?');
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
<p>&nbsp;</p>
<table width="640" class="bordes" border="0" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <th colspan="7" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">CONSULTA DE FAMILIARES</th>
  </tr>
  <tr>
    <th width="167" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">Nombres y Apellidos</th>
    <th width="73" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">Cedula</th>
    <th width="57" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">Edad </th>
    <th width="101" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">Parentesco</th>
    <th width="123" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">Observaciones</th>
    <th width="26" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">M</th>
    <th width="28" align="center" valign="middle" bgcolor="#a4e237" class="Estilo1 Estilo2" scope="col">E</th>
  </tr>
 
  
    <?php do { ?>
      <tr>
        <td align="center" valign="middle" bgcolor="#f2f0f0"><?php echo $row_fam['nombres']; ?></td>
        <td align="center" valign="middle" bgcolor="#f2f0f0"><?php echo $row_fam['cedula']; ?></td>
        <td align="center" valign="middle" bgcolor="#f2f0f0"><?php echo $row_fam['edad']; ?></td>
        <td align="center" valign="middle" bgcolor="#f2f0f0"><?php echo $row_fam['parentesco']; ?></td>
        <td align="center" valign="middle" bgcolor="#f2f0f0"><?php echo $row_fam['observaciones']; ?></td>
        <td align="center" bgcolor="#f2f0f0"><div align="center"><? echo "<a href='modificar_familiar.php?cedula=$row_fam[cedula]&empleado=$cedula'>IR</a>" ?></div></td>
        <td align="center" bgcolor="#f2f0f0"><div align="center"><? echo "<a onClick='return validar()' href='eliminar_familiar.php?id=$row_fam[id_familiares]&empleado=$cedula'>IR</a>" ?></div></td>
      </tr>
      <?php } while ($row_fam = mysql_fetch_assoc($fam)); ?>
   
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_fam > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_fam=%d%s", $currentPage, 0, $queryString_fam); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_fam > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_fam=%d%s", $currentPage, max(0, $pageNum_fam - 1), $queryString_fam); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_fam < $totalPages_fam) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_fam=%d%s", $currentPage, min($totalPages_fam, $pageNum_fam + 1), $queryString_fam); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_fam < $totalPages_fam) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_fam=%d%s", $currentPage, $totalPages_fam, $queryString_fam); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
</body>
</html>
