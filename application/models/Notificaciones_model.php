<?php
class Notificaciones_model extends CI_Model 
{
 	public function __construct() {
    	$this->load->database();
    }

    #   Consulta las cotizaciones con join en contactos
    function CNS_Notificaciones($Id_Tipo_Usuario,$Id_Usuario){
        $this->db->select("*");
        $this->db->from("Notificaciones");
        $this->db->where("Id_Tipo_Usuario",$Id_Tipo_Usuario);
        $this->db->where("Id_Usuario",$Id_Usuario);
        $query = $this->db->get();
        return $query->result_array();
    }

    #   Actualiza notificacion
    function UPD_Notificacion($Id_Notificacion,$dataarray){
        $this->db->where("Id_Notificacion",$Id_Notificacion);
        $this->db->update("Notificaciones",$dataarray);
        return $this->db->affected_rows();
    }

    #   Elimina una notificación
    function DEL_Notificacion($Id_Notificacion)
    {
        $this->db->where("Id_Notificacion",$Id_Notificacion);
        $this->db->delete("Notificaciones");
        return $this->db->affected_rows();
    }
}