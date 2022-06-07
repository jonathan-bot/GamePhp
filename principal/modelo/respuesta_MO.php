<?php
class respuesta_MO
{
	private $conexion;
	
	function __construct($conexion)
	{
		$this->conexion=$conexion;
	}

	function agregar($arreglo_respuesta)
	{
		$resp_descripcion=$arreglo_respuesta["resp_descripcion"];
		$resp_correcta=$arreglo_respuesta["resp_correcta"];
		$resp_activo=$arreglo_respuesta["resp_activo"];
		$resp_ruta_recurso=$arreglo_respuesta["resp_ruta_recurso"];
		$resp_tipo_recurso=$arreglo_respuesta["resp_tipo_recurso"];
		$preg_id=$arreglo_respuesta["preg_id"];
		
		$sql="INSERT INTO principal.respuesta
		  (
            resp_descripcion,
            resp_correcta,
            resp_activo,
            resp_ruta_recurso,
            resp_tipo_recurso,
            preg_id
		  )
		  VALUES(
		   '$resp_descripcion',
		   '$resp_correcta',
		   '$resp_activo',
		   '$resp_ruta_recurso',
		   '$resp_tipo_recurso',
		   '$preg_id'
		  )";

	    $this->conexion->consulta($sql);

	    return $this->conexion->filasAfectadas();
	}

	function actualizar($arreglo_respuesta)
	{
		$resp_id=$arreglo_respuesta["resp_id"];
		$resp_descripcion=$arreglo_respuesta["resp_descripcion"];
		$resp_activo=$arreglo_respuesta["resp_activo"];
		
		$sql="UPDATE principal.respuesta
		SET 
		resp_descripcion='$resp_descripcion',
		resp_activo='$resp_activo'
		WHERE resp_id='$resp_id'";

	    $this->conexion->consulta($sql);

	    return $this->conexion->filasAfectadas();
	}

    function seleccionar($resp_id)
	{
	  	$lista_arreglo=array(); 

		$sql="SELECT *
		      FROM principal.respuesta
		      WHERE resp_id='$resp_id'
		      ";

		$this->conexion->consulta($sql);

		while($row=$this->conexion->extraerRegistro())
		{ 	
		    $lista_arreglo[]=$row;
		}

		return $lista_arreglo;
	}

    function listar()
	{
	  	$lista_arreglo=array();

		$sql="SELECT *
		      FROM principal.respuesta
		      WHERE resp_activo='SI'
		      ";

		$this->conexion->consulta($sql);

		while($row=$this->conexion->extraerRegistro())
		{ 	
		    $lista_arreglo[]=$row;
		}

		return $lista_arreglo;
	}

    function paginar($tamano_pagina,$inicio,$busqueda="")
	{
	  	$lista_arreglo=array(); 

		if($busqueda=='0' || $busqueda)
		{
			$sql="
				  SELECT * 
				  FROM principal.respuesta
				  WHERE TEXT(resp_descripcion) ILIKE TEXT('%$busqueda%')
				  ORDER BY resp_descripcion LIMIT $tamano_pagina OFFSET $inicio";
		}	
		else
		{
			$sql="SELECT *
			      FROM principal.respuesta
			      ORDER BY resp_descripcion DESC LIMIT $tamano_pagina OFFSET $inicio";

		}

		$this->conexion->consulta($sql);

		while($row=$this->conexion->extraerRegistro())
		{ 	
		    $lista_arreglo[]=$row;
		}

		return $lista_arreglo;
	}		

	function totalPaginar($busqueda="")
	{  
	  	$NroRegistros=0; 


		if($busqueda=='0' || $busqueda)
		{
			$sql="SELECT count(resp_id) as total_registros
			      FROM principal.respuesta
				  WHERE TEXT(resp_descripcion) ILIKE TEXT('%$busqueda%')
				  ";
		}
		else
		{
			$sql="SELECT count(resp_id) as total_registros 
			      FROM principal.respuesta
				  ";
		}

		$this->conexion->consulta($sql);

		if($row=$this->conexion->extraerRegistro())
		{ 	
		    $NroRegistros=$row["total_registros"];
		}

		return $NroRegistros;
	}
}
?>