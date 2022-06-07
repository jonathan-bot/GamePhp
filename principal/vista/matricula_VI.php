<?php
require_once "../../librerias/configuraciones.php";
if ($_SESSION["usua_perfil"] !== "DOCENTE") {header("Location: salir.php");exit;}

require_once "../../librerias/servidor.php";
require_once "../modelo/matricula_MO.php";
require_once "../modelo/usuario_MO.php";
require_once "../modelo/curso_MO.php";

$conexion     = new servidor();
$matricula_MO = new matricula_MO($conexion);
$usuario_MO   = new usuario_MO($conexion);
$curso_MO     = new curso_MO($conexion);

$lista_estudiante = $usuario_MO->listarEstudiante();

$lista_curso = $curso_MO->listar();

$bloque = $_GET["bloque"];

if ($bloque == "INICIO") {
    ?>
    <div class="card">

	    <div class="card-header text-light bg-danger"><span class="fa fa-edit"></span> Matrícula </div>

	        <div class="card-body">
			<form id="formulario_agregar" role="form" autocomplete="off" action="return false;">
	           <div class="row">

	             <div class="col-md-12">
	               <div class="form-group">
	               <label for="curs_id"> Cursos </label>
	               <select class="form-control" name="curs_id" id="curs_id">
	               	<option value=""></option>
                       <?php
foreach ($lista_curso as $arreglo_curso) {
        $curs_id     = $arreglo_curso["curs_id"];
        $curs_nombre = $arreglo_curso["curs_nombre"];
        ?>
                            <option value="<?php echo $curs_id; ?>"><?php echo $curs_nombre; ?></option>
                            <?php
}
    ?>
	               </select>
	               </div>
	             </div>

	             <div class="col-md-12">
	               <div class="form-group">
	               <label for="usua_id_estudiante"> Estudiantes </label>
	               <select class="form-control" name="usua_id_estudiante" id="usua_id_estudiante">
	               	<option value=""></option>
                       <?php
foreach ($lista_estudiante as $arreglo_estudiante) {
        $usua_id_estudiante     = $arreglo_estudiante["usua_id"];
        $usua_nombre = $arreglo_estudiante["usua_nombre"];
        ?>
                            <option value="<?php echo $usua_id_estudiante; ?>"><?php echo $usua_nombre; ?></option>
                            <?php
}
    ?>
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
    function listarEstudiantes(){

    	$.post('vista/matricula_VI.php?bloque=PAGINAR',function(respuesta)
		{
			$('#paginar').html(respuesta);
		});
    }
	function agregar()
	{
        var cadena=$('#formulario_agregar').serialize();

        crud('controlador/matricula_CO.php?bloque=AGREGAR',cadena,function(respuesta)
        {
            if(respuesta[0])
            {
                exito(respuesta[1]);

                $.post('vista/matricula_VI.php?bloque=PAGINAR',function(respuesta)
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

	$.post('vista/matricula_VI.php?bloque=PAGINAR',function(respuesta)
	{
		$('#paginar').html(respuesta);
	});
	</script>

	<?php
} else if ($bloque == "PAGINAR" && count($lista_curso)) {
    $pagina_local = "vista/matricula_VI.php?bloque=PAGINAR";
    $div          = "#paginar";

    $RegistrosAMostrar = 5;
    require_once "../../librerias/numero_registros.php";

    if (isset($_POST["busqueda"])) {$busqueda = $_POST["busqueda"];} else { $busqueda = '';}

    $lista_estudiante = $matricula_MO->paginar($RegistrosAMostrar, $RegistrosAEmpezar, $busqueda);
    $NroRegistros     = $matricula_MO->totalPaginar($busqueda);
    ?>
    <div class="card">

	    <div class="card-header text-light bg-dange"><span class="fa fa-list"></span> Lista </div>

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
	        <th style="text-align:center;"> Curso </th>
	        <th style="text-align:center;"> Activo </th>
	        <th style="text-align:center;"> Acci&oacute;n </th>
	        </tr>

			<?php
$size_lista_estudiante = count($lista_estudiante);

    if ($size_lista_estudiante) {
        for ($j = 0; $j < $size_lista_estudiante; $j++) {
            $matr_id     = $lista_estudiante[$j]["matr_id"];
            $usua_id     = $lista_estudiante[$j]["usua_id"];
            $usua_nombre = $lista_estudiante[$j]["usua_nombre"];
            $curs_nombre = $lista_estudiante[$j]["curs_nombre"];
            $matr_activo = $lista_estudiante[$j]["matr_activo"];
            $curs_id     = $lista_estudiante[$j]["curs_id"];
            ?>
					<tr>
					<td> <?php echo $usua_nombre; ?></td>
					<td> <?php echo $curs_nombre; ?></td>
					<td style="text-align:center;"> <?php echo $matr_activo; ?></td>

					<td style="text-align:center;">
						<span class="fas fa-edit" title="Actualizar Registro"  style="margin-right:10px;"
						onClick="ventanaModal('vista/matricula_VI.php?bloque=VER','Actualizar Registro','matr_id=<?php echo $matr_id; ?>')"></span>
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
} else {
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
			buscar('vista/matricula_VI.php?bloque=PAGINAR','#paginar','#buscar');
		}
	}

	function clicBuscar()
	{
	    buscar('vista/matricula_VI.php?bloque=PAGINAR','#paginar','#buscar');
	}
	</script>
    <?php
} else if ($bloque == "VER") {
    $matr_id = $_POST["matr_id"];

    $lista_matricula = $matricula_MO->seleccionar($matr_id);

    $usua_nombre = $lista_matricula[0]["usua_nombre"];
    $matr_activo = $lista_matricula[0]["matr_activo"];
    ?>
    <div class="card">

        <div class="card-body">

           <form id="formulario_actualizar" role="form" autocomplete="off" action="return false;">

            <div class="row">

             <div class="col-md-8">
               <div class="form-group">
               <label> <?php echo $usua_nombre; ?> </label>
               </div>
             </div>

             <div class="col-md-4">
               <div class="form-group">
               <label for="matr_activo"> Activo </label>
               <select class="form-control" data-validar="O" name="matr_activo" id="matr_activo">
                <?php
if ($matr_activo == 'SI') {
        ?>
                   	<option value="SI">SI</option>
                   	<option value="NO">NO</option>
                    <?php
} else if ($matr_activo == 'NO') {
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

           <input type="hidden" name="matr_id" id="matr_id" value="<?php echo $matr_id; ?>">

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

        crud('controlador/matricula_CO.php?bloque=ACTUALIZAR',cadena,function(respuesta)
        {
            if(respuesta[0])
            {
                exito(respuesta[1]);

                $.post('vista/matricula_VI.php?bloque=PAGINAR',function(respuesta)
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
