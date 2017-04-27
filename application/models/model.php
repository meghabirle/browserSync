

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model extends CI_Model {
       public function __construct() {
				parent::__construct();
				 $this->load->database();
				}
				
		public function insertData($table,$data)
		{ 
			$query = $this->db->insert($table,$data); 
		}
		public function avg_groupby_doctor($table)
		{
			   $this->db->select_avg('rate');
		       $this->db->select('doctorid');
			   $this->db->group_by('doctorid'); 
               $query = $this->db->get('yg_comment'); 
		       return $query->result_array();
		}
			
}
?>

