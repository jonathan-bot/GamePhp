<?php
class curso_MO
{
	private $conexion;
	
	function __construct($conexion)
	{
		$this->conexion=$conexion;
	}
	
    function agregar($arreglo_curso)
	{
		$curs_nombre=$arreglo_curso["curs_nombre"];
		$curs_fecha_creacion=$arreglo_curso["curs_fecha_creacion"];
		$curs_activo=$arreglo_curso["curs_activo"];
		$usua_id_docente=$arreglo_curso["usua_id_docente"];


		$arreglo=array();
        $sql="SELECT * FROM principal.curso WHERE curs_nombre='$curs_nombre'";
        $this->conexion->consulta($sql);
        if($row=$this->conexion->extraerRegistro())
        {
            $arreglo=$row;
        }
        if(count($arreglo)==0){
            
       
		$sql="INSERT INTO principal.curso
		  (
		  curs_nombre,
		  curs_fecha_creacion,
		  curs_activo,
		  usua_id_docente
		  )
		  VALUES(
		   '$curs_nombre',
		   '$curs_fecha_creacion',
		   '$curs_activo',
		   '$usua_id_docente'
		  )";

	    $this->conexion->consulta($sql);

	    return $this->conexion->filasAfectadas();
	}else{
            return false;
        }
    }

	function actualizar($arreglo_curso)
	{
		$curs_id=$arreglo_curso["curs_id"];
		$curs_nombre=$arreglo_curso["curs_nombre"];
		$curs_activo=$arreglo_curso["curs_activo"];
		
		$sql="UPDATE principal.curso
		SET 
		curs_nombre='$curs_nombre',
		curs_activo='$curs_activo'
		WHERE curs_id='$curs_id'";

	    $this->conexion->consulta($sql);

	    return $this->conexion->filasAfectadas();
	}

    function seleccionar($curs_id)
	{
	  	$lista_arreglo=array(); 

		$sql="SELECT *
		      FROM principal.curso
		      WHERE curs_id='$curs_id'
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
	  	$usua_id_docente=$_SESSION["usua_id"];

		$sql="SELECT *
		      FROM principal.curso
		      WHERE usua_id_docente='$usua_id_docente'
		      AND curs_activo='SI'
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
	  	$usua_id_docente=$_SESSION["usua_id"];

		if($busqueda=='0' || $busqueda)
		{
			$sql="
				  SELECT * 
				  FROM principal.curso
				  WHERE TEXT(curs_nombre) ILIKE TEXT('%$busqueda%')
				  AND usua_id_docente='$usua_id_docente'
				  ORDER BY curs_nombre LIMIT $tamano_pagina OFFSET $inicio";
		}	
		else
		{
			$sql="SELECT *
			      FROM principal.curso
			      WHERE usua_id_docente='$usua_id_docente'
			      ORDER BY curs_nombre DESC LIMIT $tamano_pagina OFFSET $inicio";

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
			$sql="SELECT count(curs_id) as total_registros
			      FROM principal.curso
				  WHERE TEXT(curs_nombre) ILIKE TEXT('%$busqueda%')
				  AND usua_id_docente='$usua_id_docente'
				  ";
		}
		else
		{
			$sql="SELECT count(curs_id) as total_registros 
			      FROM principal.curso
			      WHERE usua_id_docente='$usua_id_docente'
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