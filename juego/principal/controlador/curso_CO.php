<?php
require_once "../../librerias/configuraciones.php";
if($_SESSION["usua_perfil"]!=="DOCENTE"){header("Location: salir.php");exit;}
                                        
require_once "../../librerias/servidor.php";
require_once "../modelo/curso_MO.php";

$conexion=new servidor();
$curso_MO=new curso_MO($conexion);

$bloque=$_GET["bloque"];

if($bloque=="AGREGAR")
{
     $curs_nombre= $_POST["curs_nombre"];
     $curs_fecha_creacion=date('Y-m-d');
     $curs_activo="SI";
     $usua_id_docente= $_SESSION["usua_id"];

     $arreglo_curso=array(
      'curs_nombre'=>$curs_nombre,
      'curs_fecha_creacion'=>$curs_fecha_creacion,
      'curs_activo'=>$curs_activo,
      'usua_id_docente'=>$usua_id_docente
     );

	 $respuesta=$curso_MO->agregar($arreglo_curso);

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
     $curs_id= $_POST["curs_id"];
     $curs_nombre= $_POST["curs_nombre"];
     $curs_activo= $_POST["curs_activo"];

     $arreglo_curso=array(
      'curs_id'=>$curs_id,
      'curs_nombre'=>$curs_nombre,
      'curs_activo'=>$curs_activo
     );

      $respuesta=$curso_MO->actualizar($arreglo_curso);

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