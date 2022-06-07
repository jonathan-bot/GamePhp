<?php
require_once "../../librerias/configuraciones.php";
if($_SESSION["usua_perfil"]!=="DOCENTE"){header("Location: salir.php");exit;}

require_once "../../librerias/servidor.php";
require_once "../modelo/usuario_MO.php";

$conexion=new servidor();
$usuario_MO=new usuario_MO($conexion);

$bloque=$_GET["bloque"];

if($bloque=="INICIO")
{
	?>
    <div class="card">

	    <div class="card-header text-light bg-danger"><span class="fa fa-address-book"></span> Usuarios </div>

	        <div class="card-body">
	        
	           <form id="formulario_agregar" role="form" autocomplete="off" action="return false;">
	           
	           <div class="row">
	           
	             <div class="col-md-12">
	               <div class="form-group">
	               <label for="usua_nombre"> Nombre </label>
	               <input type="text" class="form-control" name="usua_nombre" id="usua_nombre" maxlength="200">
	               </div>
	             </div>
	             <div class="col-md-12">
	               <div class="form-group">
	               <label for="usua_genero"> Genero </label>
	               <select class="form-control" data-validar="O" name="usua_genero" id="usua_genero">
	                   <option value="MASCULINO">MASCULINO</option>
	                   <option value="FEMENINO">FEMENINO</option>
	               </select>
	               </div>
	             </div>
	             <div class="col-md-12">
	               <div class="form-group">
	               <label for="usua_perfil"> Perfil </label>
	               <select class="form-control" data-validar="O" name="usua_perfil" id="usua_perfil">
	                   <option value="DOCENTE">DOCENTE</option>
	                   <option value="ESTUDIANTE">ESTUDIANTE</option>
	               </select>
	               </div>
	             </div>
	               
	           </div>

	           <a href="javascript:void(0)" class="btn text-light bg-danger rounded float-right" onClick="agregar()">
	           <span class="fas fa-plus-circle"></span> Guardar 
	           </a>

	           </form>
	           
	        </div>
    </div>
    <br>
    <div id="paginar"></div>

    <script>
	function agregar()
	{
        var cadena=$('#formulario_agregar').serialize();

        crud('controlador/usuario_CO.php?bloque=AGREGAR',cadena,function(respuesta)
        {
            if(respuesta[0])
            {
                exito(respuesta[1]); 

                $.post('vista/usuario_VI.php?bloque=PAGINAR',function(respuesta)
                {
                    $('#paginar').html(respuesta);
                });
            }
            else
            {
                error(respuesta[1]);
            }					
        });
	}

	$.post('vista/usuario_VI.php?bloque=PAGINAR',function(respuesta)
	{
		$('#paginar').html(respuesta);
	});
	</script>  

	<?php
}
else if($bloque=="PAGINAR")
{
	$pagina_local="vista/usuario_VI.php?bloque=PAGINAR";
    $div="#paginar";
	
	$RegistrosAMostrar=5;
	require_once "../../librerias/numero_registros.php";
	
	if(isset($_POST["busqueda"])){$busqueda=$_POST["busqueda"];}else{$busqueda='';}

	$lista_usuario=$usuario_MO->paginar($RegistrosAMostrar,$RegistrosAEmpezar,$busqueda);
	$NroRegistros=$usuario_MO->totalPaginar($busqueda);
	?>
    <div class="card">

	    <div class="card-header text-light bg-danger"><span class="fa fa-list"></span> Lista </div>

		<div class="card-body">
	    
	        <div class="table-responsive">
	        <table class="table table-striped table-bordered">
	        <tbody>
	        
	        <tr>  
	        <td colspan="9">
	        <div class="input-group">
	            <input type="text" id="buscar" name="buscar" placeholder="Buscar por nombre" class="form-control" onKeyUp="enterBuscar(event)" autocomplete="off">
	            <span class="input-group-prepend">
	                <span class="input-group-text" title="Buscar registro" onClick="clicBuscar()">
	                    <span class="fas fa-search"></span>
	                </span>
	            </span>                  
	        </div>               
	        </td>
	        </tr>
	        
	        <tr> 
	        <th style="text-align:center;"> Nombre </th>
	        <th style="text-align:center;"> Género </th>
	        <th style="text-align:center;"> Perfil </th>
	        <th style="text-align:center;"> Acci&oacute;n </th>
	        </tr>
	        
			<?php
	        $size_lista_usuario=count($lista_usuario);
	        
	        if($size_lista_usuario)
	        {
				for($j=0;$j<$size_lista_usuario;$j++)
	            {  
	                $usua_id=$lista_usuario[$j]["usua_id"];
	                $usua_nombre=$lista_usuario[$j]["usua_nombre"];
	                $usua_genero=$lista_usuario[$j]["usua_genero"];
	                $usua_perfil=$lista_usuario[$j]["usua_perfil"];
					?>
					<tr>   
					<td> <?php echo $usua_nombre;?></td>
					<td style="text-align:center;"> <?php echo $usua_genero;?></td>
					<td style="text-align:center;"> <?php echo $usua_perfil;?></td>
					
					<td style="text-align:center;">
						<span class="fas fa-edit" title="Actualizar Registro"  style="margin-right:10px;" 
						onClick="ventanaModal('vista/usuario_VI.php?bloque=VER','Actualizar Registro','usua_id=<?php echo $usua_id;?>')"></span>
					</td>
					</tr>
					<?php
	            }
				?>
	            <tr>
	            <td colspan="9">
	            <?php
				require_once "../../librerias/paginacion.php";
				?>
	            </td>
	            </tr>
	            <?php
	        }
			else
			{
				?>
	            <tr><td colspan="9" style="text-align:center;">No hay registros</td></tr>
	            <?php
			}
	        ?>
	        </tbody>
	        </table>
	        </div>
	    </div>
	</div>
	<script>
	function enterBuscar(e)
	{
		tecla = (document.all) ? e.keyCode : e.which;

		if(tecla==13)
		{
			buscar('vista/usuario_VI.php?bloque=PAGINAR','#paginar','#buscar');
		}
	}
	
	function clicBuscar()
	{
	    buscar('vista/usuario_VI.php?bloque=PAGINAR','#paginar','#buscar');
	}
	</script>
    <?php
}
else if($bloque=="VER")
{
    $usua_id=$_POST["usua_id"];

    $lista_usuario=$usuario_MO->seleccionar($usua_id);

    $usua_nombre=$lista_usuario[0]["usua_nombre"];
    $usua_perfil=$lista_usuario[0]["usua_perfil"];
    ?>
    <div class="card">

        <div class="card-body">
        
           <form id="formulario_actualizar" role="form" autocomplete="off" action="return false;">
           
            <div class="row">
           
             <div class="col-md-8">
               <div class="form-group">
               <label for="usua_nombre"> Nombre </label>
               <input type="text" class="form-control" data-validar="O" name="usua_nombre" id="usua_nombre" value="<?php echo $usua_nombre;?>" maxlength="200">
               </div>
             </div>

             <div class="col-md-4">
               <div class="form-group">
               <label for="usua_perfil"> Perfil </label>
               <select class="form-control" data-validar="O" name="usua_perfil" id="usua_perfil">
                <?php
                if($usua_perfil=='DOCENTE')
                {
                    ?>
                   	<option value="DOCENTE">DOCENTE</option>
                   	<option value="ESTUDIANTE">ESTUDIANTE</option>
                    <?php
                }
                else if($usua_perfil=='ESTUDIANTE')
                {
                    ?>
                    <option value="ESTUDIANTE">ESTUDIANTE</option>
                   	<option value="DOCENTE">DOCENTE</option>
                    <?php  
                }
                ?>
               </select>
               </div>
             </div>
               
           </div>

           <input type="hidden" name="usua_id" id="usua_id" value="<?php echo $usua_id;?>">

           <a href="javascript:void(0)" class="btn text-light bg-danger rounded float-right" onClick="actualizar()">
           <span class="fas fa-plus-circle"></span> Guardar 
           </a>

           </form>
           
        </div>
    </div>
    <script>
	function actualizar()
	{
        var cadena=$('#formulario_actualizar').serialize();

        crud('controlador/usuario_CO.php?bloque=ACTUALIZAR',cadena,function(respuesta)
        {
            if(respuesta[0])
            {
                exito(respuesta[1]); 

                $.post('vista/usuario_VI.php?bloque=PAGINAR',function(respuesta)
                {
                    $('#paginar').html(respuesta);
                });
            }
            else
            {
                error(respuesta[1]);
            }					
        });
	}
	</script>  
	<?php
}
?>
