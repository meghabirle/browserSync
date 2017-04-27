<?php 
class Alldata_process extends CI_Model {

        public function __construct()
        {
			parent::__construct();
			$this->load->library('pagination');
        }
	/* Filter form data*/
	public function filterData($arr=array())
	{
		$arr2 = array('tbl_name','id','token');
		$filter = array_merge_recursive($arr,$arr2);
		$data = array();
		
		foreach($this->input->post()  as $key=>$val){
			if(!in_array($key,$filter)){
				$data[$key]=$val;
			}
		}
		return $data;
	}
	
	public function getmydoctor($id,$order='',$limit='',$page='')
		{
			$this->db->select('ygr.*, ygr.active as dcactive, firstname, lastname, masters, doctorimage, ygs.english_name, ygs.greek_name, street, cityname, countryname, statename, zipcode');
			$this->db->from('yg_relation as ygr');
			$this->db->join('yg_dcprofile as dcp', 'dcp.userid = ygr.doctorid');
			$this->db->join('yg_user as ygu', 'ygu.userid = ygr.doctorid');
			$this->db->join('yg_country', 'yg_country.countryid = dcp.country');
			$this->db->join('yg_states', 'yg_states.stateid = dcp.state');
			$this->db->join('yg_cities', 'yg_cities.cityid = dcp.city');
			$this->db->join('yg_speciality as ygs', 'ygs.spid = dcp.speciality');
			$this->db->where('ygr.userid', $id);
			$this->db->order_by($order);
			
			if($limit!='')
			{
				$page = $page-1;
				$start = $page*$limit;
				$this->db->limit($limit,$start);
			}
			$query = $this->db->get();
			return $query->result_array();
		}
			
    public function record_count($table,$data=array()) 
	{
	      $this->db->where($data);
		  $this->db->from($table);
	      return $this->db->count_all_results();
		  
	}

   //Fetch data according to per_page limit.
		public function fetch_data($limit, $page) 
		{ 
		    $page = $page-1;
		    $start = $page*$limit;
			$this->db->limit($limit,$start);
			$query = $this->db->get("yg_states");
			if ($query->num_rows() > 0) 
			{
				foreach ($query->result() as $row)
				{
					$data[] = $row;
				}
			return $data;
			}
		}
	  public function get_country($q)
	  {
			$this->db->select('*');
			$this->db->like('countryname', $q);
			$query = $this->db->get('yg_country');
			if($query->num_rows > 0)
			{
			  foreach ($query->result_array() as $row)
			  {
				$new_row['label']=htmlentities(stripslashes($row['sortname']));
				$new_row['value']=htmlentities(stripslashes($row['countryname']));
				$row_set[] = $new_row; //build an array
			  }
			  echo json_encode($row_set); //format the array into json data
			}
		  }
		 /*code for search doctor*/ 
		public function get_serach($q, $limit='', $page='')
		{
		    $this->db->select('*');
			$this->db->from('yg_user');
			$this->db->join('yg_dcprofile as dcp', 'dcp.userid = yg_user.userid');
			$this->db->join('yg_country', 'yg_country.countryid = dcp.country');
			$this->db->join('yg_states', 'yg_states.stateid = dcp.state');
			$this->db->join('yg_cities', 'yg_cities.cityid = dcp.city');
			$this->db->join('yg_speciality as ygs', 'ygs.spid = dcp.speciality');
			$qr = explode(' ',$q);
			foreach($qr as $v)
			{
			  $this->db->or_like(array('lastname' => $v, 'firstname' => $v, 'street'=>$v, 'countryname'=>$v, 'cityname'=>$v,'statename'=>$v,'ygs.english_name'=>$v,'ygs.greek_name'=>$v));
			}
			if($limit!='')
			{
				$page = $page-1;
				$start = $page*$limit;
				$this->db->limit($limit,$start);
			}
			$query = $this->db->get();
			return $query->result_array();
		}
    
       public function get_serach1($q)
		{
		    $this->db->select('*');
			$this->db->from('yg_user');
			$this->db->join('yg_dcprofile as dcp', 'dcp.userid = yg_user.userid');
			$this->db->join('yg_country', 'yg_country.countryid = dcp.country');
			$this->db->join('yg_states', 'yg_states.stateid = dcp.state');
			$this->db->join('yg_cities', 'yg_cities.cityid = dcp.city');
			$this->db->join('yg_speciality as ygs', 'ygs.spid = dcp.speciality');
			$qr = explode(' ',$q);
			foreach($qr as $v)
			{
			  $this->db->or_like(array('lastname' => $v, 'firstname' => $v, 'street'=>$v, 'countryname'=>$v, 'cityname'=>$v,'statename'=>$v,'ygs.english_name'=>$v,'ygs.greek_name'=>$v));
			}
			
			$query = $this->db->get();
			return $query->result_array();
		}
    
