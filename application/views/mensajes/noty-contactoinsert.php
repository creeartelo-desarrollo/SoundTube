<div style="font-family: Arial; text-align: justify; width: 90%; margin: 30px auto;">
	<h1> Notificación <?= $config["NAME"]?></h1>
	<p>
		Un nuevo contacto se ha registrado en <?= $config["NAME"]?> <br>
		<strong><?= $nombres . " " . $apellidos ?></strong> se ha unido al sitio. <br>
		Puedes consultarlo en el panel de administración <br>
		<a href="<?= base_url('admin') ?>" style="background-color:#323b8d;color:#fff;padding: 18px 0px;text-decoration:none;display: block; width:220px; text-align:center; margin: 17px auto">IR AL ADMINISTRADOR</a>
	</p>
</div>
	
