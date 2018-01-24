<?php
#	CONTROLADOR DEL MÓUDLO COTIZACIONES DEL USUARIO
defined('BASEPATH') OR exit('No direct script access allowed');
class Miscotizaciones extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("Cotizaciones_model");
		$this->load->library("form_validation");
		$this->load->helper("security");
	}

	#	Carga vistas del módulo
	public function index()
	{
		$session = $this->session->userdata();
		if(isset($session["permisos"]["MISCOTI"])){
			$data["session"] = $session;
			$data["config"] = $this->getConfiguracion();
			$data["libs"] = array("miscotizaciones");
			$data["notys"] = $this->getNotys();
			$this->load->view("back-end/templates/header");
			$this->load->view("back-end/templates/topnav",$data);
			$this->load->view("back-end/templates/sidebar",$data);
			$this->load->view("back-end/miscotizaciones");
			$this->load->view("back-end/templates/footer",$data);
		}else{
			redirect(base_url());
		}
	}

	public function muestraCotizaciones(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["MISCOTI"])){
			$Id_Usuario = $this->session->userdata("Id_Usuario");
			$res = $this->Cotizaciones_model->CNS_Cotizaciones($Id_Usuario);
			$cotizaciones = array("data" => $res);
			echo json_encode($cotizaciones);
		}
	}

	public function genPDF($Folio){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["MISCOTI"])){
			#	Consulta cotización por folio
			$cotizacion = $this->Cotizaciones_model->CNS_CotizacionByFolio($Folio);
			
			#	Consulta el detalle y lo separa en array por servicios
			$cotidetalle = $this->Cotizaciones_model->CNS_CotizacionDetalle($cotizacion->Id_Cotizacion);
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
		}else{
			redirect(base_url());
		}
	}

	public function eliminarCotizacion(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["MISCOTI"])){
			$Id_Cotizacion = $this->input->post("Id_Cotizacion");
			$cotidetalle = $this->Cotizaciones_model->CNS_CotizacionDetalle($Id_Cotizacion);
			$ard = $this->Cotizaciones_model->DEL_CotizacionDetalle($Id_Cotizacion);
			$ar = $this->Cotizaciones_model->DEL_Cotizacion($Id_Cotizacion);
			$this->Log("Cotizaciones","DEL",$Id_Cotizacion);
			if($ar){
				echo "_ok:Excelente, hemos eliminado tu registro se ha eliminado";
			}else{
				echo "_er:Uh uh; hubo un problema al eliminar el registro, intenta recargar la página";
			}
		}
	}
}