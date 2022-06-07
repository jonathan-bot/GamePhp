<?php
class matricula_MO
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    function agregar($arreglo_matricula)
    {
        $arreglo = array();
        $curs_id=$arreglo_matricula["curs_id"];
        $usua_id_estudiante=$arreglo_matricula["usua_id_estudiante"];
        $matr_activo=$arreglo_matricula["matr_activo"];
        
        $sql="SELECT * FROM principal.matricula WHERE usua_id_estudiante='$usua_id_estudiante' AND curs_id='$curs_id'";

        $this->conexion->consulta($sql);
        while ($row = $this->conexion->extraerRegistro()) {
            $arreglo = $row;
        }

        if(!count($arreglo)){

            $sql="INSERT INTO principal.matricula
              (
              curs_id,
              usua_id_estudiante,
              matr_activo
              )
              VALUES(
               '$curs_id',
               '$usua_id_estudiante',
               '$matr_activo'
              )";

            $this->conexion->consulta($sql);

            return $this->conexion->filasAfectadas();
        }
    }

    public function verificarMatricula($usua_id)
    {
        $arreglo = array();
        $sql     = "SELECT m.* FROM principal.matricula m, principal.curso c WHERE m.usua_id_estudiante='$usua_id' AND m.matr_activo='SI' AND c.curs_activo='SI' AND m.curs_id=c.curs_id";
        $this->conexion->consulta($sql);
        while ($row = $this->conexion->extraerRegistro()) {
            $arreglo = $row;
        }
        return $arreglo;
    }

    public function paginar($tamano_pagina, $inicio, $busqueda = "")
    {
        $lista_arreglo = array();

        if ($busqueda == '0' || $busqueda) {
            $sql = "
                  SELECT *
                  FROM principal.matricula m, principal.usuario u, principal.curso c
                  WHERE TEXT(usua_nombre) ILIKE TEXT('%$busqueda%')
                  AND m.usua_id_estudiante=u.usua_id AND m.curs_id=c.curs_id
                  ORDER BY c.curs_nombre LIMIT $tamano_pagina OFFSET $inicio";
        } else {
            $sql = "SELECT *
                  FROM principal.matricula m, principal.usuario u, principal.curso c
                  WHERE m.usua_id_estudiante=u.usua_id AND m.curs_id=c.curs_id
                  ORDER BY c.curs_nombre DESC LIMIT $tamano_pagina OFFSET $inicio";

        }

        $this->conexion->consulta($sql);

        while ($row = $this->conexion->extraerRegistro()) {
            $lista_arreglo[] = $row;
        }

        return $lista_arreglo;
    }

    public function totalPaginar($busqueda = "")
    {
        $NroRegistros = 0;

        if ($busqueda == '0' || $busqueda) {
            $sql = "SELECT count(matr_id) as total_registros
                  FROM principal.matricula m, principal.usuario u, principal.curso c
                  WHERE TEXT(usua_nombre) ILIKE TEXT('%$busqueda%')
                  AND m.usua_id_estudiante=u.usua_id AND m.curs_id=c.curs_id
                  ";
        } else {
            $sql = "SELECT count(matr_id) as total_registros
                  FROM principal.matricula m, principal.usuario u, principal.curso c
                  WHERE m.usua_id_estudiante=u.usua_id AND m.curs_id=c.curs_id
                  ";
        }

        $this->conexion->consulta($sql);

        if ($row = $this->conexion->extraerRegistro()) {
            $NroRegistros = $row["total_registros"];
        }

        return $NroRegistros;
    }

    public function seleccionar($matr_id)
    {
        $lista_arreglo = array();

        $sql = "SELECT *
              FROM principal.matricula m, principal.usuario u
              WHERE m.matr_id='$matr_id' AND m.usua_id_estudiante=u.usua_id
              ";

        $this->conexion->consulta($sql);

        while ($row = $this->conexion->extraerRegistro()) {
            $lista_arreglo[] = $row;
        }

        return $lista_arreglo;
    }

    public function actualizar($arreglo_matricula)
    {
        $matr_id     = $arreglo_matricula["matr_id"];
        $matr_activo = $arreglo_matricula["matr_activo"];

        $sql = "UPDATE principal.matricula
        SET
        matr_activo='$matr_activo'
        WHERE matr_id='$matr_id'";

        $this->conexion->consulta($sql);

        return $this->conexion->filasAfectadas();
    }
}
