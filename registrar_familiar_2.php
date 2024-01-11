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
$query_familiares = "SELECT * FROM familiares where cedula='$_POST[cedula2]'";
$familiares = mysql_query($query_familiares, $BD) or die(mysql_error());
$row_familiares = mysql_fetch_assoc($familiares);
$totalRows_familiares=  mysql_num_rows($familiares);
	
	if($totalRows_familiares>=1){
	echo "<script type=\"text/javascript\">alert ('Esta Cedula ya esta registrada ');  location.href='registrar_familiar.php' </script>";
	exit;
}
	

mysql_select_db($database_BD, $BD);
$query_empleado = "SELECT * FROM empleado where cedula='$_POST[cedula2]'";
$empleado = mysql_query($query_empleado, $BD) or die(mysql_error());
$row_empleado = mysql_fetch_assoc($empleado);
$totalRows_empleado = mysql_num_rows($empleado);


if($totalRows_empleado>=1){
	echo "<script type=\"text/javascript\">alert ('Esta Cedula ya esta registrada ');  location.href='registrar_familiar.php' </script>";
	exit;
}

//validar esposa
	mysql_select_db($database_BD, $BD);
$query_familiares2 = "SELECT * FROM familiares where empleado='$_POST[cedula]' and parentesco='Esposo(a)'";
$familiares2 = mysql_query($query_familiares2, $BD) or die(mysql_error());
$row_familiares2 = mysql_fetch_assoc($familiares2);
$totalRows_familiares2 = mysql_num_rows($familiares2);

	if($totalRows_familiares2>=1 and $_POST['parentesco']=="Esposo(a)"){
	echo "<script type=\"text/javascript\">alert ('Esta empleado ya tiene Esposo(a) ');  location.href='registrar_familiar.php' </script>";
	exit;
}
//validar Concubino(a)
	mysql_select_db($database_BD, $BD);
$query_familiares5 = "SELECT * FROM familiares where empleado='$_POST[cedula]' and parentesco='Concubino(a)'";
$familiares5 = mysql_query($query_familiares5, $BD) or die(mysql_error());
$row_familiares5 = mysql_fetch_assoc($familiares5);
$totalRows_familiares5 = mysql_num_rows($familiares5);

	if($totalRows_familiares5>=1 and $_POST['parentesco']=="Concubino(a)"){
	echo "<script type=\"text/javascript\">alert ('Esta empleado ya tiene Concubino(a)');  location.href='registrar_familiar.php' </script>";
	exit;
}
    //validar padre
	mysql_select_db($database_BD, $BD);
$query_familiares3 = "SELECT * FROM familiares where empleado='$_POST[cedula]' and parentesco='Padre'";
$familiares3 = mysql_query($query_familiares3, $BD) or die(mysql_error());
$row_familiares3 = mysql_fetch_assoc($familiares3);
$totalRows_familiares3 = mysql_num_rows($familiares3);

	if($totalRows_familiares3>=1 and $_POST['parentesco']=="Padre"){
	echo "<script type=\"text/javascript\">alert ('Esta empleado ya tiene padre ');  location.href='registrar_familiar.php' </script>";
	exit;
}          
     
	   //validar madre
	mysql_select_db($database_BD, $BD);
