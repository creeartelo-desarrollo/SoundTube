<div style="font-family: Arial; text-align: justify; width: 90%; margin: 30px auto;">
	<h1 style="text-align: left;"> Gracias por agendar con nosotros <?= $config["NAME"]?></h1>
	<p>
		Hola <strong><?= $evento->Nombres . " " . $evento->Apellidos ?></strong>, hemos recibido una solicitud para agendar un evento con nosotros. <br>
		Por favor corrobora que los siguientes datos son correctos. <br>
	</p>	
	<p style="text-align: left;">
		<strong>Nombre:</strong> 					<?= $evento->Nombre ?>					<br>
		<strong>Correo Electrónico:</strong> 		<?= $evento->Correo_Electronico ?>		<br>
		<strong>Teléfono:</strong> 					<?= $evento->Telefono ?>				<br>
		<strong>Servicio:</strong> 					<?= $evento->TipoServicio ?>			<br>
		<strong>Fecha inicio solicitada:</strong> 	<?= $evento->Fecha_Inicio ?>			<br>
		<strong>Fecha fin solicitada:</strong> 		<?= $evento->Fecha_Fin ?>				<br>
		<strong>Observaciones:</strong> 		    <?= $evento->Observaciones ?>			<br>
	</p>

	<p>Si esta información es correcta, confírmalo haciendo click en este link</p>
	<a href="<?= base_url('miagenda/confirmacion/'.$evento->Key) ?>" style="background-color:#323b8d;color:#fff;padding: 18px 0px;text-decoration:none;display: block; width:220px; text-align:center; margin: 17px auto">CONFIRMAR</a>
	
</div>
	
