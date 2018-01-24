<!DOCTYPE html>
<html lang="es">
<head>
	<title>Promoción Live Sessions</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Formulario para solicitar información sobre la Promoción de Live Sessions SoundTube">
	<meta name="keywords" content="Promoción, Live Sessions, Estudio de Grabación">
	<link rel="shortcut icon" href="<?= base_url('public/libs/front/images/favicon.ico') ?>"> 
	<link rel="stylesheet" href="<?= base_url('public/libs/foundation/css/foundation.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('public/libs/front/css/promos.css') ?>">
	<style type="text/css">
		body{background-image: url("<?= base_url('public/libs/front/images/background-promo-1.jpg') ?>");}
	</style>
	<!-- Facebook Pixel Code -->
	<script>
		!function(f,b,e,v,n,t,s)
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];
		s.parentNode.insertBefore(t,s)}(window,document,'script',
		'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '470730396630414'); 
		fbq('track', 'PageView');
	</script>
	<noscript>
		 <img height="1" width="1" 
		src="https://www.facebook.com/tr?id=470730396630414&ev=PageView
		&noscript=1"/>
	</noscript>
	<!-- End Facebook Pixel Code -->
</head>
<body>
	<div class="alert alert-error"></div>
	<div class="alert alert-success"></div>

	<section id="content">
		<!-- <div class="row"> -->
			<div class="columnas column large-6 medium-6" style="background-color: #fff">
				<img src="<?= base_url('public/libs/front/images/live-sessions.png') ?>" alt="Live Sessions SoundTube" class="img-responsive" style="width:210px">
				<h1 class="aprovecha">APROVECHA NUESTRA PROMOCIÓN DE LANZAMIENTO</h1>
				<img src="<?= base_url('public/libs/front/images/grabacion-y-edicion.png') ?>" alt="7,000.00 Grabación y Edición" class="img-responsive" style="width:184px; margin-top: 20px">
				<p class="info">
					Vive la experiencia de   
					“Live Session by SoundTube” 
					En un solo día puedes tener  
					una grabación profesional 
					en audio y video, listo para  
					poder promocionar tu 
					música, <span class="grito">mostrando un  
					performance natural y en vivo.</span> 
				</p>
				<p class="info">
					Espacio amplio en doble altura.
					48 canales en directo
					5 camaras HD
					Edición profesional
					Salida en diferentes formatos
					Ingreso al estudio  9:00 AM
					Entrega de material terminado  6:00 PM
				</p>
				<img src="<?= base_url('public/libs/front/images/pago-tarjeta.png') ?>" alt="Pago con tarjeta" style="width: 200px">
			</div>
			<div class="columnas column large-6 medium-6">
				<h2 class="ponte">PONTE EN CONTACTO AHORA MISMO</h2>
				<form id="frmcontacto" action="<?= base_url('welcome/enviarPromo') ?>">
					<input type="hidden"  name="hdnformulario" value="1">
					<input type="text" placeholder="Nombre" name="txtnombre">
					<input type="text" placeholder="Correo Electrónico" name="emlcorreo_electronico">
					<input type="text" placeholder="Teléfono" name="txttelefono">
					<input type="number" placeholder="Nº Personas del performance" name="nmbpersonas" step="1" min="1">
					<textarea placeholder="Observaciones / Preguntas" rows="5" name="txaobservaciones"></textarea>
					<div class="spinner">Trabajando...</div>
					<button type="reset">BORRAR</button>
					<button type="submit">ENVIAR</button>					
				</form>
				<h3 class="breve">EN BREVE NOS COMUNICAMOS CONTIGO PARA RESPONDER TUS DUDAS Y AGENDAR TU SESIÓN</h3>
				<h4 class="valida">Promoción válida hasta el 30 de Septiembre 2017</h4>

				<img src="<?= base_url('public/libs/front/images/logo_2.png')?>" alt="SoundTube”" id="logo">
			</div>
		<!-- </div> -->
	</section>
	<script type="text/javascript" src="<?= base_url('public/libs/jQuery/js/jquery-2.2.3.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('public/libs/jquery-validation/js/jquery.validate.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('public/libs/front/js/promos.js') ?>"></script>
</body>
</html>