$query_familiares4 = "SELECT * FROM familiares where empleado='$_POST[cedula]' and parentesco='Madre'";
$familiares4 = mysql_query($query_familiares4, $BD) or die(mysql_error());
$row_familiares4 = mysql_fetch_assoc($familiares4);
$totalRows_familiares4 = mysql_num_rows($familiares4);

	if($totalRows_familiares4>=1 and $_POST['parentesco']=="Madre"){
	echo "<script type=\"text/javascript\">alert ('Esta empleado ya tiene madre ');  location.href='registrar_familiar.php' </script>";
	exit;
}            
           


  $insertSQL = sprintf("INSERT INTO familiares (nombres, cedula, parentesco, empleado, observaciones) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombres2'], "text"),
                       GetSQLValueString($_POST['cedula2'], "int"),
                       GetSQLValueString($_POST['parentesco'], "text"),
                       GetSQLValueString($_POST['cedula'], "int"),
                       GetSQLValueString($_POST['observaciones'], "text"));

  mysql_select_db($database_BD, $BD);
  $Result1 = mysql_query($insertSQL, $BD) or die(mysql_error());
  if($Result1){
  echo "<script type=\"text/javascript\">alert ('Familiar Registrado');  location.href='fondo.php' </script>";
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


if($totalRows_empleado==0){
	echo "<script type=\"text/javascript\">alert ('Cedula no Registrada ');  location.href='registrar_familiar.php' </script>";
	exit;
}
	mysql_select_db($database_BD, $BD);
$query_familiares = "SELECT * FROM familiares where empleado='$_POST[cedula]'";
$familiares = mysql_query($query_familiares, $BD) or die(mysql_error());
$row_familiares = mysql_fetch_assoc($familiares);
$totalRows_familiares = mysql_num_rows($familiares);
	
	
if($totalRows_familiares==7){
	echo "<script type=\"text/javascript\">alert ('Ya este Empleado Posee 7 familiares ');  location.href='registrar_familiar.php' </script>";
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

		
	if(document.form1.cedula.value!=""){
			 var filtro = /^(\d)+$/i;
		      if (!filtro.test(document.getElementById('cedula2').value)){
				alert('SOLO PUEDE INGRESAR NUMEROS EN LA CEDULA DEL FAMILIAR');
				return false;
		   		}
				}
				
			
	if(document.form1.cedula.value!=""){
			 var filtro = /^(\d)+$/i;
		      if (!filtro.test(document.getElementById('edad').value)){
				alert('SOLO PUEDE INGRESAR NUMEROS EN LA EDAD DEL FAMILIAR');
				return false;
		   		}
				}
				
				
				if(document.form1.nombres2.value==""){
						alert("Ingrese el nombre y el apellido del Familiar");
						return false;
				}
				
				if(document.form1.edad.value==""){
						alert("Ingrese la edad del Familiar");
						return false;
				}
				
				
				

				
				
		}
</script>
<body>
<form action="<?php echo $editFormAction; ?>" onsubmit="return validar()" method="post" name="form1" id="form1">
  <table align="center" class="bordes">
    <tr valign="baseline">
      <td colspan="2" align="center" bgcolor="#a4e237" class="negrita">Registro de Familiares</td>
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
        <select name="nomina" id="nomina" disabled="disabled">
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
      <td><input name="cargo" type="text" id="cargo" value="<?php echo $row_empleado['cargo']; ?>" size="32" maxlength="20" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Departamento:</td>
      <td><label for="departamento"></label>
        <select name="departamento" id="departamento" disabled="disabled" >
          <option value="Informatica" <?php if (!(strcmp("Informatica", $row_empleado['departamento']))) {echo "selected=\"selected\"";} ?>>Informatica</option>
          <option value="Recursos Humanos" <?php if (!(strcmp("Recursos Humanos", $row_empleado['departamento']))) {echo "selected=\"selected\"";} ?>>Recursos Humanos</option>
          <option value="Tesoreria" <?php if (!(strcmp("Tesoreria", $row_empleado['departamento']))) {echo "selected=\"selected\"";} ?>>Tesoreria</option>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fecha de Ingreso:</td>
      <td><input name="fecha_ingreso" type="text" id="fecha_ingreso" value="<?php echo $row_empleado['fecha_ingreso']; ?>" size="20" maxlength="10" readonly="readonly" />
        </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefono:</td>
      <td><input name="telefono" type="text" value="<?php echo $row_empleado['telefono']; ?>" size="20" maxlength="11" readonly="readonly"/></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#a4e237" class="negrita">Ingrese el Familiar</td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#FFFFFF"><table width="554" align="center">
        <tr valign="baseline">
          <td align="right" nowrap="nowrap" class="negrita">N° de Familiares Actualemente:</td>
          <td><?=$totalRows_familiares;?></td>
        </tr>
        <tr valign="baseline">
          <td width="198" align="right" nowrap="nowrap" class="negrita">Nombres:</td>
          <td width="344"><input name="nombres2" type="text" value="" size="50" maxlength="30" /></td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap="nowrap" class="negrita">Cedula:</td>
          <td><input name="cedula2" id="cedula2" type="text" value="" size="15" maxlength="8" /></td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap="nowrap" class="negrita">Edad:</td>
          <td><input name="edad" id="edad" type="text" value="" size="5" maxlength="2" /></td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap="nowrap" class="negrita">Parentesco:</td>
          <td><label>
            <select name="parentesco" id="parentesco">
              <option value="Esposo(a)">Esposo(a)</option>
              <option value="Hijo(a)">Hijo(a)</option>
              <option value="Padre">Padre</option>
              <option value="Madre">Madre</option>
              <option value="Concubino(a)">Concubino(a)</option>
            </select>
          </label></td>
        </tr>
        <tr valign="baseline">
          <td align="right" nowrap="nowrap" valign="middle" class="negrita">Observaciones:</td>
          <td><textarea name="observaciones" cols="50" rows="5" onKeyDown="if(this.value.length &gt;= 300){ alert('Has superado el numero de caracteres permitido de este campo'); return false; }"></textarea></td>
        </tr>
      </table></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap" bgcolor="#a4e237"><input name="button" type="submit" class="negrita" id="button" value="Registrar Familiar" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>
    <input type="hidden" name="MM_insert" value="form2" />
  </p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($empleado);

mysql_free_result($familiares);
?>
