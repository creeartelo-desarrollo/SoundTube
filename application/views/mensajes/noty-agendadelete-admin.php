<div style="font-family: Arial; text-align: justify; width: 90%; margin: 30px auto;">
	<h1> Notificación <?= $config["NAME"]?></h1>
	<p>
		El cliente <strong><?= $evento->Nombres . " " . $evento->Apellidos ?></strong> ha dado de baja al evento de <strong><?= $evento->TipoServicio ?>. <?= $evento->Sala ?></strong>
		Puedes consultar los cambios en el panel de administración <br>
		<a href="<?= base_url('admin') ?>" style="background-color:#323b8d;color:#fff;padding: 18px 0px;text-decoration:none;display: block; width:220px; text-align:center; margin: 17px auto">IR AL ADMINISTRADOR</a>
	</p>
</div>
	