<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
   public function __construct() {
        parent::__construct();
	      $this->load->model('auth');
        $this->load->model('userdata');
	      $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
		
	}

  function index() {
      
        $table = $this->db->dbprefix('users');
        $result = $this->userdata->getWhere($table);         

   }
	public function registration()
	{

	              $this->form_validation->set_rules('username', 'Username', 'required|callback_username_check');
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|max_length[12]',
                 array('required' => 'You must provide a %s.', 'min_length'=>'Password should be 5 character long', 'max_length'=>'password should not be more than 12 character '));
                   
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');


                if ($this->form_validation->run() == FALSE)
                {
                
                   $this->load->view('user-registration');
                }
                else
                {
                    $_POST['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
                   
                    $table = $this->db->dbprefix('users'); // outputs prefix_tablename
                    $_POST['uid'] = 9;
                    
                    $query = $this->auth->registration($table, $_POST);
                    
                    if($query){
                                echo $this->db->last_query();
                                return $this->db->insert_id();
                            } else {
                                $msg = $this->db->error();

                                   var_dump($msg);

                            }
                   }

	       }

   public function update($str)
  {

                $this->form_validation->set_rules('username', 'Username', 'required|callback_username_check');
                   
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');


                if ($this->form_validation->run() == FALSE)
                {
                
                   $this->load->view('user-registration');
                }
                else
                {
                    $_POST['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
                   
                    $table = $this->db->dbprefix('users'); // outputs prefix_tablename
                    
                    $query = $this->userdata->update($table, $_POST,['id'=>$this->input->post('id')]);

                    if($query){
                                echo $this->db->last_query();
                                return $this->db->insert_id();
                            } else {
                                $msg = $this->db->error();

                                   var_dump($msg);

                            }
                   }

         }


 	public function username_check($str)
        {
               $qry = $this->db->simple_query("SELECT * from md_users where username = '{$str}'");
            
               if($qry->num_rows > 0) { 
                   $this->form_validation->set_message('username_check', 'This username allready has been taken');

                     return FALSE;
                     }
                     else { 
                      return TRUE; 
                    }
                    
               return $result;      
        }


  public function email_check($str)
        {
               $qry = $this->db->simple_query("SELECT * from md_users where email = '{$str}'");
            
               if($qry->num_rows > 0) { 
                   $this->form_validation->set_message('email_check', 'This email allready has been taken');
                     return FALSE;
                     }
                     else { 
                      return TRUE; 

                    }
             
        }
        
	
}