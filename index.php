<?php require_once('Connections/BD.php'); ?>
<?php
session_start();

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

//recepcion de datos
$usuario= $_POST["usuario"];
$contrasena= $_POST["clave"];

mysql_select_db($database_BD, $BD);
//ejecucuion de la sentemcia sql
$sql="select usuario from usuario where usuario='$usuario' and clave='$contrasena'";
$resultado= mysql_query($sql)or die(mysql_error());
$fila=mysql_fetch_array($resultado);

//verificar si  son validos los datos
if($fila["usuario"]!=$usuario){
echo "<script type=\"text/javascript\">alert ('Usted no es un usuario registrado');  location.href='index.php' </script>";
exit;
}
else{

setcookie("usr",$usuario,time()+7776000);
setcookie("clv",$contrasena,time()+7776000);

$_SESSION["usu"]=$fila["usuario"];


if (isset($_SESSION["usu"])){
header("Location:inicio.php");
}else{
echo "<script type=\"text/javascript\">alert ('Ocurrio un error vuelva a iniciar sesion');  location.href='index.php' </script>";
exit;
}
}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0155)http://webcache.googleusercontent.com/search?q=cache:OSe-XuxLYKoJ:www.me.gob.ve/+ministerio+de+educacion+venezuela&cd=1&hl=es&ct=clnk&source=www.google.com -->
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>GOBERNACION INDIGENA DEL ESTADO AMAZONAS</title>
<!--<base href="http://www.me.gob.ve/index.php">-->
<base href="." />
<script language="JavaScript">
<!--
function mmLoadMenus() {
  if (window.mm_menu_0503104418_0) return;
              window.mm_menu_0503104418_0 = new Menu("root",77,18,"",12,"#000000","#FFFFFF","#CCCCCC","#000084","left","middle",3,0,1000,-5,7,true,false,true,0,true,true);
  mm_menu_0503104418_0.addMenuItem("Registro","location='Principal.php?link=link7'");
  mm_menu_0503104418_0.addMenuItem("Consulta","location='Principal.php?link=link71'");
   mm_menu_0503104418_0.hideOnMouseOut=true;
   mm_menu_0503104418_0.bgColor='#555555';
   mm_menu_0503104418_0.menuBorder=1;
   mm_menu_0503104418_0.menuLiteBgColor='#FFFFFF';
   mm_menu_0503104418_0.menuBorderBgColor='#777777';

mm_menu_0503104418_0.writeMenus();
} // mmLoadMenus()
//-->
</script>
<script language="JavaScript" src="mm_menu.js"></script>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo2 {color: #5a7210}
.Estilo3 {	color: #FFFFFF;
	font-style: italic;
	font-weight: bold;
}
.navenlace {	
	padding:1px;
	margin-top: 1;
	margin-right: 0;
	margin-bottom: 1;
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
</head>
<script language="javascript">
<!--
function validar(){


		   if(document.form1.usuario.value==""){
		   alert("DEBE INGRESAR UN USUARIO");
		   return false;
		   }
		    if(document.form1.clave.value==""){
		   alert("DEBE INGRESAR UNA CLAVE");
		   return false;
		   }
		  
   }
   
//-->
</script>
<body marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" background="imagenes/fondo.jpg" >

<script language="JavaScript1.2">mmLoadMenus();
ventana=windows.open("principal.php");
</script>
<div style="margin:-1px -1px 0;padding:0;border:1px solid #999;background:#fff"></div>
<table width="776" border="0" align="center" cellpadding="0" cellspacing="0" class="bordes">
  <tbody>
    <tr>
      <td height="28" colspan="3"><img src="imagenes/cintillo_gobernacion.jpg" width="844" height="127" /></td>
    </tr>
    <tr>
      <td width="4" height="450" class="fondo" background="imagenes/border_left.jpg"></td>
      <td class="fondo" width="769" valign="top"><!--  Contenido  -->
          <table border="0" cellpadding="0"  cellspacing="0" width="98%">
            <tbody>
              <tr>
                <td width="746"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                      <tr>
                        <td><table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                              <tr>
                                <td><!-- Columna de Contenido Izquierda -->
                                    <script type="text/javascript" src="imagenes/functions.js"></script>
                                    <script type="text/javascript" src="imagenes/menu.js"></script>
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                      <tbody>
                                        <tr>
                                          <!--	<td class="barra" width="205">
								   	<a href="http://www.portaleducativo.edu.ve" class="bar" target="blank">Portal Educativo</a>
								  	<a href="http://renadit.me.gob.ve" class="bar" target="blank">Renadit</a>
								 		<a href="http://www.ind.gov.ve" class="bar" target="blank">IND</a>
								 		<a href="contenido.php?id_seccion=29" class="bar">Más enlaces...</a>
								  </td>	-->
                                          <td width="141" bgcolor="#a4e237" ><br />                                          </td>
                                          <td width="49" bgcolor="#a4e237" ></td>
                                          <td width="564"  align="right" bgcolor="#a4e237" >&nbsp;</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  <!-- Columna de Contenido Izquierda -->                                </td>
                              </tr>
                              <tr>
                                <td height="374" valign="top" ><!-- Columna de Contenido Izquierda -->
                                    <table border="0" bgcolor="#FFFFFF" width="178" cellpadding="0" cellspacing="0">
                                      <tbody>
                                        <tr>
                                          <td width="178" height="5"></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <form id="form1" name="form1" onsubmit="return validar()" method="post" action="<?php echo $editFormAction; ?>">
                                      <p align="center">&nbsp;</p>
                                      <p align="center">&nbsp;</p>
                                      <table width="35%" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr bgcolor="#FFFFFF">
                                          <th colspan="2" bgcolor="#2099ac" scope="col">&nbsp;</th>
                                        </tr>
                                        <tr bgcolor="#CCCCCC">
                                          <th colspan="2" bgcolor="#2099ac" scope="col"><span class="Estilo1">Ingreso al Sistema</span></th>
                                        </tr>
                                        <tr bgcolor="#CCCCCC">
                                          <td width="33%" bgcolor="#2099ac"><div align="right" class="Estilo1">Usuario:</div></td>
                                          <td width="67%" bgcolor="#2099ac"><label>
                                            <input name="usuario" type="text" id="usuario" maxlength="10" />
                                          </label></td>
                                        </tr>
                                        <tr bgcolor="#CCCCCC">
                                          <td bgcolor="#2099ac"><div align="right" class="Estilo1">Clave:</div></td>
                                          <td bgcolor="#2099ac"><input name="clave" type="password" id="clave" maxlength="10" /></td>
                                        </tr>
                                        <tr bgcolor="#CCCCCC">
                                          <td height="28" colspan="2" bgcolor="#2099ac"><div align="center">
                                            <input type="submit" name="Submit2" value="Validar" />
                                          </div></td>
                                        </tr>
                                        <tr bgcolor="#FFFFFF">
                                          <td height="20" colspan="2" bgcolor="#2099ac">&nbsp;</td>
                                        </tr>
                                      </table>
                                      <p align="center">
                                        <input type="hidden" name="MM_insert" value="form1" />
                                      </p>
                                    </form>
                                    <!-- Fin de Columna de Contenido Izquierda -->                                <!-- Columna de Contenido Central -->
                                    <!-- Fin de Columna de Contenido Central --></td>
                              </tr>
                            </tbody>
                        </table></td>
                      </tr>
                    </tbody>
                </table></td>
              </tr>
            </tbody>
          </table>
        <!--  Fin del Contenido  -->
      </td>
      <td width="7" height="450" class="fondo" background="imagenes/border_right.jpg"></td>
    </tr>
    <tr>
      <td colspan="3"><div align="center"></div></td>
    </tr>
    <tr>
      <td height="2" colspan="3"><!--  Footer  -->
          <table border="0" width="100%" cellpadding="0" cellspacing="0">
            <tbody>
              <tr>
                <td align="center" class="footer"><!-- <a href="mailto://webmaster@me.gob.ve" class="foot">webmaster@me.gob.ve</a> -->
                </td>
              </tr>
            </tbody>
          </table>
        <!-- Fin Footer-->
      </td>
    </tr>
  </tbody>
</table>
<p>&nbsp;</p>
</body></html>