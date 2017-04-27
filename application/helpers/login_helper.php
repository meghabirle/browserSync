<?php 
if(!function_exists('is_logged_in'))    
{ 
    function is_logged_in()
    {
	$CI =& get_instance();
    $is_logged_in = $CI->session->userdata('is_logged_in');
       	//var_dump($is_logged_in);exit;
	   if(!isset($is_logged_in) || $is_logged_in != true)
	   {

	   		redirect(base_url().'login');
	   }
	}
}
if(!function_exists('my_usertype'))    
{
    function my_usertype($id)
    {
		$CI =& get_instance();
		$usertype = $CI->session->userdata('usertype');
		if($id === 1 )
		{
			if($usertype == $id){}else{redirect(base_url().'user');}
		}
		else
		{
			if($usertype == $id){}else{redirect(base_url().'maid');}
		}
	}
}
if(!function_exists('has_logged_in'))    
{
    function has_logged_in()
    {
	$CI =& get_instance();
    $is_logged_in = $CI->session->userdata('is_logged_in');
       	//var_dump($is_logged_in);exit;
	   if(isset($is_logged_in) || $is_logged_in == true)
	   {
	   		$usertype = $CI->session->userdata('usertype');
			if($usertype==1)
			{
				redirect(base_url().'user');
			}
			else
			{
				redirect(base_url().'maid');
		     }
	   }
	}
}
