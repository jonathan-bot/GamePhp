<?php
class usuario_MO
{
    private $conexion;
    function __construct($conexion)
    {
        $this->conexion=$conexion;
    }
    function verificarLogin($usuario,$clave)
    {
        $arreglo=array();
        $sql="SELECT * FROM principal.usuario WHERE usua_nombre='$usuario' AND usua_clave='$clave'";
        $this->conexion->consulta($sql);
        if($row=$this->conexion->extraerRegistro())
        {
            $arreglo=$row;
        }
        return $arreglo;
    }

    function agregar($arreglo_usuario)
    {
        $usua_nombre=$arreglo_usuario["usua_nombre"];
        $usua_genero=$arreglo_usuario["usua_genero"];
        $usua_perfil=$arreglo_usuario["usua_perfil"];
        
        $sql="INSERT INTO principal.usuario
          (
          usua_nombre,
          usua_genero,
          usua_perfil,
          usua_clave
          )
          VALUES(
           '$usua_nombre',
           '$usua_genero',
           '$usua_perfil',
           '$usua_nombre'
          )";

        $this->conexion->consulta($sql);

        return $this->conexion->filasAfectadas();
    }

    function actualizar($arreglo_usuario)
    {
        $usua_id=$arreglo_usuario["usua_id"];
        $usua_nombre=$arreglo_usuario["usua_nombre"];
        $usua_perfil=$arreglo_usuario["usua_perfil"];
        
        $sql="UPDATE principal.usuario
        SET 
        usua_nombre='$usua_nombre',
        usua_perfil='$usua_perfil'
        WHERE usua_id='$usua_id'";

        $this->conexion->consulta($sql);

        return $this->conexion->filasAfectadas();
    }

    function seleccionar($usua_id)
    {
        $lista_arreglo=array(); 

        $sql="SELECT *
              FROM principal.usuario
              WHERE usua_id='$usua_id'
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
              FROM principal.usuario
              ";

        $this->conexion->consulta($sql);

        while($row=$this->conexion->extraerRegistro())
        {   
            $lista_arreglo[]=$row;
        }

        return $lista_arreglo;
    }
    function listarEstudiante()
    {
        $lista_arreglo=array();

        $sql="SELECT *
              FROM principal.usuario
              WHERE usua_perfil='ESTUDIANTE'
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
                  FROM principal.usuario
                  WHERE TEXT(usua_nombre) ILIKE TEXT('%$busqueda%')
                  ORDER BY usua_nombre LIMIT $tamano_pagina OFFSET $inicio";
        }   
        else
        {
            $sql="SELECT *
                  FROM principal.usuario
                  ORDER BY usua_nombre DESC LIMIT $tamano_pagina OFFSET $inicio";

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
            $sql="SELECT count(usua_id) as total_registros
                  FROM principal.usuario
                  WHERE TEXT(usua_nombre) ILIKE TEXT('%$busqueda%')
                  ";
        }
        else
        {
            $sql="SELECT count(usua_id) as total_registros 
                  FROM principal.usuario
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