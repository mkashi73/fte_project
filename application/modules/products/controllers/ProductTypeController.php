<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: Products Status Controller
	Date 		: 02/10/2018
*/

class ProductTypeController extends MX_Controller 
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
				'table'				=> 	'product_type',
				'order_attribute'	=>	'E_DATE_TIME',
				'order_by'			=>	'ASC',
			);

			$data = array(
				"links"				=>	array(
					"show_menu"		=> 	$parent_menu
				),
				"headerData"		=>	array(
					"companyName"	=>	'FTE',
					"pageName"		=>	'Product Type'
				),
				"token"				=>	getTokenData('token'),
				"productStatus"		=>	$this->common->getRecord( $productStatusTable ),
				"filepath"			=>	'product_type/product_type.js'

			);

			$this->load->view('common/header', $data);
			$this->load->view('common/sidebar', $data);
			$this->load->view('products/product_type_vw', $data);
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
	public function getProductTypePagination( $page ) 
	{
		$productTypeTable = array(
						'select'	=>	'*',
						'table'		=>	'product_type'
					);

		$productType = $this->common->getRecord( $productTypeTable );

		$total_menu = count($productType);

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
				'table'	=>	'product_type',
				'order_attribute' 	=> 'product_type.PRODUCT_TYPE',
				'order_by' 			=> 'ASC',
			)
		);

		$output = array(
			"ProductTypePaginationLink"	=>	$this->pagination->create_links(),
			"ProductTypeList"		=>	$this->product->productTypePagination( $paginationData )
		);

		echo json_encode($output);

	}

	/***********
	GET FUNCTION
	***********/
	public function GetProductTypeData()
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
				$productTypeTable = array(
					'select'			=> 	'*',
					'table'				=> 	'product_type',
					'condition'			=>	array(
						'PRODUCT_TYPE_ID'	=>	$data['productTypeId']
					),
					'order_attribute'	=>	'E_DATE_TIME',
					'order_by'			=>	'ASC'
				);

				echo json_encode( array( 'code' => SUCCESS, 'productTypeData' => $this->common->getRecord( $productTypeTable)[0] ) );
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
	public function AddProductType()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			extract($_POST);
            
	        if ( !empty ($_POST['productTypeName'] ) ) 
	        {
	        	$checkProductType = array(
	    			'select'			=> 	'*',
					'table'				=> 	'product_type',
					'condition' 	=> 	array(
			    		'PRODUCT_TYPE'	=>	$_POST['productTypeName']
			    	)
	    		);

            	$productTypeName = $this->common->getRecord( $checkProductType );

            	// $this->debug( $productStatusName );

            	if ( empty ( $productTypeName ) )
            	{
		        	$data = array(
						'PRODUCT_TYPE'		=>	$_POST['productTypeName'],
						'E_USER_ID'			=>	$this->tokenData['id'],
						'E_DATE_TIME'		=>	getDateOffset()
					);

					$result = $this->common->createRecord( $data, 'product_type');

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
	public function UpdateProductType()
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
            	$productTypeData = array(
					'table'		=>	'product_type',
					'record'	=>	array (
						'PRODUCT_TYPE'			=>	$_POST['productTypeName'],		
						'U_USER_ID'				=>	$this->tokenData['id'],
						'U_DATE_TIME'			=>	getDateOffset()
					),
					'condition'		=>	array(
						'PRODUCT_TYPE_ID'	=>	$_POST['productTypeId']
					)
				);

            	// $this->debug( $productStatusData );

				if ( $this->common->updateRecord( $productTypeData ) ) 
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

	public function DeleteProductType()
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
				if ( isset ( $data['productTypeId'] ) ) 
				{
					$productTypeData = array (
						'condition'		=>	array(
							'PRODUCT_TYPE_ID'	=>	$data['productTypeId']
						),
						'table'			=>	'product_type'
					);

					$result = $this->common->deleteRecord( $productTypeData );
				
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