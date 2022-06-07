<?php
require_once "../../librerias/configuraciones.php";
if($_SESSION["usua_perfil"]!=="DOCENTE"){header("Location: salir.php");exit;}
                                        
require_once "../../librerias/servidor.php";
require_once "../modelo/nivelPregunta_MO.php";
require_once "../modelo/pregunta_MO.php";
require_once "../modelo/nivel_MO.php";

$conexion=new servidor();
$nivelPregunta_MO=new nivelPregunta_MO($conexion);
$nivel_MO=new nivel_MO($conexion);
$pregunta_MO=new pregunta_MO($conexion);

$bloque=$_GET["bloque"];

if($bloque=="AGREGAR")
{
    


     $nive_id= $_POST["nive_id"];
     $preg_id=$_POST["preg_id"];
     $nipr_activo=$_POST["nipr_activo"];

     $arreglo_nivelPregunta=array(
      'nive_id'=>$nive_id,
      'preg_id'=>$preg_id,
      'nipr_activo'=>$nipr_activo
     );

	 $respuesta=$nivelPregunta_MO->agregar($arreglo_nivelPregunta);

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

?>