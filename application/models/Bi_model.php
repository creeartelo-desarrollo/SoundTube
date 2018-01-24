<?php
class Bi_model extends CI_Model 
{
 	public function __construct() {
    	$this->load->database();
    }

    #   Cuenta cotizaciones
    function COUNT_Cotizaciones($Id_Usuario = null){
    	$this->db->select("Id_Cotizacion");
    	$this->db->from("Cotizaciones");
    	if($Id_Usuario){
	    	$this->db->where("Id_Contacto",$Id_Usuario);
    	}
    	return $this->db->count_all_results();
    }

    #   Cuenta eventos agendados
    function COUNT_Agendados($Id_Usuario = null){
    	$this->db->select("Id_Evento");
    	$this->db->from("Eventos");
    	if($Id_Usuario){
	    	$this->db->where("Id_Contacto",$Id_Usuario);
    	}
    	return $this->db->count_all_results();
    }

    #   Cuenta contactos activos
    function COUNT_Contactos(){
        $this->db->select("Id_Contacto");
        $this->db->from("Contactos");
        $this->db->where("Estatus",1);
        return $this->db->count_all_results();
    }

    #   Consulta servicios mas agendados
    function CNS_TopServiciosAgendados(){
        $this->db->select("t.Nombre as Tipo_Evento, COUNT(e.Id_Cat_Tipo_Evento) AS Score");
        $this->db->from("Cat_Tipo_Evento AS t");
        $this->db->join("Eventos as e","t.Id_Cat_Tipo_Evento = e.Id_Cat_Tipo_Evento","left");
        $this->db->group_by("e.Id_Cat_Tipo_Evento");
        $this->db->order_by("Score","desc");
        $query =  $this->db->get();
        return $query->result_array();
    }

    #   Consulta servicios mas cotizados
    function CNS_TopServiciosCotizados(){
        $this->db->select("p.Pregunta, COUNT(p.Pregunta) AS Score");
        $this->db->from("Preguntas_Cotizador AS p");
        $this->db->join("Cotizacion_Detalle as c","p.Pregunta = c.Pregunta","left");
         $this->db->where("p.Grupo",1);
        $this->db->group_by("p.Pregunta");
        $this->db->order_by("Score","desc");
        $query =  $this->db->get();
        return $query->result_array();
    }

    #   Consulta contactos con mayor interacción
    function CNS_TopContactos(){
        $query = "SELECT Nombres, Apellidos, SUM(Score) as Total FROM
        (SELECT c.Nombres, c.Apellidos, COUNT(e.Id_Contacto) AS Score 
        FROM Contactos AS c
        LEFT JOIN Eventos as e
        ON c.Id_Contacto = e.Id_Contacto
        WHERE c.Estatus = 1
        GROUP BY e.Id_Contacto
        UNION ALL
        SELECT c.Nombres, c.Apellidos, COUNT(cot.Id_Contacto) AS Score 
        FROM Contactos AS c
        LEFT JOIN Cotizaciones as cot
        ON c.Id_Contacto = cot.Id_Contacto
        WHERE c.Estatus = 1
        GROUP BY cot.Id_Contacto) as t
        ORDER BY Total DESC
        LIMIT 10";
        $qry = $this->db->query($query);
        return $qry->result_array();
    }

    #   Consulta Intección de Contactos
    function CNS_InteraccionContactos(){
        $query = "SELECT c.Id_Contacto, c.Nombres, c.Apellidos,
            (SELECT COUNT(coti.Id_Cotizacion) FROM Cotizaciones as coti WHERE coti.Id_Contacto = c.Id_Contacto) as Numcotis,
            (SELECT COUNT(e.Id_Evento) FROM Eventos as e WHERE e.Id_Contacto = c.Id_Contacto) as Numeventos
        FROM Contactos AS c";
        $qry = $this->db->query($query);
        return $qry->result_array();
    }

    #   Consulta agenda en rango de fechas
    function CNS_EventosByFechas($Fecha_Inicio,$Fecha_Fin){
        $query = "SELECT Fecha_Inicio, COUNT(Id_Evento) as Score
        FROM Eventos as e
        WHERE Fecha_Inicio >= '".$Fecha_Inicio."' AND Fecha_Fin  <= '".$Fecha_Fin."'
        GROUP BY MONTH(Fecha_Inicio)";
        $qry = $this->db->query($query);
        return $qry->result_array();
    }

    #   Consulta visitas agrupadas por ciudad
    function COUNT_VisitasCiudad(){
        $this->db->select("*, COUNT(Id_Visita) AS Score");
        $this->db->from("Visitas");
        $this->db->group_by("Ciudad");
        $query = $this->db->get();
        return $query->result_array();
    }

    #   Consulta visitas agrupadas por ciudad
    function CNS_VisitasByRango($Fecha_Inicio,$Fecha_Fin){
        $this->db->select("*");
        $this->db->from("Visitas");
        $this->db->where("Fecha_Ejecucion >=",$Fecha_Inicio);
        $this->db->where("Fecha_Ejecucion <=",$Fecha_Fin);
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>