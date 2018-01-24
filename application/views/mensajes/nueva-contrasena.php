<!DOCTYPE html>
<html>
<head>
	<title><?= $config["NAME"]?> | Nueva contraseña</title>
	<meta charset="utf-8">
</head>
<body>
	<div style="font-family: Arial; text-align: justify; width: 90%; margin: 30px auto;">
	<h1> <?= $config["NAME"]?> | Nueva contraseña </h1>
	<p>
		Hola <strong><?= $usuario->Nombres ?></strong>. <br>
		Al parecer tienes problemas para ingresar a tu cuenta, así que hemos cambiado tu contraseña por la siguiente. <strong><?=$newpass?></strong> <br>
		Una vez iniciando sesión, puedes modficarla nuevamente.
		<a href="<?= base_url() ?>" style="background-color:#323b8d;color:#fff;padding: 18px 0px;text-decoration:none;display: block; width:220px; text-align:center; margin: 17px auto">REGRESAR A <?= $config["NAME"]?></a>
	</p>
</div>
</body>
</html>
