<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
require dirname(__FILE__).'/Base.php';

class MX_Controller 
{
	public $autoload = array();
	
	public function __construct() 
	{	
		date_default_timezone_set('Asia/karachi');
		// $ci = "";
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));

		log_message('debug', $class . " MX_Controller Initialized");
		
		Modules::$registry[strtolower($class)] = $this;	

		$this->auth = array(
	      "id_field" 		=> "id",
	      "service_name" 	=> "auth",
	      "cookie_name" 	=> "token"
	    );
		
		$ci =& get_instance();

		$ci->load->model('common/Common_mdl', 'common');

		$ci->load->helper('common');
		
		$this->tokenData = getTokenData('token');

		$this->getMenu = $ci->common->showMenu( $this->tokenData['role_id'] );

	    $this->links = array(
	    	"sidebar" => array(
	    		"home"		=>	base_url() . 'welcome',
	    		"users"		=>	array(
	    			"user_management"				=>	base_url() . 'user',
	    			"user_role_management"			=>	base_url() . 'user/role'
	    		),
	    		"products"	=>	array(
	    			"manage_products"	=>	base_url() . 'product'
	    		),
	    	)
	    );
	    $this->msg = array (
			"success_msg" 	=> 	array(
				'create'	=>	"Record inserted successfully",
				'delete'	=>	"Record deleted successfully",
				'update'	=>	"Record updated successfully"
			),
			"error_msg" 	=>	array(
				'create'	=>	"Error! Record insertion failed",
				'delete'	=>	"Error! Record deletion failed",
				'update'	=>	"Error! Record updation failed"
			),
			"general_msg"	=>	array(
				'input_error'		=>	"Please enter all the fields",
				'attribute_error'	=>	"Please make sure you have attribute",
				'post_data_error'	=>	"Only HTTP POST method is acceptable",
				'no_record_error'	=>	"No record found"
			),
			"auth_msg"		=>	array(
				'auth_error'		=>	"Error! You are not authorized"
			)
		);
		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);	
		
		/* autoload module items */
		$this->load->_autoloader($this->autoload);

		$this->authenticate();
	}
	
	public function __get($class) 
	{
		return CI::$APP->$class;
	}

	public function authenticate() 
    {
   	   	if(check_jwt_cookie( $this->auth["service_name"], $this->auth["cookie_name"]) )
	    {
			$secret = "UhT0MaDpVrUgGnPkP7dTEkBfEU2DUbob";
			// incase if you want to regenerate token on every page.......
			$cookie_contents = json_decode($_COOKIE[$this->auth['cookie_name']], true);

  			$token = (array) jwt_decode($cookie_contents["token"], $secret);

			regenerate_jwt_cookie($this->auth["service_name"], $this->auth["cookie_name"] ); 
		} 
		else  	
		{
			redirect (base_url('login'));
		}
   	}

   	public function debug ( $arg ) 
   	{
   		echo "<pre>";
   		print_r($arg);
   		echo "<pre>";
   		exit();
   	}

}