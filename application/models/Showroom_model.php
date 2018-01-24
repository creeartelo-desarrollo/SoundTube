<?php
class Showroom_model extends CI_Model 
{
 	public function __construct() {
    	$this->load->database();
    }

    #   Consulta videos del ShowRoom
    function CNS_Showroom(){
        $this->db->select("*");
        $this->db->from("Showroom");      
        $query = $this->db->get();
        return $query->result_array();
    }

    #	Inserta video en tabla
    function INS_Showroom($dataarray)
    {
    	$this->db->insert("Showroom",$dataarray);
    	return $this->db->insert_id();
    }

     #  Actualiza video en tabla
    function UPD_Showroom($Id_Showroom, $dataarray)
    {
        $this->db->where("Id_Showroom",$Id_Showroom);
        $this->db->update("Showroom",$dataarray);
        return $this->db->affected_rows();
    }

    #   Consulta que el Id_Video sea unico
    function CNS_UQVideo($Id_Video,$Id_Showroom){     
        $this->db->select("Id_Video");
        $this->db->from("Showroom");
        $this->db->where("Id_Video",$Id_Video);
        if($Id_Showroom != ""){ 
            $this->db->where("Id_Showroom !=",$Id_Showroom);
        }
        return $this->db->count_all_results();
    }

    #   Consulta un registro por su ID
    function CNS_ShowroomById($Id_Showroom){
        $this->db->select("*");
        $this->db->from("Showroom");
        $this->db->where("Id_Showroom",$Id_Showroom);
        $query = $this->db->get();
        return $query->row();
    }

    #   Elimina registro
    function DEL_Showroom($Id_Showroom){
        $this->db->where("Id_Showroom",$Id_Showroom);
        $this->db->delete("Showroom");
        return $this->db->affected_rows();
    }
}
?>