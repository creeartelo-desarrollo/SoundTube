<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#	CONTROLADOR DEL MÓUDLO AGENDA DE LA EMPRESA
class Agenda extends MY_Controller {
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
		if(isset($session["permisos"]["AGEN"])){
			$data["session"] = $session;
			$data["config"] = $this->getConfiguracion();
			$data["libs"] = array("agenda");
			$data["notys"] = $this->getNotys();
			$data["contactos"] = $this->Agenda_model->CNS_Contactos();
			$data["salas"] = $this->Agenda_model->CNS_CatalogoSalas();
			$data["tservicios"] = $this->Agenda_model->CNS_CatalogoTiposEvento();
			$this->load->view("back-end/templates/header");
			$this->load->view("back-end/templates/topnav",$data);
			$this->load->view("back-end/templates/sidebar",$data);
			$this->load->view("back-end/agenda");
			$this->load->view("back-end/templates/footer",$data);
		}else{
			redirect(base_url("admin"));
		}
	}

	#	Muestra todos los eventos de la agenda en JSON
	public function mostrarEventos(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["AGEN"])){
			$eventos = $this->Agenda_model->CNS_Eventos();
			$arrayeventos = array();
			foreach ($eventos as $evt) {
				$arrayeventos[] = array(
											"id"              => $evt["Id_Evento"],
											"backgroundColor" => $evt["Color"],
											"title"			  => $evt["Nombre"],
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
		if(isset($session["permisos"]["AGEN"])){
			$Id_Evento = $this->input->post("Id_Evento");
			$data["evento"] = $this->Agenda_model->CNS_EventoByID($Id_Evento);
			$data["side"] = $this->input->post("side");
			if($data["evento"]){
				$eventohtml = $this->load->view("mensajes/evento-detalle",$data,true);
				echo $eventohtml;
			}
		}
	}

	#	Muestra JSON de un Evento
	public function mostrarEvento(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["AGEN"])){
			$Id_Evento = $this->input->post("Id_Evento");
			$evento = $this->Agenda_model->CNS_EventoByID($Id_Evento);
			echo json_encode($evento);
		}
	}

	#	Muestra JSON de un Contacto
	public function mostrarContacto(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["AGEN"])){
			$Id_Contacto = $this->input->post("Id_Contacto");
			$contacto = $this->Agenda_model->CNS_ContactoByID($Id_Contacto);
			echo json_encode($contacto);
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
		if(isset($session["permisos"]["AGEN"])){
			date_default_timezone_set("America/Mexico_City");
			$Id_Evento     = $this->input->post("Id_Evento");
			$Fecha_Inicio  = $this->input->post("txtfinicio");
			$Id_Cat_Sala   = $this->input->post("cmbsalas");
			$err_time_comp = $this->getErrores("Fin","Inicio");
			$this->form_validation->set_rules("txtnombre","Nombre del Evento","trim|xss_clean|max_length[50]|required");
			$this->form_validation->set_rules("cmbcontactos","Contactos","trim|xss_clean|required|greater_than_equal_to[0]");
			$this->form_validation->set_rules("txttelefono","Teléfono","trim|xss_clean|max_length[45]|required");
			$this->form_validation->set_rules("txtemail","Correo Electrónico","trim|xss_clean|max_length[200]|required");
			$this->form_validation->set_rules("cmbtservicio","Tipo de Servicio","trim|xss_clean|required|greater_than_equal_to[0]");
			$this->form_validation->set_rules("cmbsalas","Sala","trim|xss_clean|greater_than_equal_to[0]");			
			$this->form_validation->set_rules("txtfinicio","Inicio","trim|xss_clean|required");
			$this->form_validation->set_rules("txtffin","Fin","trim|xss_clean|required|callback_time_comp[$Fecha_Inicio]",$err_time_comp);
			$this->form_validation->set_rules("txaobservaciones","Observaciones","trim|xss_clean|max_length[255]");
			if($this->form_validation->run() == true)
	        {
	        	$Fecha_Fin = $this->input->post("txtffin");
	        	$ocupado = $this->Agenda_model->CNS_Disponibilidad($Fecha_Inicio,$Fecha_Fin,$Id_Cat_Sala,$Id_Evento);
	        	if($ocupado){
	        		echo "_er:Uh oh!, al parecer las fechas que nos indicaste ya se encuetran agendadas,". 	
	 	        		 "puedes consultar en el calendario para ver la disponibilidad";
	        	}else{
	        		$dataarray = array(
										"Id_Contacto"        => $this->input->post("cmbcontactos"),
										"Nombre"			 => $this->input->post("txtnombre"),
										"Correo_Electronico" => $this->input->post("txtemail"),
										"Telefono"			 => $this->input->post("txttelefono"),
										"Id_Cat_Sala"        => $this->input->post("cmbsalas"),
										"Id_Cat_Tipo_Evento" => $this->input->post("cmbtservicio"),
										"Fecha_Inicio"       => $this->input->post("txtfinicio"),
										"Fecha_Fin"          => $this->input->post("txtffin"),
										"Observaciones"      => $this->input->post("txaobservaciones"),
										"Status"			 => $this->input->post("optstatus"),
										"Confirmado"	     => 1
	        							);
	        		if(is_numeric($Id_Evento)){
		        		$ar = $this->Agenda_model->UPD_Evento($Id_Evento, $dataarray);
		        		$evento = $this->Agenda_model->CNS_EventoByID($Id_Evento);
		        		if($ar){
		        			$this->Log("Eventos","UPD",$Id_Evento);
		        			$this->notificar("upd",$evento);
		        			echo "_ok:Excelente, el evento ha sido guardado";
		        		}
					}else{
						$dataarray["Fecha_Alta"] = date("Y-m-d H:i:s");
						$last = $this->Agenda_model->INS_Evento($dataarray);
						if($last){
							#	Actualiza el registro con la clave de confirmación
							$this->generaLlave($last);
							$this->Log("Eventos","INS",$last);
							$evento = $this->Agenda_model->CNS_EventoByID($last);
							$this->notificar("ins",$evento);
		        			echo "_ok:Excelente, el evento ha sido guardado";
		        		}
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
		if(isset($session["permisos"]["AGEN"])){
			$Id_Evento = $this->input->post("Id_Evento");
			$evento = $this->Agenda_model->CNS_EventoByID($Id_Evento);
			$ar = $this->Agenda_model->DEL_Evento($Id_Evento);
			if($ar){
				$this->Log("Eventos","DEL",$Id_Evento);
				$this->notificar("del",$evento);
				echo "_ok:Exito al eliminar el evento";
			}
		}
	}

	#	Notifica al contacto que hubo notificaciones en su evento
	#		- Envia un correo
	#		- Inserta en la tabla de notificaciones por medio del método
	#		  agregarNotificacion de MY_Controller 
	#		- Recibe dos parametros: la accion (UPD,DEL,INS)  y el evento en objeto
	#		- Dependiendo de la varible acción es el correo que se manda		
	private function notificar($accion,$evento){
		date_default_timezone_set("America/Mexico_City");
		$emailconfig = $this->emailConfig();
		$configsite = $this->getConfiguracion();
		$data = array("config" => $configsite,"evento" => $evento);

		if($accion == "ins"){
			$asunto = $configsite["NAME"]. " | Hemos agendado un nuevo evento contigo";
			$mensaje = $this->load->view("mensajes/noty-agendainsert-contact",$data,true);
		}elseif($accion == "upd"){
			$asunto = $configsite["NAME"]. " | Hemos modificado tu evento";
			$mensaje = $this->load->view("mensajes/noty-agendaupdate-contact",$data,true);
		}elseif($accion == "del") {
			$asunto = $configsite["NAME"]. " | Hemos eliminado tu evento";
			$mensaje = $this->load->view("mensajes/noty-agendadelete-contact",$data,true);
		}
		$this->load->library("email");
		$this->email->initialize($emailconfig);	
		$this->email->from($configsite["EMAIL"],$configsite["NAME"]);
		$this->email->to($evento->Correo_Electronico);			
		$this->email->subject($asunto);
		$this->email->message($mensaje);
		$this->email->send();

		$datanoty = array(
							"Id_Usuario"      => $evento->Id_Contacto,
							"Id_Tipo_Usuario" => 2,
							"Mensaje"         => "Hemos agendado contigo un nuevo evento",
							"Fecha_Envio"     => date("Y-m-d H:i:s"),
							"Leido"           => 1
				);
		$this->agregarNotificacion($datanoty);
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

	#	Instancia el método de validación de Fechas de MY_Controller
	#		- este método válida que la Fecha de Inicio sea menor a la de Fin
	public function time_comp($fmayor,$fmenor){
		return $this->time_compare($fmayor,$fmenor);
	}
}
