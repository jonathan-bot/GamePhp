<?php
class nivel_MO
{
	private $conexion;
	
	function __construct($conexion)
	{
		$this->conexion=$conexion;
	}

	function agregar($arreglo_nivel)
	{
		$nive_nombre=$arreglo_nivel["nive_nombre"];
		$nive_orden=$arreglo_nivel["nive_orden"];
		$nive_activo=$arreglo_nivel["nive_activo"];
		$nive_cantidad_pregunta=$arreglo_nivel["nive_cantidad_pregunta"];
		$nive_ruta_imagen=$arreglo_nivel["nive_ruta_imagen"];
		$curs_id=$arreglo_nivel["curs_id"];
		
		$sql="INSERT INTO principal.nivel
		  (
		  nive_nombre,
		  nive_orden,
		  nive_activo,
		  nive_cantidad_pregunta,
		  nive_ruta_imagen,
		  curs_id
		  )
		  VALUES(
		   '$nive_nombre',
		   '$nive_orden',
		   '$nive_activo',
		   '$nive_cantidad_pregunta',
		   '$nive_ruta_imagen',
		   '$curs_id'
		  )";

	    $this->conexion->consulta($sql);

	    return $this->conexion->filasAfectadas();
	}

	function actualizar($arreglo_nivel)
	{
		$nive_id=$arreglo_nivel["nive_id"];
		$nive_nombre=$arreglo_nivel["nive_nombre"];
		$nive_activo=$arreglo_nivel["nive_activo"];
		
		$sql="UPDATE principal.nivel
		SET 
		nive_nombre='$nive_nombre',
		nive_activo='$nive_activo'
		WHERE nive_id='$nive_id'";

	    $this->conexion->consulta($sql);

	    return $this->conexion->filasAfectadas();
	}

    function seleccionar($nive_id)
	{
	  	$lista_arreglo=array(); 

		$sql="SELECT *
		      FROM principal.nivel
		      WHERE nive_id='$nive_id'
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
		      FROM principal.nivel
		      WHERE nive_activo='SI'
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
				  FROM principal.nivel
				  WHERE TEXT(nive_nombre) ILIKE TEXT('%$busqueda%')
				  ORDER BY nive_nombre LIMIT $tamano_pagina OFFSET $inicio";
		}	
		else
		{
			$sql="SELECT *
			      FROM principal.nivel
			      ORDER BY nive_nombre DESC LIMIT $tamano_pagina OFFSET $inicio";

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
	  	$usua_id_docente=$_SESSION["usua_id"];

		if($busqueda=='0' || $busqueda)
		{
			$sql="SELECT count(nive_id) as total_registros
			      FROM principal.nivel
				  WHERE TEXT(nive_nombre) ILIKE TEXT('%$busqueda%')
				  ";
		}
		else
		{
			$sql="SELECT count(nive_id) as total_registros 
			      FROM principal.nivel
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