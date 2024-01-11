<?php require_once('Connections/BD.php'); ?>

<?
include("login.php");
?>
<?php 
//validar usuario
if($validacion==true){
	if($Admi==0){
	echo "<script type=\"text/javascript\">alert ('Usted no posee permisos para consultar usuarios Registros');location.href='fondo.php' </script>";
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

$maxRows_usuarios = 10;
$pageNum_usuarios = 0;
if (isset($_GET['pageNum_usuarios'])) {
  $pageNum_usuarios = $_GET['pageNum_usuarios'];
}
$startRow_usuarios = $pageNum_usuarios * $maxRows_usuarios;

mysql_select_db($database_BD, $BD);
$query_usuarios = "SELECT * FROM usuario";
$query_limit_usuarios = sprintf("%s LIMIT %d, %d", $query_usuarios, $startRow_usuarios, $maxRows_usuarios);
$usuarios = mysql_query($query_limit_usuarios, $BD) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);

if (isset($_GET['totalRows_usuarios'])) {
  $totalRows_usuarios = $_GET['totalRows_usuarios'];
} else {
  $all_usuarios = mysql_query($query_usuarios);
  $totalRows_usuarios = mysql_num_rows($all_usuarios);
}
$totalPages_usuarios = ceil($totalRows_usuarios/$maxRows_usuarios)-1;

$queryString_usuarios = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_usuarios") == false && 
        stristr($param, "totalRows_usuarios") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_usuarios = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_usuarios = sprintf("&totalRows_usuarios=%d%s", $totalRows_usuarios, $queryString_usuarios);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>

<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
.Estilo3 {color: #FFFFFF; font-weight: bold; }
.Estilo4 {color: #000000}
-->
</style>
</head>
<script language="javascript">
<!--

function validar(){

			var valor=confirm('¿Esta seguro de Eliminar este Usuario?');
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
<table width="572" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#5a7210">
  <tr bgcolor="#00CCFF">
    <th colspan="9" bgcolor="#a4e237" ><span class="Estilo1"><strong>Usuarios</strong></span></th>
  </tr>
  <tr>
    <td colspan="2"><div align="center" ><strong>Login y Contrase&ntilde;as </strong></div></td>
    <td colspan="5"><div align="center" ><strong>Permisos que Posee el Usuario </strong></div></td>
    <td colspan="2"><div align="center" ><strong>Opciones</strong></div></td>
  </tr>
  <tr bgcolor="#00CCFF">
    <td width="111" bgcolor="#a4e237"><span class="Estilo3">Usuario</span></td>
    <td width="99" bgcolor="#a4e237"><span class="Estilo3">Clave</span></td>
    <td width="60" bgcolor="#a4e237"><span class="Estilo3">Modifica</span></td>
    <td width="50" bgcolor="#a4e237"><span class="Estilo3">Elimina</span></td>
    <td width="58" bgcolor="#a4e237"><span class="Estilo3">Registra</span></td>
    <td width="65" bgcolor="#a4e237"><span class="Estilo3">Consultar</span></td>
    <td width="73" bgcolor="#a4e237"><span class="Estilo3">Administra</span></td>
    <td width="28" bgcolor="#a4e237"><span class="Estilo3">Op1</span></td>
    <td width="28" bgcolor="#a4e237"><span class="Estilo3">Op2</span></td>
  </tr>
    <?php 
	$modulo=0;
	$cont=0;
	
	do { 
  	$m=$row_usuarios["modificar"];
$r=$row_usuarios["registrar"];
$e=$row_usuarios["eliminar"];
$c=$row_usuarios["consultar"];
$a=$row_usuarios["administrar"];
//validar permisos
if($m!=0){
$m="si";
}
else{
$m="no";
}

if($c!=0){
$c="si";
}
else{
$c="no";
}

if($e!=0){
$e="si";
}
else{
$e="no";
}

if($r!=0){
$r="si";
}
else{
$r="no";
}

if($a!=0){
$a="si";
}
else{
$a="no";
}

  
  	$modulo=$cont%2;
			
			if($modulo!=0){
			$color="#a4e237";
			}else{
			$color="#FFFFFF";
			}
			
	
	  ?>
  <tr bgcolor="<?php echo $color; ?>">
      <td><span class="Estilo4"><?php echo $row_usuarios['usuario']; ?></span></td>
      <td><span class="Estilo4"><?php echo $row_usuarios['clave']; ?></span></td>
      <td><div align="center" class="Estilo4"><?php echo $m; ?></div></td>
      <td><div align="center" class="Estilo4"><?php echo $e; ?></div></td>
      <td><div align="center" class="Estilo4"><?php echo $r; ?></div></td>
      <td><div align="center" class="Estilo4"><?php echo $c; ?></div></td>
      <td><div align="center" class="Estilo4"><?php echo $a; ?></div></td>
      <td><span class="Estilo4"><?php echo "<a href='modificarUsuarios.php?cod=$row_usuarios[idUsuario]'>Modificar</a>"; ?></span></td>
    <td><span class="Estilo4"><?php echo "<a onClick='return validar()' href='eliminarUsuarios.php?id=$row_usuarios[idUsuario]'>Eliminar</a>"; ?></span></td>
    
        <?php $cont++;  } while ($row_usuarios = mysql_fetch_assoc($usuarios)); ?>
  </tr>
</table>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_usuarios > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_usuarios=%d%s", $currentPage, 0, $queryString_usuarios); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_usuarios > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_usuarios=%d%s", $currentPage, max(0, $pageNum_usuarios - 1), $queryString_usuarios); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_usuarios < $totalPages_usuarios) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_usuarios=%d%s", $currentPage, min($totalPages_usuarios, $pageNum_usuarios + 1), $queryString_usuarios); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_usuarios < $totalPages_usuarios) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_usuarios=%d%s", $currentPage, $totalPages_usuarios, $queryString_usuarios); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
</body>
</html>
