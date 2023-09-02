<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: Products Status Controller
	Date 		: 02/10/2018
*/

class ProductsStatusController extends MX_Controller 
{
	public function __construct() 
	{
		parent::__construct();

		$this->load->model('Products_mdl', 'product');
		$this->load->library('Pagination');
	}
	/**************
	INDEX FUNCTION
	**************/
	public function index()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$parent_menu = $this->getMenu;

			$productStatusTable = array(
				'select'			=> 	'*',
				'table'				=> 	'product_status',
				'order_attribute'	=>	'E_DATE_TIME',
				'order_by'			=>	'ASC',
			);

			$data = array(
				"links"				=>	array(
					"show_menu"		=> 	$parent_menu
				),
				"headerData"		=>	array(
					"companyName"	=>	'FTE',
					"pageName"		=>	'Product Status'
				),
				"token"				=>	getTokenData('token'),
				"productStatus"		=>	$this->common->getRecord( $productStatusTable ),
				"filepath"			=>	'product_status/product_status.js'

			);

			$this->load->view('common/header', $data);
			$this->load->view('common/sidebar', $data);
			$this->load->view('products/products_status_vw', $data);
			$this->load->view('common/footer', $data);
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
			redirect(base_url());
		} // end of Role validation
	}

	/******************
	PAGINATION FUNCTION
	******************/
	public function getProductStatusPagination( $page ) 
	{
		$productStatusTable = array(
						'select'	=>	'*',
						'table'		=>	'product_status'
					);

		$productStatus = $this->common->getRecord( $productStatusTable );

		$total_menu = count($productStatus);

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
				'table'	=>	'product_status',
				'order_attribute' 	=> 'product_status.PRODUCT_STATUS_NAME',
				'order_by' 			=> 'ASC',
			)
		);

		$output = array(
			"ProductStatusPaginationLink"	=>	$this->pagination->create_links(),
			"ProductStatusList"		=>	$this->product->productStatusPagination( $paginationData )
		);

		echo json_encode($output);

	}

	/***********
	GET FUNCTION
	***********/
	public function GetProductStatusData()
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
				$productTable = array(
					'select'			=> 	'*',
					'table'				=> 	'product_status',
					'condition'			=>	array(
						'PRODUCT_STATUS_ID'	=>	$data['productStatusId']
					),
					'order_attribute'	=>	'E_DATE_TIME',
					'order_by'			=>	'ASC'
				);

				echo json_encode( array( 'code' => SUCCESS, 'productStatusData' => $this->common->getRecord( $productTable)[0] ) );
				// $this->debug( $this->common->getRecord( $productTable ) );

			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	/***********
	ADD FUNCTION
	***********/
	public function AddProductStatus()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			extract($_POST);
            
	        if ( !empty ($_POST['productStatusName'] ) ) 
	        {
	        	$checkProductStatus = array(
	    			'select'			=> 	'*',
					'table'				=> 	'product_status',
					'condition' 	=> 	array(
			    		'PRODUCT_STATUS_NAME'	=>	$_POST['productStatusName']
			    	)
	    		);

            	$productStatusName = $this->common->getRecord( $checkProductStatus );

            	// $this->debug( $productStatusName );

            	if ( empty ( $productStatusName ) )
            	{
		        	$data = array(
						'PRODUCT_STATUS_NAME'		=>	$_POST['productStatusName'],
						'E_USER_ID'					=>	$this->tokenData['id'],
						'E_DATE_TIME'				=>	getDateOffset()
					);

					$result = $this->common->createRecord( $data, 'product_status');

					// $this->debug( $result );

					if ( !empty ($result) )
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
					echo json_encode( array ( "code" => 403, 'message' => 'Product status name already exist' ) );
				}
			}
			else
			{
				echo json_encode( array ( "code" => 403, 'message' => 'Please enter Product Status name' ) );
			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}
	/**************
	UPDATE FUNCTION
	**************/
	public function UpdateProductStatus()
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
            	$productStatusData = array(
					'table'		=>	'product_status',
					'record'	=>	array (
						'PRODUCT_STATUS_NAME'	=>	$_POST['productStatusName'],		
						'U_USER_ID'				=>	$this->tokenData['id'],
						'U_DATE_TIME'			=>	getDateOffset()
					),
					'condition'		=>	array(
						'PRODUCT_STATUS_ID'	=>	$_POST['productStatusId']
					)
				);

            	// $this->debug( $productStatusData );

				if ( $this->common->updateRecord( $productStatusData ) ) 
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

	/**************
	DELETE FUNCTION
	**************/

	public function DeleteProductStatus()
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
				if ( isset ( $data['productStatusId'] ) ) 
				{
					$productData = array (
						'condition'		=>	array(
							'PRODUCT_STATUS_ID'	=>	$data['productStatusId']
						),
						'table'			=>	'product_status'
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