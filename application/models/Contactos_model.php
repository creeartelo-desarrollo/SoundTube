<?php
class Contactos_model extends CI_Model 
{
 	public function __construct() {
    	$this->load->database();
    }

    #   Consulta las cotizaciones con join en contactos
    function CNS_Contactos(){
        $this->db->select("*");
        $this->db->from("Contactos");
        $query = $this->db->get();
        return $query->result_array();
    }

    #   Consulta contacto por su ID
    function CNS_ContactoByID($Id_Contacto){
        $this->db->select("*");
        $this->db->from("Contactos");
        $this->db->where("Id_Contacto",$Id_Contacto);
        $query = $this->db->get();
        return $query->row();
    }

    #   Actualiza un Contacto
    function UPD_Contacto($Id_Contacto,$dataarray){
        $this->db->where("Id_Contacto",$Id_Contacto);
        $this->db->update("Contactos",$dataarray);
        return $this->db->affected_rows();
    }
}
?>