<?php 
class servidor
{
    private $conexion;
    private $resultado;
    function __construct(){
        $this->conectarBaseDatos();
        $this->consulta("BEGIN");
    }

    private function conectarBaseDatos(){
        $user = "rol_all";
        $pass = "rol_all_2019";
        $host = "localhost";
        $db = "juego";
        $puerto = "5432";
        $this->conexion=pg_connect("host=$host dbname=$db user=$user password=$pass port=$puerto") or die ("Ocurre algo en la conexi&oacute;n");
    }

    function consulta($consulta){
        $this->resultado=pg_query($this->conexion,$consulta) or die("Ocurre algo en la consulta");
    }

    function extraerRegistro(){
        if($fila=pg_fetch_assoc($this->resultado)){
            return $fila;
        }else{
            return false;
        }
    }

    function filasAfectadas()
    {
        if(pg_affected_rows($this->resultado)){
            return true;
        }
        else{
            return false;
        }
    }

    function confirmar(){
        $this->consulta("COMMIT");
        $this->cerrar();
    }

    function revertir(){
        $this->consulta("ROLLBACK");
        $this->cerrar();
    }

    function cerrar(){
        pg_close($this->conexion);
    }

}

?>