<?php
require_once "librerias/configuraciones.php";
if(isset($_SESSION["esta_autenticado"]) && $_SESSION["esta_autenticado"]=='si')
{
session_unset();
$_SESSION = array();
if (ini_get("session.use_cookies"))
{
$params = session_get_cookie_params();
setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}
session_destroy();
}
header("Location: index.php");
?>