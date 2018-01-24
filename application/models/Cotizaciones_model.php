<?php
class Cotizaciones_model extends CI_Model 
{
 	public function __construct() {
    	$this->load->database();
    }

    #   Consulta las cotizaciones con join en contactos
    function CNS_Cotizaciones($Id_Contacto = null){
        $this->db->select("coti.*, cont.Nombres,cont.Apellidos");
        $this->db->from("Cotizaciones as coti");
        $this->db->join("Contactos AS cont","coti.Id_Contacto = cont.Id_Contacto","left");
        if($Id_Contacto){
            $this->db->where("cont.Id_Contacto",$Id_Contacto);
        }       
        $query = $this->db->get();
        return $query->result_array();
    }

    #   Consulta cotización por su ID
    function CNS_CotizacionByFolio($Folio){
        $this->db->select("coti.*, cont.Nombres,cont.Apellidos");
        $this->db->from("Cotizaciones as coti");
        $this->db->join("Contactos AS cont","coti.Id_Contacto = cont.Id_Contacto","left");
        $this->db->where("Folio",$Folio);
        $query = $this->db->get();
        return $query->row();
    }

    #   Consulta el Id de los servicios de una cotización   
    function CNS_ServiciosDetalle($Id_Cotizacion){
        $this->db->select("Servicio");
        $this->db->from("Cotizacion_Detalle");
        $this->db->where("Id_Cotizacion",$Id_Cotizacion);
        $this->db->where("Servicio !=","");
        $this->db->group_by("Servicio");
        $query = $this->db->get();
        return $query->result_array();
    }
    
   #   Consulta detalle de una cotización
    function CNS_CotizacionDetalle($Id_Cotizacion){
        $this->db->select("*");
        $this->db->from("Cotizacion_Detalle");
        $this->db->where("Id_Cotizacion",$Id_Cotizacion);
    
        $query = $this->db->get();
        return $query->result_array();
    }

    #   Elimina una cotización
    function DEL_Cotizacion($Id_Cotizacion)
    {
        $this->db->where("Id_Cotizacion",$Id_Cotizacion);
        $this->db->delete("Cotizacion_Detalle");
        return $this->db->affected_rows();
    }

    #   Elimina reigitros de la tabla Cotizacion_Detalle
    #   relacionados a con el el ID de una cotización
    function DEL_CotizacionDetalle($Id_Cotizacion)
    {
        $this->db->where("Id_Cotizacion",$Id_Cotizacion);
        $this->db->delete("Cotizaciones");
        return $this->db->affected_rows();
    }
}