<?php class Userdata extends CI_Model
  {
  function __construct()
    {
    // Call the Model constructor
    parent::__construct();
   
    }

 function filter($arr=array())
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



function get($table,$select='',$data='',$orderby='',$limit='')
 {
      if($select != '') 
         { $this->db->select($select); } else { $this->db->select('*'); }  
      
      if($data != '') 
         $this->db->where($data);

      if($orderby != '') {
          if(! is_array($orderby))
            $this->db->order_by($orderby, 'ASC');
          else 
            $this->db->order_by($orderby[0], $orderby[1]);     
         }
      if($limit =! '') 
         $this->db->limit($limit);

      $query = $this->db->get($table);

    
      
      return $query->result_array();
  }
 function getWhere($table,$arr) {
      $query = $this->db->get_where($table,$arr);
      return $query->result_array(); 

 }
 
 function getLike($table,$arr,$like)
  {
       
        $this->db->select('*');
        $this->db->where($arr);
        $this->db->from($table);
        $this->db->like('title',$like);
         
        $query = $this->db->get(); 
    
        return $query->result_array();
    }

 public function getWhereIn($table,$col,$in,$data, $select='',$order='',$limit='')
  {
        if($select!=''){ $this->db->select($select); }else{ $this->db->select('*'); }
              
      $this->db->from($table);
      $this->db->where_in($col,$in);
            $this->db->where($data); 
      
            if($order!=''){$this->db->order_by($order);}
      
      if($limit!=''){$this->db->limit($limit);}
            
            $query = $this->db->get(); 
      
      return $query->result_array();
    }
function Query($query,$rt='')
  {
      $query = $this->db->query($query);
        if($rt!='')
        { return $query->row_array();}
        else
        {
           return $query; 
        }
  }


 function set($table,$arr)
    { 
       $this->db->insert($table,$arr);
       return $this->db->insert_id();  
    }
  function update($table,$pdata,$id)
	{
      $this->db->where($id);
      $query = $this->db->update($table,$pdata);
      return $query; 
	}
  function delete($table,$data)
    {
        $this->db->where($data);
        $qry = $this->db->delete($table);
        return $qry;
    }
 

   
 
 function count($table,$data='')
    {
      if($data !='') {$this->db->where($data);}
        $query = $this->db->get($table);
        return $query->num_rows();       
    }

    /*Case seestive record from table*/

function joinCount($table,$joinarr,$data,$select,$offset='',$in)
    {
     $limit = $this->cntRecord('tbl_delivery');
 
    if($select!=''){ $this->db->select($select); }else{ $this->db->select('*'); }
       foreach($joinarr as $joindata)
        {
          if(array_key_exists("jointype",$joindata))
           { 
          $this->db->join($joindata['table'], $joindata['on'],$joindata['jointype']);                }
           else
           {
             $this->db->join($joindata['table'], $joindata['on']);  
           }
        }
          if($data!='')
           {
             $this->db->where($data);
           }
         
    
          $this->db->limit($limit,$offset);
      if($in !='')
             {$this->db->where_in('id',$in);}
  
      $query = $this->db->count_all_results($table); 
  
       return $query;

    }    
 
 function Jointables($table1,$joinarr,$data='',$select='',$order='', $by='',$in='',$find_in_set='')
	{
    
		if($select!=''){ $this->db->select($select); }else{ $this->db->select('*'); }
          $this->db->from($table1);
           foreach($joinarr as $joindata)
          {
               
              if(array_key_exists("jointype",$joindata))
               { 
                  $this->db->join($joindata['table'], $joindata['on'],$joindata['jointype']); }
               else
               {
                 $this->db->join($joindata['table'], $joindata['on']);  }
               }
         if($data!='')
      
            {$this->db->where($data);}
          
          if($order!='')
            {$this->db->order_by($order,$by);}    
          if($in !='')
             {$this->db->where_in('id',$in);}
           if($find_in_set!='')
           { 
            $this->db->where('FIND_IN_SET("'.$find_in_set.'",repeatday)!=',0);
           }
            $query = $this->db->get(); 
        	return $query->result_array();
		}
 
function avgRatingByUser($rating)
    {
           $this->db->select('DISTINCT(uid)');
           $this->db->group_by('uid');
           $this->db->having('ROUND(AVG(rating)) >=',$rating);
      
           $qry = $this->db->get('tbl_rating');
       
           $result = $qry->result_array();
           return $result;
    }
 
    
  function Jointable($table1,$table2,$data,$on,$select='',$id='',$limit='',$order='',$groupby='')
    {
        if($select!=''){ $this->db->select($select); }else{ $this->db->select('*'); }
                  $this->db->from($table1);
                  if($id !='')
                   {$this->db->where('id >',$id);}
                  if($data!='')
                    {$this->db->where($data);}
                 
                  if($limit!='')
                    {$this->db->limit($limit);}
                  if($groupby='')
                    {$this->db->group_by($groupby);}
         
      
                   $this->db->join($table2, $on);

                     if($order!='')
             {$this->db->order_by('id',$order);}
             $query = $this->db->get(); 
        
                
        return $query->result_array();
        }
 
   
   
}
