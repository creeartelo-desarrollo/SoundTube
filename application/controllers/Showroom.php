<?php
#	CONTROLADOR DEL MÓUDLO NOTIFICACIONES DE LA EMPRESA
defined('BASEPATH') OR exit('No direct script access allowed');
class Showroom extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("Showroom_model");
		$this->load->library("form_validation");
		$this->load->helper("security");
	}

	#	Carga vistas del módulo
	public function index()
	{
		$session = $this->session->userdata();
		if(isset($session["permisos"]["SHROO"])){
			$data["session"] = $session;
			$data["config"] = $this->getConfiguracion();
			$data["libs"] = array("showroom");
			$data["notys"] = $this->getNotys();
			$this->load->view("back-end/templates/header");
			$this->load->view("back-end/templates/topnav",$data);
			$this->load->view("back-end/templates/sidebar",$data);
			$this->load->view("back-end/showroom");
			$this->load->view("back-end/templates/footer",$data);
		}else{
			redirect(base_url());
		}
	}

	#	Muestra consulta de videos
	public function muestraShowroom(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["SHROO"])){
			$res = $this->Showroom_model->CNS_Showroom();
			$showroom = array("data" => $res);
			echo json_encode($showroom);
		}
	}

	#	Guarda Video 
	#		Se recibe url de YT del formulario
	#		Se descompone la URL para obtener sus parámetros (ID del video)
	#		Se comprueba que el Id_Video no esté duplicado
	#		Se realiza una solicitud por CURL para obtener los datos del video
	#		- con la apikey de Google Developers y el ID dek video
	#		- se obtiente los datos del json devuelto y se inserta o actualiza
	public function guardarShowroom(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["SHROO"])){
			$this->form_validation->set_rules("txturl","URL YouTube","trim|xss_clean|max_length[300]|required|valid_url");
			if($this->form_validation->run() == true)
	        {
	        	$Id_Showroom = $this->input->post("Id_Showroom");
	        	$apikey = "AIzaSyAALL-MewZHE-8lBV0MiS1tqzFpDjfeHRo";
		        $yt_url = $this->input->post("txturl");
		        parse_str(parse_url( $yt_url, PHP_URL_QUERY ), $my_array_of_vars );
				$uqyoutube = $this->Showroom_model->CNS_UQVideo($my_array_of_vars["v"],$Id_Showroom);
			    if($uqyoutube == 0){
		        	$ch = curl_init();
		        	$url = "https://www.googleapis.com/youtube/v3/videos?id=".$my_array_of_vars["v"]."&key=".$apikey."&part=snippet";
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_URL,$url);
					$result=curl_exec($ch);
					curl_close($ch);
					$json = json_decode($result,true);

					$imgyt = file_get_contents($json["items"][0]["snippet"]["thumbnails"]["high"]["url"]);
					file_put_contents("./public/uploads/showroom/" . $my_array_of_vars["v"]. ".jpg", $imgyt);
					
					#	Array de datos para la B.D.
					$dataarray = array(
							"Id_Video" => $my_array_of_vars["v"],
							"Titulo" => $json["items"][0]["snippet"]["title"],
							"Ruta_Imagen" => $my_array_of_vars["v"] . ".jpg"
						);

					if($Id_Showroom){
						#	Si es un UPD se elimina la imagen del registro anterior
						$sr = $this->Showroom_model->CNS_ShowroomById($Id_Showroom);
						if($sr){
							$ruta = "./public/uploads/showroom/". $sr->Ruta_Imagen;
							if(is_file($ruta) && file_exists($ruta)){
								unlink($ruta);
							}
						}

						$ar = $this->Showroom_model->UPD_Showroom($Id_Showroom,$dataarray);
						if($ar){
							echo "_ok:Excelente, el evento ha sido guardado";
						    $this->Log("Showroom","UPD",$Id_Showroom);
						}
					}else{
				        $last = $this->Showroom_model->INS_Showroom($dataarray);
						if($last){
							echo "_ok:Excelente, el video ha sido guardado";
						    $this->Log("Showroom","INS",$last);
						}else{
							echo "_er:Uh oh!, al parecer hubo un error al guardar, intenta recargar la página";
						}
				    }
				}else{
					echo "_er:Uh oh! parece que este video ya se encuentra, intenta con otra url";
				}
	        }else{
				$errors = preg_replace("[\n|\r|\n\r]", "<br>", validation_errors());
				echo "_er:".$errors;
			}
		}
	}

	#	Muestra JSON de un registro consultado por su ID
	public function mostrarShowroomByID(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["SHROO"])){
			$Id_Showroom = $this->input->post("Id_Showroom");
			$showroom = $this->Showroom_model->CNS_ShowroomById($Id_Showroom);
			$showroom->Id_Video = "https://www.youtube.com/watch?v=".$showroom->Id_Video;
			echo json_encode($showroom);
		}
	}

	#	Elimina un registro del Showroom 
	public function eliminarShowroom(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["SHROO"])){
			$Id_Showroom = $this->input->post("Id_Showroom");
			#	se elimina la imagen anterior
			$sr = $this->Showroom_model->CNS_ShowroomById($Id_Showroom);
			if($sr){
				$ruta = "./public/uploads/showroom/". $sr->Ruta_Imagen;
				if(is_file($ruta) && file_exists($ruta)){
					unlink($ruta);
				}
			}

			$ar = $this->Showroom_model->DEL_Showroom($Id_Showroom);
			if($ar){
				echo "_ok:Hemos eliminado el video";
			    $this->Log("Showroom","DEL",$Id_Showroom);
			}else{
				echo "_er:Uh oh!, al parecer hubo un error y el registro no se ha eliminado, intenta recargar la página";
			}
		}
	}
}
?>