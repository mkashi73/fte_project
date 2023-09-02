<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: login
	Date 		: 02/10/2018
*/

class ProductTrackingController extends CI_Controller 
{
	public function __construct() 
	{
		parent::__construct();

		$this->load->model('Products_mdl', 'product');
		$this->load->library('Pagination');
	}

	public function index()
	{
		$data = array(
			"headerData"		=>	array(
				"companyName"	=>	'FTE',
				"pageName"		=>	'Tracking Product'
			),
			"filepath"			=>	'products/products.js'

		);

		$this->load->view('products/tracking/tracking_page_vw', $data);
	}

	public function SearchTracking()
	{
		// $this->debug( $_POST );

		$config = 
				array 
				(
		        	array 
		        	(
		            	'field' => 'CNNumber',
		                'label' => 'CN Number',
		                'rules' => 'required',
		                'errors' => array (
		                	'required' => 'You must provide a %s'
	                	)
	        		)
				);

		$this->form_validation->set_rules( $config );

		if ( $this->form_validation->run() == FALSE )
        {
            echo json_encode ( array ( 'code' => '403', 'ProductTrackingData' => strip_tags ( validation_errors() ) ) );
        }
        else
        {
        	$productTable = array (
				'db'		=>	array (
					'select' => 'product.*, tracking_status.TRACKING_ID, tracking_status.TRACKING_CODE',
					'table'	 =>	'product',
					'join'	=>	array (
						'joined_table'			=>	'tracking_status',
						'joined_condition'		=>	'product.TRACKING_STATUS = tracking_status.TRACKING_ID'
					),
					'condition'	=>	array (
						'product.CN_NUMBER' => $this->input->post('CNNumber')
					)
				)
			);

           	$result = $this->product->GetSearchProductTrackingData( $productTable );

           	// $this->debug( $result );

           	if ( !empty( $result ) )
           	{
           		echo json_encode( 
           							array ( 
           								'code' => '200', 
           								'ProductTrackingData' => $result 
           							) 
           						);
           	}
           	else
           	{
           		echo json_encode( 
       								array ( 
       									'code' => '403', 
       									'ProductTrackingData' => 'Product does not exist'
       								) 
           						);
           	}
        }

	}

	public function debug( $arg )
	{
		echo "<pre>";
		print_r( $arg );
		echo "</pre>";
		exit();
	}
}