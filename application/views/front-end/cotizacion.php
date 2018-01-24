<!-- <pre>
	<?php print_r($cotizacion_detalle) ?>
</pre> -->


<!-- CABECERA -->
<div style="font-family: Helvetica;">
	<div style="float: left; width: 390px">
		<img src="./public/libs/front/images/logo_black.png" style="max-width: 100%">
	</div>
	<div  style="text-align: right; float: right">
		<br>
		Calle Sonora 276 <br>
		Col. El Mante, Zapopan , Jalisco <br>
		C.P. 45235, Tel: 32710872 <br>
	</div>
	<div style="width: 100%; border-bottom: solid 4px #2427ae;  box-shadow: 0px 2px 0px; margin-top: 35px"></div>
</div>

<div style="margin-top: 50px; font-family: Helvetica">
<div style="width:50%; float: left">
	<?= date_format(date_create($cotizacion->Fecha),"Y/m/d")?>
</div>
<div style="width:50%; float: right; text-align: right;">
	<strong>Atención:</strong> <br>
	<?= $cotizacion->Nombres . " " . $cotizacion->Apellidos ?> <br> <br>
	<strong>Cotización:</strong> <br>
	
	<?php foreach($cotizacion_detalle as $servicio){ ?>
		<?php foreach ($servicio as $cot) { ?>
			<?php if($cot["Remitente"] == "C" && $cot["Operacion"] != "SEP"){ ?>
				<?= $cot["Pregunta"]; ?><br> 	
				<?php break; ?>			
			<?php } ?>
		<?php } ?>
	<?php } ?>
</div>


<!-- BREAD CRUMBS -->
<div style="width: 100%; margin-bottom: 50px">
	<strong>Descripción del proyecto</strong> <br>
	<?php foreach ($cotizacion_detalle as $servicio) { ?>
		<span>*</span>
		<?php foreach ($servicio as $cot) { ?>
			<?php if($cot["Remitente"] == "C" && $cot["Operacion"] != "SEP"){ ?>
				<span style="display: inline-block;"><?php if($cot["Tipo"] == "number"){ ?>
					<?= $cot["Valor"] ?> 
				<?php }?>	
				<?= $cot["Pregunta"] ?> / <span>
			<?php	} ?>
		<?php } ?>
		<span>*</span> <br> 
	<?php } ?>
</div>

<!-- DESGLOSE -->
<div>
	<strong>Desglose</strong> <br>
	<table style="font-family: Helvetica;" cellspacing="0" cellpadding="0">
		<?php
			$total = 0.0; 
			#	array de los servicios
			foreach ($cotizacion_detalle as $servicio) {
				$subtotal = 0.0; 
				#	array de respuestas
				foreach ($servicio as $cot) {
					#	Valores con los que puede trabajar de las respuestas
					$valor  = floatval($cot["Valor"]);
					$valor2 = floatval($cot["Valor_2"]);

					#	Si el remitente es el cliente se realizan y se muestran las operaciones
					if($cot["Remitente"] == "C" && $cot["Operacion"] != "SEP"){
						#	Si Operación es SUM: Se suma el valor al subtotal 
						if($cot["Operacion"] == "SUMA"){
							$subtotal += $valor;
						}elseif($cot["Operacion"] == "MULT"){
							if($subtotal == 0){
								$subtotal = 1; 
							}
							$subtotal *= $valor;
						}elseif($cot["Operacion"] == "MULSU"){
							$subtotal += ($valor * $valor2);
						}


		?>
						<tr>
							<td style="border: none; vertical-align: middle; text-align: left;  width: 300px"><?= $cot["Pregunta"] ?> </td>
							<?php if($cot["Operacion"] == "NO") {?>
								<td style="border: none; vertical-align: middle; text-align: left; font-weight: bold;"></td>
							<?php }else if($valor2 > 0){ ?>
								<td style="border: none; vertical-align: middle; text-align: left;"><?= ($valor * $valor2) ." (".$valor . "x" . $valor2 . ") "   ?></td>
							<?php }else{?>
								<td style="border: none; vertical-align: middle; text-align: left;"><?= $valor?></td>
							<?php } ?>
							<td style="width: 100px;"></td>
						</tr>	
			<?php	}
				}

				$total += $subtotal;
			?>
				<tr>
					<td colspan="3" style="text-align: right; border-bottom:solid 4px #2427ae; "> $<?= $subtotal ?></td>
				</tr>
			<?php }			
		?>

		<tr>
			<td style="height: 50px; vertical-align: bottom;">TOTAL</td>
			<td style="text-align: right; vertical-align: bottom;" colspan="2"> <strong>$<?= number_format($total,2) ?></strong></td>
		</tr>
	</table> <br><br>
	<h4>Notas:</h4>
	<p>
		En los servicios de Grabación Musical y Live Session considera que el 30% del tiempo contratado es destinado a post-producción. <br>
		En la renta de sala Surround (2.1, 5.1 y 7.1) para mezcla de cine, incluye ingeniero de apoyo. <br>
		Los precios no incluyen impuestos. <br>
		El alcance de la presente cotización será solamente por los servicios aquí descritos, aunque puede sufrir ajustes dependiendo las eventualidades que llegaran a presentarse. <br>
		La presente cotización tiene una validez de 15 días naturales a partir de la fecha descrita en la misma. <br> <br>

		*Esta cotización se calcula con base a los requerimientos regulares del género; para una cotización más acertada a tus necesidades, te invitamos a comunicarte con nosotros vía correo electrónico o llámanos al teléfono que aparece en la parte superior de este documento.
	</p>
	<p style="text-align: right;">
		¡Gracias por confiar en nosotros! <br>
		Esperamos colaborar contigo. <br><br>

		Atentamente: <br><br>

		<strong>Equipo SoundTube</strong>
	</p>
</div>