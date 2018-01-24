<div style="font-family: Arial; font-size: 18px">
	<h3 style="text-align: center;">Enhorabuena un nuevo contacto en la campaña de Live Sessions</h3>
	<p style="margin-bottom: 30px; text-align: center;">
		Alguien ha solicitado información sobre la campaña de Live Sessions desde en el sitio <strong><?= $config["NAME"]?></strong>,
	</p>
	<p>
		<strong>Nombre: </strong> <?= $form["Nombre"]?> <br>
		<strong>Correo Electrónico: </strong> <?= $form["Correo_Electronico"]?> <br>
		<strong>Nº Personas: </strong> <?= $form["No_Personas"]?> <br>
		<strong>Observaciones: </strong> <?= $form["Observaciones"]?> <br>

	</p>

	<p>
		También puedes consultar los mensajes en el administrador:
	</p>
	<a href="<?=base_url('admin')?>" style="background-color: #323b8d; color: #fff; padding: 20px 10px; text-transform: none; width: 220px; display: block; text-align: center; margin: 0 auto">IR AL ADMINISTRADOR</a>
	
</div>