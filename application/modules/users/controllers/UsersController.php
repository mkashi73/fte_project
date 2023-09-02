<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: login
	Date 		: 02/10/2018
*/

class UsersController extends MX_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->library('Pagination');
		$this->load->model('User_mdl', 'user');
	}

	public function index()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$parent_menu = $this->getMenu;

			$data['headerData'] = array
			(
				"companyName"	=>	'FTE',
				"pageName"		=>	'User Management'
			);

			$data['links'] = array(
				"show_menu"		=> 	$parent_menu
			);

			$userRolesJoinedTable = array(
				'select'			=> 	'users.`USER_ID`, users.`FULL_NAME`, users.`EMAIL_ADDRESS`, users.`STATION_NAME`, users.`U_ROLE_ID`, user_roles.`USER_ROLE_ID`, users.`IS_ACTIVE`, user_roles.`ROLE`, users.`E_DATE_TIME`',
				'table'				=> 	'users',
				'order_attribute'	=>	'E_DATE_TIME',
				'order_by'			=>	'ASC',
				'join'				=>	array(
					'joined_table'		=>	'user_roles',
					'joined_condition'	=>	'users.U_ROLE_ID = user_roles.USER_ROLE_ID'
				)
			);

			$userRolesTable = array (
				'select'			=> 	'`USER_ROLE_ID`, `ROLE`',
				'table'				=> 	'user_roles',
				'order_attribute'	=>	'E_DATE_TIME',
				'order_by'			=>	'ASC'
			);
			// $data['userData'] = $this->user->getUserRoleData();
			$data['usersRole'] = $this->common->getRecord($userRolesTable);

			$data['userData'] = $this->common->getRecord($userRolesJoinedTable);

			// $this->debug( $data['usersRole'] );

			$data['token'] = getTokenData('token');
			// $this->debug($data);
			$footerData['filepath'] = 'users/users.js';

			$this->load->view('common/header', $data);
			$this->load->view('common/sidebar', $data);
			$this->load->view('common/breadcrum');
			$this->load->view('users/user_vw', $data);
			$this->load->view('common/footer', $footerData);
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
			redirect(base_url());
		} // end of Role validation
	}

	public function AddUser()
	{

		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			extract($_POST);

			// print_r($_POST);

			$token = getTokenData('token');

			// print_r( $token );
			$password = getEncryptedString('sha256', $_POST['password']);
			if (
				isset ( $_POST['full_name'] ) 
				&& !empty( $_POST['full_name'] )
				&& isset ( $_POST['password'])
				&& !empty( $_POST['password'] )
				&& isset ( $_POST['email'])
				&& !empty( $_POST['email'] )
				&& isset( $_POST['role'] ) 
				&& !empty( $_POST['role'] )
				&& isset( $_POST['status'] )
				&& !empty( $_POST['status'] )
				) 
			{
				$data = array(
					'FULL_NAME'		=>	$_POST['full_name'],
					'EMAIL_ADDRESS'	=>	$_POST['email'],
					'ENCRYPTED_PWD'	=>	$password,
					'U_ROLE_ID'		=>	$_POST['role'],
					'IS_ACTIVE'		=>	$_POST['status'],
					'E_USER_ID'		=>	$token['id'],
					'E_DATE_TIME'	=>	getDateOffset(),
					'U_USER_ID'		=>	NULL,
					'U_DATE_TIME'	=>	NULL
				);

				$id = $this->common->createRecord( $data, 'users');

				if ( !empty ($id) )
				{
					echo json_encode( array ( "code" => 200, 'message' => 'Record inserted successfully' ) );
				}
				else
				{
					echo json_encode( array ( "code" => 403, 'message' => 'There is some error while entering data' ) );
				}
			}
			else
			{
				echo json_encode( array ( "code" => 403, 'message' => 'Please make sure you have entered all the fields' ) );
			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function UpdateUser()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			header('Content-Type: application/json');

		    $data = json_decode(file_get_contents('php://input'), TRUE);
		    
		    if ( $data['password'] == $data['retypePassword'] ) 
		    {
		    	$password = getEncryptedString('sha256', $data['password']);

		        // $this->debug( $data );
		        if (
					isset ( $data['fullname'] ) 
					&& !empty( $data['fullname'] )
					&& isset ( $data['email'] )
					&& !empty( $data['email'] )
					&& isset ( $data['password'] )
					&& !empty( $data['password'] )
					&& isset( $data['role'] ) 
					&& !empty( $data['role'] )
					&& isset( $data['status'] )
					&& !empty( $data['status'] )
					) 
				{
					$updateData = array(
						'table' 		=>	'users',
						'condition'		=>	array(
							'USER_ID'		=>	$data['userId']	
						),
						'record'		=>	array(
							'FULL_NAME'		=>	$data['fullname'],
							'EMAIL_ADDRESS'	=>	$data['email'],
							'ENCRYPTED_PWD'	=>	$password,
							'U_ROLE_ID'		=>	$data['role'],
							'IS_ACTIVE'		=>	$data['status'],
							'U_USER_ID'		=>	$this->tokenData['id'],
							'U_DATE_TIME'	=>	getDateOffset(),
						)
					);

					$result = $this->common->updateRecord($updateData);
					// exit();

				    // $result = $this->Payment->updateMembershipPrice($data['id'], $data['price']);
				    if ( $result )
				    {
				        echo json_encode( array ( "code" => SUCCESS, "message" => "Record update successfully" ) );
				    }
				    else
				    {
				        echo json_encode( array ( "code" => BAD_DATA, "message" => $result ) );
				    }
				}
				else
				{
					echo json_encode( array ( "code" => BAD_DATA, 'message' => 'Please make sure you have entered all the fields' ) );
				}
			}
			else
			{
				echo json_encode( array ( "code" => BAD_DATA, 'message' => 'Please make sure passwords match' ) );
			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function GetUserById( $user_id ) 
	{
		// $userData = $this->common->getRecord('users');
	    
	    $data = array(
	    	'select'		=>	'`USER_ID`, `FULL_NAME`, `EMAIL_ADDRESS`,`U_ROLE_ID`, `IS_ACTIVE`',
	    	'table' 		=> 	'users',
	    	'condition' 	=> 	array(
	    		'USER_ID'	=>	$user_id
	    	)
	    );

	    $userTableData = $this->common->getRecordById( $data );
	    // $getMembershipDataById = $this->common->getMembershipDataById($id);   
	    
	    echo json_encode(array("data" => $userTableData));
	}

	public function GetUserData () 
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
				$userRolesTable = array(
					'select'			=> 	'users.`USER_ID`, users.`FULL_NAME`, users.`EMAIL_ADDRESS`, users.`U_ROLE_ID`, users.`IS_ACTIVE`, users.`E_DATE_TIME`, user_roles.`ROLE`',
					'table'				=> 	'users',
					'condition'			=>	array(
						'USER_ID'	=>	$data['userId']
					),
					'order_attribute'	=>	'E_DATE_TIME',
					'order_by'			=>	'ASC',
					'join'	=>	array (
						'joined_table'	=>	'user_roles',
						'joined_condition'		=>	'users.U_ROLE_ID = user_roles.USER_ROLE_ID'
					)
				);

				echo json_encode( array( 'code' => SUCCESS, 'userData' => $this->common->getRecord( $userRolesTable)[0] ) );
				// $this->debug( $this->common->getRecord( $productTable ) );

			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function getUserPagination( $page ) 
	{
		$userTable = array(
			'select'	=>	'`USER_ID`, `FULL_NAME`, `EMAIL_ADDRESS`, `IS_ACTIVE`, `E_DATE_TIME`',
			'table'		=>	'users'
		);

		$user = $this->common->getRecord( $userTable );

		$total_menu = count($user);

		$config = array(
			"base_url"			=>	"#",
			"attributes"		=> 	array('class' => 'page-link'),
			"total_rows"		=>	$total_menu,
			"per_page"			=>	5,
			"uri_segment"		=>	4,
			"use_page_numbers"	=>	TRUE,
			"full_tag_open"		=>	"<div class='pagination-wrapper'><nav aria-label='Page navigation'><ul class='pagination pagination-circle pagination-primary'>",
			"full_tag_close"	=>	"</ul><nav></div>",
			"first_tag_open"	=>	"<li class='page-item'>",
			"first_tag_close"	=>	"</li>",
			"last_tag_open"		=>	"<li class='page-item'>",
			"last_tag_close"	=>	"</li>",
			"next_link"			=>	"&gt;",
			"next_tag_open"		=>  "<li class='page-item'>",
			"next_tag_close"	=>  "</li>",
			"prev_link"			=>	"&lt;",
			"prev_tag_open"		=>	"<li class='page-item'>",
			"prev_tag_close"	=>	"</li>",
			"cur_tag_open"		=>	"<li class='active page-item'><a class='page-link' href='#'>",
			"cur_tag_close"		=>	"</a></li>",
			"num_tag_open"		=> 	"<li class='page-item'>",
			"num_tag_close"		=>	"</li>",
			"num_links"			=>	1
		);
		
		$this->pagination->initialize($config);

		$start = ($page - 1) * $config['per_page'];
		
		$paginationData = array(
			'db'		=>	array(
				'limit'	=>	$config['per_page'],
				'start'	=>	$start,
				'table'	=>	'users',
				'order_attribute' 	=> 'users.FULL_NAME',
				'order_by' 			=> 'ASC',
				'join'	=>	array (
					'joined_table'	=>	'user_roles',
					'joined_condition'		=>	'users.U_ROLE_ID = user_roles.USER_ROLE_ID'
				)
			)
		);

		$output = array(
			"UserPaginationLink"	=>	$this->pagination->create_links(),
			"UserList"		=>	$this->user->userPagination( $paginationData )
		);

		echo json_encode($output);

	}

	public function DeleteUser()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
		    $data = json_decode(file_get_contents('php://input'), TRUE);

		    if($this->input->method(true) != 'POST')
		    {
		    	echo json_encode( array ( "code" => 403, 'message' => $this->msg['general_msg']['post_data_error'] ) );
		    }
		    else
			{
				if ( isset ( $data['userId'] ) ) 
				{
					$productData = array (
						'condition'		=>	array(
							'USER_ID'	=>	$data['userId']
						),
						'table'			=>	'users'
					);

					$result = $this->common->deleteRecord( $productData );
				
					if ( $result ) 
					{
						echo json_encode(array("code" => SUCCESS, 'message' => $this->msg['success_msg']['delete']));
					}
					else
					{
						echo json_encode(array("code" => SUCCESS, 'message' => $this->msg['error_msg']['delete']));
					}
				}
				else
				{
					echo json_encode(array("code" => SUCCESS, 'message' => 'You have not selected product' ));
				}
			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}
}