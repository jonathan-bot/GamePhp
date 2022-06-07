<?php
require_once "../../librerias/configuraciones.php";
if($_SESSION["usua_perfil"]!=="DOCENTE"){header("Location: salir.php");exit;}
                                        
require_once "../../librerias/servidor.php";
require_once "../modelo/usuario_MO.php";

$conexion=new servidor();
$usuario_MO=new usuario_MO($conexion);

$bloque=$_GET["bloque"];

if($bloque=="AGREGAR")
{
     $usua_nombre= $_POST["usua_nombre"];
     $usua_genero=$_POST["usua_genero"];
     $usua_perfil=$_POST["usua_perfil"];

     $arreglo_usuario=array(
      'usua_nombre'=>$usua_nombre,
      'usua_genero'=>$usua_genero,
      'usua_perfil'=>$usua_perfil,
     );

	 $respuesta=$usuario_MO->agregar($arreglo_usuario);

     if($respuesta)
     {
     	$conexion->confirmar();
        echo "EXITO: Agregado";
     }
     else
     {
		$conexion->revertir();
        echo "ERROR: No Agregado";
     }

}
else if($bloque=="ACTUALIZAR")
{
     $usua_id= $_POST["usua_id"];
     $usua_nombre= $_POST["usua_nombre"];
     $usua_perfil= $_POST["usua_perfil"];

     $arreglo_usuario=array(
      'usua_id'=>$usua_id,
      'usua_nombre'=>$usua_nombre,
      'usua_perfil'=>$usua_perfil
     );

      $respuesta=$usuario_MO->actualizar($arreglo_usuario);

  if($respuesta)
     {
     	$conexion->confirmar();
        echo "EXITO: Guardado";
     }
     else
     {
		$conexion->revertir();
        echo "ERROR: No Guardado";
     }
}
?>