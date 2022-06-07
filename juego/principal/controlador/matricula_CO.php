<?php
require_once "../../librerias/configuraciones.php";
if ($_SESSION["usua_perfil"] !== "DOCENTE") {header("Location: salir.php");exit;}

require_once "../../librerias/servidor.php";
require_once "../modelo/matricula_MO.php";

$conexion     = new servidor();
$matricula_MO = new matricula_MO($conexion);

$bloque = $_GET["bloque"];

if ($bloque == "AGREGAR") {
    $curs_id     = $_POST["curs_id"];
    $usua_id_estudiante     = $_POST["usua_id_estudiante"];
    $matr_activo = "SI";

    $arreglo_matricula = array(
        'curs_id'     => $curs_id,
        'usua_id_estudiante'     => $usua_id_estudiante,
        'matr_activo' => $matr_activo,
    );

    $respuesta = $matricula_MO->agregar($arreglo_matricula);

    if ($respuesta) {
        $conexion->confirmar();
        echo "EXITO: Agregado";
    } else {
        $conexion->revertir();
        echo "ERROR: No Agregado";
    }

} else if ($bloque == "ACTUALIZAR") {
    $matr_id     = $_POST["matr_id"];
    $matr_activo = $_POST["matr_activo"];

    $arreglo_matricula = array(
        'matr_id'     => $matr_id,
        'matr_activo' => $matr_activo,
    );

    $respuesta = $matricula_MO->actualizar($arreglo_matricula);

    if ($respuesta) {
        $conexion->confirmar();
        echo "EXITO: Guardado";
    } else {
        $conexion->revertir();
        echo "ERROR: No Guardado";
    }
}
