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



mysql_select_db($database_BD, $BD);
$query_empleado = "SELECT * FROM empleado where cedula='$_GET[cedula]'";
$empleado = mysql_query($query_empleado, $BD) or die(mysql_error());
$row_empleado = mysql_fetch_assoc($empleado);
$totalRows_empleado = mysql_num_rows($empleado);

$maxRows_fam = 7;
$pageNum_fam = 0;
if (isset($_GET['pageNum_fam'])) {
  $pageNum_fam = $_GET['pageNum_fam'];
}
$startRow_fam = $pageNum_fam * $maxRows_fam;

mysql_select_db($database_BD, $BD);
$query_fam = "SELECT * FROM familiares where empleado='$_GET[cedula]'";
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


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
.IZQ {
	text-align: left;
	font-size: 14px;
	font-style: italic;
}
.IZQ2 {
	text-align: left;
	font-size: 18px;
	font-style: italic;
}
.PIE {
	font-size: 12px;
	text-align: left;
}
.bordes {
	border: medium solid #000;
	text-align: center;
	font-size: 14px;
	font-style: italic;
}

.diez {
	font-size: 10px;
}
.bordes_bajos {
	border-bottom-style: none;
	border-top-style: none;
	border-right-style: none;
	border-left-style: none;
}
</style>
</head>
<script>
function imprimir(){
window.print()
window.close();
}
</script>
<body  <? if((isset($_POST["ver"]))){
	
	if($_POST["ver"]==1){ 
	  echo "onload='imprimir();'";	
	  }} ?>>
<form  action="carnet_familiar.php" method="post" name="form1" id="form1" />

<table width="475" height="297" border="0" align="left" class="bordes">
  <tr>
      <th width="144" height="243" class="diez" scope="col"><br><br><br><br><br>SELLO</th>
    <th width="313" valign="top" scope="col"><table width="313" height="241" border="0" align="left">
        <tr>
          <th width="307" height="75" valign="top" class="IZQ" scope="row"><table width="304" border="0" align="left">
            <tr>
              <th width="101" rowspan="3" scope="col"><img src="imagenes/cintillo_gobernacion 3.jpg" alt="" width="63" height="67" /></th>
              <th width="193" height="25" scope="col"><span class="diez">DEC. EJCT. DE RECURSOS HUMANOS</span></th>
            </tr>
            <tr>
              <th height="17" scope="row"><span class="diez">PUERTO AYACUCHO</span></th>
            </tr>
            <tr>
              <th height="23" scope="row"><span class="diez">UNIDAD DE ARCHIVO</span></th>
            </tr>
        </table></th>
        </tr>
        <tr>
          <th height="30" class="IZQ" scope="row">NOMBRES Y APELLIDOS: &nbsp;&nbsp;&nbsp;<?php echo $row_empleado['nombres']; ?></th>
        </tr>
        <tr>
          <th height="19" class="IZQ" scope="row">CEDULA N°: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row_empleado['cedula']; ?></th>
        </tr>
        <tr>
          <th height="19" class="IZQ" scope="row">FECHA DE EXP:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;            <? $fecha_cambiada = mktime(0,0,0,date("m"),date("d"),date("Y")+1); 
	$fecha = date("d/m/Y", $fecha_cambiada);
	echo $fecha; ?></th>
        </tr>
        <tr>
          <th height="19" class="IZQ" scope="row">CARGO: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $row_empleado['cargo']; ?></th>
        </tr>
        <tr>
          <th height="19" class="IZQ" scope="row">DEPENDIENTE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; GOB. EDO. AMAZ.</th>
        </tr>
        <tr>
          <th height="19" class="IZQ" scope="row">REVISADO POR:</th>
        </tr>
        <tr>
          <th height="23" class="IZQ2" scope="row">RIF-G-20000162-3</th>
        </tr>
    </table></th>
  </tr>
  <tr>
    <th height="21" colspan="2" scope="col" valign="top" align="left">___________________________ </th>
  </tr>
  <tr>
    <th height="17" colspan="2" class="PIE"  scope="col">SECRETARIA DE RECURSOS HUMANOS &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;VALIDO POR (1) AÑO</th>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><br>
</p>
<table width="475" height="297" border="0"  align="left" bordercolor="#000000" class="bordes" >
  <tr>
    <th height="19" colspan="4" scope="col">CARGA FAMILIAR</th>
  </tr>
  <tr >
    <th width="65" height="19" scope="col">Nro</th>
    <th width="257" scope="col">NOMBRES Y APELLIDOS</th>
    <th width="87" scope="col">EDAD</th>
    <th width="139" scope="col">PARENTESCO</th>
  </tr>
  <?php 
  $i=1;
 
   do { 
   
  	$nombres[$i]=$row_fam['nombres'];
	$edades[$i]=$row_fam['edad'];
	$parentescos[$i]=$row_fam['parentesco'];
	
	$i++;
   } while ($row_fam = mysql_fetch_assoc($fam)); 
   ?>
    <tr>
      <th height="20" scope="col">1.</th>
      <th scope="col"><?php echo $nombres[1]; ?></th>
      <th scope="col"><?php echo $edades[1]; ?></th>
      <th scope="col"><?php echo $parentescos[1]; ?></th>
    </tr>
    <tr>
      <th height="29" scope="col">2.</th>
      <th scope="col"><?php echo $nombres[2]; ?></th>
      <th scope="col"><?php echo $edades[2]; ?></th>
      <th scope="col"><?php echo $parentescos[2]; ?></th>
    </tr>
    <tr class="bordes_bajos">
      <th height="29" scope="col">3.</th>
      <th scope="col"><?php echo $nombres[3]; ?></th>
      <th scope="col"><?php echo $edades[3]; ?></th>
      <th scope="col"><?php echo $parentescos[3]; ?></th>
    </tr>
    <tr>
      <th height="29" scope="col">4.</th>
      <th scope="col"><?php echo $nombres[4]; ?></th>
      <th scope="col"><?php echo $edades[4]; ?></th>
      <th scope="col"><?php echo $parentescos[4]; ?></th>
    </tr>
    <tr>
      <th height="29" scope="col">5.</th>
      <th scope="col"><?php echo $nombres[5]; ?></th>
      <th scope="col"><?php echo $edades[5]; ?></th>
      <th scope="col"><?php echo $parentescos[5]; ?></th>
    </tr>
    <tr >
      <th height="29" scope="col">6.</th>
      <th scope="col"><?php echo $nombres[6]; ?></th>
      <th scope="col"><?php echo $edades[6]; ?></th>
      <th scope="col"><?php echo $parentescos[6]; ?></th>
    </tr>
    <tr>
      <th height="29" scope="col">7.</th>
      <th scope="col"><?php echo $nombres[7]; ?></th>
      <th scope="col"><?php echo $edades[7]; ?></th>
      <th scope="col"><?php echo $parentescos[7]; ?></th>
    </tr>
   
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div align="center">
  <input type="hidden" name="cedula" value="<? echo $row_empleado["cedula"]; ?>" />
  <input type="hidden" name="ver" value="1" />
  <input type="submit" v="v" name="imprimir" value="Imprimir" <?  if((isset($_POST["ver"])) ){ if($_POST["ver"]==1){ 
	  echo "style='visibility:hidden'";}}?>
	 />
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</form>
</body>
</html>

