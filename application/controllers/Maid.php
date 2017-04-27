<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Maid extends CI_Controller {
  public function __construct() 
    {
     parent::__construct();
      $this->load->database();
      $this->load->model('userdata');
      $this->load->library('form_validation');
      is_logged_in();
    }
 function index() {
      
        $table = $this->db->dbprefix('maid');
        $result = $this->userdata->getWhere($table);         

   }
  
   public function registration() {                 
                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('contact', 'Contact', 'required|is_natural|min_length[10]|max_length[12]|callback_contact_check',
                 array('required' => 'You must provide a %s.', 'min_length'=>'Contact should be 10 character long', 'max_length'=>'Contact should not be more than 12 character '));
                   
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('skype', 'skype', 'required|callback_skype_check');
             
                if ($this->form_validation->run() == FALSE)
                {
                  $this->load->view('maid-registration');
                }
                else
                {

                    $_POST['Age'] = 24; 
                    $_POST['Gender'] = 2;
                    $_POST['Expertise'] = 'cooky | nany';                 
                    $_POST['Expected_Salary'] = 12000; 
                    $_POST['Location'] = 'Africa'; 
                    $_POST['Nationality'] = 'African'; 
                    $_POST['Work_Type'] = 'full'; 
                    $_POST['Maritial_Status'] = 1; 
                    $_POST['Visa'] = 'Visa'; 
                    $_POST['Visa_Expiry_Date'] = '2017-03-17'; 
  

                    $table = $this->db->dbprefix('maid'); // outputs prefix_tablename
        
                    $query = $this->userdata->set($table,$_POST);
                    
                    if($query){
                               echo $this->db->last_query();
                               return $this->db->insert_id();
                            } else {
                                $msg = $this->db->error();

                                   var_dump($msg);

                            }


                     }
   
        }

 
 public function update() {                 
               
                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('contact', 'Contact', 'required|is_natural|min_length[10]|max_length[12]|callback_contact_check',
                 array('required' => 'You must provide a %s.', 'min_length'=>'Contact should be 10 character long', 'max_length'=>'Contact should not be more than 12 character '));
                   
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('skype', 'skype', 'required|callback_skype_check');
             
                if ($this->form_validation->run() == FALSE)
                {
                
                    $this->load->view('maid-registration');
                }
                else
                {

                    $_POST['Age'] = 24; 
                    $_POST['Gender'] = 2;
                    $_POST['Expertise'] = 'cooky | nany';                 
                    $_POST['Expected_Salary'] = 12000; 
                    $_POST['Location'] = 'Africa'; 
                    $_POST['Nationality'] = 'African'; 
                    $_POST['Work_Type'] = 'full'; 
                    $_POST['Maritial_Status'] = 1; 
                    $_POST['Visa'] = 'Visa'; 
                    $_POST['Visa_Expiry_Date'] = '2017-03-17'; 
  

                    $table = $this->db->dbprefix('maid'); // outputs prefix_tablename
          
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
        
        public function contact_check($str)
        {
               $qry = $this->db->simple_query("SELECT * from md_maid where contact = '{$str}'");
            
               if($qry->num_rows > 0) { 
                   $this->form_validation->set_message('contact_check', 'This contact number allready has been taken');
                     return FALSE;
                     }
                     else { 
                      return TRUE; 

                    }
             
        }


   public function skype_check($str)
        {
               $qry = $this->db->simple_query("SELECT * from md_maid where skype = '{$str}'");
            
               if($qry->num_rows > 0) { 
                   $this->form_validation->set_message('skype_check', 'This skype allready has been taken');
                     return FALSE;
                     }
                     else { 
                      return TRUE; 

                    }
             
        }

    
}