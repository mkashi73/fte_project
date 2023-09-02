<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: login
	Date 		: 02/10/2018
*/

class UsersRolesController extends MX_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->library('Pagination');
		$this->load->model('User_mdl', 'user');
	}

	public function index()
	{
		$parent_menu = $this->getMenu;
		// echo $parent_menu;
		// exit();
		$data['headerData'] = array
		(
			"companyName"	=>	'FTE',
			"pageName"		=>	'User Roles Management'
		);

		$data['links'] = array(
			"show_menu"		=> 	$parent_menu
		);
		$data['token'] = getTokenData('token');

		// $this->common->debug($data);
		
		// $data['roleRecords'] = $this->common->getRecord('user_roles');

		$userRolesTable = array (
			'select'			=> 	'`USER_ROLE_ID`, `ROLE`, ACTIVE_FLAG',
			'table'				=> 	'user_roles',
			'order_attribute'	=>	'E_DATE_TIME',
			'order_by'			=>	'ASC'
		);
		// $data['userData'] = $this->user->getUserRoleData();
		$data['roleRecords'] = $this->common->getRecord($userRolesTable);

		$footerData['filepath'] = 'user_roles/user_roles.js';


 		$this->load->view('common/header', $data);
 		$this->load->view('common/sidebar', $data);
 		$this->load->view('common/breadcrum');
		$this->load->view('users/users_roles_vw', $data);
 		$this->load->view('common/footer', $footerData);
	}

	public function AddUserRoles()
	{
		extract($_POST);

		// print_r($_POST);

		$token = getTokenData('token');

		// print_r( $token );

		if (
			isset ( $_POST['role'] ) 
			&& !empty( $_POST['role'] )
			&& isset ( $_POST['active_flag'])
			&& !empty( $_POST['active_flag'] )
			) 
		{
			$data = array(
				'ROLE'			=>	$_POST['role'],
				'ACTIVE_FLAG'	=>	$_POST['active_flag'],
				'E_USER_ID'		=>	$token['id'],
				'E_DATE_TIME'	=>	getDateOffset(),
				'U_USER_ID'		=>	NULL,
				'U_DATE_TIME'	=>	NULL
			);


			$id = $this->common->createRecord( $data, 'user_roles');

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

	public function UpdateUserRole()
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
            	$userRolesData = array(
					'table'		=>	'user_roles',
					'record'	=>	array (
						'ROLE'			=>	$data['userRole'],		
						'ACTIVE_FLAG'	=>	$data['userRoleFlag'],
						'U_USER_ID'		=>	$this->tokenData['id'],
						'U_DATE_TIME'	=>	getDateOffset()
					),
					'condition'		=>	array(
						'USER_ROLE_ID'	=>	$data['userRoleId']
					)
				);

				if ( $this->common->updateRecord( $userRolesData ) ) 
				{
					echo json_encode( array( 'code' => SUCCESS, 'message' => $this->msg['success_msg']['update'] ) );
				}
				else
				{
					echo json_encode( array( 'code' => BAD_DATA, 'message' => $this->msg['error_msg']['update'] ) );
				}
			}

		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function getUserRolesPagination( $page ) 
	{
		$userRolesTable = array(
						'select'	=>	'*',
						'table'		=>	'user_roles'
					);

		$userRoles = $this->common->getRecord( $userRolesTable );

		$total_menu = count($userRoles);

		$config = array(
			"base_url"			=>	"#",
			"attributes"		=> 	array('class' => 'page-link'),
			"total_rows"		=>	$total_menu,
			"per_page"			=>	5,
			"uri_segment"		=>	5,
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
				'table'	=>	'user_roles',
				'order_attribute' 	=> 'ROLE',
				'order_by' 			=> 'ASC'
			)
		);

		$output = array(
			"UserRolesPaginationLink"	=>	$this->pagination->create_links(),
			"UserRolesList"		=>	$this->user->userRolesPagination( $paginationData )
		);

		echo json_encode($output);

	}

	public function GetUserRolesData()
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
					'select'			=> 	'`USER_ROLE_ID`, `ROLE`, `ACTIVE_FLAG`, `E_DATE_TIME`',
					'table'				=> 	'user_roles',
					'condition'			=>	array(
						'USER_ROLE_ID'	=>	$data['userRoleId']
					),
					'order_attribute'	=>	'E_DATE_TIME',
					'order_by'			=>	'ASC'
				);

				echo json_encode( array( 'code' => SUCCESS, 'userRolesData' => $this->common->getRecord( $userRolesTable)[0] ) );
				// $this->debug( $this->common->getRecord( $productTable ) );

			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function DeleteUserRole()
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
				if ( isset ( $data['userRoleId'] ) ) 
				{
					$productData = array (
						'condition'		=>	array(
							'USER_ROLE_ID'	=>	$data['userRoleId']
						),
						'table'			=>	'user_roles'
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