<?php
class Agenda_model extends CI_Model 
{
 	public function __construct() {
    	$this->load->database();
    }

    #   Consulta los eventos de la agenda
    #   - Recibe el parametro Id_Usuario que puede ser nulo
    #   - Si el parametro no es nulo, se compara que el campo Id_Contacto
    #     coincida con el paramtro
    function CNS_Eventos($Id_Usuario = null){
    	$this->db->select("e.*,s.Nombre as Sala,t.Nombre as TipoServicio,t.Color");
        $this->db->from("Eventos as e");
        $this->db->join("Cat_Salas as s","e.Id_Cat_Sala = s.Id_Cat_Sala","left");
        $this->db->join("Cat_Tipo_Evento as t","e.Id_Cat_Tipo_Evento = t.Id_Cat_Tipo_Evento","left");
        $this->db->where("Confirmado",1);
        if($Id_Usuario){
            $this->db->where("e.Id_Contacto",$Id_Usuario);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    #   Consulta todos los eventos que esten activos
    function CNS_EventosActivos(){
        $this->db->select("e.*,s.Nombre as Sala,t.Nombre as TipoServicio,t.Color");
        $this->db->from("Eventos as e");
        $this->db->join("Contactos as c","e.Id_Contacto = c.Id_Contacto","left");
        $this->db->join("Cat_Salas as s","e.Id_Cat_Sala = s.Id_Cat_Sala","left");
        $this->db->join("Cat_Tipo_Evento as t","e.Id_Cat_Tipo_Evento = t.Id_Cat_Tipo_Evento","left");
        $this->db->where("Status",1);
        $this->db->where("Confirmado",1);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    #   Consulta un evento por su ID
    function CNS_EventoByID($Id_Evento){
        $this->db->select("e.*,c.Nombres, c.Apellidos,s.Nombre as Sala, t.Nombre as TipoServicio,t.Color");
    	$this->db->from("Eventos as e");
        $this->db->join("Contactos as c","e.Id_Contacto = c.Id_Contacto","left");
        $this->db->join("Cat_Salas as s","e.Id_Cat_Sala = s.Id_Cat_Sala","left");
        $this->db->join("Cat_Tipo_Evento as t","e.Id_Cat_Tipo_Evento = t.Id_Cat_Tipo_Evento","left");
    	$this->db->where("e.Id_Evento",$Id_Evento);
    	$query = $this->db->get();
    	return $query->row();
    }

     #   Consulta un evento por su Key
    function CNS_EventoByKey($Key){
        $this->db->select("e.*,c.Nombres, c.Apellidos,s.Nombre as Sala, t.Nombre as TipoServicio,t.Color");
        $this->db->from("Eventos as e");
        $this->db->join("Contactos as c","e.Id_Contacto = c.Id_Contacto","left");
        $this->db->join("Cat_Salas as s","e.Id_Cat_Sala = s.Id_Cat_Sala","left");
        $this->db->join("Cat_Tipo_Evento as t","e.Id_Cat_Tipo_Evento = t.Id_Cat_Tipo_Evento","left");
        $this->db->where("e.Key",$Key);
        $query = $this->db->get();
        return $query->row();
    }

    #   Consulta el catálogo de Tipo Cat_Tipo_Evento
    function CNS_CatalogoTiposEvento(){
        $this->db->select("*");
        $this->db->from("Cat_Tipo_Evento");
        $query = $this->db->get();
        return $query->result_array();
    }

    #   Consulta el catálogo de Cat_Salas
    function CNS_CatalogoSalas(){
        $this->db->select("*");
        $this->db->from("Cat_Salas");
        $query = $this->db->get();
        return $query->result_array();
    }

    #   Consulta los contactos
    function CNS_Contactos(){
        $this->db->select("Id_Contacto,Nombres,Apellidos");
        $this->db->from("Contactos");
        $this->db->where("Estatus",1);
        $this->db->order_by("Nombres");
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

    #   Consulta disponibilidad
    #   - Consulta que no haya un evento activo entre las fechas y las sala indicada
    #   - Recibe 4 parámetros
    #   - Fecha_Inicio y Fecha_Fin (Fechas en las que se compara la disponibilidad)
    #   - Id_Cat_Sala que es la sala en la que se compara la diponibilidad
    #   - Id_Evento que puede ser nulo para comparar la disponiblidad en un UPDATE
    function CNS_Disponibilidad($Fecha_Inicio,$Fecha_Fin,$Id_Cat_Sala,$Id_Evento = null)
    {
        $strquery = "SELECT * FROM Eventos WHERE 
        (Fecha_Inicio BETWEEN
        '".$Fecha_Inicio."' AND '".$Fecha_Fin."' OR
        Fecha_Fin  BETWEEN
        '".$Fecha_Inicio."' AND '".$Fecha_Fin."')";
        
        if($Id_Cat_Sala > 0){
            $strquery .="AND Id_Cat_Sala = ".$Id_Cat_Sala;              
        }      
      
        if($Id_Evento){
            $strquery .= " AND Id_Evento != ".$Id_Evento;
        }

        $strquery .= " AND Status = 1";
        $query = $this->db->query($strquery);
        return $query->result_array();
    }

    #   Inserta un evento en la agenda
    function INS_Evento($dataarray){
        $this->db->insert("Eventos",$dataarray);
        return $this->db->insert_id();
    }  

    #   Actualiza un evento
    function UPD_Evento($Id_Evento,$dataarray){
        $this->db->where("Id_Evento",$Id_Evento);
        $this->db->update("Eventos",$dataarray);
        return $this->db->affected_rows();
    }

    #   Elimina un evento
    function DEL_Evento($Id_Evento){
        $this->db->where("Id_Evento",$Id_Evento);
        $this->db->delete("Eventos");
        return $this->db->affected_rows();
    }
}
?>