        public function get_serachpatientDoctor()
		{
		    $this->db->select('*');
			$this->db->from('yg_relation as ygrl');
            $this->db->join('yg_user', 'yg_user.userid = ygrl.doctorid');
			$this->db->join('yg_dcprofile as dcp', 'dcp.userid = ygrl.doctorid');
			$this->db->join('yg_country', 'yg_country.countryid = dcp.country');
			$this->db->join('yg_states', 'yg_states.stateid = dcp.state');
			$this->db->join('yg_cities', 'yg_cities.cityid = dcp.city');
			$this->db->join('yg_speciality as ygs', 'ygs.spid = dcp.speciality');
			$this->db->where(array('ygrl.userid'=>$this->session->userdata('userid')));
			
			$query = $this->db->get();
			return $query->result_array();
		}
    
       
    
    
		public function getdoctor($did)
		{
			$this->db->select('*');
			$this->db->from('yg_user');
			$this->db->join('yg_dcprofile as dcp', 'dcp.userid = yg_user.userid');
			$this->db->join('yg_country', 'yg_country.countryid = dcp.country');
			$this->db->join('yg_states', 'yg_states.stateid = dcp.state');
			$this->db->join('yg_cities', 'yg_cities.cityid = dcp.city');
			$this->db->join('yg_speciality as ygs', 'ygs.spid = dcp.speciality');
			$this->db->where(array('yg_user.userid'=>$did));
			$query = $this->db->get();
			return $query->result_array();
		}
    
    
      public function get_serach_spaciality($q)
		{
		    $this->db->select('*');
			$this->db->from('yg_user');
			$this->db->join('yg_dcprofile as dcp', 'dcp.userid = yg_user.userid');
			$this->db->join('yg_country', 'yg_country.countryid = dcp.country');
			$this->db->join('yg_states', 'yg_states.stateid = dcp.state');
			$this->db->join('yg_cities', 'yg_cities.cityid = dcp.city');
			$this->db->join('yg_speciality as ygs', 'ygs.spid = dcp.speciality');
			$this->db->where('ygs.spid',$q);
			
			$query = $this->db->get();
			return $query->result_array();
		}
    
    
      public function getallData($table)
		{
			$query = $this->db->get($table); 
			return $query->result_array();
		}
		
		public function getComment($did ,$limit='', $page='')
		{
			$this->db->select('ygc.*, ygu.firstname, ygu.lastname');
			$this->db->from('yg_comment as ygc');
			$this->db->join('yg_user as ygu', 'ygc.userid = ygu.userid');
			$this->db->order_by('id desc');
			$this->db->where(array('ygc.doctorid'=>$did));
			
			$page = $page-1;
			$start = $page*$limit;
			$this->db->limit($limit,$start);
			
			$query = $this->db->get();
			return $query->result_array();
		}
		
		/* User activation*/
		public function activateuser($table,$pdata,$data)
		{
			$query = $this->db->update($table,$pdata,$data);
			return $query;
		}
		
		public function login_md($table,$lgdata)
		{
				$query = $this->db->get_where($table,$lgdata);
				return $query->row_array();
		}
		
		/*Check user already exist*/
		public function alreadyExist($table,$data)
		{
			$query = $this->db->get_where($table,$data);
			return $query->row_array();
		}
		
		/*Set extra pin into table*/
		public function setExtraPin($table,$pdata,$id)
		{
			$query = $this->db->update($table,$pdata,$id);
			return $query;
		}
		
		/*Insert data into table*/
		public function postDataTbl($table,$data)
		{
			$query = $this->db->insert($table, $data); 
			return $query;
		}
		
		/*Retrive data from table*/
		public function getDataTbl($table,$data)
		{
			$query = $this->db->get_where($table, $data); 
			return $query->row_array();
		}
		/*Retrive data from table*/
		
