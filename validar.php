<?php 
require_once "librerias/configuraciones.php";
require_once "librerias/servidor.php";

require_once "principal/modelo/usuario_MO.php";
require_once "principal/modelo/matricula_MO.php";
require_once "principal/modelo/estadistica_MO.php";

$conexion = new servidor();

$usuario_MO = new usuario_MO($conexion);
$matricula_MO = new matricula_MO($conexion);
$estadistica_MO = new estadistica_MO($conexion);

$usuario=$_POST['usuario'];
$clave=$_POST['clave'];

$arreglo_login=$usuario_MO->verificarLogin($usuario,$clave);

if(count($arreglo_login))
{
    $_SESSION["usua_id"]=$arreglo_login["usua_id"];
    $_SESSION["usua_perfil"]=$arreglo_login["usua_perfil"];
    $_SESSION["usua_nombre"]=$arreglo_login["usua_nombre"];
    
    if($arreglo_login["usua_perfil"]==="DOCENTE")
    {
        header("Location: principal/docente.php"); exit;
    }
    else if($arreglo_login["usua_perfil"]==="ESTUDIANTE")
    {
        $arreglo_matricula=$matricula_MO->verificarMatricula($arreglo_login["usua_id"]);
        
        if(count($arreglo_matricula))
        {
            $matr_id=$arreglo_matricula["matr_id"];
            $curs_id=$arreglo_matricula["curs_id"];

            $_SESSION["matr_id"]=$matr_id;
            $_SESSION["curs_id"]=$curs_id;

            $arreglo_estadistica=array(
                'curs_id'=>$curs_id,
                'usua_id_estudiante'=>$arreglo_login["usua_id"],
                'esta_fecha_ingreso'=>date('Y-m-d'),
                'esta_hora_ingreso'=>date('H:i')
            );
            
            $estado=$estadistica_MO->agregar($arreglo_estadistica);
            
            if($estado)
            {
                $conexion->confirmar();
            }
            else
            {
                $conexion->revertir();
            }
            
            header("Location: principal/estudiante.php"); exit;
        }
    }
    else
    {
        header("Location: salir.php");
        exit;
    }
}
else
{
    header("Location: salir.php");
    exit;
}
?>