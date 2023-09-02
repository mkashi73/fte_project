<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: login
	Date 		: 02/10/2018
*/

class ProductMultipleController extends MX_Controller 
{
	public function __construct() 
	{
		parent::__construct();

		$this->load->model('Products_mdl', 'product');
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
					"pageName"		=>	'Multiple Product'
				),
				"token"				=>	getTokenData('token'),
				"filepath"			=>	'product_multiple/product_multiple.js'
			);

			$this->load->view('common/header', $data);
			$this->load->view('common/sidebar', $data);
			$this->load->view('products/product_multiple_vw', $data);
			$this->load->view('common/footer', $data);
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function AddMultipleProduct()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			// $this->debug( $_POST );

			$config = 	array 
						(
				        	array 
				        	(
				            	'field' => 'productName[0]',
				                'label' => 'Product Name',
				                'rules' => 'required',
				                'errors' => array (
				                	'required' => 'You must provide a %s'
			                	)
			        		),
			        		array 
				        	(
				            	'field' => 'productNoOfPieces[0]',
				                'label' => 'Product Number of Pieces',
				                'rules' => 'required',
				                'errors' => array (
				                	'required' => 'You must provide a %s'
			                	)
			        		),
			        		array 
				        	(
				            	'field' => 'productPricePerPiece[0]',
				                'label' => 'Product Price',
				                'rules' => 'required',
				                'errors' => array (
				                	'required' => 'You must provide a %s'
			                	)
			        		),
			        			
						);

			$this->form_validation->set_rules( $config );

			if ( $this->form_validation->run() == FALSE )
	        {
	            echo json_encode ( 
	            					array 
	            					( 
	            						'code' => '403', 
	            						'message' => strip_tags ( validation_errors() ) 
	            					) 
	            				);
	        }
	        else
	        {
	        	for ( $i = 0; $i < sizeof( $this->input->post('productName') ); $i++ )
	        	{
	        		$dbData = array (
						"PRODUCT_CN_NUMBER"	=>	$this->input->post('getCNNumber'),
						'PRODUCT_NAME'		=>	$this->input->post('productName')[$i],
						'PRODUCT_QUANTITY'	=>	$this->input->post('productNoOfPieces')[$i],
						'PRODUCT_PRICE'		=>	$this->input->post('productPricePerPiece')[$i],
						"E_USER_ID"			=>	$this->tokenData['id'],
						"E_DATE_TIME"		=>	getDateOffset()
					);

					$result = $this->common->createRecord( $dbData, 'product_multiple' );
	        	}
	        	
				if ( $result )
			    {
					echo json_encode(array("code" => SUCCESS, 'message' => $this->msg['success_msg']['create']));
				}
				else
				{
					echo json_encode(array("code" => BAD_DATA, 'message' => $this->msg['error_msg']['create']));
				}
	        }
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		}
	}

	public function ShowMultipleProduct () 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			// $this->debug( $_POST );

			$config = 	array 
						(
				        	array 
				        	(
				            	'field' => 'CNNumber',
				                'label' => 'CN Number',
				                'rules' => 'required',
				                'errors' => array (
				                	'required' => 'You must provide a %s'
			                	)
			        		),
						);

			$this->form_validation->set_rules( $config );

			if ( $this->form_validation->run() == FALSE )
	        {
	        	echo json_encode ( 
	            					array 
	            					( 
	            						'code' => '403', 
	            						'message' => strip_tags ( validation_errors() ) 
	            					) 
	            				);
	        }
	        else
	        {
	        	$productTable = array(
					'db'		=>	array(
						'select' => 'product.*, tracking_status.TRACKING_ID, tracking_status.TRACKING_CODE',
						'table'	 =>	'product',
						'join'	=>	array (
							'joined_table'	=>	'tracking_status',
							'joined_condition'		=>	'product.TRACKING_STATUS = tracking_status.TRACKING_ID'
						),
						'condition'	=>	array(
							'product.CN_NUMBER' => $this->input->post('CNNumber')
						)
					),

					'productMultipleDb'	=>	array (
						'table'		=>	'product_multiple',
						'condition' => array (
							'PRODUCT_CN_NUMBER'	=>	$this->input->post('CNNumber')
						)
					)
				);

				$result = $this->product->GetSearchMultipleProductData( $productTable );

				// $this->debug( $result );

				if ( !empty( $result ) )
               	{
               		echo json_encode( 
               							array ( 
               								'code' => '200', 
               								'ProductMultipleData' => $result['productMultipleDetail'],
               								'ProductMultipleListing' => $result['productMultipleListing'],
               								'CNNumber'	=>	$this->input->post('CNNumber')
               							) 
               						);
               	}
               	else
               	{
               		echo json_encode( array ( 'code' => '403', 'message' => $this->msg['general_msg']['no_record_error'] ) );
               	}
	        }
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		}
	}

	public function GetProductMultipleData()
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
				$productMultipleTable = array(
					'select'			=> 	'*',
					'table'				=> 	'product_multiple',
					'condition'			=>	array(
						'PRODUCT_MULTIPLE_ID'	=>	$data['id']
					),
				);

				echo json_encode( array( 'code' => SUCCESS, 'productMultipleData' => $this->common->getRecord( $productMultipleTable )[0] ) );
				// $this->debug( $this->common->getRecord( $productTable ) );

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
	public function UpdateMultipleProduct()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			header('Content-Type: application/json');

		    $data = json_decode(file_get_contents('php://input'), TRUE);

		    // $this->debug( $_POST );

		    if($this->input->method(true) != 'POST')
		    {
		    	echo json_encode( array ( "code" => 403, 'message' => $this->msg['general_msg']['post_data_error'] ) );
		    }
		    else
			{
            	$productTypeData = array(
					'table'		=>	'product_multiple',
					'record'	=>	array (
						'PRODUCT_NAME'			=>	$_POST['productname'],
						'PRODUCT_QUANTITY'		=>	$_POST['noofpieces'],
						'PRODUCT_PRICE'			=>	$_POST['unitprice'],		
						'U_USER_ID'				=>	$this->tokenData['id'],
						'U_DATE_TIME'			=>	getDateOffset()
					),
					'condition'		=>	array(
						'PRODUCT_MULTIPLE_ID'	=>	$_POST['productMultipleId']
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

	public function DeleteMultipleProduct()
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
				if ( isset ( $data['id'] ) ) 
				{
					$productData = array (
						'condition'		=>	array(
							'PRODUCT_MULTIPLE_ID'	=>	$data['id']
						),
						'table'			=>	'product_multiple'
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