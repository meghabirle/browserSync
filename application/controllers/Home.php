<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
  public function __construct() 
    {
     parent::__construct();
      $this->load->database();
      $this->load->model('userdata');
      is_logged_in();
    }
	
	public function index()
	 {
          
             $table = $this->db->dbprefix('maid');
             $data = ['id'=>24];
             $order = ['username','DESC'];
             $result = $this->userdata->get($table);
             
             $this->load->view('index');
    
    }


  function getdata() {
      
        $table = $this->db->dbprefix('maid');
        $result = $this->userdata->getWhere($table);         

   }

    
}