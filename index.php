<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Juego Viaje a la Geometría </title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/all.min.css">

		<style>
			*
			{
				cursor:url(imagenes/cursor2.cur), pointer;
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
				top:400px;
				width:350px;
				position: absolute;
				margin: 0 auto;
				left: 0;
				right: 0;
				opacity:0;
				background-color:#D276D9;
				animation-name:inicio_sesion_animacion;
				animation-direction:normal;
				animation-duration:1s;
				animation-iteration-count:1;
				animation-timing-function:linear;
				animation-fill-mode:forwards;
			}

			@keyframes inicio_sesion_animacion
			{
				100%
				{
					opacity:0.9;
					top: 200px;
				}
			}

			#titulo
			{
				background-image:url(imagenes/titulo3.png);
				width: 300px;
				height: 276px;
				position:absolute;
				margin: 0 auto;
				left: 0;
				right: 0;
				top: -120px;
				animation-name: titulo_animacion;
				animation-duration: 1.5s;
				animation-fill-mode: forwards;
			}
			@keyframes titulo_animacion
			{
				100%
				{
					top: -20px;
				}
			}

			#ufo1	
			{
				background-image:url(imagenes/ufo1.png);
				width: 117px;
				height: 87px;
				left: -117px;
				top:50%;
				position:absolute;
				animation-name: ufo1;
				animation-duration: 8s;
				animation-timing-function: linear;
				animation-iteration-count: infinite;

			}
			@keyframes ufo1
			{
				100%
				{
					left: 70%;
					top: 100%;
					
				}
			}
            
            #puntero	
			{
				background-image:url(imagenes/puntero.png);
				width: 171px;
				height: 87px;
				right: -171px;
				top:80%;
				position:absolute;
				animation-name: puntero;
				animation-duration: 10s;
				animation-timing-function: linear;
				animation-iteration-count: infinite;
				animation-delay: 2s;
				animation-direction: alternate;
			}
			@keyframes puntero
			{
				100%
				{
					right: 100%;
					top: -171px;
					
				}
			}

			#letras
			{
				background-image:url(imagenes/letras.png);
				width: 133px;
				height: 87px;
				right: 10%;
				top: -87px;
				position:absolute;
				animation-name: letras;
				animation-duration: 20s;
				animation-timing-function: linear;
				animation-iteration-count: infinite;
				animation-delay: 2s;
				animation-direction: alternate;
			}
			@keyframes letras
			{
				100%
				{
					right: 100%;
					top: 110%;
					
				}
			}

			


			#planeta
			{
				background-image:url(imagenes/planeta_index.png);
				width: 216px;
				height: 192px;
				position:absolute;
				margin: 0 auto;
				left: 0;
				right: 60%;
				top: -68px;
				animation-name: planeta;
				animation-duration: 1.5s;
				animation-fill-mode: forwards;
			}
			@keyframes planeta
			{
				100%
				{
					top: 0px;
				}
			}

			#destello
			{
				background-image:url(imagenes/luz_planeta_index.png);
				width: 230px;
				height: 209px;
				position:absolute;
				opacity:0;
				margin: 0 auto;
				left: 0;
				right: -280px;
				top: 38px;
				animation-name: destello;
				animation-duration: 1s;
				animation-fill-mode: forwards;
				animation-delay: 1.5s;
			}
			@keyframes destello
			{
				100%
				{
					opacity: inherit;
				}
			}

			#destello2
			{
				background-image:url(imagenes/luz_planeta_index.png);
				width: 230px;
				height: 209px;
				position:absolute;
				opacity:0;
				margin: 0 auto;
				left: 0;
				right: 250px;
				top: -8%;
				animation-name: destello2;
				animation-duration: 1s;
				animation-fill-mode: forwards;
				animation-delay: 1.5s;
			}
			@keyframes destello2
			{
				100%
				{
					opacity: inherit;
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


		</style>

	</head>
	<body>
    <audio autoplay src="mi-archivo-de-audio.mp3"></audio>

		<div id="luces_uno"></div>
		<div id="luces_dos"></div>
        <div id="ufo1"></div>
        <div id="puntero"></div>
        <div id="letras"></div>
		<div id="planeta"></div>
		<div id="destello"></div>
		<div id="destello2"></div>


		<div id="titulo"></div>
		<div class="card" id="inicio_sesion">
			<div class="card-header" style="color:#0071DB ;"><span class="fas fa-shield-alt"></span> Inicio de Sesi&oacute;n</div>
			<div class="card-body">
				<form id="formulario" method="post" autocomplete="off" action="validar.php">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-append"><span class="input-group-text" style="color:#0071DB ;"><span class="fas fa-user" style="font-size:20px;"></span></span></span>
							<input type="text" placeholder="Usuario" id="usuario" name="usuario" class="form-control" maxlength="20" autofocus>
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-append"><span class="input-group-text" style="color:#0071DB ;"><span class="fas fa-lock" style="width:18px;"></span></span></span>
							<input type="password" name="clave" id="clave" placeholder="Clave" class="form-control" maxlength="20">
						</div>
					</div>
					<input type="submit" class="btn btn-secondary rounded float-right text-white" style="color:blueviolet;" value="Entrar">
				</form>
			</div>
		</div>


	</body>
</html>
