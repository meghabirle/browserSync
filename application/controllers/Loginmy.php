<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function index()
	 {
    if($this->session->has_userdata('uname')) :		
       $this->load->view('index');
    else :
       $this->load->view('login');	
	 endif;
    }

   }