<?php
require_once "../librerias/configuraciones.php";
if($_SESSION["usua_perfil"]!=="DOCENTE"){header("Location: salir.php");exit;}
?>
<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>DOCENTE</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/all.min.css">
        <link rel="stylesheet" href="../css/estilos.css">
        <style>						
			body
            {
                background-image:url(../imagenes/fondo_index.png), url(../imagenes/fondo_index.jpg);
                background-size:100% 100%;
                background-attachment:fixed;
                overflow:hidden;
                margin:0px;
				cursor:url(imagenes/cursor2.cur), pointer;		
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="../js/sistema.js"></script>
    </head>
    <body>
        <div id="ventana"></div>

        <div class="alert" id="alerta"></div>
        
        <div class="container-fluid">
            <div id="barra_superior">
                <i class="fas fa-rocket text-danger" id="logo_sistema" style="margin-left:3px;"></i>
                <span id="nombre_software" class="text-danger"> VIAJE A LA GEOMETRIA </span>
                <a href="../salir.php" style="float:right; margin-right:10px;"><span class="fas fa-power-off text-danger" title="Cerrar"></span></a>
                <a href="docente.php" style="float:right; margin-right:10px;"><span class="fas fa-home text-danger" title="Actualizar"></span></a>
            </div>
            <div id="barra_inferior" style="height: 20px;"><span style="margin-left:50%;font-size:15px;">Docente: <?php echo $_SESSION["usua_nombre"];?></span></div>
            <div id="menu">
                <div class="card">
                    <div class="card-header text-light bg-danger"><i class="fa fa-tasks"></i> MEN&Uacute;</div>
                    <div class="card-body bg-light" style="padding:5px; overflow-y:scroll;">
                        <div class="dropdown">
                            <a class="btn btn-light boton_menu" title="Cursos" role="button" onClick="menu('vista/curso_VI.php')">
                                <i class="fa fa-spinner"></i> Cursos
                            </a>
                            <a class="btn btn-light boton_menu" title="Cursos" role="button" onClick="menu('vista/usuario_VI.php')">
                                <i class="fa fa-address-book"></i> Usuarios
                            </a>
                            <a class="btn btn-light boton_menu" title="Cursos" role="button" onClick="menu('vista/matricula_VI.php')">
                                <i class="fa fa-edit"></i> Matricula
                            </a>
                            <a class="btn btn-light boton_menu" title="Niveles" role="button" onClick="menu('vista/nivel_VI.php')">
                                <i class="fa fa-bomb"></i> Niveles
                            </a>
                            <a class="btn btn-light boton_menu" title="Niveles" role="button" onClick="menu('vista/nivelPregunta_VI.php')">
                                <i class="fa fa-building"></i> Nivel Pregunta
                            </a>
                            <a class="btn btn-light boton_menu" title="Preguntas" role="button" onClick="menu('vista/pregunta_VI.php')">
                                <i class="fa fa-comment"></i> Preguntas
                            </a>
                            <a class="btn btn-light boton_menu" title="Respuestas" role="button" onClick="menu('vista/respuesta_VI.php')">
                                <i class="fa fa-comments"></i> Respuestas
                            </a>
                         
                        </div>
                    </div>
                </div>
            </div>
            <div id="contenido">
                <div class="card">
                    <div class="card-header text-light bg-danger"><i class="far fa-caret-square-down"></i> BIENVENIDO </div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
        <script src="../js/bootstrap.min.js"></script>
        
        <script>
            function menu(ruta)
            {
                if(ruta.length>0)
                {
                    $.post(ruta+'?bloque=INICIO',function(respuesta)
                           {
                        $('#contenido').html(respuesta);
                    });
                }
            }
            var ancho_pantalla=window.innerWidth;
            var alto_pantalla=window.innerHeight;
            document.getElementById("menu").style.height=(alto_pantalla-100)+"px";
            document.getElementById("contenido").style.width=(ancho_pantalla-290)+"px";
            function cambio()
            {
                ancho_pantalla=window.innerWidth;
                alto_pantalla=window.innerHeight;
                document.getElementById("menu").style.height=(alto_pantalla-100)+"px";
                document.getElementById("contenido").style.width=(ancho_pantalla-290)+"px";
            }
            window.onresize = cambio;
        </script>
    </body>
</html>
