<?php
session_name("JUEGO");
session_start();
date_default_timezone_set('America/Bogota');
setlocale(LC_ALL,"es_ES@euro","es_CO","esp");
header('X-FRAME-OPTIONS: DENY');
/****************************************************************/
$modo="MODO_DESARROLLO";//MODO_PRODUCCION
if($modo=="MODO_DESARROLLO")
{
    //error_reporting(E_ALL & ~E_NOTICE);
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}
else if($modo=="MODO_PRODUCCION")
{
    error_reporting(0);
    ini_set('display_errors', 'Off');
}
/****************************************************************/
?>