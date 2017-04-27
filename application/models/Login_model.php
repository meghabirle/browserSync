<?php 
class Auth extends CI_Model {

       /* public function __construct()
        {
			parent::__construct();
            
        }*/
		
		public function login($lgdata)
		{
		$query = $this->db->get_where('yg_user',$lgdata);
				//$query = $this->db->get_where('yg_user', array('email' => $lgdata['email'],'password'=> $lgdata['password'],'usertype'=>$lgdata['usertype']));
				
				return $query->row_array();
		}
}
?>