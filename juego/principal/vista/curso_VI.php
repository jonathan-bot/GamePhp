<?php
require_once "../../librerias/configuraciones.php";
if($_SESSION["usua_perfil"]!=="DOCENTE"){header("Location: salir.php");exit;}

require_once "../../librerias/servidor.php";
require_once "../modelo/curso_MO.php";

$conexion=new servidor();
$curso_MO=new curso_MO($conexion);

$bloque=$_GET["bloque"];

if($bloque=="INICIO")
{
	?>
    <div class="card">

	    <div class="card-header text-light bg-danger"><span class="fa fa-spinner"></span> Cursos </div>

	        <div class="card-body">
	        
	           <form id="formulario_agregar" role="form" autocomplete="off" action="return false;">
	           
	           <div class="row">
	           
	             <div class="col-md-12">
	               <div class="form-group">
	               <label for="curs_nombre"> Nombre </label>
	               <input type="text" class="form-control" name="curs_nombre" id="curs_nombre" maxlength="200">
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

        crud('controlador/curso_CO.php?bloque=AGREGAR',cadena,function(respuesta)
        {
            if(respuesta[0])
            {
                exito(respuesta[1]); 

                $.post('vista/curso_VI.php?bloque=PAGINAR',function(respuesta)
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

	$.post('vista/curso_VI.php?bloque=PAGINAR',function(respuesta)
	{
		$('#paginar').html(respuesta);
	});
	</script>  

	<?php
}
else if($bloque=="PAGINAR")
{
	$pagina_local="vista/curso_VI.php?bloque=PAGINAR";
    $div="#paginar";
	
	$RegistrosAMostrar=2;
	require_once "../../librerias/numero_registros.php";
	
	if(isset($_POST["busqueda"])){$busqueda=$_POST["busqueda"];}else{$busqueda='';}

	$lista_curso=$curso_MO->paginar($RegistrosAMostrar,$RegistrosAEmpezar,$busqueda);
	$NroRegistros=$curso_MO->totalPaginar($busqueda);
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
	        <th style="text-align:center;"> Fecha creaci&oacute;n </th>
	        <th style="text-align:center;"> Activo </th>
	        <th style="text-align:center;"> Acci&oacute;n </th>
	        </tr>
	        
			<?php
	        $size_lista_curso=count($lista_curso);
	        
	        if($size_lista_curso)
	        {
				for($j=0;$j<$size_lista_curso;$j++)
	            {  
	                $curs_id=$lista_curso[$j]["curs_id"];
	                $curs_nombre=$lista_curso[$j]["curs_nombre"];
	                $curs_fecha_creacion=$lista_curso[$j]["curs_fecha_creacion"];
	                $curs_activo=$lista_curso[$j]["curs_activo"];
					?>
					<tr>   
					<td> <?php echo $curs_nombre;?></td>
					<td style="text-align:center;"> <?php echo $curs_fecha_creacion;?></td>
					<td style="text-align:center;"> <?php echo $curs_activo;?></td>
					
					<td style="text-align:center;">
						<span class="fas fa-edit" title="Actualizar Registro"  style="margin-right:10px;" 
						onClick="ventanaModal('vista/curso_VI.php?bloque=VER','Actualizar Registro','curs_id=<?php echo $curs_id;?>')"></span>
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
			buscar('vista/curso_VI.php?bloque=PAGINAR','#paginar','#buscar');
		}
	}
	
	function clicBuscar()
	{
	    buscar('vista/curso_VI.php?bloque=PAGINAR','#paginar','#buscar');
	}
	</script>
    <?php
}
else if($bloque=="VER")
{
    $curs_id=$_POST["curs_id"];

    $lista_curso=$curso_MO->seleccionar($curs_id);

    $curs_nombre=$lista_curso[0]["curs_nombre"];
    $curs_activo=$lista_curso[0]["curs_activo"];
    ?>
    <div class="card">

        <div class="card-body">
        
           <form id="formulario_actualizar" role="form" autocomplete="off" action="return false;">
           
            <div class="row">
           
             <div class="col-md-8">
               <div class="form-group">
               <label for="usua_nombre"> Nombre </label>
               <input type="text" class="form-control" data-validar="O" name="curs_nombre" id="curs_nombre" value="<?php echo $curs_nombre;?>" maxlength="200">
               </div>
             </div>

             <div class="col-md-4">
               <div class="form-group">
               <label for="curs_activo"> Activo </label>
               <select class="form-control" data-validar="O" name="curs_activo" id="curs_activo">
                <?php
                if($curs_activo=='SI')
                {
                    ?>
                   	<option value="SI">SI</option>
                   	<option value="NO">NO</option>
                    <?php
                }
                else if($curs_activo=='NO')
                {
                    ?>
                    <option value="NO">NO</option>
                   	<option value="SI">SI</option>
                    <?php  
                }
                ?>
               </select>
               </div>
             </div>
               
           </div>

           <input type="hidden" name="curs_id" id="curs_id" value="<?php echo $curs_id;?>">

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

        crud('controlador/curso_CO.php?bloque=ACTUALIZAR',cadena,function(respuesta)
        {
            if(respuesta[0])
            {
                exito(respuesta[1]); 

                $.post('vista/curso_VI.php?bloque=PAGINAR',function(respuesta)
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
