<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campanas_model extends CI_Model {
	public function __construct() {
    	$this->load->database();
    }

    #   Consulta la taba de Datos_Promo
    function CNS_Campana(){
        $this->db->select("*");
        $this->db->from("Datos_Promo");
        $query = $this->db->get();
        return $query->result_array();
    }
	
	#	Consulta el detalle del contacto por su ID
	function CNS_CampanaById($Id_Datos_Promo){
		$this->db->select("*");
        $this->db->from("Datos_Promo");
        $this->db->where("Id_Datos_Promo", $Id_Datos_Promo);
        $query = $this->db->get();
        return $query->row();
	}	

}

/* End of file Campanas_model.php */
/* Location: ./application/models/Campanas_model.php */
