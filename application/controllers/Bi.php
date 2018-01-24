<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bi extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("Bi_model");
	}

	public function index()
	{
		$session = $this->session->userdata();
		if(isset($session["permisos"]["BI"])){
			date_default_timezone_set("America/Mexico_City");
			$data["session"] = $session;
			$data["config"] = $this->getConfiguracion();
			$data["cont_cotis"] = $this->Bi_model->COUNT_Cotizaciones();
			$data["cont_agen"] = $this->Bi_model->COUNT_Agendados();
			$data["cont_conts"] = $this->Bi_model->COUNT_Contactos();
			$data["top_agendados"] = $this->Bi_model->CNS_TopServiciosAgendados();
			$data["top_cotizados"] = $this->Bi_model->CNS_TopServiciosCotizados();
			$data["top_contactos"] = $this->Bi_model->CNS_TopContactos();
			$data["notys"] = $this->getNotys();
			$data["libs"] = array("bi");
			$this->load->view("back-end/templates/header");
			$this->load->view("back-end/templates/topnav",$data);
			$this->load->view("back-end/templates/sidebar",$data);
			$this->load->view("back-end/bi",$data);
			$this->load->view("back-end/templates/footer");
		}else{
			redirect(base_url("admin"));
		}
	}

	#	Muestra la interacción de los contactos
	public function muestraInteraccionContactos(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["BI"])){
			$res = $this->Bi_model->CNS_InteraccionContactos();
			$contactos =  array("data" => $res);
			echo json_encode($contactos);
		}
	}

	#	Muestra numero de eventos en un rango de fechas agrupados por mes
	public function muestraAgendaEnRango(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["BI"])){
			date_default_timezone_set("America/Mexico_City");
			$Fecha_Inicio = $this->input->post("Fecha_Inicio");
			$Fecha_Fin = $this->input->post("Fecha_Fin");
			if(!$Fecha_Inicio){
				$Fecha_Inicio = date("Y-m-01");
			}
			if(!$Fecha_Fin){
				$Fecha_Fin = date("Y-m-31");
			}
			$eventos = $this->Bi_model->CNS_EventosByFechas($Fecha_Inicio,$Fecha_Fin);
			echo json_encode($eventos);
		}
	}

	#	Muestra visitas
	public function muestraVisitasCiudad(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["BI"])){
			$visitas = $this->Bi_model->COUNT_VisitasCiudad();
			echo json_encode($visitas);
		}
	}

	#	Muestra vistas en un rango de fechas
	public function muestraVisitasFechas(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["BI"])){
			date_default_timezone_set("America/Mexico_City");
			$Fecha_Inicio = $this->input->post("Fecha_Inicio");
			$Fecha_Fin = $this->input->post("Fecha_Fin");
			if(!$Fecha_Inicio){
				$Fecha_Inicio = date("Y-m-01");
			}
			if(!$Fecha_Fin){
				$Fecha_Fin = date("Y-m-31");
			}
			$res = $this->Bi_model->CNS_VisitasByRango($Fecha_Inicio,$Fecha_Fin);
			$visitas = array("data" => $res);
			echo json_encode($visitas);
		}
	}
}
