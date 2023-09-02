<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: login
	Date 		: 02/10/2018
*/

class CommonController extends MX_Controller 
{
	public function __construct() 
	{
		parent::__construct();
	}

	public function GetAllCountry()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$tableSetting = array(
				'select'	=>	'`COUNTRY_ID`, `COUNTRY`',
				'table'		=>	'country'
			);

			echo json_encode( array( "code" => SUCCESS, 'data' => $this->common->getRecord( $tableSetting ) ) );
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function GetAllStates()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$tableSetting = array(
				'select'	=>	'`STATE_ID`, `CITY_ID`, `STATE`',
				'table'		=>	'state',
			);

			echo json_encode( array( "code" => SUCCESS, 'data' => $this->common->getRecord( $tableSetting ) ) );
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function AttributeValidation () 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			header('Content-Type: application/json');

		    $data = json_decode(file_get_contents('php://input'), TRUE);

		    if($this->input->method(true) != 'POST')
		    {
		    	echo json_encode( array ( "code" => 403, 'message' => $this->msg['general_msg']['post_data_error'] ) );
		    }
		    else
		    {
		    	if ( !empty ( $data['attribute_name'] ) && !empty ( $data['attribute_value'] ) ) 
		    	{
		    		$checkData = array(
		    			'select'			=> 	$data['select'],
						'table'				=> 	$data['table'],
						'condition' 	=> 	array(
				    		$data['attribute_name']	=>	$data['attribute_value']
				    	)
		    		);

		    		$userTableData = $this->common->getRecord( $checkData );

		    		// $this->debug( $userTableData );

		    		if ( $userTableData ) 
		    		{
		    			echo json_encode( array ( "code" => BAD_DATA, 'message' => 'Username already exist' ) );
		    		}
		    		else
		    		{
		    			echo json_encode( array ( "code" => SUCCESS, 'message' => 'User available' ) );
		    		}
		    		
		    	}
		    	else
		    	{
		    		echo json_encode( array ( "code" => 403, 'message' => $this->msg['general_msg']['attribute_error'] ) );
		    	}	
		    }
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}
}