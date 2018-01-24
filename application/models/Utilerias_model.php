<?php
 #	MODELO CON FUNCIONES QUE SE UTILIZAN EN TODO EL SITIO
 #	SE INSTANCIA EN EL CONTROLADOR MY_Controller 
 #	(	QUE ES EL CONTROLLADOR MAESTRO DEL QUE HEREDAN LOS DEMÁS CONTROLADORES DE LA APP )
 class Utilerias_model extends CI_Model 
 {
 	public function __construct() {
    	$this->load->database();
    }

    #	Consulta la configuración del sitio
    function CNS_Configuracion()
    {
    	$this->db->select("*");
		$this->db->from("Configuracion");
    	$query = $this->db->get();
    	return $query->result_array();
    }

    #	Consulta si ya exite un campo con un valor ademas de uno que se compara con Id_Referencia
    #		- Recibe 4 parametros: compara, tabla, Id_Referencia, campo
    #		- compara es el valor que se va a buscar
    #		- tabla es en la tabla que se va a buscar
    #		- Id_Referencia es el el ID con el que se va a comparar que sea diferente
    #		- Primero se obtiene el nombre de la Primary Key de la tabla
    #		- Se busca el valor compara en la tabla que tenga un PK diferente a Id_Referencia
    function CNS_Unicos($compara,$tabla,$Id_Referencia,$campo)
 	{
 		if($compara != "" && $tabla != "" && $Id_Referencia != "" && $campo != ""){
	 		$query = $this->db->query("SHOW KEYS FROM ".$tabla." WHERE Key_name = 'PRIMARY'");
	 		$query = $query->row();
	 		if($query && $query->Column_name){
	 			$pk = $query->Column_name;

	 			$this->db->select($pk);
	 			$this->db->from($tabla);
	 			$this->db->where("$pk !=",$Id_Referencia);
	 			$this->db->where($campo,$compara);
	 			$query2 = $this->db->get();
	 			return $query2->num_rows();
	 		}
	 	}
 	}

 	#	Consulta los administradores del sitio que tengan ciertos permisos
 	function CNS_Administradores($permisos){
 		$this->db->select("e.*");
	 	$this->db->from("Empleados as e");
	 	$this->db->join("Cat_Roles as r","e.Id_Rol = r.Id_Rol","inner");
	 	$this->db->join("Rel_Rol_Secciones as rel","r.Id_Rol = rel.Id_Rol","inner");
	 	$this->db->join("Cat_Secciones as s","rel.Id_Seccion = rel.Id_Seccion","inner");
	 	$this->db->group_by("e.Correo_Electronico");
	 	if($permisos){		
		 	$this->db->where("Abreviatura",$permisos);
 		}
 		$query = $this->db->get();
 		return $query->result_array();
 	}

 	#	Consulta las notificaciones de un usuario
 	#		-	Recibe la variable leido que puede ser nula
 	#		-	Si leido es nulla consulta todas
 	#		-	Si leido tiene un valor, se consulta que los registros coincidan con ese valor 
 	function CNS_Notificaciones($leido = null){
 		$Id_Tipo_Usuario = $this->session->userdata("Id_Tipo_Rol");
 		$Id_Usuario = $this->session->userdata("Id_Usuario");
 		$this->db->select("*");
 		$this->db->from("Notificaciones");
 		$this->db->where("Id_Tipo_Usuario",$Id_Tipo_Usuario);
 		$this->db->where("Id_Usuario",$Id_Usuario);
 		if($leido){	
 			$this->db->where("Leido",$leido);
 		}
 		$query = $this->db->get();
 		return $query->result_array();
 	}

 	#	Inserta una notificación
 	function INS_Notificacion($dataarray){
 		$this->db->insert("Notificaciones",$dataarray);
 		return $this->db->insert_id();
 	}

 	#	Guadar Log
 	function INS_Log($dataarray)
 	{	
 		$this->db->insert("Log",$dataarray);
 		return $this->db->insert_id();
 	}
 }
?>