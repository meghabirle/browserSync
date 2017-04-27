<?php 
class Auth extends CI_Model {

       public function __construct()
        {
			parent::__construct();
            $this->load->database();            
        }
		
		public function login($lgdata)
		{
		    $query = $this->db->get_where('md_users',$lgdata);
			return $query->row_array();
		}

		function registration($table, $data) {

          $qry = $this->db->insert($table,$data);

          return $qry;
		}

	
}
?>