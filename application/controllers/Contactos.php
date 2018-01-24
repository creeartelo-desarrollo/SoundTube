<?php
#	CONTROLADOR DEL MÓUDLO COTIZACIONES DE LA EMPRESA
defined('BASEPATH') OR exit('No direct script access allowed');
class Contactos extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("Contactos_model");
		$this->load->library("form_validation");
		$this->load->helper("security");
	}

	#	Carga vistas del módulo
	public function index()
	{
		$session = $this->session->userdata();
		if(isset($session["permisos"]["CONT"])){
			$data["session"] = $session;
			$data["config"] = $this->getConfiguracion();
			$data["libs"] = array("contactos");
			$data["notys"] = $this->getNotys();
			$this->load->view("back-end/templates/header");
			$this->load->view("back-end/templates/topnav",$data);
			$this->load->view("back-end/templates/sidebar",$data);
			$this->load->view("back-end/contactos");
			$this->load->view("back-end/templates/footer",$data);
		}else{
			redirect(base_url("admin"));
		}
	}

	public function muestraContactos(){
		$res = $this->Contactos_model->CNS_Contactos();
		$contactos = array("data" => $res);
		echo json_encode($contactos);
	}

	#	Muestra Detalle del Contacto
	public function showDetalle(){
		$Id_Contacto      = $this->input->post("Id_Contacto");
		$data["contacto"] = $this->Contactos_model->CNS_ContactoByID($Id_Contacto);
		$html             = $this->load->view("back-end/contacto-detalle",$data,true);
		echo $html;
	}

	#	Cambia Status de un Contacto
	public function modificarContacto(){
		$Estatus     = $this->input->post("optstatus");
		$Id_Contacto = $this->input->post("Id_Contacto");
		$dataarray   = array("Estatus" => $Estatus);

		$ar = $this->Contactos_model->UPD_Contacto($Id_Contacto,$dataarray);
		if($ar){
			$this->Log("Contactos","UPD",$Id_Contacto);
			echo "_ok:Excelente hemos modificado el Estatus del Contacto";
		}else{
			echo "_er:Uh oh! Al parecer hubo un problema al modificar el contacto, intenta recargar la página";
		}
	}
}
?>