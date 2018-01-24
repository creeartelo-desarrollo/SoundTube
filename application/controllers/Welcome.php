<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->helper("security");
		$this->load->helper("cookie");
		$this->load->library("session");
		$this->load->model("Welcome_model");
		$this->load->model("Agenda_model");
		$this->load->library("form_validation");
	}

	#	Carga la vista del sitio
	#		- Envia a las vistas las variables necesarias para las funcionalidades
	#		  (Login URL  para inicio de sesión de FB, variables de sesión, catálogos de la agenda)
	public function index()
	{
		$data["session"] = $this->session->userdata();
		$permisos = array("email","user_birthday");
		$data["showroom"] = $this->Welcome_model->CNS_Showroom();
		$data["cattevento"] = $this->Agenda_model->CNS_CatalogoTiposEvento();
		$data["catsalas"] = $this->Agenda_model->CNS_CatalogoSalas();
		$this->cuentaVisitas();
		$this->load->view("front-end/index-min",$data);

		// print_r($data["session"]);
	}

	#	Carga de vistas de aviso de privacidad
	public function avisoPrivacidad(){
		$this->load->view("front-end/avisoprivacidad");
	}	 


	#	Login Facebook / Manual
	public function login(){
		$origen = $this->input->post("origen");
		if($origen == "F"){
			$this->form_validation->set_rules("email","Correo Electrónico","trim|xss_clean|max_length[200]|required");
			$email      = $this->input->post("email");
			$contrasena = null;
		}elseif($origen == "M"){
			$this->form_validation->set_rules("txtemail","Correo Electrónico","trim|xss_clean|max_length[200]|required");
			$this->form_validation->set_rules("pswcontrasena","Contraseña","trim|required|xss_clean");
			$email      = $this->input->post("txtemail");
			$contrasena = $this->input->post("pswcontrasena");
		}
		#	Si cumple con las validaciones se consultan los datos
		if($this->form_validation->run() == true)
	    {
			$login = $this->Welcome_model->Login($email,$contrasena);
	    	if($login){
	    		# Se construye un array con los permisos del usuario
	    		$array = $this->Welcome_model->CNS_Permisos(0);
		        $arraypermisos = array();
		        foreach ($array as $key => $value)
		        	$arraypermisos[$value["Abreviatura"]] = $value["Descripcion"];

		        #	Si el origen es F: se actualiza la info en B.D. con la info de FB 
		        if($origen == "F"){
					$arrayupdate = array(
								"Correo_Electronico" => $this->input->post("email"),
								"Apellidos"          => $this->input->post("apellidos"),
								"Nombres"            => $this->input->post("nombre"),
								"Fecha_Nacimiento"   => $this->input->post("fecha_nacimiento"),
								"Genero"             => $this->input->post("genero"),
								"Ruta_Imagen"        => $this->input->post("imagen"),								
								);
					$ar = $this->Welcome_model->UPD_Contacto($login->Id_Contacto,$arrayupdate);
				}

				#	Se guardan los datos del usuario en session
				$arraysession = array(
							"Id_Usuario"         => $login->Id_Contacto,
							"Id_Tipo_Rol"        => 2,
							"Correo_Electronico" => $login->Correo_Electronico,
							"Apellidos"          => $login->Apellidos,
							"Nombres"            => $login->Nombres,
							"Fecha_Nacimiento"   => $login->Fecha_Nacimiento,
							"Genero"             => $login->Genero,
							"Ruta_Imagen"        => $login->Ruta_Imagen,
							"Origen"			 => $origen,
							"permisos"			 => $arraypermisos										
							);
				$this->session->set_userdata($arraysession);

				#	Se manda mensaje al front
				echo "_ok:Bienvenid@ ".$login->Nombres;
				$this->session->set_flashdata("msn","Hola ".$login->Nombres.", bienvenid@");
	    	}else{
	    		echo "_er:Uh oh! Al parecer tu usuario y/o contraseña no coinciden en nuestro sistema. Verifíca los datos";
	    	}
	    }else{
			$errors = preg_replace("[\n|\r|\n\r]", "<br>", validation_errors());
			echo "_er:".$errors;
		}
		// $this->output->enable_profiler = true;
	}

	#	Registro Faceook /Manual
	public function registro()
	{
		date_default_timezone_set("America/Mexico_City");
		$errs = $this->getErrores("este correo electrónico");
		$origen = $this->input->post("origen");
		$this->form_validation->set_rules("txtemail","Correo Electrónico","trim|xss_clean|max_length[150]|required|is_unique[Contactos.Correo_Electronico]",$errs);
		$this->form_validation->set_rules("txtnombres","Nombres","trim|required|xss_clean|max_length[150]");
		$this->form_validation->set_rules("txtapellidos","Apellidos","trim|xss_clean|max_length[150]|required");
		$this->form_validation->set_rules("cmbsexo","Sexo","trim|required|xss_clean");
		$this->form_validation->set_rules("txtfecha_nacimiento","Fecha de Nacimiento","trim|xss_clean|max_length[150]|required");
		if($origen == "F"){
			$this->form_validation->set_rules("pswcontrasena","Contraseña","trim|xss_clean|max_length[150]");
			$this->form_validation->set_rules("pswcontrasenaconf","Confirmación de contraseña","trim|xss_clean|max_length[150]|matches[pswcontrasena]");
		}else{
			$this->form_validation->set_rules("pswcontrasena","Contraseña","trim|xss_clean|required|max_length[150]");
			$this->form_validation->set_rules("pswcontrasenaconf","Confirmación de contraseña","trim|xss_clean|max_length[150]|required|matches[pswcontrasena]");
		}

		$this->form_validation->set_rules("imagen","Imagen","trim|xss_clean");
		
		#	Si cumple con las validaciones se consultan los datos
		if($this->form_validation->run() == true)
	    {
	    	#	Array para insertar en B.D.
	    	$arrayinsert = array(
								"Correo_Electronico" => $this->input->post("txtemail"),
								"Apellidos"          => $this->input->post("txtapellidos"),
								"Nombres"            => $this->input->post("txtnombres"),
								"Fecha_Nacimiento"   => $this->input->post("txtfecha_nacimiento"),
								"Genero"             => $this->input->post("cmbsexo"),
								"Ruta_Imagen"        => $this->input->post("imagen"),
								"Contrasena"		 => md5($this->input->post("pswcontrasena")),
								"Estatus"			 => 1,
								"Origen"			 => $origen,	
								"Fecha_Registro"	 => date("Y-m-d H:i:s")							
								);
	    	$last = $this->Welcome_model->INS_Contacto($arrayinsert);
	    	#	Se guarda el Log
	    	$this->Log("Contactos","INS",$last);

	    	if($last){
	    		# Se construye un array con los permisos del usuario
	    		$array = $this->Welcome_model->CNS_Permisos(0);
		        $arraypermisos = array();
		        foreach ($array as $key => $value)
		        	$arraypermisos[$value["Abreviatura"]] = $value["Descripcion"];

		       	#	Se guardan los datos del usuario en session y se envían correos de notificación
	    		$arraysession = array(
	    				"Id_Usuario"         => $last,
						"Id_Tipo_Rol"        => 2,
						"Correo_Electronico" => $this->input->post("txtemail"),
						"Apellidos"          => $this->input->post("txtapellidos"),
						"Nombres"            => $this->input->post("txtnombres"),
						"Fecha_Nacimiento"   => $this->input->post("txtfecha_nacimiento"),
						"Genero"             => $this->input->post("cmbsexo"),
						"Ruta_Imagen"        => $this->input->post("imagen"),
						"Origen"			 => $origen,
						"permisos"			 => $arraypermisos,	
	    			);				
				$this->session->set_userdata($arraysession);
				$this->sendMail($arrayinsert["Correo_Electronico"],$arrayinsert["Nombres"],$arrayinsert["Apellidos"]);
				
				#	Se manda mensaje al front
				echo "_ok:Bienvenid@ ".$arrayinsert["Nombres"];
				$this->session->set_flashdata("msn", "Hola ".$arrayinsert["Nombres"].", bienvenid@");
			}else{
				echo "_er:Uh oh! Al parecer hubo un error al realizar el registro, intenta recargar la página";
			}

	    }else{
			$errors = preg_replace("[\n|\r|\n\r]", "<br>", validation_errors());
			echo "_er:".$errors;
		}
	}


	#	Envia correo de Bienvenida
	private function sendMail($email,$nombres,$apellidos = null){
		$mailadmins        = $this->getAdminsData("MISNOTY","Correo_Electronico");
		$configmail        = $this->emailConfig();
		$configsite        = $this->getConfiguracion();
		$data              = array("config" => $configsite);
		$data["nombres"]   = $nombres;
		$data["apellidos"] = $apellidos;
		$mensaje           = $this->load->view("mensajes/bienvenido",$data,true);
		$mensajeadmn       = $this->load->view("mensajes/noty-contactoinsert",$data,true);
		$this->load->library("email");
		$this->email->initialize($configmail);	
		$this->email->from($configsite["EMAIL"],$configsite["NAME"]);
		$this->email->to($email);			
		$this->email->subject("Bienvenido a".$configsite["NAME"]);
		$this->email->message($mensaje);
		$this->email->send();
		$this->email->clear();
    	$this->email->from($configsite["EMAIL"],$configsite["NAME"]);
		$this->email->to($mailadmins);			
		$this->email->subject("Nuevo contacto en  ".$configsite["NAME"]);
		$this->email->message($mensajeadmn);
		$this->email->send();	    	
	}

	#	Envia nueva contrasena al usuario
	#		-	Recibe correo por post
	#		- 	Consulta si el contacto existe
	#		-	Envia nueva contrasena generada aleatroriamente al correo
	public function recuperarContrasena()
	{
		$this->form_validation->set_rules("txtemail","Correo Electrónico","trim|xss_clean|required");
		#	Si cumple con las validaciones se consultan los datos
		if($this->form_validation->run() == true)
	    {
	    	$email = $this->input->post("txtemail");
	    	$login = $this->Welcome_model->Login($email,null);
	    	if($login){
	    		$configsite 		= $this->getConfiguracion();		
				$data["config"] 	= $configsite;
				$data["usuario"]    = $login;
				$data["newpass"]    = $this->genRandomCode();
				$mensaje            = $this->load->view("mensajes/nueva-contrasena",$data,true);
				$configmail         = $this->emailConfig();
				$this->load->library("email");
				$this->email->initialize($configmail);	
				$this->email->from($configsite["EMAIL"],$configsite["NAME"]);
				$this->email->to($email);			
				$this->email->subject("Nueva contraseña | ".$configsite["NAME"]);
				$this->email->message($mensaje);
				$dataarray["Contrasena"] = md5($data["newpass"]);
				$ar = $this->Welcome_model->UPD_Contacto($login->Id_Contacto,$dataarray);
				if($ar){	
					#	Se guarda log y se envia mensaje a la vista
	    			$this->Log("Contactos","UPD",$login->Id_Contacto,null,"Recuperación de contraseña usuario público.");
					
					if($this->email->send()){
						echo "_ok:Excelente! Hemos enviado a tu correo una nueva contraseña";
					}else{
						echo "_er:Uh oh! Al parecer hubo un error de conexión, por favor intenta más tarde";
					}
				}else{
					echo "_er:Uh oh! Al parecer hubo un error de conexión, por favor intenta más tarde";
				}
	    		
	    	}else{
	    		echo "_er:Uh oh! Al parecer este correo no se encuentra registrado";
	    	}	
	    }else{
			$errors = preg_replace("[\n|\r|\n\r]", "<br>", validation_errors());
			echo "_er:".$errors;
		}
	}

	#	Genera una contraseña aleatoria de 6 caracteres
	private function genRandomCode()
	{
		$an = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$su = strlen($an) - 1;
		$cadena = "";
		$length = 6;
		for ($i=0; $i < $length; $i++) { 
			$cadena .= substr($an, rand(0, $su), 1);
		}
		return  $cadena;
	}

	#	Muestra Preguntas del Cotizador
	#		- Asigna parametro a variable Id_Pregunta
	#		- Si no se recibe parametro, se recibe por post
	#		- Se consulta la pregunta por su ID
    #		- Se consultan sus hijos
	#		- Si el remitente es el Servidor, la función se llama a su mismo
    public function mostrarPregunta($data = null){
		#	Se asigan valor a Id_Pregunta, ya se reciba por parametro o por post
		$valor = $this->input->post("valor");
		if(!isset($data["Id_Pregunta"])){
			$Id_Pregunta = $this->input->post("Id_Pregunta");
		}else{
			$Id_Pregunta = $data["Id_Pregunta"];
		}

		if($Id_Pregunta == 0){
			$this->session->set_userdata("cotizador",array());
			$Id_Pregunta_Hijo = 0;
		}else{
			$res = $this->Welcome_model->CNS_PreguntaById($Id_Pregunta);
			$Id_Pregunta_Hijo = $res->Id_Pregunta_Hijo;
		}

		$this->cotizar($Id_Pregunta,$valor);
		$pregunta = $this->Welcome_model->CNS_PreguntaByGrupo($Id_Pregunta_Hijo);
		if($pregunta){
			if($pregunta[0]["Remitente"] == "S"){
	    		echo "<div class='col-lg 12 turno turno-servidor'>".$pregunta[0]["Pregunta"]."</div>";
	    		$this->mostrarPregunta(array("Id_Pregunta" => $pregunta[0]["Id_Pregunta_Cotizador"]));
	    	}else{
	    		echo "<form class='col-lg 12 turno turno-cliente'>"; 
	    		if($pregunta[0]["Grupo"] != 1 && $pregunta[0]["Grupo"] != 1003){
		    		echo "<img src='".base_url('public/libs/front/images/left-arrow.png')."' class='regresar'> <br>";           
	    		}
	
	    		foreach ($pregunta as $p) {
		    		switch ($p["Tipo"]) {
		    			case "radio":
		    				echo "<label>";
		    				echo "<input type='radio' name='Id_Pregunta' value='".$p["Id_Pregunta_Cotizador"]."' required>";
		    				echo $p["Pregunta"]."</label>";
		    				break;
		    			case "select":
		    				# code...
		    				break;
		    			case "number":
		    				echo "<div style='max-width:250px'>
			    				<div class='input-group'>							  
								  <input type='hidden' name='Id_Pregunta' value='".$p["Id_Pregunta_Cotizador"]."'>
								  <input class='input-group-field' name='valor' type='number' min='".$p["Minval"]."' step='1' value='".$p["Minval"]."'>
								  <span class='input-group-label'>".$p["Pregunta"]."</span>
								</div>
							</div>";
		    				break;
		    			case "area":
		    				echo "<input type='hidden' name='Id_Pregunta' value='".$p["Id_Pregunta_Cotizador"]."'>
		    				<label>".$p["Pregunta"]."</label>
		    				<textarea name='valor' rows='5' max='200'></textarea>";
		    				break;
		    			case "button":
		    				echo "<a class='button ".$p["Valor"]."'>".$p["Pregunta"]."</a>";
		    				break;
		    			
		    			default:
		    				echo "<label>".$p["Pregunta"]."</label>";
		    				break;
		    		}
		    	}
		    	if($pregunta[0]["Notas"]){echo "<span class='nota'>".$pregunta[0]["Notas"]. "</span>";}
		    	echo "<input type='hidden' value='".$pregunta[0]["Grupo"]."'>";
		    	#	Si no es la última pregunta se muestra el botón
		    	if($pregunta[0]["Id_Pregunta_Hijo"] != -1){	
					echo "<br><button type='button'>Responder</button>";
				}
				echo "</form>";
	    	}
	    	#	Si es -1 es por que finalizó el ciclo
	    	if($pregunta[0]["Id_Pregunta_Hijo"] == -1){
	    		$this->guardaCotizacion();
	    		$this->session->set_userdata("cotizador",array());
	    	}
    	}
    	$this->output->enable_profile = true;
    }

    #	Regresa a la pregunta anterior
    public function descotizar(){
    	#	Cotizador de sessión
  		$arraycoti = $this->session->userdata("cotizador");
  		
  		#	Se quitan los dos últimos elementos del array 
  		#	y se envía a la variable de sesión
  		array_pop($arraycoti);
  		array_pop($arraycoti);
		
		#	Se obtiene el Id del último elemento del array
		end($arraycoti); 
    	$key = key($arraycoti);
    	$dataarray["Id_Pregunta"] = $arraycoti[$key]["Id_Pregunta"];
    	#	Se elimina nuevamente el último elemento para evitar duplicados 
    	#	y se envía a sesión
    	array_pop($arraycoti);
  		$this->session->set_userdata("cotizador",$arraycoti);
  		#	Se muestra la pregunta que sigue
  		$this->mostrarPregunta($dataarray);  		
    }

    #	Agrega pregunta a sesión cotizador
    private function cotizar($Id_Pregunta,$valor = null){
    	$cotizador = $this->session->userdata("cotizador");
    	$pregunta = $this->Welcome_model->CNS_PreguntaById($Id_Pregunta);
	    if($pregunta){
	    	$registro = array(	
								"Id_Pregunta" => $Id_Pregunta,
								"operacion"   => $pregunta->Operacion,
								"pregunta"    => $pregunta->Pregunta,
								"remitente"   => $pregunta->Remitente,
								"tipo"        => $pregunta->Tipo,								    			
							);
	    

	    	#	Si no hubo una entrada de valor (input number o area): se asigna el valor que tiene en B.D.
	    	# 	Si se recibio valor y el valor de B.D. es mayor a 0: se asigna el valor de B.D. a valor2
	    	$valor2 = 0;	
			if(!$valor){
				$valor =  $pregunta->Valor;
			}elseif($valor && floatval($pregunta->Valor) > 0){
				$valor2 = $pregunta->Valor;
			}

			$registro["valor"] = $valor;	
			$registro["valor2"] = $valor2;	
			array_push($cotizador, $registro);
			$this->session->set_userdata("cotizador", $cotizador);	
    	}
    }

    #	Muestra Eventos de la Agenda
	public function mostrarEventos(){
		$eventos = $this->Agenda_model->CNS_EventosActivos();
		$arrayeventos = array();
		foreach ($eventos as $evt) {
			$arrayeventos[] = array(
										"id"              => $evt["Id_Evento"],
										"backgroundColor" => $evt["Color"],
										"title"			  => $evt["TipoServicio"],
										"start"			  => $evt["Fecha_Inicio"],
										"end"			  => $evt["Fecha_Fin"],
									);
		}
		// print_r($eventos);
		echo json_encode($arrayeventos);
	}

	#	Guarda la cotización en B.D. y envía Email a los administradores con permisos de notificaciones
	private function guardaCotizacion(){
		#	Se traen las variables que se vana utilizar
		#	Correos y IDs de los administradores a los que se les debe notificar
		#	Cotizador guardado en sesión
		$mailadmins = $this->getAdminsData("MISNOTY","Correo_Electronico");
		$idadmins   = $this->getAdminsData("MISNOTY","Id_Empleado");
		$cotizador  = $this->session->userdata("cotizador");
		$nombre     = $this->session->userdata("Nombres");
		$apellidos  = $this->session->userdata("Apellidos");
    	date_default_timezone_set("America/Mexico_City");
    	$arraycoti = array(
    						"Fecha" => date("Y-m-d H:i:s"),
    						"Folio" => date("ymdHis"),
    						"Id_Contacto" => $this->session->userdata("Id_Usuario"),    		
    		);
    	$last = $this->Welcome_model->INS_Cotizacion($arraycoti);
    	
    	#	Se guarda el Log
		$this->Log("Cotizaciones","INS",$last);
    	
    	foreach ($cotizador as $key => $value) {
    		$dataarray = array(
					"Id_Cotizacion" => $last, 
					"Pregunta"      => $value["pregunta"],
					"Remitente"     => $value["remitente"],
					"Operacion"     => $value["operacion"],
					"Tipo"			=> $value["tipo"],
					"Valor"         => $value["valor"],
					"Valor_2"       => $value["valor2"],
    			);
    		$lasdet = $this->Welcome_model->INS_CotizacionDetalle($dataarray);
    	}

    	// ENVIO DE EMAIL ADMINISTRADOR
    	$this->load->library("email");
		$configmail = $this->emailConfig();
		$configsite = $this->getConfiguracion();
		$this->email->initialize($configmail);
		$data = array("config" => $configsite);
		$mensaje = $this->load->view("mensajes/noty-cotizacion",$data,true);
		$this->email->from($configsite["EMAIL"],$configsite["NAME"]);
		$this->email->to($mailadmins);			
		$this->email->subject("Se ha solicitado una nueva cotización desde el sitio");
		$this->email->message($mensaje);
		$this->email->send();    	

		//	ENVIO DE NOTIFICACIONES
		foreach ($idadmins as $id => $val) {
			$datanoty = array(
								"Id_Usuario"      => $val,
								"Id_Tipo_Usuario" => 1,
								"Mensaje"         => $nombre . " " . $apellidos. " ha solicitado un nueva cotización",
								"Fecha_Envio"     => date("Y-m-d H:i:s"),
								"Leido"           => 1
				);
			$this->agregarNotificacion($datanoty);
		} 
    }

    #	Generar PDF  de la Cotización
	public function genPDF(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["MISCOTI"])){
			$Id_Usuario = $session["Id_Usuario"];
			#	Consulta ultima cotización hecha por el usuariop
			$cotizacion = $this->Welcome_model->CNS_LastCotizacionByUser($Id_Usuario);
			
			#	Consulta el detalle y lo separa en array por servicios
			$cotidetalle = $this->Welcome_model->CNS_CotizacionDetalle($cotizacion->Id_Cotizacion);
			$cotizacion_detalle = array();
			$contador = 0;
			foreach ($cotidetalle as $coti) {
				$cotizacion_detalle[$contador][] = $coti;			
				if($coti["Operacion"] == "SEP"){
					$contador ++;
				}
			}

			#	Se quita el último array que solo contiene el mensaje de despedida
			array_pop($cotizacion_detalle);

			$data["cotizacion"] = $cotizacion;
			$data["cotizacion_detalle"] = $cotizacion_detalle;
			$this->load->library("Pdf");
			$pdf = $this->pdf->load();
			$html = $this->load->view("front-end/cotizacion",$data,true);
			$pdf->WriteHtml($html);
			
			$pdf->Output();
		}
	}

	#	Enviar correo de contacto
	public function sendMailContacto(){
		$this->form_validation->set_rules("txtnombre","Nombre","trim|xss_clean|max_length[50]|required");
		$this->form_validation->set_rules("txttelefono","Teléfono","trim|xss_clean|max_length[45]|required");
		$this->form_validation->set_rules("txtemail","Correo Electrónico","trim|xss_clean|max_length[200]|required");
		$this->form_validation->set_rules("txamensaje","Mensaje","trim|xss_clean|max_length[255]|required");
		if($this->form_validation->run() == true)
	    {
	    	$mailadmins        = $this->getAdminsData("MISNOTY","Correo_Electronico");
			$configmail        = $this->emailConfig();
			$configsite        = $this->getConfiguracion();
			$data = array(
				"config" =>$configsite,
				"msj" => array(
						"Nombre"             => $this->input->post("txtnombre"),
						"Correo_Electronico" => $this->input->post("txtemail"),
						"Telefono"           => $this->input->post("txttelefono"),
						"Mensaje"            => $this->input->post("txamensaje"),
					)
				);        

	

			$mensaje           = $this->load->view("mensajes/gracias-mensaje",$data,true);
			$mensajeadmn       = $this->load->view("mensajes/nuevo-mensaje",$data,true);

			$this->load->library("email");
			$this->email->initialize($configmail);	
			// MENSAJE AL ADMINISTRADOR
			$this->email->from($configsite["EMAIL"],$configsite["NAME"]);
			$this->email->to($mailadmins);	
			$this->email->subject("Nuevo mensaje desde el sitio ".$configsite["NAME"]);		
			$this->email->message($mensajeadmn);			
			if($this->email->send()){	
				echo "_ok:Excelente, tu mensaje ha sido enviado";			
				// MENSAJE AL CONTACTO
				$this->email->clear();
		    	$this->email->from($configsite["EMAIL"],$configsite["NAME"]);
				$this->email->to($data["msj"]["Correo_Electronico"]);			
				$this->email->subject("Gracias por contactarnos en ".$configsite["NAME"]);
				$this->email->message($mensaje);
				$this->email->send();
			}else{
				echo "_er:Uh oh! Al parecer hubo un error, por favor intentalo nuevamente";
			} 	    	
	    }else{
			$errors = preg_replace("[\n|\r|\n\r]", "<br>", validation_errors());
			echo "_er:".$errors;
		}
	}
	#	Contador de visitas
	private function cuentaVisitas(){
		date_default_timezone_set("America/Mexico_City");
 		$dataarray["Fecha_Ejecucion"] = date("Y:m:d H:i:s");

		$browser=array("IE","OPERA","NETSCAPE","FIREFOX","SAFARI","CHROME");
		$os=array("WIN","MAC","LINUX");
		$dataarray["Navegador"] = "OTHER";
		$dataarray["Sistema_Operativo"] = "OTHER";
		
		# Obtención Navegador
		foreach($browser as $parent)
		{
			$s = strpos(strtoupper($_SERVER["HTTP_USER_AGENT"]), $parent);
			$f = $s + strlen($parent);
			$version = substr($_SERVER["HTTP_USER_AGENT"], $f, 15);
			$version = preg_replace("/[^0-9,.]/","",$version);
			if ($s){
				$dataarray["Navegador"] = $parent;
				$dataarray["Version_Navegador"] = $version;
			}
		}
	 
		# Obtención Sistema Operativo 
		foreach($os as $val)
		{
			if (strpos(strtoupper($_SERVER["HTTP_USER_AGENT"]),$val)!==false){
				$dataarray["Sistema_Operativo"] = $val;
			}
		}

		# Obtención IP
		$dataarray["IP"] = $_SERVER["REMOTE_ADDR"];
		if (!empty($_SERVER["HTTP_CLIENT_IP"]))
			$dataarray["IP"] = $_SERVER["HTTP_CLIENT_IP"];
		if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
			$dataarray["IP"] = $_SERVER["HTTP_X_FORWARDED_FOR"];

		# Obtención de Geolocalización	
		$url = "http://ip-api.com/json/". $_SERVER["REMOTE_ADDR"];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$url);
		$result=curl_exec($ch);
		curl_close($ch);
		$json = json_decode($result,true);
		
		$dataarray["Pais"]          = $json["country"];
		$dataarray["Codigo_Pais"]   = $json["countryCode"];
		$dataarray["Region"]        = $json["regionName"];
		$dataarray["Ciudad"]        = $json["city"];
		$dataarray["Codigo_Postal"] = $json["zip"];
		$dataarray["Latitud"]       = $json["lat"];
		$dataarray["Longitud"]      = $json["lon"];
	
		$visitante = get_cookie("visitante");
		$dataarray["Visitante"] = md5($visitante);
		$last = $this->Welcome_model->INS_Visitas($dataarray);
		if(!isset($visitante)){
			$encvisitante = md5($last);
			set_cookie("visitante",$encvisitante,86400);			
			$this->Welcome_model->UPD_Visitas($last,array("Visitante" => $encvisitante));	
		}
	}

	#	Cerrar sessión
	public function logout() {
		$session = array(
						"Id_Usuario",
						"fb_access_token", 
						"Id_Tipo_Rol",
						"Correo_Electronico",
						"Apellidos",
						"Nombres",
						"Fecha_Nacimiento",
						"Genero",          
						"Ruta_Imagen",
						"permisos",
						);
		$this->session->unset_userdata($session);			

		redirect(base_url());
	}

	public function promoLS1(){
		$this->load->view("front-end/promo-live-session");
	}

	public function promoLS2(){
		$this->load->view("front-end/promo-live-session-2");
	}
	public function enviarPromo(){
		date_default_timezone_set("America/Mexico_City");
		$this->form_validation->set_rules("txtnombre","Nombre","trim|xss_clean|max_length[50]|required");
		$this->form_validation->set_rules("emlcorreo_electronico","Correo Electrónico","trim|xss_clean|valid_email|required");
		$this->form_validation->set_rules("txttelefono","Teléfono","trim|xss_clean|min_length[10]|max_length[100]|required");
		$this->form_validation->set_rules("nmbpersonas","No. Personas","trim|xss_clean|min[1]|required");
		$this->form_validation->set_rules("txaobservaciones","Observaciones / Preguntas","trim|xss_clean|max_length[5000]|required");
		
		#	Si no cumple las validaciones		
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array("head" => "_er:","body" => validation_errors(" ","\n")));
			exit();
		}		

		// #	Array de inserción
		$data = array(
			"Nombre"             => $this->input->post("txtnombre"),
			"Correo_Electronico" => $this->input->post("emlcorreo_electronico"),
			"No_Personas"        => $this->input->post("nmbpersonas"),
			"Observaciones"      => $this->input->post("txaobservaciones"),
			"Formulario"         => $this->input->post("hdnformulario"),
			"Fecha"				 => date("Y-m-d H:i:s"),
			);

		// #	Inserta en B.D. 
		$last = $this->Welcome_model->INS_Promo($data);
		if(!$last){
			echo json_encode(array("head" => "_er:","body" => "Oh uh! Hubo un error al intentar guardar, por favor intenta nuevamente"));
			exit();
		}else{
			echo json_encode(array("head" => "_ok:","body" => "Excelente! Tu mensaje ha sido enviado, nos comunicaremos contigo a la brevedad"));
		}

		#	Envía mensaje al administrador
		$configmail = $this->emailConfig();
		$configsite = $this->getConfiguracion();
		$mailadmins = $this->getAdminsData("MISNOTY","Correo_Electronico");
		// $mailadmins = array("desarrollo@creeartelo.mx");
		$data       = array("config" => $configsite,"form" => $data);
		$mensaje    = $this->load->view("mensajes/noty-promo-admin",$data,true);
		$mensaje    = $this->load->view("mensajes/noty-promo-contact",$data,true);
		

		#	Envía mensaje a los administrador
		$this->load->library("email");		
		$this->email->initialize($configmail);
		$this->email->from($configsite["EMAIL"],$configsite["NAME"]);
		$this->email->to($mailadmins);			
		$this->email->subject("Se ha solicitado una nueva cotización desde el sitio");
		$this->email->message($mensaje);
		$this->email->send();   

		#	Envía mensaje al contacto
		$this->email->clear();
		$this->email->from($configsite["EMAIL"],$configsite["NAME"]);
		$this->email->to($data["msj"]["Correo_Electronico"]);			
		$this->email->subject("Gracias por contactarnos en ".$configsite["NAME"]);
		$this->email->message($mensaje);
		$this->email->send(); 	
	}
}
