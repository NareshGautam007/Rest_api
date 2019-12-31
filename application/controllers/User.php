<?php

defined('BASEPATH') OR exit('No direct script access allowed');


require_once("application/libraries/REST_Controller.php");
require_once("application/libraries/Format.php");


/**
 * 
 */
class User extends REST_Controller
{
	
	public function __construct()
	{
			
		parent::__construct();	

		$this->load->model('user_model');



	}
		
		public function user_get($id = 0){
		//return all rows if parametert doesn't exits

		$users= $this->user_model->getRows($id);

		/*var_dump($users);
		die();*/

		if(! empty($users)){
			//set response and exit
			$this->response($users, REST_Controller:: HTTP_OK);
		}
		else{

			$this->response([
				'status'=> FALSE,
				'message' => 'No user were found'
			], REST_Controller:: HTTP_NOT_FOUND);

		}

	}


	public function login_get(){
		//return all rows if parametert doesn't exits
			if(empty($_POST)) {
			    # Get JSON as a string
			    $json_str = file_get_contents('php://input');
			    # Get as an array
			    $_POST = json_decode($json_str, true);
				}


	
		$email = $this->input->post('email');
		$password= md5($this->input->post('password'));

		
		$users_login= $this->user_model->getUsers($email,$password);

		

		if(!empty($users_login)) {
			//set response and exit

			

			$this->response([
			    
			    'status'=>TRUE,
			    'id'=>$users_login['id'],
			    'username'=>$users_login['username'],
			    'passcode'=>$users_login['passcode'],
			    'email'=>$users_login['email'],
			    'mobile'=>$users_login['mobile']
			    
			    
			    ],REST_Controller:: HTTP_OK);
			
			
			
		}

		else{



			//$this->response($user_data, REST_Controller:: HTTP_BAD_REQUEST);

			$this->response([
				'status'=> FALSE,
				'message' => 'Invalid Login'
			], REST_Controller:: HTTP_NOT_FOUND);

		}

	}


/*
	public function already_email_exists($email)
	{

		if(empty($_POST)) {
			    # Get JSON as a string
			    $json_str = file_get_contents('php://input');
			    # Get as an array
			    $_POST = json_decode($json_str, true);
				}


		if($this->user_model->check_email_exists($email))
		{
			return TRUE;
		}
		else{

			return false;
		}
		
	}
*/

	// To register your data into table
	public function users_post()
	{

			if(empty($_POST)) {
				    # Get JSON as a string
				    $json_str = file_get_contents('php://input');
				    # Get as an array
				    $_POST = json_decode($json_str, true);
					}
					

				if($this->already_email())
				{

					$user_responde_error= array(
					'status'=>false,
					'message'=>'Email alreday exits',
					//'username'=> $userdata['username']


				);

            print(json_encode($user_responde_error));
            die();
				}
			


		$userdata=array();

		$set = '1234';
		$code = substr(str_shuffle($set), 0, 12);

		/*var_dump($code);
		die();*/
		//$password= $_POST['password'];

		$userdata['passcode']= $code;
		$userdata['username'] = $this->input->post('username');

		$userdata['email']    = $this->input->post('email');
		$userdata['mobile']	  = $this->input->post('mobile');
		$userdata['address']  = $this->input->post('address');
		$userdata['password'] = md5($this->input->post('password'));
		$userdata['status']	  = TRUE;

		if(!empty($userdata['username']) && !empty($userdata['email']) && !empty($userdata['mobile'])
			&& !empty($userdata['address']) && !empty($userdata['password']) )
		{
			//insert data into table

			$insert= $this->user_model->insert($userdata);

			/*var_dump($userdata);
			die();*/

			if($insert)
			{

			$this->response(
					[
						'status'=>TRUE,
						'message' =>'Registration success..!!',	
						'username'=> $userdata['username'],
					], REST_Controller:: HTTP_OK);

				/*$this->response(
					[
						'status'=>TRUE,
						'message' =>'Registration success..!!'	
						'username'=> $userdata['username'],
					], REST_Controller:: HTTP_OK);
*/
			}
			else{



			$this->response(
					[
						'status'=>FALSE,
						'message'=>'there some problem please try again.'

					], REST_Controller:: HTTP_BAD_REQUEST);

       // print(json_encode($user_responde_error));

			/*	$this->response(
					[
						'status'=>FALSE,
						'message'=>'there some problem please try again.'

					], REST_Controller:: HTTP_BAD_REQUEST);*/

			}

		//	print(json_encode($user_responde));


		}


	}


	public function already_email(){

		$email=$_POST['email'];
		 $check = $this->user_model->mail_exists($email);

			if($check)
			{
				return TRUE;
			}
			else{

				return false;
			}
		}



		
	public function user_delete($id)
	{
		if($id){


			$delete= $this->user_model->delete($id);

			if($delete)
			{
				$this->response(
					[
						'status'=>TRUE,
						'message' =>'User Deleted succesfully'


					], REST_Controller:: HTTP_OK);

			}
			else{

				$this->response([

					'status'=>false,
					'message'=>'Somethig went wrong'

				], REST_Controller:: HTTP_BAD_REQUEST);

			}

		}
	}




	/*	public function user_put($id)
		{
			$userdata=array();
			$id= $this->put($id);

			$userdata['username'] = $this->put('username');
			$userdata['email'] = $this->put('email');
			$userdata['mobile'] = $this->put('mobile');
			$userdata['address'] = $this->put('address');
			$userdata['password'] = $this->put('password');

			if(!empty($userdata['username']) && !empty($userdata['email']) && !empty($userdata['mobile'])
		&& !empty($userdata['address']) && !empty($userdata['password']))
			{

					$update = $this->user_model->update($userdata,$id);
					if($update)
					{
						$this->response(
							[
								'status'=> TRUE,
								'message'=> 'User data has been updated'

							],REST_Controller::HTTP_OK

						);

					}

					else{

						$this->response(
							[
								'status'=>false,
								'message'=>'Something went wrong'

							],REST_Controller::HTTP_BAD_REQUEST
						);
					}


			}
}*/




	




		public function index_post()
		{
		    echo "POST_request...!!";
		}

		public function index_get()
		{   
		    echo "GET_request";
		}   



		public function index_put()
		{
		    echo "PUT_request";
		}

		public function index_patch()
		{
		    echo "PATCH_request";
		}

		public function index_delete()
		{
		    echo "DELETE_request";
		}


}



?>
