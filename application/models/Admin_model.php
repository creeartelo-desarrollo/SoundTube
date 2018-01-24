<?php
 class Admin_model extends CI_Model 
 {
 	public function __construct() {
    	$this->load->database();
   }
 	
    #   Conusulta usuario activo por Correo y Contraseña
 	function Login($usuario, $contrasena)
    {
        $this->db->select("e.*,r.Nombre as Rol");
        $this->db->from("Empleados as e");
        $this->db->join("Cat_Roles as r","ON e.Id_Rol = r.Id_Rol","inner");
        $this->db->where("Correo_Electronico",$usuario);
        $this->db->where("Contrasena",$contrasena);
        $this->db->where("status",1);
        $query = $this->db->get();
        return $query->row();
    }

    #   Consulta los permisos que tiene un rol
    function CNS_Permisos($idTipo)
    {
        $this->db->select("r.*, s.*");
        $this->db->from("Cat_Roles AS r");
        $this->db->join("Rel_Rol_Secciones AS p","r.Id_Rol = p.Id_Rol","inner");
        $this->db->join("Cat_Secciones as s","p.Id_Seccion = s.Id_Seccion","inner");
        $this->db->where("r.Id_Rol",$idTipo);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    #   Actualiza una notificación
    function UPD_Notificacion($Id_Notificacion,$dataarray){
        $this->db->where("Id_Notificacion",$Id_Notificacion);
        $this->db->update("Notificaciones",$dataarray);       
        return $this->db->affected_rows();
    }

    #   Consulta usuario (publico o administrador) por su ID
    function CNS_Usuario($Id_Usuario,$Tipo)
    {
        $this->db->select("*");
        #   Si es 1 (administrador) : Se consulta tabla Empleados
        #   Si es 2 (público) : Se consulta tabla Contactos
        if($Tipo == 1){
            $this->db->from("Empleados");
            $this->db->where("Id_Empleado",$Id_Usuario);
        }elseif($Tipo == 2){
            $this->db->from("Contactos");
            $this->db->where("Id_Contacto",$Id_Usuario);
        }

        $query = $this->db->get();
        return $query->row();
    }

    #   Consulta empleado por su Correo
    function CNS_EmpleadoByMail($Correo_Electronico)
    {
        $this->db->select("*");
        $this->db->from("Empleados");
        $this->db->where("Correo_Electronico",$Correo_Electronico);
        $query = $this->db->get();
        return $query->row();
    }

    #   Actualiza un contacto (Usuario público)
    function UPD_Contacto($Id_Contacto, $dataarray){
        $this->db->where("Id_Contacto",$Id_Contacto);
        $this->db->update("Contactos",$dataarray);
        return $this->db->affected_rows();
    } 

    #   Actualiza un empleado
    function UPD_Empleado($Id_Empleado, $dataarray){
        $this->db->where("Id_Empleado",$Id_Empleado);
        $this->db->update("Empleados",$dataarray);
        return $this->db->affected_rows();
    } 
}