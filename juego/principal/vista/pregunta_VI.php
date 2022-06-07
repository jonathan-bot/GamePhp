<?php
require_once "../../librerias/configuraciones.php";
if ($_SESSION["usua_perfil"] !== "DOCENTE") {
    header("Location: salir.php");
    exit;
}

require_once "../../librerias/servidor.php";
require_once "../modelo/pregunta_MO.php";
require_once "../modelo/nivel_MO.php";

$conexion = new servidor();
$pregunta_MO = new pregunta_MO($conexion);
$nivel_MO = new nivel_MO($conexion);

$lista_nivel = $nivel_MO->listar();

$bloque = $_GET["bloque"];

if ($bloque == "INICIO") {
    ?>
    <div class="card">

        <div class="card-header text-light bg-danger"><span class="fa fa-comment"></span> Preguntas </div>

        <div class="card-body">

            <form id="formulario_agregar" role="form" autocomplete="off" action="return false;">

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="preg_descripcion"> Descripción de la pregunta</label>
                            <input type="text" class="form-control" name="preg_descripcion" id="preg_descripcion" maxlength="1000">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="preg_activo"> Activo </label>
                            <select class="form-control" name="preg_activo" id="preg_activo">
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="preg_tipo_recurso"> Tipo de recurso </label>
                            <select class="form-control" name="preg_tipo_recurso" id="preg_tipo_recurso">
                                <option value="VIDEO"></option>
                                <option value="IMAGEN">IMAGEN</option>
                                <option value="AUDIO">AUDIO</option>
                                <option value="VIDEO">VIDEO</option>
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
                            <a href="javascript:void(0)" class="btn btn-primary rounded" onclick="subirArchivos('ruta_recurso','vista_previa','preg_ruta_recurso')">
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

            crud('controlador/pregunta_CO.php?bloque=AGREGAR', cadena, function(respuesta) {
                if (respuesta[0]) {
                    exito(respuesta[1]);

                    $.post('vista/pregunta_VI.php?bloque=PAGINAR', function(respuesta) {
                        $('#paginar').html(respuesta);
                    });
                } else {
                    error(respuesta[1]);
                }
            });
        
        }

        $.post('vista/pregunta_VI.php?bloque=PAGINAR', function(respuesta) {
            $('#paginar').html(respuesta);
        });
    </script>

<?php
} else if ($bloque == "PAGINAR") {
    $pagina_local = "vista/pregunta_VI.php?bloque=PAGINAR";
    $div = "#paginar";

    $RegistrosAMostrar = 5;
    require_once "../../librerias/numero_registros.php";

    if (isset($_POST["busqueda"])) {
        $busqueda = $_POST["busqueda"];
    } else {
        $busqueda = '';
    }

    $lista_pregunta = $pregunta_MO->paginar($RegistrosAMostrar, $RegistrosAEmpezar, $busqueda);
    $NroRegistros = $pregunta_MO->totalPaginar($busqueda);
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
                            <th style="text-align:center;"> Descripción de la pregunta </th>
                            <th style="text-align:center;"> Tipo de pregunta </th>
                            <th style="text-align:center;"> Activo </th>
                            <th style="text-align:center;"> Acci&oacute;n </th>
                        </tr>

                        <?php
                            $size_lista_pregunta = count($lista_pregunta);

                            if ($size_lista_pregunta) {
                                for ($j = 0; $j < $size_lista_pregunta; $j++) {
                                    $preg_id = $lista_pregunta[$j]["preg_id"];
                                    $preg_descripcion = $lista_pregunta[$j]["preg_descripcion"];
                                    $preg_tipo_recurso = $lista_pregunta[$j]["preg_tipo_recurso"];
                                    $preg_activo = $lista_pregunta[$j]["preg_activo"];
                                    $usua_id = $lista_pregunta[$j]["usua_id"];

                                   
                                    ?>
                                <tr>
                                    <td style="text-align:center;"> <?php echo $preg_descripcion; ?></td>
                                    <td style="text-align:center;"> <?php echo $preg_tipo_recurso; ?></td>
                                    <td style="text-align:center;"> <?php echo $preg_activo; ?></td>

                                    <td style="text-align:center;">
                                        <span class="fas fa-edit" title="Actualizar Registro" style="margin-right:10px;" onClick="ventanaModal('vista/pregunta_VI.php?bloque=VER','Actualizar Registro','preg_id=<?php echo $preg_id; ?>')"></span>
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
                buscar('vista/pregunta_VI.php?bloque=PAGINAR', '#paginar', '#buscar');
            }
        }

        function clicBuscar() {
            buscar('vista/pregunta_VI.php?bloque=PAGINAR', '#paginar', '#buscar');
        }
    </script>
<?php
} else if ($bloque == "VER") {
    $preg_id = $_POST["preg_id"];

    $lista_pregunta = $pregunta_MO->seleccionar($preg_id);

    $preg_descripcion = $lista_pregunta[0]["preg_descripcion"];
    $preg_activo = $lista_pregunta[0]["preg_activo"];
    ?>
    <div class="card">

        <div class="card-body">

            <form id="formulario_actualizar" role="form" autocomplete="off" action="return false;">

                <div class="row">

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="preg_descripcion"> Descripción </label>
                            <input type="text" class="form-control" data-validar="O" name="preg_descripcion" id="preg_descripcion" value="<?php echo $preg_descripcion; ?>" maxlength="200">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="preg_activo"> Activo </label>
                            <select class="form-control" data-validar="O" name="preg_activo" id="preg_activo">
                                <?php
                                    if ($preg_activo == 'SI') {
                                        ?>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                <?php
                                    } else if ($preg_activo == 'NO') {
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

                <input type="hidden" name="preg_id" id="preg_id" value="<?php echo $preg_id; ?>">

                <a href="javascript:void(0)" class="btn text-light bg-danger rounded float-right" onClick="actualizar()">
                    <span class="fas fa-plus-circle"></span> Guardar
                </a>

            </form>

        </div>
    </div>
    <script>
        function actualizar() {
            var cadena = $('#formulario_actualizar').serialize();

            crud('controlador/pregunta_CO.php?bloque=ACTUALIZAR', cadena, function(respuesta) {
                if (respuesta[0]) {
                    exito(respuesta[1]);

                    $.post('vista/pregunta_VI.php?bloque=PAGINAR', function(respuesta) {
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