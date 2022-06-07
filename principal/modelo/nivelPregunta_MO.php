<?php
class nivelPregunta_MO
{
	private $conexion;
	
	function __construct($conexion)
	{
		$this->conexion=$conexion;
	}

        
    function agregar($arreglo_nivelPregunta)
    {
        $nive_id=$arreglo_nivelPregunta["nive_id"];
        $preg_id=$arreglo_nivelPregunta["preg_id"];
        $nipr_activo=$arreglo_nivelPregunta["nipr_activo"];
        
        
        $sql="INSERT INTO principal.nivel_pregunta
          (
          nive_id,
          preg_id,
          nipr_activo

          
          )
          VALUES(
           '$nive_id',
           '$preg_id',
           '$nipr_activo'
          )";

        $this->conexion->consulta($sql);

        return $this->conexion->filasAfectadas();
    }


    function paginar($tamano_pagina,$inicio,$busqueda="")
	{
	  	$lista_arreglo=array(); 

		if($busqueda=='0' || $busqueda)
		{
			$sql="
				  SELECT * 
				  FROM principal.nivel_pregunta
				  WHERE TEXT(nive_id) ILIKE TEXT('%$busqueda%')
				  ORDER BY nive_id LIMIT $tamano_pagina OFFSET $inicio";
		}	
		else
		{
			$sql="SELECT *
			      FROM principal.nivel_pregunta
			      ORDER BY nive_id DESC LIMIT $tamano_pagina OFFSET $inicio";

		}

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
		      FROM principal.nivel_pregunta
		      WHERE nive_activo='SI'
		      ";

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
			$sql="SELECT count(nipr_id) as total_registros
			      FROM principal.nivel_pregunta
				  WHERE TEXT(nive_id) ILIKE TEXT('%$busqueda%')
				  ";
		}
		else
		{
			$sql="SELECT count(nipr_id) as total_registros 
			      FROM principal.nivel_pregunta
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