<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_BD = "localhost";
$database_BD = "gobernacion";
$username_BD = "root";
$password_BD = "root";
$BD = mysql_pconnect($hostname_BD, $username_BD, $password_BD) or trigger_error(mysql_error(),E_USER_ERROR); 
?>