<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: login
	Date 		: 02/10/2018
*/
class MenuController extends MX_Controller 
{
	public function __construct() 
	{
		parent::__construct();

		$this->load->model('Menu_mdl', 'menu');
		$this->load->library('Pagination');
	}

	public function index() 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$parent_menu = $this->getMenu;

			$data = array(
				"links"				=>	array(
					"show_menu"		=> 	$parent_menu
				),
				"headerData"		=>	array(
					"companyName"	=>	'FTE',
					"pageName"		=>	'Mega Menu'
				),
				"menuRecords"		=>	$this->menu->getMenuRecords(),
				"parentMenu"		=>	$this->menu->getParentMenu(),
				"userRoles"			=>	$this->menu->getUserRole(),
				"token"				=>	getTokenData('token'),
				"filepath"			=>	'menu/menu.js'

			);

			$this->load->view('common/header', $data);
			$this->load->view('common/sidebar', $data);
			$this->load->view('menu_vw');
			$this->load->view('common/footer', $data);
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
			redirect(base_url());
		} // end of Role validation
	}

	public function AddMenu() 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$role = [];

			if  ( isset( $_POST['menuRole'] ) ) 
			{
				$userRole = $_POST['menuRole'];

				$role = implode(',', $userRole);
			}
		
			if ( isset ( $_POST['menuText'] )
				&& !empty( $_POST['menuText'] )
				&& isset ( $_POST['menuLink'] )
				&& !empty( $_POST['menuLink'] )
				&& isset ( $_POST['menuIcon'] )
				&& !empty( $_POST['menuIcon'] )
				&& isset ( $_POST['menuParent'] )
				&& !empty( $_POST['menuParent'] )
				&& isset ( $_POST['menuRole']  )
				&& !empty( $_POST['menuRole'] )
			 	) 
			{
				if ( empty ( $_POST['menuParent'] ) ) 
				{
					$menuParent = NULL;
				}
				else
				{
					$menuParent = $_POST['menuParent'];
				}
				$dbData = array(
					"MENU_TEXT"		=>	$_POST['menuText'],
					"MENU_ICON"		=>	$_POST['menuIcon'],
					"MENU_URL"		=>	$_POST['menuLink'],
					"PARENT_ID"		=>	$menuParent,
					"USER_ROLE_ID"	=>	$role
				);

				if ( $this->menu->addMenu($dbData) )
				{
					echo json_encode(array("code" => SUCCESS, 'message' => $this->msg['success_msg']['create']));
				}
				else
				{
					echo json_encode(array("code" => BAD_DATA, 'message' => $this->msg['error_msg']['create']));
				}
			}
			else
			{
				echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['general_msg']['input_error']) );
				// echo $this->msg['general_msg']['input_error'];
			} // end of input validation
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}


	public function UpdateMenu() 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$role = [];
			
			if  ( isset( $_POST['menuRole'] ) ) 
			{
				$userRole = $_POST['menuRole'];

				$role = implode(',', $userRole);
			}

			if ( isset ( $_POST['menuParent'] ) && !empty( $_POST['menuParent'] ) )  
			{
				$menuParent = $_POST['menuParent'];
			}
			else
			{
				$menuParent = NULL;
			}
		
			if ( isset ( $_POST['menuText'] )
				&& !empty( $_POST['menuText'] )
				&& isset ( $_POST['menuIcon'] )
				&& !empty( $_POST['menuIcon'] )
				&& isset ( $_POST['menuRole']  )
				&& !empty( $_POST['menuRole'] )
			 	) 
			{

				$menuData = array(
					'table'		=>	'user_menu',
					'record'	=>	array (
						"MENU_TEXT"		=>	$_POST['menuText'],
						"MENU_ICON"		=>	$_POST['menuIcon'],
						"MENU_URL"		=>	$_POST['menuLink'],
						"PARENT_ID"		=>	$menuParent,
						"USER_ROLE_ID"	=>	$role,
						'U_USER_ID'		=>	$this->tokenData['id'],
						'U_DATE_TIME'	=>	getDateOffset()
					),
					'condition'		=>	array(
						'MENU_ID'	=>	$_POST['menuId']
					)
				);


				if ( $this->common->updateRecord( $menuData ) )
				{
					echo json_encode(array("code" => SUCCESS, 'message' => $this->msg['success_msg']['update']));
				}
				else
				{
					echo json_encode(array("code" => BAD_DATA, 'message' => $this->msg['error_msg']['update']));
				}
			}
			else
			{
				echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['general_msg']['input_error']) );
			} // end of input validation
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	/**************
	DELETE FUNCTION
	**************/

	public function DeleteMenu()
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
				if ( isset ( $data['menuId'] ) ) 
				{
					$productData = array (
						'condition'		=>	array(
							'MENU_ID'	=>	$data['menuId']
						),
						'table'			=>	'user_menu'
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

	// Pagination
	public function GetMenu ( $page ) 
	{
		$row = array(
			
		);
		$MenuDb = array(
						'select'	=>	'`MENU_ID`, `MENU_TEXT`, `MENU_ICON`, `MENU_URL`, `PARENT_ID`',
						'table'		=>	'user_menu'
					);

		$menu = $this->common->getRecord( $MenuDb );

		$total_menu = count($menu);

		$config = array(
			"base_url"			=>	"#",
			"attributes"		=> 	array('class' => 'page-link'),
			"total_rows"		=>	$total_menu,
			"per_page"			=>	5,
			"uri_segment"		=>	3,
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
				'table'	=>	'user_menu',
				'order_attribute' 	=> 'user_menu.PARENT_ID, user_menu.MENU_TEXT',
				'order_by' 			=> 'ASC',
			)
		);

		$output = array(
			"pagination_link"	=>	$this->pagination->create_links(),
			"MenuList"		=>	$this->common->paginationRecord( $paginationData )
		);

		// $this->debug( $output );

		echo json_encode($output);
	}

	/***********
	GET FUNCTION
	***********/
	public function GetMenuData()
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
				$query = "  SELECT * 
							FROM 
							`user_menu` as um,
							`user_roles` as ur
							WHERE 
							ur.`USER_ROLE_ID` IN (" . $data['roleId'] . ")
							AND um.`MENU_ID` = " . $data['menuId'];

				echo json_encode( array( 'code' => SUCCESS, 'menuData' => $this->common->getRecordByCustomQuery( $query ) ) );

			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}
}