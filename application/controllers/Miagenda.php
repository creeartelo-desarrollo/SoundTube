<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#	CONTROLADOR DEL MÓUDLO AGENDA DEL LADO DEL USUARIO PÚBLICO
class Miagenda extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("Agenda_model");
		$this->load->library("form_validation");
		$this->load->helper("security");
	}

	#		Carga vistas del módulo
	public function index()
	{
		$session = $this->session->userdata();
		if(isset($session["permisos"]["MIAGEN"])){
			$data["session"] = $session;
			$data["config"] = $this->getConfiguracion();
			$data["libs"] = array("miagenda");
			$data["notys"] = $this->getNotys();
			$data["tservicios"] = $this->Agenda_model->CNS_CatalogoTiposEvento();
			$this->load->view("back-end/templates/header");
			$this->load->view("back-end/templates/topnav",$data);
			$this->load->view("back-end/templates/sidebar",$data);
			$this->load->view("back-end/miagenda");
			$this->load->view("back-end/templates/footer",$data);
		}else{
			redirect(base_url());
		}
	}

	#	Muestra todos los eventos de la agenda del Usuario loggeado en JSON
	public function mostrarEventos(){
		$session = $this->session->userdata();
		$Id_Usuario = $session["Id_Usuario"];
		if(isset($session["permisos"]["MIAGEN"])){
			$eventos = $this->Agenda_model->CNS_Eventos($Id_Usuario);

			$arrayeventos = array();
			foreach ($eventos as $evt) {
				$arrayeventos[] = array(
											"id"              => $evt["Id_Evento"],
											"backgroundColor" => $evt["Color"],
											"title"			  => $evt["TipoServicio"] . ". " . $evt["Sala"],
											"start"			  => $evt["Fecha_Inicio"],
											"end"			  => $evt["Fecha_Fin"],
										);
			}
			echo json_encode($arrayeventos);
		}
	}

	#	Muestra detalle del evento,
	#		Se recibe una variable por post que indica de donde se realizó la solicitud
	#		Si se realizó del lado del cliente: no se muestran los botones de editar, eliminar ni el status del evento
	public function mostrarEventoDetalle(){
		$session = $this->session->userdata();
		$Id_Evento = $this->input->post("Id_Evento");
		$data["side"] = $this->input->post("side");
		$data["evento"] = $this->Agenda_model->CNS_EventoByID($Id_Evento);
		if($data["evento"]){
			$eventohtml = $this->load->view("mensajes/evento-detalle",$data,true);
			echo $eventohtml;
		}
	}

	#	Muestra JSON de un Evento
	public function mostrarEvento(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["MIAGEN"])){
			$Id_Evento = $this->input->post("Id_Evento");
			$evento = $this->Agenda_model->CNS_EventoByID($Id_Evento);
			echo json_encode($evento);
		}
	}

	#	Guarda evento en la Agenda
	#		- Valida los campos, y que no halla un evento activo en las fechas que ingresó
	#		- Si pasa las validaciones, guarda o actualiza
	#		- Si se recibió el ID actualiza, de lo contrario inserta
	#		- Manda a llamar el método de notificar
	public function guardarEvento()
	{
		$session = $this->session->userdata();
		if(isset($session["permisos"]["MIAGEN"])){
			$Fecha_Inicio = $this->input->post("txtfinicio");
			date_default_timezone_set("America/Mexico_City");
			$err_time_comp = $this->getErrores("Fin","Inicio");
			$this->form_validation->set_rules("txtnombre","Nombre del Evento","trim|xss_clean|max_length[50]|required");
			$this->form_validation->set_rules("txttelefono","Teléfono","trim|xss_clean|max_length[45]|required");
			$this->form_validation->set_rules("txtemail","Correo Electrónico","trim|xss_clean|max_length[200]|required");
			$this->form_validation->set_rules("cmbtservicio","Tipo de Servicio","trim|xss_clean|required|greater_than_equal_to[0]");		
			$this->form_validation->set_rules("txtfinicio","Inicio","trim|xss_clean|required");
			$this->form_validation->set_rules("txtffin","Fin","trim|xss_clean|required|callback_time_comp[$Fecha_Inicio]",$err_time_comp);
			$this->form_validation->set_rules("txaobservaciones","Observaciones","trim|xss_clean|max_length[255]");
			if($this->form_validation->run() == true)
	        {	
				$Id_Evento   = $this->input->post("Id_Evento");
				$Fecha_Fin   = $this->input->post("txtffin");
				$dataarray = array(
								 	"Id_Contacto"        => $this->session->userdata("Id_Usuario"),
									"Nombre"			 => $this->input->post("txtnombre"),
									"Correo_Electronico" => $this->input->post("txtemail"),
									"Telefono"			 => $this->input->post("txttelefono"),
									"Id_Cat_Tipo_Evento" => $this->input->post("cmbtservicio"),
									"Fecha_Inicio"       => $this->input->post("txtfinicio"),
									"Fecha_Fin"          => $this->input->post("txtffin"),
									"Observaciones"      => $this->input->post("txaobservaciones"),																		
	        						);
		        if($Id_Evento){
		        	$ar = $this->Agenda_model->UPD_Evento($Id_Evento,$dataarray);
					$evento = $this->Agenda_model->CNS_EventoByID($Id_Evento);
					if($ar){							
		        		$this->notificar("upd",$evento);
				    	echo "_ok:Excelente, el evento ha sido guardado";
				    	$this->Log("Eventos","UPD",$Id_Evento);
			    	}
			    }else{
			    	#	Si el evento es nuevo (INSERT), se guarda con Status = 0
					$dataarray["Status"]     = 0;
					$dataarray["Confirmado"] = 0;
					$dataarray["Fecha_Alta"]  = date("Y-m-d H:i:s");
			    	$last = $this->Agenda_model->INS_Evento($dataarray);
					if($last){
						#	Actualiza el registro con la clave de confirmación
						$this->generaLlave($last);
						$evento = $this->Agenda_model->CNS_EventoByID($last);
						$this->notificar("ins",$evento);
				    	echo "_ok:Excelente, el evento ha sido guardado, te hemos enviado un correo con los siguientes pasos";
				    	$this->Log("Eventos","INS",$last);
			    	}
			    }	
			}else{
				$errors = preg_replace("[\n|\r|\n\r]", "<br>", validation_errors());
				echo "_er:".$errors;
			}
		}
	}
	
	#	Eliminar evento y notifica
	public function eliminarEvento(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["MIAGEN"])){
			$Id_Evento = $this->input->post("Id_Evento");
			$evento = $this->Agenda_model->CNS_EventoByID($Id_Evento);
			$ar = $this->Agenda_model->DEL_Evento($Id_Evento);
			if($ar){
				$this->notificar("del",$evento);
				echo "_ok:Exito al eliminar el evento";
				$this->Log("Eventos","DEL",$Id_Evento);
			}
		}
	}

	#	Notifica a los administradores con permisos de notificaciones que hubo cambios en un evento
	#		- Envia un correo
	#		- Inserta en la tabla de notificaciones por medio del método
	#		  agregarNotificacion de MY_Controller 
	#		- Recibe dos parametros: la accion (UPD,DEL,INS)  y el evento en objeto
	#		- Dependiendo de la varible acción es el correo que se manda
	private function notificar($accion,$evento){
		date_default_timezone_set("America/Mexico_City");
		$mailadmins = $this->getAdminsData("MISNOTY","Correo_Electronico");
		$idadmins   = $this->getAdminsData("MISNOTY","Id_Empleado");
		$emailconfig = $this->emailConfig();
		$configsite = $this->getConfiguracion();
		$data = array("config" => $configsite,"evento" => $evento);

		#	Condiciones del texto del mensaje del correo
		#	Nuevo, Actualización, Borrado, Confirmado 
		if($accion == "conf"){
			$asunto = $configsite["NAME"]. " | Se ha agregado un nuevo evento";
			$mensaje = $this->load->view("mensajes/noty-agendainsert-admin",$data,true);
		}elseif($accion == "upd"){
			$asunto = $configsite["NAME"]. " | Se ha modificado un evento";
			$mensaje = $this->load->view("mensajes/noty-agendaupdate-admin",$data,true);
		}elseif($accion == "del") {
			$asunto = $configsite["NAME"]. " | Se ha eliminado un evento";
			$mensaje = $this->load->view("mensajes/noty-agendadelete-admin",$data,true);
		}

		#	Carga e inicializa libreria Email
		$this->load->library("email");
		$this->email->initialize($emailconfig);	
		
		#	Envía correo a cliente			
		if($accion == "ins"){
			$mensajecont = $this->load->view("mensajes/noty-agendapasos",$data,true);
			
			$this->email->from($configsite["EMAIL"],$configsite["NAME"]);
			$this->email->to($evento->Correo_Electronico);			
			$this->email->subject($configsite["NAME"]. " | Gracias por agendar con nosotros");
			$this->email->message($mensajecont);
			$this->email->send();
		}


		#	Inserta notificaciones en B.D.
		foreach ($idadmins as $id => $val) {
			$datanoty = array(
								"Id_Usuario"      => $val,
								"Id_Tipo_Usuario" => 1,
								"Mensaje"         => $evento->Nombres . " " . $evento->Apellidos. " ha agregado un nuevo evento",
								"Fecha_Envio"     => date("Y-m-d H:i:s"),
								"Leido"           => 1
				);
			$this->agregarNotificacion($datanoty);
		}

		#	Notificar a los administradores, si la accion es diferente de ins
		#		No se notifica a los administradores cuando se inserta un evento, si no
		#		hasta que se confirma
		if($accion != "ins"){
			$this->email->clear();
			$this->email->from($configsite["EMAIL"],$configsite["NAME"]);
			$this->email->to($mailadmins);			
			$this->email->subject($asunto);
			$this->email->message($mensaje);
			if($this->email->send()){
				return true;
			}
		}
	}

	#	Asigna clave de confirmación a un evento
	private function generaLlave($Id_Evento){
		$evento = $this->Agenda_model->CNS_EventoByID($Id_Evento);
		$sub1 = $evento->Id_Evento;
		$sub2 = substr($evento->Nombres, 0,1);
		$sub3 = substr($evento->Correo_Electronico, 0,1);
		$sub4 = substr($evento->Telefono, 0,1);
		$sub5 = substr($evento->Fecha_Inicio, -2,2);
		$sub6 = substr($evento->Fecha_Fin, -2,2);

		$cadena = $sub1 . $sub2 . $sub3 . $sub4 . $sub5 . $sub6;
		$dataarray["Key"] = md5($cadena);
		$this->Agenda_model->UPD_Evento($sub1,$dataarray);
	}

	#	Confirma que el cliente si quiere el evento	
	public function confirmacion($key){
		$evento = $this->Agenda_model->CNS_EventoByKey($key);
		$data["configsite"] = $this->getConfiguracion();
		if($evento->Confirmado == 0){
			#	Actualiza confirmado a 1
			$dataarray["Confirmado"] = 1;
			$ar = $this->Agenda_model->UPD_Evento($evento->Id_Evento,$dataarray);
			$conf = $this->notificar("conf",$evento);
			if($ar > 0 && $conf){
				$this->load->view("back-end/confirmacion-ok",$data);
			}else{
				$this->load->view("back-end/confirmacion-er",$data);
			}
		}else{
			$this->load->view("back-end/confirmacion-wr",$data);
		}          
	}

	#	Instancia el método de validación de Fechas de MY_Controller
	#		- este método válida que la Fecha de Inicio sea menor a la de Fin
	public function time_comp($fmayor,$fmenor){
		return $this->time_compare($fmayor,$fmenor);
	}
}