<?php
class pregunta_MO
{
    private $conexion;

    function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    function agregar($arreglo_pregunta)
    {
        $preg_descripcion = $arreglo_pregunta["preg_descripcion"];
        $preg_activo = $arreglo_pregunta["preg_activo"];
        $preg_tipo_recurso = $arreglo_pregunta["preg_tipo_recurso"];
        $preg_ruta_recurso = $arreglo_pregunta["preg_ruta_recurso"];
        $usua_id = $arreglo_pregunta["usua_id"];

        $sql = "INSERT INTO principal.pregunta
		  (
            preg_descripcion,
            preg_activo,
            preg_tipo_recurso,
            preg_ruta_recurso,
            usua_id
		  )
		  VALUES(
		   '$preg_descripcion',
		   '$preg_activo',
		   '$preg_tipo_recurso',
		   '$preg_ruta_recurso',
		   '$usua_id'
		  )";

        $this->conexion->consulta($sql);

        return $this->conexion->filasAfectadas();
    }
   
    function actualizar($arreglo_pregunta)
    {
        $preg_id = $arreglo_pregunta["preg_id"];
        $preg_descripcion = $arreglo_pregunta["preg_descripcion"];
        $preg_activo = $arreglo_pregunta["preg_activo"];

        $sql = "UPDATE principal.pregunta
		SET 
		preg_descripcion='$preg_descripcion',
		preg_activo='$preg_activo'
		WHERE preg_id='$preg_id'";

        $this->conexion->consulta($sql);

        return $this->conexion->filasAfectadas();
    }

    function seleccionar($preg_id)
    {
        $lista_arreglo = array();

        $sql = "SELECT *
		      FROM principal.pregunta
		      WHERE preg_id='$preg_id'
		      ";

        $this->conexion->consulta($sql);

        while ($row = $this->conexion->extraerRegistro()) {
            $lista_arreglo[] = $row;
        }

        return $lista_arreglo;
    }

    function listar()
    {
        $lista_arreglo = array();

        $sql = "SELECT *
		      FROM principal.pregunta
		      WHERE preg_activo='SI'
		      ";

        $this->conexion->consulta($sql);

        while ($row = $this->conexion->extraerRegistro()) {
            $lista_arreglo[] = $row;
        }

        return $lista_arreglo;
    }

    function paginar($tamano_pagina, $inicio, $busqueda = "")
    {
        $lista_arreglo = array();

        if ($busqueda == '0' || $busqueda) {
            $sql = "
				  SELECT * 
				  FROM principal.pregunta
				  WHERE TEXT(preg_descripcion) ILIKE TEXT('%$busqueda%')
				  ORDER BY preg_descripcion LIMIT $tamano_pagina OFFSET $inicio";
        } else {
            $sql = "SELECT *
			      FROM principal.pregunta
			      ORDER BY preg_descripcion DESC LIMIT $tamano_pagina OFFSET $inicio";
        }

        $this->conexion->consulta($sql);

        while ($row = $this->conexion->extraerRegistro()) {
            $lista_arreglo[] = $row;
        }

        return $lista_arreglo;
    }

    function totalPaginar($busqueda = "")
    {
        $NroRegistros = 0;
        $usua_id_docente = $_SESSION["usua_id"];

        if ($busqueda == '0' || $busqueda) {
            $sql = "SELECT count(preg_id) as total_registros
			      FROM principal.pregunta
				  WHERE TEXT(preg_descripcion) ILIKE TEXT('%$busqueda%')
				  ";
        } else {
            $sql = "SELECT count(preg_id) as total_registros 
			      FROM principal.pregunta
				  ";
        }

        $this->conexion->consulta($sql);

        if ($row = $this->conexion->extraerRegistro()) {
            $NroRegistros = $row["total_registros"];
        }

        return $NroRegistros;
    }
}
