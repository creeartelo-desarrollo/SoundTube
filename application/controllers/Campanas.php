<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campanas extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Campanas_model");
	}

	public function index()
	{
		$session = $this->session->userdata();
		if(isset($session["permisos"]["CAMP"])){
			$data["session"] = $session;
			$data["config"] = $this->getConfiguracion();
			$data["libs"] = array("campanas");
			$data["notys"] = $this->getNotys();
			$this->load->view("back-end/templates/header");
			$this->load->view("back-end/templates/topnav",$data);
			$this->load->view("back-end/templates/sidebar",$data);
			$this->load->view("back-end/campanas");
			$this->load->view("back-end/templates/footer",$data);
		}else{
			redirect(base_url());
		}
	}

	public function muestraCampana(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["CAMP"])){
			$res = $this->Campanas_model->CNS_Campana();
			$campana = array("data" => $res);
			echo json_encode($campana);
		}
	}

	public function muestraDetalle(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["CAMP"])){
			$Id_Datos_Promo = $this->input->post("Id_Datos_Promo");
			$data["detalle"] = $this->Campanas_model->CNS_CampanaById($Id_Datos_Promo);
			if($data["detalle"]){
				$this->load->view("back-end/detalle-campana",$data);
			}
		
		}
	}

}

