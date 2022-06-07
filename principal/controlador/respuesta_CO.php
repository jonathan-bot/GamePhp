<?php
require_once "../../librerias/configuraciones.php";
if($_SESSION["usua_perfil"]!=="DOCENTE"){header("Location: salir.php");exit;}
                                        
require_once "../../librerias/servidor.php";
require_once "../modelo/respuesta_MO.php";

$conexion=new servidor();
$respuesta_MO=new respuesta_MO($conexion);

$bloque=$_GET["bloque"];

if($bloque=="AGREGAR")
{
     $resp_descripcion=$_POST["resp_descripcion"];
     $resp_correcta=$_POST["resp_correcta"];
     $resp_activo=$_POST["resp_activo"];
     $resp_ruta_recurso=$_POST["resp_ruta_recurso"];
     $resp_tipo_recurso=$_POST["resp_tipo_recurso"];
     $preg_id=$_POST["preg_id"];

     $arreglo_respuesta=array(
      'resp_descripcion'=>$resp_descripcion,
      'resp_correcta'=>$resp_correcta,
      'resp_activo'=>$resp_activo,
      'resp_ruta_recurso'=>$resp_ruta_recurso,
      'resp_tipo_recurso'=>$resp_tipo_recurso,
      'preg_id'=>$preg_id,
     );

	 $respuesta=$respuesta_MO->agregar($arreglo_respuesta);

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
  
     $resp_id=$_POST["resp_id"];
     $resp_descripcion=$_POST["resp_descripcion"];
     $resp_activo=$_POST["resp_activo"];

     $arreglo_respuesta=array(
      'resp_id'=>$resp_id,
      'resp_descripcion'=>$resp_descripcion,
      'resp_activo'=>$resp_activo
     );

      $respuesta=$respuesta_MO->actualizar($arreglo_respuesta);

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