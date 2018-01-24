<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model("Admin_model");
		$this->load->library("form_validation");
		$this->load->helper("security");
	}

	#	Carga vista de login
	public function index()
	{
		$data["config"] = $this->getConfiguracion();
		$this->load->view('back-end/login',$data);
	}

	#	Inicio de sesión
	public function login()
	{		
		$this->form_validation->set_rules("txtusuario","Usuario","trim|required|xss_clean|valid_email");
		$this->form_validation->set_rules("pswcontrasena","Contraseña","trim|required|xss_clean");
		if($this->form_validation->run() == true)
        {
	        $usuario = $this->input->post("txtusuario");
	        $contrasena = $this->input->post("pswcontrasena");
	        $contrasena = md5($contrasena);
	        $login = $this->Admin_model->Login($usuario, $contrasena);

	        if($login)
	        {
	            $array = $this->Admin_model->CNS_Permisos($login->Id_Rol);
	            
	            /*Se construye un array con los permisos del usuario*/
	            	$arraypermisos = array();
	            foreach ($array as $key => $value)
	            	$arraypermisos[$value["Abreviatura"]] = $value["Descripcion"];
	            
	            if($login->Ruta_Imagen){
	            	$Ruta_Imagen = $login->Ruta_Imagen;
	            }else{
	            	$Ruta_Imagen = "default.png";
	            }
	            $sessiondata = array
	                (
						"Id_Usuario"         => $login->Id_Empleado,
						"Id_Tipo_Rol"		 => 1,
						"Id_Rol"             => $login->Id_Rol,
						"Rol"                => $login->Rol,
						"Status"             => $login->Status,
						"Ap_Paterno"         => $login->Ap_Paterno,
						"Ap_Materno"         => $login->Ap_Materno,
						"Nombres"            => $login->Nombres,
						"Correo_Electronico" => $login->Correo_Electronico,
						"Ruta_Imagen"        => $Ruta_Imagen,
						"permisos"           => $arraypermisos
	                );
	            
	            	$this->session->set_userdata($sessiondata);
	            	$this->session->set_flashdata("msn", "Hola ".$login->Nombres.", bienvenid@");
	            	redirect(base_url("bi"));
	        }else{
	            $this->session->set_flashdata("msne","Usuario y Contraseña Incorrectos</p>");
	            redirect(base_url("admin"));
	        }
	    }else{
	    	$errors = preg_replace("[\n|\r|\n\r]", "<br>", validation_errors());
	    	$this->session->set_flashdata("msne",$errors);
	    	redirect(base_url("admin"));
	    }

	}

	#	Cambio de contraseña
	function cambiarContrasena(){
		$this->form_validation->set_rules("pswcontrasena","Contraseña","trim|xss_clean|required|max_length[150]");
		$this->form_validation->set_rules("pswcontrasenaconf","Confirmación de contraseña","trim|xss_clean|max_length[150]|required|matches[pswcontrasena]");
		#	Si pasa las validaciones
		if($this->form_validation->run() == true)
        {
        	$Id_Tipo_Rol = $this->session->userdata("Id_Tipo_Rol");
        	$Id_Usuario = $this->session->userdata("Id_Usuario");
        	$newpass = md5($this->input->post("pswcontrasena"));
        	$dataarray = array(
        			"Contrasena"	=> $newpass
        		);

        	#	Si la contraseña nueva es diferente a la actual se actualiza en B.D.
        	#	de lo contraario, se envia un alerta
        	$usuario = $this->Admin_model->CNS_Usuario($Id_Usuario,$Id_Tipo_Rol);
        	if($usuario->Contrasena != $newpass){
        		#	Si es un usuario administrador: se actualiza en la tabla de Empleados
	        	#	Si es un usuario público: se actualiza en la tabla de Contactos
	        	if($Id_Tipo_Rol == 1){
	        		$ar = $this->Admin_model->UPD_Empleado($Id_Usuario,$dataarray);
	        	}elseif($Id_Tipo_Rol == 2) {
	        		$ar = $this->Admin_model->UPD_Contacto($Id_Usuario,$dataarray);
	        	}

	        	if($ar > 0){
	        		#	Se guarda log y se envia mensaje a la vista
	        		if($Id_Tipo_Rol == 1){
						$this->Log("Empleados","UPD",$Id_Usuario,null,"Cambio de contraseña administrador");
	        		}elseif($Id_Tipo_Rol == 2){
	        			$this->Log("Contactos","UPD",$Id_Usuario,null,"Cambio de contraseña de usuario público");
	        		}
	        		
	        		echo "_ok:Excelente! Se ha actualizado tu contraseña";
	        	}else{
	        		echo "_er:Uh oh! Hubo un error al intentar cambia tu contraseña, intentalo nuevamente";
	        	}
	        }else{
	        	echo "_wr:Tu nueva contraseña es idéntica a la actual";
	        }
        }else{
			$errors = preg_replace("[\n|\r|\n\r]", "<br>", validation_errors());
			echo "_er:".$errors;
		}
	}

	#	Envia nueva contrasena al usuario
	#		-	Recibe correo por post
	#		- 	Consulta si el contacto existe
	#		-	Envia nueva contrasena generada aleatroriamente al correo
	public function recuperarContrasena()
	{
		$this->form_validation->set_rules("txtemail","Correo Electrónico","trim|xss_clean|required");
		#	Si cumple con las validaciones se consultan los datos
		if($this->form_validation->run() == true)
	    {
	    	$email = $this->input->post("txtemail");
	    	$empleado = $this->Admin_model->CNS_EmpleadoByMail($email);
	    	if($empleado){
	    		$configsite 		= $this->getConfiguracion();		
				$data["config"] 	= $configsite;
				$data["usuario"]    = $empleado;
				$data["newpass"]    = $this->genRandomCode();
				$mensaje            = $this->load->view("mensajes/nueva-contrasena",$data,true);
				$configmail         = $this->emailConfig();
				$this->load->library("email");
				$this->email->initialize($configmail);	
				$this->email->from($configsite["EMAIL"],$configsite["NAME"]);
				$this->email->to($email);			
				$this->email->subject("Nueva contraseña | ".$configsite["NAME"]);
				$this->email->message($mensaje);
				$dataarray["Contrasena"] = md5($data["newpass"]);
				$ar = $this->Admin_model->UPD_Empleado($empleado->Id_Empleado,$dataarray);
				if($ar){	
					if($this->email->send()){
						#	Se guarda log y se envia mensaje a la vista
						$this->Log("Empleados","UPD",$empleado->Id_Empleado,null,"Recuperación de contraseña administrador");
						echo "_ok:Excelente! Hemos enviado a tu correo una nueva contraseña";
					}else{
						echo "_er:Uh oh! Al parecer hubo un error de conexión, por favor intenta más tarde";
					}
				}else{
					echo "_er:Uh oh! Al parecer hubo un error de conexión, por favor intenta más tarde";
				}
	    		
	    	}else{
	    		echo "_er:Uh oh! Al parecer este correo no se encuentra registrado";
	    	}	
	    }else{
			$errors = preg_replace("[\n|\r|\n\r]", "<br>", validation_errors());
			echo "_er:".$errors;
		}
	}


	#	Genera una contraseña aleatoria de 6 caracteres
	private function genRandomCode()
	{
		$an = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$su = strlen($an) - 1;
		$cadena = "";
		$length = 6;
		for ($i=0; $i < $length; $i++) { 
			$cadena .= substr($an, rand(0, $su), 1);
		}
		return  $cadena;
	}
	#	Cerrar sesión
	public function logout()
	{
		$sessiondata = array
	     					(
		 						"Id_Usuario", 
		 						"Id_Rol", 
		 						"Rol",
		 						"Status",
		 						"Ap_Paterno",
		 						"Ap_Materno",
		 						"Nombres",
		 						"Correo_Electronico",
		 						"Ruta_Imagen", 
		 						"permisos"
	     					);
	    $this->session->unset_userdata($sessiondata);
	    $this->session->set_flashdata("msn","Bye bye...");
	    redirect(base_url("admin"));
	}

	#	Marcar notificación como leida
	function marcarLeido(){
		$Id_Notificacion = $this->input->post("Id_Notificacion");
		$dataarray = array("Leido" => 0);
		$this->Admin_model->UPD_Notificacion($Id_Notificacion,$dataarray);		
	}
}
