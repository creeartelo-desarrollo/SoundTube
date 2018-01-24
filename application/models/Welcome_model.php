<?php
 class Welcome_model extends CI_Model 
 {
 	public function __construct() {
    	$this->load->database();
   }
 	
    #   Login público
    function Login($usuario, $contrasena = null)
    {
        $this->db->select("*");
        $this->db->from("Contactos");
        $this->db->where("Correo_Electronico",$usuario);
        if($contrasena){
             $this->db->where("Contrasena",md5($contrasena));
        }
        $this->db->where("Estatus",1);
        $query = $this->db->get();
        return $query->row();
    }

    #   Consulta permisos de acuerdo al Rol y Tipo de Rol
    function CNS_Permisos($idTipo)
    {
        $this->db->select("s.*");
        $this->db->from("Rel_Rol_Secciones AS r");
        $this->db->join("Cat_Secciones as s","r.Id_Seccion = s.Id_Seccion","inner");
        $this->db->where("r.Id_Rol",$idTipo);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    #   Consulta una pregunta del cotizador por su ID
    function CNS_PreguntaById($Id_Pregunta_Cotizador){
        $this->db->select("*");
        $this->db->from("Preguntas_Cotizador");
        $this->db->where("Id_Pregunta_Cotizador",$Id_Pregunta_Cotizador);

        $query = $this->db->get();
        return $query->row();
    }

    #   Consulta una pregunta por grupo de pregunta
    function CNS_PreguntaByGrupo($Grupo){
        $this->db->select("*");
        $this->db->from("Preguntas_Cotizador");
        $this->db->where("Grupo",$Grupo);

        $query = $this->db->get();
        return $query->result_array();
    }

    #   Inserta un contacto (Usuario público)
    function INS_Contacto($dataarray){
        $this->db->insert("Contactos",$dataarray);
        return $this->db->insert_id();
    } 

    #   Actualiza un contacto (Usuario público)
    function UPD_Contacto($Id_Contacto, $dataarray){
        $this->db->where("Id_Contacto",$Id_Contacto);
        $this->db->update("Contactos",$dataarray);
        return $this->db->affected_rows();
    }   

    #   Inserta maestro cotización
    function INS_Cotizacion($dataarray){
        $this->db->insert("Cotizaciones",$dataarray);
        return $this->db->insert_id();
    }

    #   Inserta detalle de una cotización
    function INS_CotizacionDetalle($dataarray){
        $this->db->insert("Cotizacion_Detalle",$dataarray);
        return $this->db->insert_id();
    }

    #   Consulta la última cotización de un Usuario
    function CNS_LastCotizacionByUser($Id_Contacto){
        $this->db->select("c.*,u.Nombres,u.Apellidos");
        $this->db->from("Cotizaciones as c");
        $this->db->where("u.Id_Contacto",$Id_Contacto);
        $this->db->join("Contactos as u","c.Id_Contacto = u.Id_Contacto","inner");
        $this->db->order_by("c.Id_Cotizacion","DESC");
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    #   Consulta detalle de una cotización
    function CNS_CotizacionDetalle($Id_Cotizacion){
        $this->db->select("*");
        $this->db->from("Cotizacion_Detalle");
        $this->db->where("Id_Cotizacion",$Id_Cotizacion);
        $query = $this->db->get();
        return $query->result_array();
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

    #   Consulta videos del ShowRoom
    function CNS_Showroom(){
        $this->db->select("*");
        $this->db->from("Showroom");      
        $query = $this->db->get();
        return $query->result_array();
    }
    
    #   Inserta Visitas
    function INS_Visitas($dataarray){
        $this->db->insert("Visitas",$dataarray);
        return $this->db->insert_id();
    }

     #   Actualiza campo vista de una vista
    function UPD_Visitas($Id_Visita,$dataarray){
        $this->db->where("Id_Visita",$Id_Visita);
        $this->db->update("Visitas",$dataarray);
        return $this->db->affected_rows();
    }

    #   Inserta en tabla de promociones
    function INS_Promo($dataarray){
        $this->db->insert("Datos_Promo",$dataarray);
        return $this->db->insert_id();
    }
 }
?>