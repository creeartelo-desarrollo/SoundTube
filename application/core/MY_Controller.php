<?php  
if ( ! defined("BASEPATH")) exit("No direct script access allowed");
 
class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Utilerias_model");
		$this->load->library("session");
		$this->load->helper("url");
	}
	
	#	Obtiene la configuración del sitio y la regresa en un array asociativo 
	public function getConfiguracion()
	{
		$dataarray = $this->Utilerias_model->CNS_Configuracion();
		$arrayconfig = array();
		foreach ($dataarray as $data) {
			$arrayconfig[$data["Abreviatura"]] = $data["Valor"];	
		}
		return $arrayconfig;
	}

	#	Validar que un campo se único en un update 
	public function check_uq_upd($compara,$parametros)
	{
		$parametros = explode("-",$parametros);	
		$query = $this->Utilerias_model->CNS_Unicos($compara,$parametros[0],$parametros[1],$parametros[2]);
		if($query === 0){
			return true;
		}else{
			return false;
		}
	}

	#	Validar que una fecha sea menot a otra
	public function time_compare($fmayor,$fmenor){
		$Fecha_Inicio = new DateTime($fmenor);	
		$Fecha_Fin = new DateTime($fmayor);
		if($Fecha_Inicio < $Fecha_Fin){
			return true;
		}else{
			return false;
		}
	}

	public function getErrores($campo,$campo2 = null){
		$arrayerrores = array(
								"uq_upd" => "Uh oh! ".$campo." ya se encuetra registrado",
								"is_unique" => "Uh oh! ".$campo." ya se encuetra registrado",
								"time_comp" => "Uh oh! ".$campo." debe ser mayor a ".$campo2,
								);

		return $arrayerrores;
	}

	#	Regresa un array con los parametros necesarios para la configuración del envío de emails
	public function emailConfig(){
		$configstore = $this->getConfiguracion();
		$config = array(
								"protocol"       => "smtp",
								"smtp_host"      => $configstore["SMTPHOST"],
								"smtp_user"      => $configstore["EMAIL"],
								"smtp_pass"      => $configstore["SMTPPSW"],
								"smtp_port"      => $configstore["SMTPPORT"],
								"smtp_keepalive" => true,
								"charset"        => "utf-8",
								"wordwrap"       => true,
								"mailtype"       => "html",
								"validate" 		 => true 
							);
		return $config;
	}

	#	Regresa un array indexado con cierto dato de administradores que cuentan con cierto permiso
	#	Recibe dos parametros 
	#	permiso = Permiso que se va a consultar que tenga el administrador
	#	valor = Dato que se va a regresar del administrador
	public function getAdminsData($permiso,$valor){
		$array_correos = array();
		$admin = $this->Utilerias_model->CNS_Administradores($permiso);
		foreach ($admin as $adm) {
			$array_correos[] =  $adm[$valor];
		}
		return $array_correos;
	}

	#	Consulta las notificaciones no leidas del usuario loggeado
	public function getNotys(){
		$notys = $this->Utilerias_model->CNS_Notificaciones(1);
		return $notys;
	}

	#	Inserta una notificación
	public function agregarNotificacion($dataarray){
		$this->Utilerias_model->INS_Notificacion($dataarray);
	}

		#	Guarda Log en la tabla
	#		- Recibe 5 parámetros 
	#			- Tabla = Tabla en la que se realizón el modificó
	#			- Tipo_Ejecucion (UPD,INS,DEL)
	#			- Id_Referencia = ID del Registro que se modificó
	#			- Id_Referencia2 para las tablas de relación (puede ser null)
	#			- Descripción opcional
	#		- El log guarda, además de los parametros recibidos:
	#	    	- Id_Usuario = ID del Usuario que realizó la modificación.
	#			  	si no hay usuario loggeado toma el valor de -1
	#			- Id_Tipo_Rol (1 = Usuario de la Empresa | 2 = Usuario público)
	#			  	si no hay usuario loggeado toma el valor de -1
	#			- Navegador desde donde se realizó el cambio
	#			- Version_Navegador desde donde se realizó el cambio
	#			- Sistema Operativo desde donde se realizó el cambio
	#			- IP Pública 	desde donde se realizó el cambio
	#			- Fecha_Ejecucion = Cuando se realizó el cambio
	public function Log($Tabla,$Tipo_Ejecucion,$Id_Referencia,$Id_Referencia2=null,$Descripcion=null)
	{
		date_default_timezone_set("America/Mexico_City");
		$dataarray["Id_Usuario"]  = $this->session->userdata("Id_Usuario");
		$dataarray["Id_Tipo_Rol"] = $this->session->userdata("Id_Tipo_Rol");
		if(!$dataarray["Id_Tipo_Rol"]){
			$dataarray["Id_Tipo_Rol"] = -1;
		}

		if(!$dataarray["Id_Usuario"]){
			$dataarray["Id_Usuario"] = -1;
		}

 		$dataarray["Tabla"] = $Tabla;
 		$dataarray["Id_Referencia"] = $Id_Referencia;
 		$dataarray["Id_Referencia2"] = $Id_Referencia2;
 		$dataarray["Tipo_Ejecucion"] = $Tipo_Ejecucion;
 		$dataarray["Descripcion"] = $Descripcion;
 		$dataarray["Fecha_Ejecucion"] = date("Y:m:d H:i:s");

		$browser=array("IE","OPERA","NETSCAPE","FIREFOX","SAFARI","CHROME");
		$os=array("WIN","MAC","LINUX");
		$dataarray["Navegador"] = "OTHER";
		$dataarray["Sistema_Operativo"] = "OTHER";
		
		# Obtención Navegador
		foreach($browser as $parent)
		{
			$s = strpos(strtoupper($_SERVER["HTTP_USER_AGENT"]), $parent);
			$f = $s + strlen($parent);
			$version = substr($_SERVER["HTTP_USER_AGENT"], $f, 15);
			$version = preg_replace("/[^0-9,.]/","",$version);
			if ($s){
				$dataarray["Navegador"] = $parent;
				$dataarray["Version_Navegador"] = $version;
			}
		}
	 
		# Obtención Sistema Operativo 
		foreach($os as $val)
		{
			if (strpos(strtoupper($_SERVER["HTTP_USER_AGENT"]),$val)!==false){
				$dataarray["Sistema_Operativo"] = $val;
			}
		}

		#Obtención IP
		$dataarray["IP"] = $_SERVER["REMOTE_ADDR"];
		if (!empty($_SERVER["HTTP_CLIENT_IP"]))
			$dataarray["IP"] = $_SERVER["HTTP_CLIENT_IP"];
		if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
			$dataarray["IP"] = $_SERVER["HTTP_X_FORWARDED_FOR"];

		$last = $this->Utilerias_model->INS_Log($dataarray);	
	}
}
?>