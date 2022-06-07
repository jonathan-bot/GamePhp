<?php
require_once "../../librerias/configuraciones.php";
if($_SESSION["usua_perfil"]!=="DOCENTE"){header("Location: salir.php");exit;}
                                        
require_once "../../librerias/servidor.php";
require_once "../modelo/pregunta_MO.php";
require_once "../modelo/nivel_MO.php";


$conexion=new servidor();
$pregunta_MO=new pregunta_MO($conexion);
$nivel_MO=new nivel_MO($conexion);


$bloque=$_GET["bloque"];

if($bloque=="AGREGAR")
{
     $preg_descripcion= $_POST["preg_descripcion"];
     $preg_activo=$_POST["preg_activo"];
     $preg_tipo_recurso=$_POST["preg_tipo_recurso"];
     $preg_ruta_recurso=$_POST["preg_ruta_recurso"];
     $usua_id= $_SESSION["usua_id"];

     $arreglo_pregunta=array(
      'preg_descripcion'=>$preg_descripcion,
      'preg_activo'=>$preg_activo,
      'preg_tipo_recurso'=>$preg_tipo_recurso,
      'preg_ruta_recurso'=>$preg_ruta_recurso,
      'usua_id'=>$usua_id
     );

	 $respuesta=$pregunta_MO->agregar($arreglo_pregunta);

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
     $preg_id= $_POST["preg_id"];
     $preg_descripcion= $_POST["preg_descripcion"];
     $preg_activo= $_POST["preg_activo"];

     $arreglo_pregunta=array(
      'preg_id'=>$preg_id,
      'preg_descripcion'=>$preg_descripcion,
      'preg_activo'=>$preg_activo
     );

      $respuesta=$pregunta_MO->actualizar($arreglo_pregunta);

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