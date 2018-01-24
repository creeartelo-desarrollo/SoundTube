<div style="font-family: Arial; text-align: justify; width: 90%; margin: 30px auto;">
	<h1> Notificación <?= $config["NAME"]?></h1>
	<p>
		Hola <strong><?= $evento->Nombres . " " . $evento->Apellidos ?></strong> hemos eliminado tu evento de <strong><?= $evento->TipoServicio ?>. <?= $evento->Sala ?></strong>
		Puedes verficarlo entrando a tu cuenta desde nuestra página <br>
		<a href="<?= base_url() ?>" style="background-color:#323b8d;color:#fff;padding: 18px 0px;text-decoration:none;display: block; width:220px; text-align:center; margin: 17px auto">IR A LA PÁGINA</a>
	</p>
</div>
	