		/*Retrive data from table for expire pin*/
		public function getDataPinexp($table,$data)
		{   
		    $sql = "select * from ".$table." where usertype=".$data['usertype']." AND pin_exp_status ='1' AND `extrapin`= ".$data['extrapin']." AND exp_timestamp > (NOW() - INTERVAL 10 MINUTE)";
		    $query = $this->db->query($sql);
			return $query->row_array();
		   
			/*$query = $this->db->get_where($table, $data); 
			return $query->row_array();*/
			//$t=(NOW()- INTERVAL 10 MINUTE);
			/*$this->db->select('*');
			$this->db->from($table);
			$this->db->where('extrapin',$data);
			//$this->db->where('exp_timestamp <',(NOW()- 'INTERVAL 10 MINUTE')); 
			$query = $this->db->get();
			return $query->row_array();*/
		}
		/*Retrive data from table for expire pin*/
		
		public function getallDataTbl($table,$data,$select='',$order='',$limit='')
		{
		    if($select!=''){ $this->db->select($select); }else{ $this->db->select('*'); }
			$this->db->from($table);
			$this->db->where($data);
			
			if($order!=''){$this->db->order_by($order);}
			
			if($limit!=''){$this->db->limit($limit);}
			
			$query = $this->db->get(); 
			
			return $query->result_array();
		}
		
		public function getaddDoctor($table,$data)
		{
		    $this->db->select('*'); 
			$this->db->from($table);
			$this->db->where($data);
			$query = $this->db->get(); 
			
			return $query->row();
		}
		public function doctor_avgrate($did)
		{
			   $this->db->select_avg('rate');
		       $this->db->where('doctorid',$did); 
               $query = $this->db->get('yg_comment'); 
		       return $query->row_array();
		}
		
    
        public function get_getGenProblem_data($id,$type)
		{
			$this->db->select('*');
			$this->db->from('yg_generalproblem');
			$this->db->where(array('id'=>$id,'type'=>$type)); 
			$query = $this->db->get();
			return $query->row();
		}
    
       
		
		public function delete_display_data($id,$tbl_name)
		{
		  $this->db->where('id', $id);
          $this->db->delete($tbl_name); 
		}
		
		public function DeleteRecord($table,$data)
		{
			$query = $this->db->delete($table, $data); 
			return $query;
		}
		
		public function recExist($did,$uid){
		    $this->db->select('id,comment,rate');
			$this->db->from('yg_comment');
			$this->db->where(array('userid'=>$uid ,'doctorid'=>$did)); 
			$query = $this->db->get();
			return $query->row();
		}
		
	 public function adddoc_exist($dc_doctorid,$userid){
	        $this->db->select('relid');
			$this->db->from('yg_relation');
			$this->db->where(array('userid'=>$userid ,'doctorid'=>$dc_doctorid)); 
			$query = $this->db->get();
			return $query->row();
	   }
    
    
         public function get_ajax_mapdata(){
	        $this->db->select('*');
			$this->db->from('yg_dcprofile');
			$query = $this->db->get();
			return $query->result();
	   }
    
    public function getDatagallerydcp($id){
          
          $this->db->select('ydp.*,u.firstname,u.lastname');
          $this->db->from('yg_dcprofile as ydp');
          $this->db->join('yg_user as u','ydp.userid=u.userid');
          $this->db->where('ydp.userid',$id);
          $query = $this->db->get();
          return $query->result_array();
        
      }
     public function getDatagalleryyaw($id){
          
          $this->db->select('*');
          $this->db->from('yg_awards as yaw');
          $this->db->where('yaw.doctorid',$id);
          $query = $this->db->get();
          return $query->result_array();
     }
    
       public function getDatagalleryyad($id){
          
          $this->db->select('*');
          $this->db->from('yg_advices as yad');
          $this->db->where('yad.doctorid',$id);
          $query = $this->db->get();
          return $query->result_array();
     }
    
     /************code for clinic section*******************/
        
        
            
        public function getClinicIDByCat($table,$data)
		{
            
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where($data); 
			$query = $this->db->get();
			return $query->result_array();
		}
    
       public function getClinicInfoByCatID($table,$data)
		{
            
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where($data); 
			$query = $this->db->get();
			return $query->result_array();
		}
     /************code for clinic section*******************/
      public function get_display_data($id,$tbl_name)
		{
			$this->db->select('*');
			$this->db->from($tbl_name);
			$this->db->where('id', $id); 
			$query = $this->db->get();
			return $query->row();
		}
    public function contact($table,$data)
    {
     $query = $this->db->insert($table, $data); 
     return $query;
    }
}

?>