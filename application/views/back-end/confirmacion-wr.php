<!DOCTYPE html>
<html>
<head>
	<title>Confirmación de Evento</title>
	<link rel="stylesheet" href="<?= base_url('public/libs/front/css/main.css') ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		body{
			background-color: #fff;
			color: #000;
		}
	</style>
</head>
<body>
	<div style="width: 90%; margin: 30px auto">
		<img src="<?= base_url('public/libs/front/images/logo_black.png')?>" style="position: relative; margin: 0 auto; display: block; max-width: 100%"> <br>
		<h1 style="text-align: center; color: #304180">Ya has confirmado los datos de tu evento</h1>
		<p>Si tienes alguna duda sobre el estatus de tu evento puedes comunicarte con nosotros al teléfono: <strong><?= $configsite["TELS"] ?></strong></p>
		<img src="<?= base_url('public/libs/front/images/info.png')?>" style="animation-name: rebote; animation-duration: 1s; animation-iteration-count: infinite; position: relative; margin: 0 auto; display: block;">
	</div>
</body>
</html>