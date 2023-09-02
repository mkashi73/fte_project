<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: login
	Date 		: 02/10/2018
*/

class LoginController extends CI_Controller 
{
	public function __construct() 
	{
		parent::__construct();

	    $this->auth = array(
	      "table" 			=> "users",
	      "username_field" 	=> "EMAIL_ADDRESS",
	      "password_field" 	=> "ENCRYPTED_PWD",
	      "id_field" 		=> "USER_ID",
	      "service_name" 	=> "auth",
	      "cookie_name" 	=> "token",
	      "t_id"			=> "1"
	    );
	    
	}
	public function index()
	{	
		$data_vw = array
		(
			"companyName"	=>	'FTE'
		);

		if(check_jwt_cookie($this->auth["service_name"], $this->auth["cookie_name"]))
		{
			// incase if you want to regenerate token on every page.......
			regenerate_jwt_cookie($this->auth["service_name"], $this->auth["cookie_name"]);

			redirect('welcome');
		}
		
		$this->load->view('_partial_views/_header_vw', $data_vw);
		$this->load->view('login_vw', $data_vw);
		$this->load->view('_partial_views/_footer_vw', $data_vw);
	}

	public function checkCredentials()
	{
	    header('Content-Type: application/json');

	    $params = json_decode(file_get_contents('php://input'), TRUE);

	    if($this->input->method(true) != 'POST')
	    {
				echo json_encode(array("message:"=>"Use the HTTP POST method to login to the system."));
				return;
	    }
		else
		if(check_jwt_cookie($this->auth["service_name"], $this->auth["cookie_name"]))
		{
			echo json_encode(regenerate_jwt_cookie($this->auth["service_name"], $this->auth["cookie_name"]));
			return;
		}
	  	else
	  	{
	  		/* JSON RESQUEST
	  		{
	            "username"  :  {USERNAME},
	            "password"  :  {PASSWORD},
	            "remember"  :  {REMEMBER_ME},
	            "t_id"      :  101
			}
	  		*/
	  		$data = json_decode(file_get_contents('php://input'), TRUE);
	  		
	  		if ( !empty( $data['email'] ) && !empty( $data['password'] ) && !empty( $data['tid'] ) )
	  		{
	  			$email = str_replace(" ", "", $data['email']);
	  			$password = getEncryptedString('sha256', $data['password']);
	  			$tid	  = $data['tid'];

			    echo json_encode(
			    					authorize( 
			    						$tid, 
			    						$email, 
			    						$password, 
			    						$this->auth["service_name"], 
			    						$this->auth["cookie_name"]
			    					) 
			    				);
			    return ;
	  		}
	  		else
	  		{
	  			echo json_encode( array( "code" => BAD_CREDENTIALS, "status" => "Please enter username or password" ) );
	  		}
  		}
  	}

	public function logout()
  	{
  		if (check_jwt_cookie($this->auth["service_name"], $this->auth["cookie_name"]))
  		{
  			delete_cookie('token');
  			redirect('login');
  		}
  	}

	public function noPageFound()
  	{
  		 // $this->load->view('404');
  	}
}
