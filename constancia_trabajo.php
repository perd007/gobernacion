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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CONSTANCIA DE TRABAJO</title>
<style type="text/css">
.interliniado {line-height: 5px;
}
.encabezado {
	font-size: 10px;
	text-align: center;
}
.doce {
	font-size: 12px;
}
.doce {
	font-size: 18px;
}
</style>
</head>
<script>
function imprimir(){
window.print()
window.close();
}
</script>
<body  <?
if((isset($_POST["ver"]) && ($_POST["MM_insert"] == "form2")) ){
	
 	if($_POST["ver"]==1){ 
	 	 echo "onload='imprimir();'";	
		
	  }
}
	  
	  
	  
	   ?>
     >
<form  action="constancia_trabajo.php" method="post" name="form1" id="form1" />

<table width="555" border="0" align="center">
  <tr>
    <td width="230" valign="top" class="encabezado">REPUBLICA BOLIVARIANA DE VENEZUELA </td>
    <td width="315" rowspan="6"><div class="interliniado" >
      <p align="center" >&nbsp;</p>
      <p align="right" ><img src="imagenes/cintillo5.jpg" alt="" width="161" height="51" /></p>
      <p align="center" >&nbsp;</p>
      <p align="center" >&nbsp;</p>
    </div></td>
  </tr>
  <tr>
    <td valign="top" class="encabezado">GOBIERNO DE AMAZONAS</td>
  </tr>
  <tr>
    <td valign="top" class="encabezado">Rif.G-20000162-3</td>
  </tr>
  <tr>
    <td valign="top" class="encabezado"><img src="imagenes/cintillo_gobernacion 3.jpg" alt="" width="55" height="62" /></td>
  </tr>
  <tr>
    <td valign="top" class="encabezado">SECRETARIA DE RECURSOS HUMEANOS</td>
  </tr>
  <tr>
    <td valign="top" class="encabezado">UNIDAD DE ARCHIVO</td>
  </tr>
  <tr>
    <td colspan="2">_____________________________________________________________________
      <p align="center">&nbsp;</p>
      <p align="center">&nbsp;</p>
      <p align="center" class="doce"><span class="doce"><strong><u>CONSTANCIA  DE TRABAJO</u></strong></span></p>
      <p align="center">&nbsp;</p>
      <p align="justify" class="doce"><span class="doce">&nbsp;Quien suscribe, Secretaria de Recursos Humanos de la Gobernacion del Estado Amazonas, por medio de la presente hace constar que el (la) Ciudadano (a): <?php echo $row_empleado['nombres']; ?>. Titular de la Cedula de identidad N° <?php echo $row_empleado['cedula']; ?>, esta adscrito (a) a la <?php echo $row_empleado['departamento']; ?>, dependiente de este Ejecutivo desde el: <?php echo $row_empleado['fecha_ingreso']; ?>, actualmente se desempeña como: (<?php echo $row_empleado['cargo']; ?>) Devengando un salario semanal integral de Bs. F </span><?php echo $row_empleado['salario']; ?></p>
      <p align="justify">&nbsp;</p>
      <p align="justify" class="doce"><span class="doce">Constancia que se  expide a solicitud de parte Interesada en la Ciudad de Puerto Ayacucho, Capital del Estado Amazonas a los d&iacute;as <?php echo date("d"); ?> del mes <?php echo date("m"); ?>&nbsp;del <?php echo date("Y"); ?></span>.</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p align="center" class="doce"><span class="doce">________________________________<br />
        <strong>Abog. ABREU EDITH</strong><br />
      Adj. Secretaria de Recursos Humanos</span></p>
      <p align="center">&nbsp;</p>
      <div align="center">
      <input type="hidden" name="MM_insert" value="form2" />
        <input type="hidden" name="cedula" value="<? echo $row_empleado["cedula"]; ?>" />
        <input type="hidden" name="ver" value="1" />
        <input type="submit" v="v" name="imprimir" value="Imprimir" <? if((isset($_POST["ver"]) && ($_POST["MM_insert"] == "form2")) ){
			if($_POST["ver"]==1){ 
	  echo "style='visibility:hidden'";}}?>
	 />
      </div></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
mysql_free_result($empleado);
?>
