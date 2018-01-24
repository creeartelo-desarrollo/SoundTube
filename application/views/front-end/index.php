<!DOCTYPE html>
<html lang="es">
<head>
	<title>SoundTube</title>
	<meta charset="utf-8">
	<meta http-equiv=X-UA-Compatible content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="grabación audio, música, liveSessions, mezcla Dolby 2.1  5.1  y 7.1, composición musical, arreglos musicales,  post producción fílmica" >
	<meta name="description" content="Empresa dedicada a la producción, grabación y distribución de audio; 20 años de experiencia en desarrollar, dirigir, producir, editar y realizar productos audiovisuales">
	<meta name="keywords" content="grabación audio, música, liveSessions, mezcla Dolby 2.1  5.1  y 7.1, composición musical, arreglos musicales,  post producción fílmica" >
	<meta name="subject" content="Soundtube" >
	<link rel="shortcut icon" href="<?= base_url('public/libs/front/images/favicon.ico') ?>"> 
	<!-- Styles -->
	<link rel="stylesheet" href="<?=base_url('public/libs/front/css/all.min.css')?>"> 
</head>
<body>
	<div id="preloader">
		<svg>
			<line x1="0" y1="0" x2="100%" y2="0"></line>
		</svg>
		<img src="<?= base_url('public/libs/front/images/preloader.gif')?>" alt="">
	</div>
	<div class="alert alert-error"></div>
	<div class="alert alert-success"></div>
	<!-- BARRA SUPERIOR -->
	<nav id="top-bar">
		<a href="#" id="logotipo">
			<img src="<?=base_url('public/libs/front/images/logo_2.png')?>" alt="SoundTube">
		</a>		
		<!-- session -->
		<?php if(!isset($session["Id_Usuario"])){?>
			<a class="icons-bar login">
				<img src="<?= base_url('public/libs/front/images/user-white.png')?>" alt="">				
				<span>Entrar</span>
			</a>
		<?php ;}elseif($session["Id_Tipo_Rol"] == 1){ ?>
			<div id="foto-perfil" style="background-image: url(public/uploads/usuarios/thumbnail/<?=$session['Ruta_Imagen'] ?>)" data-text="<?= substr($session["Nombres"],0,1) ?>">
				<ul id="menu-perfil" style="display: none;">
					<li><a href="<?= base_url('bi') ?>">MI CUENTA</a></li>
					<li><a href="<?= base_url('welcome/logout') ?>">CERRAR SESIÓN</a></li>
				</ul>
			</div>			
		<?php ;}elseif($session["Id_Tipo_Rol"] == 2 && $session["Ruta_Imagen"]){ ?>
			<div id="foto-perfil" style="background-image: url(<?= $session['Ruta_Imagen'] ?>)" data-text="<?= substr($session["Nombres"],0,1) ?>">
				<ul id="menu-perfil" style="display: none;">
					<li><a href="<?= base_url('mibi') ?>">MI CUENTA</a></li>
					<li><a href="<?= base_url('welcome/logout') ?>">CERRAR SESIÓN</a></li>
				</ul>
			</div>
		<?php ;}else{ ?>
			<div id="foto-perfil" style="background-image: url(public/uploads/usuarios/thumbnail/default.png)" data-text="<?= substr($session["Nombres"],0,1) ?>">
				<ul id="menu-perfil" style="display: none;">
					<li><a href="<?= base_url('mibi') ?>">MI CUENTA</a></li>
					<li><a href="<?= base_url('welcome/logout') ?>">CERRAR SESIÓN</a></li>
				</ul>
			</div>
		<?php ;} ?>
		<div class="segunda-barra">
			<a class="icons-bar show-agenda">
				<img src="<?= base_url('public/libs/front/images/calendar-icon.png')?>" alt="">
				<span>Agenda</span>
			</a>
			<a class="icons-bar show-cotizador">				
				<img src="<?= base_url('public/libs/front/images/cotizador-icon.png')?>" alt="">
				<span>Cotizador</span>
			</a>
			<!-- blog -->
			<a class="blog" href="<?=base_url('blog')?>" target="_blank">
				<svg>
				  <circle cx="15" cy="15" r="14"/>
				</svg>
				<span>Blog</span>
			</a>
			<!-- menu redes -->
			<div  id="menuredes">
				<ul>
					<li class="displayer">
						<a>
							<svg>
							  <circle cx="17.5" cy="17.5" r="16"/>
							</svg>
						</a>
					</li>
					<li>
						<a title="https://www.facebook.com/SoundTubeMX/" href="https://www.facebook.com/SoundTubeMX/"  target="_blank">
							<svg>
							  <circle cx="17.5" cy="17.5" r="16"/>
							</svg>
						</a>
					</li>
					<li>
						<a title="https://twitter.com/soundtubemx" href="https://twitter.com/soundtubemx" target="_blank">
							<svg>
							  <circle cx="17.5" cy="17.5" r="16"/>
							</svg>
						</a>
					</li>
					<li>
						<a title="https://www.youtube.com/channel/UCeW1qZHzSvYTW2Ta-g_u6aA" href="https://www.youtube.com/channel/UCeW1qZHzSvYTW2Ta-g_u6aA" target="_blank">
							<svg>
							  <circle cx="17.5" cy="17.5" r="16"/>
							</svg>
						</a>
					</li>
					<li>
						<a title="https://www.instagram.com/soundtubemx/" href="https://www.instagram.com/soundtubemx/" target="_blank">
							<svg>
							  <circle cx="17.5" cy="17.5" r="16"/>
							</svg>
						</a>
					</li>
					<li>
						<a title="https://www.snapchat.com/add/soundtubemx" href="https://www.snapchat.com/add/soundtubemx" target="_blank">
							<svg>
							  <circle cx="17.5" cy="17.5" r="16"/>
							</svg>
						</a>
					</li>
					<li>
						<a title="https://soundcloud.com/soundtubemx" href="https://soundcloud.com/soundtubemx" target="_blank">
							<svg>
							  <circle cx="17.5" cy="17.5" r="16"/>
							</svg>
						</a>
					</li>
				</ul>
			</div>

			<!-- contacto -->
			<a class="contacto">
				contacto
			</a>
		</div>
	</nav>
	<!-- MENUS PRINCIPALES -->
	<a class="mainmenus" id="mnunosotros">
		<span>Nosotros</span>
		<svg>
			<line x1="0" y1="0" x2="0" y2="50" />
			<line x1="2" y1="0" x2="2" y2="120" />
		</svg>
	</a>
	<a class="mainmenus" id="mnuservicios">
		<svg>
			<line x1="0" y1="0" x2="50" y2="0" />
			<line x1="0" y1="2" x2="120" y2="2" />
		</svg>
		<span>Servicios</span>
	</a>
	<a class="mainmenus" id="mnuserviciosmb">
		<svg>
			<line x1="0" y1="0" x2="50" y2="0" />
			<line x1="0" y1="2" x2="120" y2="2" />
		</svg>
		<span>Servicios</span>
	</a>
	<a class="mainmenus" id="mnushowsroom">
		<svg>
			<line x1="0" y1="0" x2="0" y2="50" />
			<line x1="2" y1="0" x2="2" y2="120" />
		</svg>
		<span>Galería</span>
	</a>
	<!-- MENÚ DE SERVICIOS -->
	<nav  id="menuservicios" class="">
		<span class="close"></span>
		<ul>
			<li>
				<a class="compmusical">
					<span> Composición musical y arreglos</span>
					<svg>
					  <circle cx="25" cy="25" r="12"/>
					  <line x1="25" y1="12" x2="25" y2="38" />
					</svg>
				</a>
			</li>
			<li>
				<a class="livesession">
					<span> Live Sessions</span>
					<svg>
					  <circle cx="25" cy="25" r="12"/>
					  <line x1="25" y1="12" x2="25" y2="38" />
					</svg>
				</a>
			</li>
			<li>
				<a class="dsonoro">
					<span> Post-Producción Fílmica</span>
					<svg>
					  <circle cx="25" cy="25" r="12"/>
					  <line x1="25" y1="12" x2="25" y2="38" />
					</svg>
				</a>
			</li>
			<li>
				<a class="mezcla">
					<span> Mezcla Dolby 2.1, 5.1 y 7.1</span>
					<svg>
					  <circle cx="25" cy="25" r="12"/>
					  <line x1="25" y1="12" x2="25" y2="38" />
					</svg>
				</a>
			</li>
		</ul>
	</nav>
	<!-- VIDEO PRINCIPAL -->
	<div class="cortina-negra"></div>
	<video id="videoprincipal" poster="<?=base_url('public/libs/front/images/home.jpg')?>" playsinline autoplay muted loop class="videobg">
		<source src="<?=base_url('public/libs/front/images/home.m4v')?>" type="video/mp4">
		<source src="<?=base_url('public/libs/front/images/home.mp4')?>" type="video/mp4">
		<source src="<?=base_url('public/libs/front/images/home.webm')?>" type="video/webm">
		<source src="<?=base_url('public/libs/front/images/home.ogg')?>" type="video/ogg">
	</video>
	<!-- SECCIONES -->
	<div id="secciones-container">	
		<!-- PRINCIPAL -->
		<section class="contenidos" id="principal">
			<div class="mensaje">
				<h2>
					<span data-text="IDEAS">IDEAS</span>
					<span data-text="EXPRESADAS">EXPRESADAS</span> 
					<span data-text="EN">EN</span>
					<span data-text="SONIDO">SONIDO</span>
				</h2>					
			</div>
		</section>
		<!-- SERVICIOS -->
		<!-- COMP MUSICAL -->
		<div class="contenidos servicios" id="compmusical">
			<span class="close"></span>
			<div class="cortina-negra"></div>
			<video poster="<?=base_url('public/libs/front/images/composicion.jpg')?>" playsinline autoplay muted loop class="videobg">
				<source src="<?=base_url('public/libs/front/images/composicion.m4v')?>" type="video/mp4">
				<source src="<?=base_url('public/libs/front/images/composicion.mp4')?>" type="video/mp4">
				<source src="<?=base_url('public/libs/front/images/composicion.webm')?>" type="video/webm">
				<source src="<?=base_url('public/libs/front/images/composicion.ogg')?>" type="video/ogg">
			</video>
			<div class="mensaje">
				<h2>
					<span data-text="COMPOSICIÓN">COMPOSICIÓN</span>
					<span data-text="MUSICAL Y">MUSICAL Y</span> 
					<span data-text="ARREGLOS">ARREGLOS</span>
				</h2>				
				<p class="descripcion large-6 medium-6">
					Profesionalizamos tu material o musicalizamos tu idea. Nos aseguramos de brindarte la satisfacción que buscas con los más altos estándares de calidad.
				</p>
				<div class="botones">
					<button type="button" class="button show-cotizador close">SOLICITAR COTIZACIÓN</button>
					<button type="button" class="button show-agenda close">AGENDAR EVENTO</button>
				</div>					
			</div>
		</div>
		<!-- LIVE SESSIONS -->
		<div class="contenidos servicios" id="livesession">
			<span class="close"></span>
			<div class="cortina-negra"></div>
			<video poster="<?=base_url('public/libs/front/images/livesessions.jpg')?>" playsinline autoplay muted loop preload="auto" class="videobg">
				<source src="<?=base_url('public/libs/front/images/livesessions.m4v')?>" type="video/mp4">
				<source src="<?=base_url('public/libs/front/images/livesessions.mp4')?>" type="video/mp4">
				<source src="<?=base_url('public/libs/front/images/livesessions.webm')?>" type="video/webm">
				<source src="<?=base_url('public/libs/front/images/livesessions.ogg')?>" type="video/ogg">
			</video>
			<div class="mensaje">
				<h2>
					<span data-text="LIVE">LIVE</span>
					<span data-text="SESSIONS">SESSIONS</span> 
				</h2>
				<p class="descripcion large-6 medium-6">
					La mejor opción para lanzar tu proyecto artístico, con la inmediatez y calidad que exigen los medios de difusión actuales. 
				</p>
				<div class="botones">
					<button type="button" class="button show-cotizador close">SOLICITAR COTIZACIÓN</button>
					<button type="button" class="button show-agenda close">AGENDAR EVENTO</button>
				</div>									
			</div>
		</div>
		<!-- DISEÑO SONORO -->
		<div class="contenidos servicios" id="dsonoro">
			<span class="close"></span>
			<div class="cortina-negra"></div>
			<video poster="<?=base_url('public/libs/front/images/foley.jpg')?>" playsinline autoplay muted loop class="videobg">
				<source src="<?=base_url('public/libs/front/images/foley.m4v')?>" type="video/mp4">
				<source src="<?=base_url('public/libs/front/images/foley.mp4')?>" type="video/mp4">
				<source src="<?=base_url('public/libs/front/images/foley.webm')?>" type="video/webm">
				<source src="<?=base_url('public/libs/front/images/foley.ogg')?>" type="video/ogg">				
			</video>
			<div class="mensaje">
				<h2>
					<span data-text="POST-PRODUCCIÓN">POST-PRODUCCIÓN</span>
					<span data-text="FíLMICA">FíLMICA</span> 
				</h2>
				<p class="descripcion large-6 medium-6">
					Diseño sonoro, efectos de sonido, foley y doblaje… todo lo necesario para generar un impacto sensorial auditivo con la determinación que exige el medio.
				</p>
				<div class="botones">
					<button type="button" class="button show-cotizador close">SOLICITAR COTIZACIÓN</button>
					<button type="button" class="button show-agenda close">AGENDAR EVENTO</button>
				</div>				
			</div>	
		</div>
		<!-- MEZCLA -->
		<div class="contenidos servicios" id="mezcla">
			<span class="close"></span>
			<div class="cortina-negra"></div>
			<video poster="<?=base_url('public/libs/front/images/mezcla.jpg')?>" playsinline autoplay muted loop class="videobg">
				<source src="<?=base_url('public/libs/front/images/mezcla.m4v')?>" type="video/mp4">
				<source src="<?=base_url('public/libs/front/images/mezcla.mp4')?>" type="video/mp4">
				<source src="<?=base_url('public/libs/front/images/mezcla.webm')?>" type="video/webm">
				<source src="<?=base_url('public/libs/front/images/mezcla.ogg')?>" type="video/ogg">
			</video>
			<div class="mensaje">
				<h2>
					<span data-text="MEZCLA DOLBY">MEZCLA DOLBY</span>
					<span data-text="2.1, 5.1 Y 7.1">2.1, 5.1 Y 7.1</span> 
				</h2>
				<p class="descripcion large-6 medium-6">
					El equipo que necesitas para crear un impacto sonoro en toda su dimensión audiovisual. 
				</p>
				<div class="botones">
					<button type="button" class="button show-cotizador close">SOLICITAR COTIZACIÓN</button>
					<button type="button" class="button show-agenda close">AGENDAR EVENTO</button>
				</div>				
			</div>	
		</div>
		<!-- NOSOTROS -->
		<div class="contenidos" id="nosotros">
			<video poster="<?=base_url('public/libs/front/images/nosotros.jpg')?>" playsinline autoplay muted loop class="videobg">
				<source src="<?=base_url('public/libs/front/images/nosotros.m4v')?>" type="video/mp4">
				<source src="<?=base_url('public/libs/front/images/nosotros.mp4')?>" type="video/mp4">
				<source src="<?=base_url('public/libs/front/images/nosotros.webm')?>" type="video/webm">
				<source src="<?=base_url('public/libs/front/images/nosotros.ogg')?>" type="video/ogg">
			</video>
			<span class="close"></span>
			<div class="contenedor-scroll">
				<!-- ABOUT US -->
				<div class="subsecciones" id="about-us">
					<div class="mensaje">
						<h2>
							<span data-text="AMAMOS">AMAMOS</span>
							<span data-text="LO QUE HACEMOS">LO QUE HACEMOS</span>
						</h2>						
						<p>
							Somos un grupo de creativos apasionados por la producción musical y el audio. A lo largo de 20 años, nos hemos capacitado para desarrollar, dirigir, producir, 
							editar y realizar productos audiovisuales en sus diversas etapas y formatos. 
						</p>
					</div>
					<span class="scroll-down"></span>
				</div>
				<!-- EQUIPO -->
				<div class="subsecciones" id="equipo">
					<div class="mensaje">
						<h2>
							<span data-text="EQUIPO">EQUIPO</span>
							<span data-text="HUMANO">HUMANO</span>
						</h2>
					</div>
					<div class="contenedor">
						<div class='fotos-equipo'>
							<div class="equipo-descripcion">
								<h3>Andres Huerta </h3>
								<p>Director General</p>
							</div>
						</div>
						<div class='fotos-equipo'>
							<div class="equipo-descripcion">
								<h3>Juan Pablo Huerta</h3>
								<p>Director de Operaciones.</p>
							</div>
						</div>
						<div class='fotos-equipo'>
							<div class="equipo-descripcion">
								<h3>Yosvany Estepe</h3>
								<p>Director Musical</p>
							</div>
						</div>
						<div class='fotos-equipo'>
							<div class="equipo-descripcion">
								<h3>Mario Martínez Cobos</h3>
								<p>Diseño Sonoro</p>
							</div>
						</div>
						<div class='fotos-equipo'>
							<div class="equipo-descripcion">
								<h3>Mario Ozuna</h3>
								<p>Diseño Sonoro y Música</p>
							</div>
						</div>
						<div class='fotos-equipo'>
							<div class="equipo-descripcion">
								<h3>German Cuervo</h3>
								<p>Ingeniero de Audio (invitado)</p>
							</div>
						</div>
					</div>					
				</div>
				<div class="subsecciones" id="equipo-tec">
					<div class="mensaje">
						<h2>
							<span data-text="INSTALACIONES">INSTALACIONES</span>
							<span data-text="Y EQUIPO">Y EQUIPO</span>
						</h2>
					</div>
					<div class="contenedor">
						<div class="columns large-12">
							<h3>Ficha Técnica Surround Room</h3>
							<ul class="columns large-6">
								<li>Cuarto de 133mts cúbicos</li>
								<li>Computadora	Apple Mac Pro</li>
								<li>DAW (Digital Audio Workstation) Avid Pro Tools HDX</li>
								<li>Software Avid Pro tools 12</li>
								<li>Tarjeta 1 Avid HDX</li>
								<li>Tarjeta 2 Avid HD Native</li>
								<li>Interface 1 Avid HD OMNI</li>
								<li>Interface 2	Digi Design 96</li>								
								<li>Controlador	Digi Design	Icon D-Control 32</li>
							</ul>
							<ul class="columns large-6">
								<li>Monitoreo Digi Design X Mon</li>
								<li>Pantalla Strong MDI Microperforada</li>
								<li>Proyector Optoma HD25-LV</li>
								<li>Screen Wall Speakers (3) JBL 3722n</li>
								<li>Surround Speakers (10) JBL 8320</li>
								<li>Amplificador 1 Crown Dci 8/300</li>
								<li>Amplificador 2 Crown Dci 2/300</li>
								<li>Reproductor BlueRay Tascam BD-O1U</li>
							</ul>
						</div>
						<div class="columns large-12">
							<h3>Ficha Técnica Control Room</h3>
							<ul class="columns large-6">
								<li>Cuarto de 95mts cúbicos</li>
								<li>Computadora	Apple Mac Pro</li>
								<li>DAW (Digital Audio Workstation)	Avid Pro Tools HDX</li>
								<li>Software Avid Pro tools 12</li>
								<li>Tarjeta1 Avid HDX</li>
								<li>Interface 1	Digi Design	96i</li>
								<li>Interface 2	Digi Design	96</li>
								<li>Interface 3	Digi Design	96</li>
							</ul>
							<ul class="columns large-6">	
								<li>Controlador	Digi Design	C 24</li>
								<li>Monitores A	Adam A8X</li>
								<li>Monitores B	Mackie HR824</li>
								<li>Preamp 1 Avalon	737p</li>
								<li>Preamp 2 Neve Portico 5024</li>
								<li>Preamp 3 Solid State Logic Alpha VHD</li>
								<li>Preamp 4 Midas XL48</li>
							</ul>
						</div>
						<div class="columns large-12">
							<h3>Ficha Técnica Tracking Room</h3>
							<ul class="columns large-6">	
								<li>Cuarto de 145mts cúbicos</li>	
								<li>32 Canales XLR</li>		
								<li>8 Canales TRS</li>		
								<li>Intrumento de iluminación Alien 42x1</li>
								<li>3 Instrumentos de iluminación Showco 250</li>
								<li>Cámara de Video HD (PTZ) JVC GV-LS2</li>
								<li>Micrófono de Condensador AKG C12-V</li>
								<li>Micrófono de Condensador (4) AKG C451</li>
								<li>Micrófono de Condensador AKG C4000</li>
								<li>Micrófono de Condensador AKG C2000</li>
								<li>Micrófono de Condensador (3) Behringer B-1</li>
								<li>Micrófono Dinámico (3) CAD	TSM411</li>
								<li>Micrófono Dinámico (2) ElectroVoive	ND468</li>
								<li>Micrófono de Condensador Manley	Reference</li>
								<li>Micrófono de Condensador MXL 2003</li>
							</ul>
							<ul class="columns large-6">
								<li>Micrófono de Condensador MXL V67</li>
								<li>Micrófono de Condensador Neumann KMS 104</li>
								<li>Micrófono de Condensador Oktava	MK319</li>
								<li>Micrófono de Condensador Oktava	MK219</li>
								<li>Micrófono de Cinta (2) Rode NTR</li>
								<li>Micrófono de Condensador Rode NT2-A</li>
								<li>Micrófono de Condensador (3) Shure KSM32</li>
								<li>Micrófono de Condensador (2) Shure SM 81</li>
								<li>Micrófono Dinámico Shure SM 7</li>
								<li>Micrófono Dinámico Shure Beta 52</li>
								<li>Micrófono Dinámico (4) Shure SM 58</li>
								<li>Micrófono Dinámico (4) Shure SM 57</li>
								<li>Micrófono de Condensador Sennheiser	e901</li>
								<li>Micrófono Dinámico (3) Sennheiser e604</li>
								<li>Micrófono Dinámico Sennheiser e602</li>
							</ul>
						</div>				
						<div class="columns large-12">
							<h3>Ficha Técnica Foley/Dubbing Room</h3>
							<ul class="columns large-6">
								<li>Cuarto de 40 mts cúbicos</li>
								<li>Pantalla LCD 40"</li>
								<li>8 Canales XLR</li>
							</ul>
							<ul class="columns large-6">	
								<li>4 Canales TRS</li>
								<li>Pits (Tierra, Pasto, Cemento y madera)</li>
							</ul>
						</div>							
					</div>
				</div>
			<!-- 	<div class="subsecciones" id="instalaciones">
					<div class="contenedor">
						<iframe src="https://www.google.com/maps/embed?pb=!1m0!3m2!1ses!2smx!4v1489436772704!6m8!1m7!1sF%3A-OSqH83A3wVU%2FWMb4IcCsrAI%2FAAAAAAAABEA%2FJNZbrrjwGkQDCy6JK5pr2Id3XXzi52vggCLIB!2m2!1d20.60934595884765!2d-103.4212921187282!3f95.9!4f10.25!5f0.7820865974627469"></iframe>
					</div>
				</div> -->
				<!-- CONTACTO -->
				<div class="subsecciones" id="contacto">
					<!-- <div style="position: absolute; width: 100%; height: 100%">	 -->
					<!-- <div class="contenedor-scroll">	 -->
					<!-- <div> -->
						<div id="mapa" class="mapa"></div>
						<div class="mapa-controles">
							<button type="button" class="btn-toforms button btn-primary" id="toformwe"></button>
							<button id="zoomIn" class="zoomIn zooms"></button>
							<button id="<zoomOut></zoomOut>" class="zooms"></button>							
						</div>						
						<div class="rec-mapa">
							<div class="contenedor-scroll">
								<div class="info-contacto">
									<h2>Contacto</h2> 
									E-mail: <a href="mailto:contacto@soundtube.com.mx">contacto@soundtube.com.mx</a> <br>
									Teléfono: <a href="tel:+52 (33) 3271 0872">+52 (33) 3271 0872</a><br>
									<h2>Dirección</h2>
									<address>
										Calle Sonora Nº276 
										Col. El Mante, cp 45235 
										Zapopan, Jalisco  
										MÉXICO
									</address> 
								</div>	
								<form class="formularios-crud reverse" id="frmcontactowe" autocomplete="off">
									<h3>Escríbenos</h3>
									<div class="columns large-4 medium-4">
										<label>* Nombre</label>
										<input type="text" name="txtnombre" value="">
									</div>
									<div class="columns large-4 medium-4">
										<label>* E-mail</label>
										<input type="text" name="txtemail" value="">
									</div>
									<div class="columns large-4 medium-4">
										<label>* Teléfono</label>
										<input type="text" name="txttelefono" value="">
									</div>
									<div class="columns large-12 medium-12">
										<label>* Mensaje</label>
										<textarea name="txamensaje" cols="30" rows="5"></textarea>
									</div>
									<div class="spinner">Trabajando...</div>
									<div class="form-botones columns large-12 medium-12">
										<button type="reset" class="button btn-danger">				           
									       Cancelar
									 	</button>
									    <button class="button btn-primary">
									       Enviar
									    </button>
									</div>
								</form>		
							</div>					
						</div>
					<!-- </div> -->
				</div>
			</div>
		</div>
		<!-- SHOWROOM -->
		<div class="contenidos" id="showroom">
			<span class="close"></span>
			<div class="contenedor-scroll">
				<div class="mensaje">
					<h2>
						<span data-text="GALERÍA">GALERÍA</span>
					</h2>
				</div>
				<div class="contenedor">
					<?php  foreach ($showroom as $sr) { ?>
						<div class="listado-video" data-video="<?=$sr['Id_Video'] ?>" style="background-image: url(<?= base_url('public/uploads/showroom/' . $sr[Ruta_Imagen]) ?>)">
							<div class="detalle-video">
								<h3><?=$sr['Titulo'] ?></h3>
							</div>
						</div>
					<?php  } ?>
				</div>
			</div>
		</div>
		<!-- VIDEO -->
		<div class="contenidos" id="ver-video">
			<span class="close"></span>
			<iframe id="frame" allowfullscreen></iframe>
		</div>
		<!-- INICIO DE SESIÓN -->
		<div id="ventana-login" class="contenidos">
			<span class="close"></span>
			<div class="contenedor">
				<div class="contenedor-scroll">
					<!-- FORUMARIO DE LOGIN -->
					<form class="formularios-crud" id="frmforgot" autocomplete="off">
						<h3>¿Olvidaste tu contraseña?</h3>
						<p class="aviso">Ingresa tu correo electrónico y te enviaremos una contraseña nueva</p>
						<div class="large-5 medium-11 large-centered medium-centered">	
							<input type="email" name="txtemail" value="">
						</div>
						<div class="spinner">Trabajando...</div>
						<div class="large-12">
							<button class="button submit">Enviar</button>
							<button class="button regresar" type="button">Regresar</button>
						</div>
					</form>
					<form class="formularios-crud" id="frmlogin" autocomplete="off">
						<div class="columns large-6 medium-6">
							<button class='button' type='button' id="openregistrarme">Registrarme</button>
						</div>
						<div class="columns large-6 medium-6 divisor">
							<div class="large-12">	
								<h3>¡Incia sesión con Facebook!</h3>
								<button type="button" class="button btn-fb" onclick="fbData('login')">Conectarme</button> <br>
								<span class="separador">o</span>
							</div>
							<div class="large-12">
								<h3>Entra con tu correo electrónico</h3>
								<label>Correo electrónico</label>
								<input type="hidden" value="M" name="origen">
								<input type="email" name="txtemail">
								<label>Contraseña</label>
								<input type="password" name="pswcontrasena">
								<a id="openforgot" class="aviso">¿Olvidaste tu contraseña?</a>	
								<button class="button">Entrar</button>															
							</div>
						</div>							
						<div class="spinner">Trabajando...</div>						
					</form>
					<!-- FORMULARIO DE REGISTRO -->
					<form id="frmregistro" class="formularios-crud" autocomplete="off">
						<div class="large-12">
							<h3>¡Regístrate con Facebook!</h3>
							<button type="button" class="button btn-fb" onclick="fbData('registro')">Conectarme</button> 
							<span class="separador">o</span>
						</div>
						<div class="large-12">
							<h3>Crea tu cuenta manualmente</h3>
							<div class="completa">Verifíca tus datos y completa tu registro</div>
							<input type="hidden" name="origen" value="M">
							<input type="hidden" name="imagen">
							<div class="columns large-4 medium-4">
								<label>Correo Electrónico</label>
							<input type="email" name="txtemail" value="">
							</div>
							<div class="columns large-4 medium-4">
								<label>Nombre(s)</label>
							<input type="text" name="txtnombres" value="">
							</div>
							<div class="columns large-4 medium-4">
								<label>Apellido(s)</label>
								<input type="text" name="txtapellidos" value="">
							</div>
							<div class="columns large-4 medium-4">
								<label>Sexo</label>
								<select name="cmbsexo">
									<option value="">Seleccione sexo</option>
									<option value="female">Femenino</option>
									<option value="male">Masculino</option>
								</select>
							</div>
							<div class="columns large-4 medium-4">
								<label>Fecha de Nacimiento</label>
								<input type="text" placeholder="aaaa/mm/dd" name="txtfecha_nacimiento" value="">
							</div>
							<div class="columns large-4 medium-4">
								<label>Contraseña</label>
								<input type="password" name="pswcontrasena" id="pswcontrasena" value="">
							</div>
							<div class="columns large-4 medium-4">
								<label>Confirmar contraseña</label>
								<input type="password" name="pswcontrasenaconf" value="">
							</div>
							<div class="spinner columns large-4 medium-4">Trabajando...</div>
							<div class="form-botones columns large-12">
								<button class="button regresar" type="button">Regresar</button>	
								<button class="button submit">Aceptar</button>
							</div>
														
						</div>					
					</form>	
				</div>								
			</div>
			<div class="contenedor-aviso">
				<p class="aviso">Realiza cotizaciones en línea, agenda tus citas, recibe información</p>	
				<a href="<?= base_url('aviso-de-privacidad') ?>" target="_blank" class="aviso">Consulta nuestro <strong>aviso de privacidad</strong></a>							
			</div>
		</div>
		<!-- VENTANA CONTACTO -->
		<div class="contenidos" id="ventana-contacto">
			<span class="close"></span>
			<div class="contenedor-scroll">
				<div id="mapa-2" class="mapa"></div>
				<div class="mapa-controles">
					<button type="button" class="btn-toforms button btn-primary" id="toform"></button>
					<button id="zoomIn-2" class="zoomIn zooms"></button>
					<button id="zoomOut-2" class="zooms"></button>
				</div>

				<div class="rec-mapa">
					<div class="contenedor-scroll">
						<div class="info-contacto">
							<h2>Contacto</h2> 
							E-mail: <a href="mailto:contacto@soundtube.com.mx">contacto@soundtube.com.mx</a> <br>
							Teléfono: <a href="tel:+52 (33) 3271 0872">+52 (33) 3271 0872</a><br>
							<h2>Dirección</h2>
							<address>
								Calle Sonora Nº276 
								Col. El Mante, cp 45235 
								Zapopan, Jalisco  
								MÉXICO
							</address> 
						</div>
						<form class="formularios-crud reverse" id="frmcontacto" autocomplete="off">
							<h3>Escríbenos</h3>
							<div class="columns large-4 medium-4">
								<label>* Nombre</label>
								<input type="text" name="txtnombre" value="">
							</div>
							<div class="columns large-4 medium-4">
								<label>* E-mail</label>
								<input type="text" name="txtemail" value="">
							</div>
							<div class="columns large-4 medium-4">
								<label>* Teléfono</label>
								<input type="text" name="txttelefono" value="">
							</div>
							<div class="columns large-12 medium-12">
								<label>* Mensaje</label>
								<textarea name="txamensaje" cols="30" rows="5"></textarea>
							</div>
							<div class="spinner">Trabajando...</div>
							<div class="form-botones columns large-12 medium-12">
								<button type="reset" class="button btn-danger">				           
							       Cancelar
							 	</button>
							    <button class="button btn-primary">
							       Enviar
							    </button>
							</div>
						</form>					
					</div>
				</div>
			</div>
		</div>
		<!-- COTIZADOR -->
		<div id="cotizador" class="contenidos">
			<span class="close"></span>
			<?php  if(isset($session["Id_Usuario"]) && $session["Id_Tipo_Rol"] == 2){ ?>
				<img src="<?=base_url('public/libs/front/images/avatar.png')?>" alt="cotizador" id="avatar-image">
				<div id="conversacion" class="columns large-12">
					
				</div>
				<div id="escribiendo">
					SoundTube está escribiendo
				</div>
			<?php	}else{ ?>
				<form class="caja-center-align mensaje-ventana" autocomplete="off">
					<h3>¡Hola! agradecemos tu interés por solicitar una cotización</h3>
					<p>Solo tienes que iniciar sesión o registrarte haciendo click en el ícono de inicio de sesión.</p>
					<img src="<?= base_url('public/libs/front/images/user-white.png')?>" alt="" class="login">
				</form>
			<?php	} ?>
		</div>
		<!-- AGENDA -->
		<div id="agenda" class="contenidos">
			<span class="close"></span>
			<div class="contenedor-scroll">
				<div class="contenedor-top">
					<h3>AGENDA DE EVENTOS</h3>
					<button type="button" class="solicitar-agenda button">AGENDAR</button>
					<div id="calendar"></div>
				</div>
			</div>
		</div>
		<!-- EVENTO DETALLE -->
		<div class="contenidos" id="ventana-detalle">
			<span class="close"></span>
			<div id="evento-detalle" class="caja-center-align"></div>
		</div>
		<!-- FORMULARIO DE AGENDA -->
		<div class="contenidos" id="ventana-agendar">
			<span class="close"></span>
			<?php  if(isset($session["Id_Usuario"]) && $session["Id_Tipo_Rol"] == 2){ ?>
				<form id="frmevento" class="formularios-crud contenedor-top" autocomplete="off">
					<h3>SOLICITAR AGENDA</h3>
				    <input type="hidden" name="Id_Evento">
				    <div class="columns large-6 medium-6">
				      <label>Nombre</label>
				      <input type="text" name="txtnombre" value="<?= $session["Nombres"] . ' ' . $session["Apellidos"]?>">
				    </div>
				    <div class="columns large-6 medium-6">
				      <label>Teléfono</label>
				      <input type="text" name="txttelefono" value="">
				    </div>
				    <div class="columns large-6 medium-6">
				      <label>Correo Electrónico</label>
				      <input type="text" name="txtemail" value="<?= $session["Correo_Electronico"] ?>">
				    </div>
				    <div class="columns large-6 medium-6">
				      <label>Tipo de Servicio</label>
				      <select name="cmbtservicio" id="cmbtservicio">
				      <?php foreach($cattevento as $serv){?>
						<option value="<?=$serv["Id_Cat_Tipo_Evento"]?>"> <?= $serv["Nombre"]?></option>
				      <?php }?>
				      </select>
				    </div>
				    <div class="columns large-6 medium-6">
				      <label>Fecha de Inicio Solicitada</label>
				      <input type="text" id="txtfinicio" name="txtfinicio" value="">
				    </div>
				    <div class="columns large-6 medium-6">
				      <label>Fecha Fin Solicitada</label>
				      <input type="text" id="txtffin" name="txtffin" value="">
				    </div>          
				    <div class="columns large-12 medium-12">
				      <label>Observaciones</label>
				      <textarea name="txaobservaciones"></textarea>
				    </div>
				    <div class="spinner">Trabajando...</div>
				    <div class="form-botones columns large-12 medium-12">
				    	<button type="reset" class="button btn-danger close">				           
				           Cancelar
				     	</button>
				        <button class="button btn-primary">
				           Guardar
				        </button>
				  	</div>
				</form>
			<?php	}else{ ?>
				<div class="caja-center-align mensaje-ventana">
					<h3>¡Hola!, agradecemos tu interés por agendar.</h3>
					<p>Solo tienes que iniciar sesión o registrarte haciendo click en el ícono de inicio de sesión.</p>
					<img src="<?= base_url('public/libs/front/images/user-white.png')?>" alt="" class="login">
				</div>
			<?php	} ?>
		</div>
	</div>
	<script type="text/javascript">base_url = "<?=base_url()?>"</script>
	<!-- scripts -->
	<script src="<?=base_url('public/libs/front/js/all.min.js')?>"></script>
	<!-- Google -->
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOQtm2Jt3wSHSqyIsfdAGPgrvnFAQ3Rlc&callback=initMap" type="text/javascript"></script>
	<?php
		$msn = $this->session->flashdata("msn");
		$msne = $this->session->flashdata("msne");
		if(isset($msn)){?>
		fade("success","<?= $msn ?>");
	<?php } ?>
	<?php if(isset($msne)){?>
		fade("error","<?= $msne ?>");
	<?php } ?>

<script type="text/javascript">
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-88696785-1', 'auto');
	  ga('send', 'pageview');
</script>
</body>
</html>