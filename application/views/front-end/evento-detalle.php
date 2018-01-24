<style type="text/css">
	#fondo-modal{
		padding: 20px;
	    color: #fff;
	    text-shadow: 1px 1px 3px;
	    top: 50%;
	    text-align: center;
	    width: 100%;
	    overflow: hidden;
	}
	#fondo-modal h1{
		font-size: 20px;
	    text-transform: uppercase;
	    font-weight: bolder;
	    color: #fff;
	}
	#fondo-modal h2{
		font-size: 16px;
	    text-transform: uppercase;
	    font-weight: bolder;
	    color: #fff;
	}
	#fondo-modal p.status span{
		font-weight: bold;
    	font-size: 1.7rem;
	}
	#fondo-modal button.btn-edit-reg {
		background-color: #323B8D;
	    border: none;
	    display: block;
	    width: 120px;
	    height: 40px;
	    float: right;
	}
	#fondo-modal button.btn-del-reg {
		background-color: #999;
	    border: none;
	    display: block;
	    width: 120px;
	    height: 40px;
	    float: left;
	}
</style>
<div id="fondo-modal">
	<h1><?= $evento->Titulo ?></h1>
	<h2><?= $evento->Nombres . " " . $evento->Apellidos ?></h2>
	<p>Inicio: <strong><?= $evento->Fecha_Inicio ?></strong></p>
	<p>Fin: <strong><?= $evento->Fecha_Fin ?></strong></p>
	<p><?= $evento->Observaciones ?></p>
	<p class="status">
		<?php if($evento->Status == 1){?>
			<span style="text-decoration: underline;">Activo</span>
		<?php }else{?>
			<span style="text-decoration: line-through">Inactivo</span>
		<?php } ?>
	</p>
</div>
	
