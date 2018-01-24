<?php
#	CONTROLADOR DEL MÓUDLO NOTIFICACIONES DE LA EMPRESA
defined('BASEPATH') OR exit('No direct script access allowed');
class Misnotificaciones extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("Notificaciones_model");
		$this->load->library("form_validation");
		$this->load->helper("security");
	}

	#	Carga vistas del módulo
	public function index()
	{
		$session = $this->session->userdata();
		if(isset($session["permisos"]["MISNOTY"])){
			$data["session"] = $session;
			$data["config"] = $this->getConfiguracion();
			$data["libs"] = array("misnotificaciones");
			$data["notys"] = $this->getNotys();
			$this->load->view("back-end/templates/header");
			$this->load->view("back-end/templates/topnav",$data);
			$this->load->view("back-end/templates/sidebar",$data);
			$this->load->view("back-end/misnotificaciones");
			$this->load->view("back-end/templates/footer",$data);
		}else{
			redirect(base_url());
		}
	}

	public function muestraNotificaciones(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["MISNOTY"])){
			$Id_Tipo_Usuario = $this->session->userdata("Id_Tipo_Rol");
			$Id_Usuario = $this->session->userdata("Id_Usuario");
			$res = $this->Notificaciones_model->CNS_Notificaciones($Id_Tipo_Usuario,$Id_Usuario);
			$notificaciones = array("data" => $res);
			echo json_encode($notificaciones);
		}
	}

	public function marcarNoty(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["MISNOTY"])){
			$Id_Notificacion = $this->input->post("Id_Notificacion");
			$Status =  $this->input->post("Status");
			$dataarray = array("Leido" => intval($Status));
			$res = $this->Notificaciones_model->UPD_Notificacion($Id_Notificacion,$dataarray);
			if($res > 0){
				echo "_ok:Excelente! Continuemos...";
				if($Status == 1){
					$nota = "Marcador no como leído";
				}else{
					$nota = "Marcador como leído";
				}
				$this->Log("Notificaciones","UPD",$Id_Notificacion,null,$nota);
			}else{
				echo "_er:Uh oh! Hubo un problema al marcar tu notificación, intenta recargar la página";
			}
		}
	}

	public function eliminarNoty(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["MISNOTY"])){
			$Id_Notificacion = $this->input->post("Id_Notificacion");
			$res = $this->Notificaciones_model->DEL_Notificacion($Id_Notificacion);
			if($res > 0){
				$this->Log("Notificaciones","DEL",$Id_Notificacion);
				echo "_ok:Excelente! Continuemos...";
			}else{
				echo "_er:Uh oh! Hubo un problema al eliminar tu notificación, intenta recargar la página";
			}
		}
	}
}
?>