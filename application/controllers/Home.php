<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{       
                $this->load->library('session');
                if(!isset($_SESSION['codigo'])) header("Location:./acceso");
                $this->load->helper('url');
                $this->load->helper('header');
				$this->load->view('home/index');
                $this->load->helper('footer');
	}
}
