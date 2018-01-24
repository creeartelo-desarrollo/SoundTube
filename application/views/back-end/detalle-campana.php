<style type="text/css">
	#fondo-modal{
		padding: 20px;
	    color: #fff;
	    text-shadow: 1px 1px 3px;
	    top: 50%;
	    text-align: left;
	    width: 100%;
	    overflow: hidden;
	    font-size: 18px;
	}
	#fondo-modal h1{
		font-size: 20px;
	    text-transform: uppercase;
	    font-weight: bolder;
	    color: #fff;
	}
</style>
<div id="fondo-modal">
	<h1><?= $detalle->Nombre ?></h1>
	<p>Fecha de contacto: <strong><?= $detalle->Fecha ?></strong></p>
	<p>Correo Electrónico: <strong><?= $detalle->Correo_Electronico ?></strong></p>
	<p>Formulario: <strong><?= $detalle->Formulario ?></strong></p>
	<p>
		Observaciones / Preguntas: <br>
		<strong><?= $detalle->Observaciones ?></strong>
	</p>
</div>