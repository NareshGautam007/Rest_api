<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * 
 */
class User_model extends CI_model
{
	
	 public function __construct()
	{
		parent::__construct();

		$this->load->database();

	}


	//Fecth data by id

	public function getRows($id){
		if(!empty($id)){

			$this->db->select('*');
			$this->db->where('id',$id);
			$q = $this->db->get('users');
			$query = $q->row_array();
			
			return $query;
			//return $query->result();
		}
		else{
				$query = $this->db->get('users');
				return $query->result_array();
			}

	}


	public function getUsers($email,$password){
		

			$this->db->select('*');
			$this->db->where('email',$email);
			$this->db->where('password',$password);
			$q = $this->db->get('users');
			$query = $q->row_array();
			return $query;
			

	}


	public function check_email_exists($email , $userid = 0){

			$this->db->select('email');
			$this->db->from('users');
			$this->db->where('email',$email);
			if($userid != 0){
				$this->db->where('id !=', $userid);
			}

			$query=$this->db->get();
			return $query->result();

			


	}


	public function insert($userdata)
	{

		
		$insert = $this->db->insert("users",$userdata );
		if($insert){

			return $this->db->insert_id();
		}else{

			return false;
		}



	}

	



	public function user_insert($data  =array())
	{

		if(!array_key_exists('created', $data )){

			$data ['created'] =date("Y-m-d H:i:s");
		}

		if(!array_key_exists('modified', $data )){
			$data ['modified'] = date("Y-m-d H:i:s");
		}

		$insert = $this->db->insert("users",$data );
		if($insert){

			return $this->db->insert_id();
		}else{

			return false;
		}



	}


	public function delete($id){
		$delete = $this->db->delete('users',array('id'=>$id));

		return $delete?true:false;


	}


}






?>