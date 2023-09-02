<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: login
	Date 		: 02/10/2018
*/

class ProductStageController extends MX_Controller 
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

			$productStageTable = array(
				'select'	=>	'*',
				'table'		=>	'product_stage'
			);

			$companyTable = array(
				'select'	=>	'*',
				'table'		=>	'company',
				'order_attribute' 	=> 	'COMPANY_NAME',
				'order_by'			=>	'ASC'
			);

			$data = array(
				"links"				=>	array(
					"show_menu"		=> 	$parent_menu
				),
				"headerData"		=>	array(
					"companyName"	=>	'FTE',
					"pageName"		=>	'Product Search'
				),
				"token"				=>	getTokenData('token'),
				"productStageData"	=>	$this->common->getRecord( $productStageTable ),
				'companyData'		=>	$this->common->getRecord( $companyTable ),
				"filepath"			=>	'product_stage/product_stage.js'
			);

			$this->load->view('common/header', $data);
			$this->load->view('common/sidebar', $data);
			$this->load->view('products/product_stage_vw', $data);
			$this->load->view('common/footer', $data);
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
			redirect(base_url());
		} // end of Role validation
	}

	public function SearchProduct()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$config = array(
		        array(
                	'field' => 'cnNumber',
	                'label' => 'CN Number',
	                'rules' => 'required',
	                'errors' => array(
	                	'required' => 'You must provide a %s'
	                )
		        )
			);

			$this->form_validation->set_rules($config);

			if ( $this->form_validation->run() == FALSE )
            {
                echo json_encode( array ( 'code' => '403', 'ProductStageData' => strip_tags ( validation_errors() ) ) );
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
							'product.CN_NUMBER' => $this->input->post('cnNumber')
						)
					)
				);

               	$result = $this->product->GetSearchProductData( $productTable );

               	if ( !empty( $result ) )
               	{
               		echo json_encode( 
               							array ( 
               								'code' => '200', 
               								'ProductStageData' => $result 
               							) 
               						);
               	}
               	else
               	{
               		echo json_encode( array ( 'code' => '403', 'ProductStageData' => $this->msg['general_msg']['no_record_error'] ) );
               	}
            }
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'ProductStageData' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function AddProductStage () 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			// $this->debug( $_POST );

			$config = array(
		        array(
                	'field' => 'productId',
	                'label' => 'CN Number',
	                'rules' => 'required',
	                'errors' => array(
	                	'required' => 'You must enter a correct %s'
            	    ),
            	)
			);

			$this->form_validation->set_rules($config);

			if ( $this->form_validation->run() == FALSE )
            {
                echo json_encode( array ( 'code' => '403', 'message' => strip_tags ( validation_errors() ) ) );
            }
            else
            {
            	$data  =	array(
					'PRODUCT_STAGE_ID'		=>	$this->input->post('productStageId'),
					'PRODUCT_ID'			=>	$this->input->post('productId'),
					'PRODUCT_STAGE_DETAIL'	=>	$this->input->post('productStageDetail'),
					'STATUS'				=>	1,
					'REGISTRY_DATE'			=>	$this->input->post('productStageDate'),
					'E_USER_ID'				=>  $this->tokenData['id'],
					'E_DATE_TIME'			=>	getDateOffset()
				);

            	$table = 'product_stage_detail';

				$result = $this->common->createRecord( $data, $table );

				if ( $result )  
				{
					echo json_encode( array ( "code" => SUCCESS, 'message' => $this->msg['success_msg']['create'] ) );
				}
				else
				{
					echo json_encode( array ( "code" => BAD_DATA, 'message' => $this->msg['error_msg']['create'] ) );
				}
            }
		}
	}

	public function GetProductStageData () 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
		    $data = json_decode(file_get_contents('php://input'), TRUE);

		    if ( !empty ( $data['productId'] ) ) 
		    {
				$result = $this->product->getProductStage( $data['productId'] );
		    }

		    if ( !empty( $_POST['productId'] ) ) 
		    {
		    	$result = $this->product->getProductStage( $_POST['productId'] );
		    }

			echo json_encode( array( "code" => SUCCESS, 'message' => $result ) );

		}	
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function updateData () 
	{

		if ( !empty ( $this->input->post('extNumber') ) && !empty ( $this->input->post('companyId') ))
		{
			// $this->debug( $_POST );

			$updateProductTable = array(
				'table' => 'product',
				'condition' => array(
					'PRODUCT_ID'	=>	$this->input->post('productId')
				),
				'record' => array(
					'COMPANY_ID'			=>	$this->input->post('companyId'),
					'EXT_TRACKING_NUMBER'	=>	$this->input->post('extNumber')
				)
			);

			// $this->debug( $updateProductTable );

			$result = $this->common->updateRecord( $updateProductTable );

			if ( $result )  
			{
				echo json_encode( array ( "code" => SUCCESS, 'message' => $this->msg['success_msg']['update'] ) );
			}
			else
			{
				echo json_encode( array ( "code" => BAD_DATA, 'message' => $this->msg['error_msg']['update'] ) );
			}
		}
		else
		{
			echo json_encode( array ( "code" => BAD_DATA, 'message' => $this->msg['general_msg']['input_error'] ) );
		}
	}
} 