<?php
require_once "../../librerias/configuraciones.php";
if($_SESSION["usua_perfil"]!=="DOCENTE"){header("Location: salir.php");exit;}

require_once "../../librerias/servidor.php";
require_once "../modelo/nivelPregunta_MO.php";
require_once "../modelo/nivel_MO.php";
require_once "../modelo/pregunta_MO.php";

$conexion=new servidor();
$nivelPregunta_MO=new nivelPregunta_MO($conexion);
$nivel_MO=new nivel_MO($conexion);
$pregunta_MO=new pregunta_MO($conexion);

$lista_pregunta=$pregunta_MO->listar();
$lista_nivel=$nivel_MO->listar();

$bloque=$_GET["bloque"];

if($bloque=="INICIO")
{
	?>
    <div class="card">

	    <div class="card-header text-light bg-danger"><span class="fa fa-building"></span> Nivel Pregunta </div>

	        <div class="card-body">
	        
	           <form id="formulario_agregar" role="form" autocomplete="off" action="return false;">
	           
	           <div class="row">
	           

	             <div class="col-md-6">
	               <div class="form-group">
	               <label for="nive_id"> Nivel </label>
	               <select class="form-control" name="nive_id" id="nive_id">
	                   <option value=""></option>
                       <?php
                        foreach($lista_nivel as $arreglo_nivel)
                        {
                            $nive_id=$arreglo_nivel["nive_id"];
                            $nive_nombre=$arreglo_nivel["nive_nombre"];
                            ?>
                            <option value="<?php echo $nive_id;?>"><?php echo $nive_nombre;?></option>
                            <?php
                        }
                       ?>
	               </select>
	               </div>
	             </div> 
                 
	             <div class="col-md-6">
	               <div class="form-group">
	               <label for="preg_id"> Pregunta </label>
	               <select class="form-control" name="preg_id" id="preg_id">
	                   <option value=""></option>
                       <?php
                        foreach($lista_pregunta as $arreglo_pregunta)
                        {
                            $preg_id=$arreglo_pregunta["preg_id"];
                            $preg_descripcion=$arreglo_pregunta["preg_descripcion"];
                            ?>
                            <option value="<?php echo $preg_id;?>"><?php echo $preg_descripcion;?></option>
                            <?php
                        }
                       ?>
	               </select>
	               </div>
	             </div> 

	             <div class="col-md-6">
	               <div class="form-group">
	               <label for="nipr_activo"> Activo </label>
	               <select class="form-control" name="nipr_activo" id="nipr_activo">
	                   <option value="SI">SI</option>
	                   <option value="NO">NO</option>
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

        crud('controlador/nivelPregunta_CO.php?bloque=AGREGAR',cadena,function(respuesta)
        {
            if(respuesta[0])
            {
                exito(respuesta[1]); 

                $.post('vista/nivelPregunta_VI.php?bloque=PAGINAR',function(respuesta)
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

	$.post('vista/nivelPregunta_VI.php?bloque=PAGINAR',function(respuesta)
	{
		$('#paginar').html(respuesta);
	});
	</script>  

	<?php
}
else if($bloque=="PAGINAR")
{
	$pagina_local="vista/nivelPregunta_VI.php?bloque=PAGINAR";
    $div="#paginar";
	
	$RegistrosAMostrar=5;
	require_once "../../librerias/numero_registros.php";
	
	if(isset($_POST["busqueda"])){$busqueda=$_POST["busqueda"];}else{$busqueda='';}

	$lista_nivelPregunta=$nivelPregunta_MO->paginar($RegistrosAMostrar,$RegistrosAEmpezar,$busqueda);
	$NroRegistros=$nivelPregunta_MO->totalPaginar($busqueda);
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
	        <th style="text-align:center;"> Nombre del Nivel </th>
	        <th style="text-align:center;"> Descripcion de la pregunta</th>
            <th style="text-align:center;"> Activo </th>    
	        <th style="text-align:center;"> Acci&oacute;n </th>
	        </tr>
	        
			<?php
	        $size_lista_nivelPregunta=count($lista_nivelPregunta);
	        
	        if($size_lista_nivelPregunta)
	        {
				for($j=0;$j<$size_lista_nivelPregunta;$j++)
	            {  
	                $nipr_id=$lista_nivelPregunta[$j]["nipr_id"];
	                $nive_id=$lista_nivelPregunta[$j]["nive_id"];

	                $lista_nivel=$nivel_MO->seleccionar($nive_id);
                    $nive_nombre=$lista_nivel[0]["nive_nombre"];

                    $preg_id=$lista_nivelPregunta[$j]["preg_id"];

                    $lista_pregunta=$pregunta_MO->seleccionar($preg_id);
                    $preg_descripcion=$lista_pregunta[0]["preg_descripcion"];

	                $nipr_activo=$lista_nivelPregunta[$j]["nipr_activo"];
                    
                    
					?>
					<tr>   
					<td style="text-align:center;"> <?php echo $nive_nombre;?></td>
					<td style="text-align:center;"> <?php echo $preg_descripcion;?></td>
					<td style="text-align:center;"> <?php echo $nipr_activo;?></td>
					
					<td style="text-align:center;">
						<span class="fas fa-edit" title="Actualizar Registro"  style="margin-right:10px;" 
						onClick="ventanaModal('vista/nivelpregunta_VI.php?bloque=VER','Actualizar Registro','nive_id=<?php echo $nive_id;?>')"></span>
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
			buscar('vista/nivelPregunta_VI.php?bloque=PAGINAR','#paginar','#buscar');
		}
	}
	
	function clicBuscar()
	{
	    buscar('vista/nivelPregunta_VI.php?bloque=PAGINAR','#paginar','#buscar');
	}
	</script>
    <?php
}
?>
