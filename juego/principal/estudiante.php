<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Juego Educativo </title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/all.min.css"> /*fontawesome*/
        <style>
            *
            {
                cursor:url(imagenes/cursor.cur), pointer;
            }

            body
            {
                background-image:url(imagenes/fondo_index.png), url(imagenes/fondo_index.jpg);
                background-size:100% 100%;
                background-attachment:fixed;
                overflow:hidden;
                margin:0px;
            }

            #inicio_sesion
            {
                top:300px;
                width:350px; 
                position: absolute;
                margin: 0 auto;
                left: 0;
                right: 0;
                opacity:0;
                color:white;
                animation-name:inicio_sesion_animacion;
                animation-direction:normal;
                animation-duration:3s;
                animation-iteration-count:1;
                animation-timing-function:linear;
                animation-fill-mode:forwards; /*conserve los ultimos valores cuando acabe la animación*/
            }
            @keyframes inicio_sesion_animacion
            {
                100%
                {
                    opacity:0.6;
                    top: 100px;
                }
            }

            #titulo
            {
                background-image:url(imagenes/titulo.png);
                width: 462px;
                height: 68px;
                position:absolute;
                margin: 0 auto;
                left: 0;
                right: 0;
                top: -68px;
                animation-name: titulo_animacion;
                animation-duration: 2s;
                animation-fill-mode: forwards;
            }
            @keyframes titulo_animacion
            {
                100%
                {
                    top: 0px;
                }
            }

            #luces_uno
            {
                background-image:url(imagenes/luces_uno.png);
                width: 1920px;
                height: 313px;
                position: absolute;
                animation-name: luces_uno_animacion;
                animation-duration: 100s;
                animation-timing-function: linear;
                animation-iteration-count: infinite;
            }
            @keyframes luces_uno_animacion
            {
                100%
                {
                    background-position: -1920px;
                }
            }

            #luces_dos
            {
                background-image:url(imagenes/luces_dos.png);
                width: 1920px;
                height: 181px;
                position: absolute;
                animation-name: luces_dos_animacion;
                animation-duration: 120s;
                animation-iteration-count: infinite;
            }
            @keyframes luces_dos_animacion
            {
                100%
                {
                    background-position: 1920px;
                }
            }

            #planeta_index
            {
                background-image:url(imagenes/planeta_index.png);
                width: 159px;
                height: 148px;
                position:absolute;
                margin: 0 auto;
                left: 0;
                right: 60;
                top: -68px;
                animation-name: planeta_animacion;
                animation-duration: 2s;
                animation-fill-mode: forwards;
            }
            @keyframes planeta_animacion
            {
                100%
                {
                    top: 0px;
                }

            }

            #luz_planeta_index
            {
                background-image:url(imagenes/luz_planeta_index.png);
                width: 230px;
                height: 209px;
                position:absolute;
                margin: 0 auto;
                opacity: 0;
                left: 0;
                right: 68;
                top: -68px;
                animation-name: luz_planeta_index_animacion;
                animation-duration: 1s;
                animation-fill-mode: forwards;
                animation-delay: 2s;
            }
            @keyframes luz_planeta_index_animacion
            {
                100%
                {
                    opacity: inherit;
                }

            }

        </style>

    </head>
    <body>

        <div id="planeta_index"></div>

        <div id="luz_planeta_index"></div>  

        <div id="luces_uno"></div>
        <div id="luces_dos"></div>


        <div id="titulo"></div>

        <div class="card" id="inicio_sesion">
            <div class="card-header" style="color:blueviolet;"><span class="fas fa-shield-alt"></span>Estudiante</div>
            <div class="card-body">
               <h1>Estudiante</h1>
            </div>
        </div>


    </body>
</html>
