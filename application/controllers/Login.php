<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
   public function __construct() {
        parent::__construct();
	    $this->load->model('auth');
		
	}
	public function index()
	 {
	  
		$data = ['username'=>'anoop'];
	
        $login = $this->auth->login($data);
         

         if($login) {
         /*if(password_verify('Anp#12345',$login['password'])) {  echo 'true';   exit;*/

             $this->session->set_userdata('is_logged_in',true);
          	
             redirect(base_url());

         /*} else
         {
         	echo 'PASSWORD NOT MATCHED'.PHP_EOL; 
         }*/
     } else
     {

     	echo 'Username is not valid'.PHP_EOL;
     }
       		
		$this->load->view('index',$login);
		
	}
	
}