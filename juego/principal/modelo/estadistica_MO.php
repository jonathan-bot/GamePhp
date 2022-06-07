<?php
class estadistica_MO
{
    private $conexion;
    function __construct($conexion)
    {
        $this->conexion=$conexion;
    }
    function agregar($arreglo_estadistica)
    {
        $curs_id=$arreglo_estadistica["curs_id"];
        $usua_id_estudiante=$arreglo_estadistica["usua_id_estudiante"];
        $esta_fecha_ingreso=$arreglo_estadistica["esta_fecha_ingreso"];
        $esta_hora_ingreso=$arreglo_estadistica["esta_hora_ingreso"];
        
        $sql="INSERT INTO principal.estadistica(curs_id,usua_id_estudiante,esta_fecha_ingreso,esta_hora_ingreso) VALUES('$curs_id','$usua_id_estudiante','$esta_fecha_ingreso','$esta_hora_ingreso')";
        
        $this->conexion->consulta($sql);
        
        return $this->conexion->filasAfectadas();
    }
}
?>