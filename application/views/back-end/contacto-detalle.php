<img src="<?= $contacto->Ruta_Imagen?>" style="border-radius: 999px">
<h1 style="font-size: 21px; color: #fff; text-transform: uppercase; font-weight: bold; font-family: Gotham;"><?= $contacto->Nombres . " " .$contacto->Apellidos ?></h1>
<h3 style="font-size: 18px; font-family: Gotham; color: #fff;"><?= $contacto->Correo_Electronico ?></h3>
<h3 style="font-size: 18px; font-family: Gotham; color: #fff;"><?= $contacto->Fecha_Nacimiento ?></h3>
<?php if($contacto->Genero == "f"){ ?>
	<h3 style="font-size: 18px; font-family: Gotham; color: #fff;"> MUJER</h3>
<?php }else{?>
	<h3 style="font-size: 18px; font-family: Gotham; color: #fff;">HOMBRE</h3>
<?php }?>
 <!-- Estatus -->
<form id="frmcontacto">
 	<input type="hidden" name="Id_Contacto" value="<?=$contacto->Id_Contacto?>">
  	<h3 style="font-size: 18px; font-family: Gotham; color: #fff;">ESTATUS</h3> 
  	<div class="radio3 radio-check radio-inline radio-success">
	    <input type="radio" id="optstatus1" name="optstatus" value="1"
		<?php if($contacto->Estatus == 1){ ?>
	     checked=""
		<?php }?>
	    >
    	<label for="optstatus1">ACTIVO</label>
	</div>
  	<div class="radio3 radio-check radio-inline radio-warning">
	    <input type="radio" id="optstatus2" name="optstatus" value="0"
		<?php if($contacto->Estatus == 0){ ?>
	     checked=""
		<?php }?>
	    >
    <label for="optstatus2">INACTIVO</label>
  </div>
</form>
