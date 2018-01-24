<?php
#	CONTROLADOR DEL MÓUDLO COTIZACIONES DE LA EMPRESA
defined('BASEPATH') OR exit('No direct script access allowed');
class Cotizaciones extends MY_Controller {
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
		if(isset($session["permisos"]["COTI"])){
			$data["session"] = $session;
			$data["config"] = $this->getConfiguracion();
			$data["libs"] = array("cotizaciones");
			$data["notys"] = $this->getNotys();
			$this->load->view("back-end/templates/header");
			$this->load->view("back-end/templates/topnav",$data);
			$this->load->view("back-end/templates/sidebar",$data);
			$this->load->view("back-end/cotizaciones");
			$this->load->view("back-end/templates/footer",$data);
		}else{
			redirect(base_url("admin"));
		}
	}

	public function muestraCotizaciones(){
		$res = $this->Cotizaciones_model->CNS_Cotizaciones();
		$cotizaciones = array("data" => $res);
		echo json_encode($cotizaciones);
	}

	public function genPDF($Folio){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["COTI"])){
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
			redirect(base_url("admin"));
		}
	}
}