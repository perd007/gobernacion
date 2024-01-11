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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
  $contador=0;
	for($i=1;$i<=11;$i++){
		
		if($_POST[$i]!=""){
			$arreglo[$i]=$i;
			$contador++;
			}else{
			$arreglo[$i]==0;
			}	
	}	
	
	for($i=1;$i<=11;$i++){

		 if($arreglo[$i]!=""){
			 
			 
			 
			 
  $insertSQL = sprintf("INSERT INTO documentos (tipo, solicitud) VALUES (%s, %s)",
                       GetSQLValueString($_POST[$i], "text"),
                       GetSQLValueString($_POST['solicitud'], "int"));

  mysql_select_db($database_BD, $BD);
  $Result1 = mysql_query($insertSQL, $BD) or die(mysql_error());
  
     if($Result1){
	   $veri2++;
  }else{
  $veri2=-100;
  }
	  }//fin del if de verificacion
  
  }//fin del for
  
   if($veri2<=0){
  echo "<script type=\"text/javascript\">alert ('Ocurrio un Error');  location.href='fondo.php' </script>";
  exit;
  }else{
   echo "<script type=\"text/javascript\">alert ('Documentos Registrados');  location.href='fondo.php' </script>";
  }
}

mysql_select_db($database_BD, $BD);
$query_solicitud = "SELECT * FROM solicitud where empleado='$_GET[empleado]'";
$solicitud = mysql_query($query_solicitud, $BD) or die(mysql_error());
$row_solicitud = mysql_fetch_assoc($solicitud);
$totalRows_solicitud = mysql_num_rows($solicitud);

mysql_select_db($database_BD, $BD);
$query_empleado = "SELECT * FROM empleado where  cedula='$_GET[empleado]' ";
$empleado = mysql_query($query_empleado, $BD) or die(mysql_error());
$row_empleado = mysql_fetch_assoc($empleado);
$totalRows_empleado = mysql_num_rows($empleado);

mysql_select_db($database_BD, $BD);
$query_documentos = "SELECT * FROM documentos where solicitud='$_GET[id]'";
$documentos = mysql_query($query_documentos, $BD) or die(mysql_error());
$row_documentos = mysql_fetch_assoc($documentos);
$totalRows_documentos = mysql_num_rows($documentos);

if($totalRows_documentos>=1){
	echo "<script type=\"text/javascript\">alert ('Documentos ya registrados para esta Solicitud');  location.href='registrar_documentos_1.php' </script>";
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<link href="css.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function validar(){
var cont=0;
				
				
				
				for(var i=1; i<=11; i++) {
				if (document.getElementById(i).checked==true){
					cont++;
					}
				}
				
				if(cont<=0){	
					alert("Debe seleccionar al menos un puesto");
					return false;		
				}
				
				
		}
		

		
</script>

<body>
<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center" class="bordes">
    <tr valign="baseline">
      <td colspan="2" align="center" bgcolor="#a4e237" class="negrita">Relacion de Documentos por Solicitud</td>
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
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_solicitud['tipo']; ?></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFFF"><table width="339" align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Fecha de Solicitud::</td>
          <td><input name="fecha" type="text" id="fecha" value="<?php echo $row_solicitud['fecha']; ?>" size="20" maxlength="10" readonly="readonly" />
        
            &nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#a4e237" class="negrita">Documentos Entregados</td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFFF"><input type="checkbox" value="Copia de la Cedula" name="1" id="1" />
        Copia de la Cedula
        <input type="checkbox" name="2" id="2" value="Neto de Pago" />
        Neto de Pago
        <input type="checkbox" name="3" id="3" value="Formato de Solicitud" />
        Formato de Solicitud
        <input type="checkbox" name="4" id="4" value="Fe de Vida" />
        Fe de Vida</td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFFF"><input type="checkbox" name="5" id="5" value="Constancia de Ubicacion" />
        Constancia de Ubicacion
        <input type="checkbox" name="6" id="6" value=" Acta de Matrimonio" />
        Acta de Matrimonio
        <input type="checkbox" name="7" id="7" value="Partida de Nacimiento"  />
      Partida de Nacimiento</td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFFF"><input type="checkbox" name="9" id="9" value="Constancia Universitaria" />
        Constancia Universitaria
        <input type="checkbox" name="10" id="10" value="Constancia de Concubinato" />
        Constancia de Concubinato
        <input type="checkbox" name="11" id="11" value="Fotos" />
      Fotos</td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#a4e237"><input name="button" type="submit" class="negrita" id="button" value="Registrar Documentos" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="solicitud" value="<?=$_GET['id']?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($solicitud);

mysql_free_result($empleado);

mysql_free_result($documentos);
?>
