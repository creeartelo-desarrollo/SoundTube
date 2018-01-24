<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mibi extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("Agenda_model");
		$this->load->model("Bi_model");
	}

	public function index()
	{
		$session = $this->session->userdata();
		$Id_Usuario = $session["Id_Usuario"];
		if(isset($session["permisos"]["MIBI"])){
			$data["session"] = $session;
			$data["config"] = $this->getConfiguracion();
			$data["cont_cotis"] = $this->Bi_model->COUNT_Cotizaciones($Id_Usuario);
			$data["cont_agen"] = $this->Bi_model->COUNT_Agendados($Id_Usuario);
			$data["notys"] = $this->getNotys();
			$data["libs"] = array("mibi");
			$this->load->view("back-end/templates/header");
			$this->load->view("back-end/templates/topnav",$data);
			$this->load->view("back-end/templates/sidebar",$data);
			$this->load->view("back-end/mibi");
			$this->load->view("back-end/templates/footer");
		}else{
			redirect(base_url());
		}
	}
}
