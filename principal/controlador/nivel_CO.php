<?php
require_once "../../librerias/configuraciones.php";
if($_SESSION["usua_perfil"]!=="DOCENTE"){header("Location: salir.php");exit;}
                                        
require_once "../../librerias/servidor.php";
require_once "../modelo/nivel_MO.php";

$conexion=new servidor();
$nivel_MO=new nivel_MO($conexion);

$bloque=$_GET["bloque"];

if($bloque=="AGREGAR")
{
     $nive_nombre= $_POST["nive_nombre"];
     $nive_orden=$_POST["nive_orden"];
     $nive_activo=$_POST["nive_activo"];
     $nive_cantidad_pregunta=$_POST["nive_cantidad_pregunta"];
     $nive_ruta_imagen=$_POST["nive_ruta_imagen"];
     $curs_id=$_POST["curs_id"];

     $arreglo_nivel=array(
      'nive_nombre'=>$nive_nombre,
      'nive_orden'=>$nive_orden,
      'nive_activo'=>$nive_activo,
      'nive_cantidad_pregunta'=>$nive_cantidad_pregunta,
      'nive_ruta_imagen'=>$nive_ruta_imagen,
      'curs_id'=>$curs_id,
     );

	 $respuesta=$nivel_MO->agregar($arreglo_nivel);

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
     $nive_id= $_POST["nive_id"];
     $nive_nombre= $_POST["nive_nombre"];
     $nive_activo= $_POST["nive_activo"];

     $arreglo_nivel=array(
      'nive_id'=>$nive_id,
      'nive_nombre'=>$nive_nombre,
      'nive_activo'=>$nive_activo
     );

      $respuesta=$nivel_MO->actualizar($arreglo_nivel);

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