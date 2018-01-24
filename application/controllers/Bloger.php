<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bloger extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$session = $this->session->userdata();
	}

	public function index()
	{
		$session = $this->session->userdata();
		$data["session"] = $session;
		$data["config"] = $this->getConfiguracion();
		$data["libs"] = array("agenda");
		$data["notys"] = $this->getNotys();
		if(isset($session["permisos"]["BLOG"])){
			$this->load->view('back-end/templates/header',$data);
			$this->load->view('back-end/templates/topnav',$data);
			$this->load->view('back-end/templates/sidebar',$data);
			$this->load->view('back-end/blog',$data);
			$this->load->view('back-end/templates/footer',$data);
		}
	}

	public function loginWP(){
		$session = $this->session->userdata();
		if(isset($session["permisos"]["BLOG"])){
			$this->load->view('back-end/wp-login');
		}
	}
}