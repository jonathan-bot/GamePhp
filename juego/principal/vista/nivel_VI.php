<?php
require_once "../../librerias/configuraciones.php";
if ($_SESSION["usua_perfil"] !== "DOCENTE") {
	header("Location: salir.php");
	exit;
}

require_once "../../librerias/servidor.php";
require_once "../modelo/nivel_MO.php";
require_once "../modelo/curso_MO.php";

$conexion = new servidor();
$nivel_MO = new nivel_MO($conexion);
$curso_MO = new curso_MO($conexion);

$lista_curso = $curso_MO->listar();

$bloque = $_GET["bloque"];

if ($bloque == "INICIO") {
	?>
	<div class="card">

		<div class="card-header text-light bg-danger"><span class="fa fa-bomb"></span> Niveles </div>

		<div class="card-body">

			<form id="formulario_agregar" role="form" autocomplete="off" action="return false;">

				<div class="row">

					<div class="col-md-6">
						<div class="form-group">
							<label for="nive_nombre"> Nombre del Nivel</label>
							<input type="text" class="form-control" name="nive_nombre" id="nive_nombre" maxlength="50">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="nive_orden"> Orden del Nivel </label>
							<input type="number" class="form-control" name="nive_orden" id="nive_orden" maxlength="50">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="nive_activo"> Activo </label>
							<select class="form-control" name="nive_activo" id="nive_activo">
								<option value="SI">SI</option>
								<option value="NO">NO</option>
							</select>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="nive_cantidad_pregunta"> Cantidad de Preguntas </label>
							<input type="number" class="form-control" name="nive_cantidad_pregunta" id="nive_cantidad_pregunta" maxlength="50">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="curs_id"> Cursos </label>
							<select class="form-control" name="curs_id" id="curs_id">
								<option value=""></option>
								<?php
									foreach ($lista_curso as $arreglo_curso) {
										$curs_id = $arreglo_curso["curs_id"];
										$curs_nombre = $arreglo_curso["curs_nombre"];
										?>
									<option value="<?php echo $curs_id; ?>"><?php echo $curs_nombre; ?></option>
								<?php
									}
									?>
							</select>
						</div>
					</div>

				</div>

				<div class="row">
					<div class="col-md-5">
						<div class="form-group">
							<label> Seleccionar recurso</label>
							<input type="file" class="form-control" name="ruta_recurso" id="ruta_recurso">
						</div>
					</div>

					<div class="col-md-1">
						<div class="form-group" style="text-align:center;">
							<label> Subir</label><br>
							<a href="javascript:void(0)" class="btn btn-primary rounded" onclick="subirArchivos('ruta_recurso','vista_previa','nive_ruta_imagen')">
								<span class="fas fa-plus-circle"></span>
							</a>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label> Vista previa</label>
							<div class="form-control" id="vista_previa" style="text-align:center; height:120px;">
								Peso m&aacute;ximo: 10MB <br>
								Formatos permitidos: jpg, png, gif, mp3, mp4<br>
								Tama&ntilde;o: 200px * 200px
							</div>
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
		function agregar() {
			var cadena = $('#formulario_agregar').serialize();

			crud('controlador/nivel_CO.php?bloque=AGREGAR', cadena, function(respuesta) {
				if (respuesta[0]) {
					exito(respuesta[1]);

					$.post('vista/nivel_VI.php?bloque=PAGINAR', function(respuesta) {
						$('#paginar').html(respuesta);
					});
				} else {
					error(respuesta[1]);
				}
			});
		}

		$.post('vista/nivel_VI.php?bloque=PAGINAR', function(respuesta) {
			$('#paginar').html(respuesta);
		});
	</script>

<?php
} else if ($bloque == "PAGINAR") {
	$pagina_local = "vista/nivel_VI.php?bloque=PAGINAR";
	$div = "#paginar";

	$RegistrosAMostrar = 5;
	require_once "../../librerias/numero_registros.php";

	if (isset($_POST["busqueda"])) {
		$busqueda = $_POST["busqueda"];
	} else {
		$busqueda = '';
	}

	$lista_nivel = $nivel_MO->paginar($RegistrosAMostrar, $RegistrosAEmpezar, $busqueda);
	$NroRegistros = $nivel_MO->totalPaginar($busqueda);
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
							<th style="text-align:center;"> Nombre del Curso </th>
							<th style="text-align:center;"> Nombre del Nivel </th>
							<th style="text-align:center;"> Activo </th>
							<th style="text-align:center;"> Acci&oacute;n </th>
						</tr>

						<?php
							$size_lista_nivel = count($lista_nivel);

							if ($size_lista_nivel) {
								for ($j = 0; $j < $size_lista_nivel; $j++) {
									$nive_id = $lista_nivel[$j]["nive_id"];
									$nive_nombre = $lista_nivel[$j]["nive_nombre"];
									$nive_activo = $lista_nivel[$j]["nive_activo"];
									$curs_id = $lista_nivel[$j]["curs_id"];

									$lista_curso = $curso_MO->seleccionar($curs_id);
									$curs_nombre = $lista_curso[0]["curs_nombre"];
									?>
								<tr>
									<td style="text-align:center;"> <?php echo $curs_nombre; ?></td>
									<td style="text-align:center;"> <?php echo $nive_nombre; ?></td>
									<td style="text-align:center;"> <?php echo $nive_activo; ?></td>

									<td style="text-align:center;">
										<span class="fas fa-edit" title="Actualizar Registro" style="margin-right:10px;" onClick="ventanaModal('vista/nivel_VI.php?bloque=VER','Actualizar Registro','nive_id=<?php echo $nive_id; ?>')"></span>
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
							<tr>
								<td colspan="9" style="text-align:center;">No hay registros</td>
							</tr>
						<?php
							}
							?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<script>
		function enterBuscar(e) {
			tecla = (document.all) ? e.keyCode : e.which;

			if (tecla == 13) {
				buscar('vista/nivel_VI.php?bloque=PAGINAR', '#paginar', '#buscar');
			}
		}

		function clicBuscar() {
			buscar('vista/nivel_VI.php?bloque=PAGINAR', '#paginar', '#buscar');
		}
	</script>
<?php
} else if ($bloque == "VER") {
	$nive_id = $_POST["nive_id"];

	$lista_nivel = $nivel_MO->seleccionar($nive_id);

	$nive_nombre = $lista_nivel[0]["nive_nombre"];
	$nive_activo = $lista_nivel[0]["nive_activo"];
	?>
	<div class="card">

		<div class="card-body">

			<form id="formulario_actualizar" role="form" autocomplete="off" action="return false;">

				<div class="row">

					<div class="col-md-8">
						<div class="form-group">
							<label for="usua_nombre"> Nombre </label>
							<input type="text" class="form-control" data-validar="O" name="nive_nombre" id="nive_nombre" value="<?php echo $nive_nombre; ?>" maxlength="200">
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label for="nive_activo"> Activo </label>
							<select class="form-control" data-validar="O" name="nive_activo" id="nive_activo">
								<?php
									if ($nive_activo == 'SI') {
										?>
									<option value="SI">SI</option>
									<option value="NO">NO</option>
								<?php
									} else if ($nive_activo == 'NO') {
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

				<input type="hidden" name="nive_id" id="nive_id" value="<?php echo $nive_id; ?>">

				<a href="javascript:void(0)" class="btn text-light bg-danger rounded float-right" onClick="actualizar()">
					<span class="fas fa-plus-circle"></span> Guardar
				</a>

			</form>

		</div>
	</div>
	<script>
		function actualizar() {
			var cadena = $('#formulario_actualizar').serialize();

			crud('controlador/nivel_CO.php?bloque=ACTUALIZAR', cadena, function(respuesta) {
				if (respuesta[0]) {
					exito(respuesta[1]);

					$.post('vista/nivel_VI.php?bloque=PAGINAR', function(respuesta) {
						$('#paginar').html(respuesta);
					});
				} else {
					error(respuesta[1]);
				}
			});
		}
	</script>
<?php
}
?>