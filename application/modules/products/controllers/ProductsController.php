<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: login
	Date 		: 02/10/2018
*/

class ProductsController extends MX_Controller 
{
	public function __construct() 
	{
		parent::__construct();

		$this->load->model('Products_mdl', 'product');
		$this->load->library('Pagination');
		ini_set('memory_limit', '-1');
	}

	public function index()
	{
	    $roleId = $this->tokenData['role_id'];
	    
		if ( $this->common->checkUserRole( $roleId ) ) 
		{
			$parent_menu = $this->getMenu;

			$productTable = array(
				'select'			=> 	'*',
				'table'				=> 	'product',
				'order_attribute'	=>	'E_DATE_TIME',
				'order_by'			=>	'ASC',
				'join'				=>	array(
					'joined_table'		=>	'tracking_status',
					'joined_condition'	=>	'product.TRACKING_STATUS = tracking_status.TRACKING_ID'
				)

			);

			$countryData = array (
				'select'			=> 	'*',
				'table'				=> 	'country'
			);

			$stateData = array (
				'select'			=> 	'*',
				'table'				=> 	'state'
			);

			$cityData = array (
				'select'			=> 	'*',
				'table'				=> 	'city'
			);	
			// new changes  to get data in dropdown
			$userDbData = array(
					'select'	=> 	'*',
					'table'		=>	'client',
					'condition'	=>	 array(
						'USER_ID'		=>	getTokenData('token')['id']					
					)
				);
					// 'condition'	=>	'USER_ID =  "'.$roleId.'" '  



					// to get data in dropdown	// 

			$data = array(
				"links"				=>	array(
					"show_menu"		=> 	$parent_menu
				),
				"headerData"		=>	array(
					"companyName"	=>	'FTE',
					"pageName"		=>	'Product'
				),
				"token"				=>	getTokenData('token'),
				"client"			=>	$this->common->getRecord($userDbData),
				"getCountry"		=>  $this->common->getRecord($countryData),
				"getState"			=>  $this->common->getRecord($stateData),
				"getCity"			=>  $this->common->getRecord($cityData),
				"product"			=>	$this->common->getRecord( $productTable ),
				"productType"		=>  $this->product->getData('product_type'),
				"trackingStatus" 	=>	$this->product->getData('tracking_status'),
				"productCondition"	=>	$this->product->getData('product_condition'),
				"productStatus"		=>	$this->product->getData('product_status'),
				"disabled"       =>  ( $roleId == 1) ? 'disabled' : '',
				"disabledopt"     =>  ( $roleId == 6 ) ? 'disabled' : '',
				"filepath"			=>	'products/products.js'
			);

			
					// 			debug($data['disabled']);

			$this->load->view('common/header', $data);
			$this->load->view('common/sidebar', $data);
			$this->load->view('products/products_vw', $data);
			$this->load->view('common/footer', $data);
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
			redirect(base_url());
		} // end of Role validation
	}

	public function AddProduct()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			extract($_POST);
			
			// $this->debug( $_POST );

			if ( !empty ( $_FILES ) && isset( $_FILES ) )
			{
				$paths = '';

				$fileConfig = array(
					'fileName' 			=> $_FILES['file']['name'],
					'fileType' 			=> $_FILES['file']['type'],
					'fileSize'			=> $_FILES['file']['size'],
					'fileTempName'		=> $_FILES['file']['tmp_name'],
					'fileUploadPath' 	=> getcwd() . '/assets/uploads/products/',
					'fileExtension'		=> $_FILES['file']['name'],
					'allowedExtensions'	=> array("jpeg","jpg","png"),
					'dbFilePath'		=> base_url() . 'assets/uploads/products/'
				);

				$filePath = $this->common->uploadFile( $fileConfig );

				// $this->debug( $filePath );

				if ( !empty( $filePath ) ) 
				{
					if ( isset( $filePath['error'] ) && !empty( $filePath['erorr'] ) )
					{
						echo json_encode( array ( "code" => 403, 'message' => $filePath['error'] ) );
					}

					if ( sizeof( $filePath ) > 1 ) 
					{
						$paths = implode('|', $filePath);
					}
					else
					{
						$paths = $filePath[0];
					}
				}
				else
				{
					$paths = NULL;
				}
			}
			else
			{
				$paths = NULL;
			}

			$token = getTokenData('token');
			
			
			$getLastProductQuery = "SELECT * FROM `product` ORDER BY `PRODUCT_ID` DESC LIMIT 1";

			$lastProduct = $this->common->getRecordByCustomQuery( $getLastProductQuery )[0];


			$lastProduct['CN_NUMBER'] = $lastProduct['CN_NUMBER'] + 1;


        	$checkCNNumber = array(
    			'select'			=> 	'*',
				'table'				=> 	'product',
				'condition' 	=> 	array(
		    		'CN_NUMBER'	=>	$lastProduct['CN_NUMBER']
		    	)
    		);

        	$checkExtTrackingNumber = array(
    			'select'			=> 	'*',
				'table'				=> 	'product',
				'condition' 	=> 	array(
		    		'EXT_TRACKING_NUMBER'	=>	$_POST['exttrackingno']
		    	)
    		);

        	$cnNumber = $this->common->getRecord( $checkCNNumber );
        	
        	$config = array(
		        array(
                	'field' => 'trackingStatus',
	                'label' => 'Tracking Status',
	                'rules' => 'required',
	                'errors' => array(
	                	'required' => 'You must provide a %s'
	                )
		        )
			);


			$this->form_validation->set_rules($config);
			
			if ( $this->form_validation->run() == FALSE )
            {
                echo json_encode( array ( 'code' => '403', 'message' => strip_tags ( validation_errors() ) ) );
            }
            else
            {
	        	if ( empty ( $cnNumber ) ) 
	        	{
	        		
	            	$data = array(
						'PRODUCT_TYPE_ID'			=>	$_POST['productType'],
						'PRODUCT_CONDITION_ID'		=>	$_POST['productCondition'],
						'PRODUCT_NAME'				=>	$_POST['productname'],
						'PRODUCT_ACTUAL_PRICE'		=>	$_POST['productActualPrice'],
						'DESCRIPTION'				=>	$_POST['Description'],
						'PRODUCT_GROSS_WEIGHT'		=>	$_POST['productweight'],
						'PRODUCT_NET_WEIGHT'		=>	$_POST['productnetweight'],
						'PRODUCT_DIMENSION'			=>	$_POST['productdimension'],
						'PRODUCT_IMAGE'				=>	$paths,
						'CLUB_NUMBER'				=>	$_POST['clubNumber'],
						'SHIPPER_NAME'				=>	$_POST['shippername'],
						'SHIPPER_ADDRESS'			=>	$_POST['shipperaddress'],
						'SHIPPER_E_ADDRESS'			=>	$_POST['shipperEmailAddress'],
						'SHIPPER_PHONE'				=>	$_POST['shipperphone'],
						'SHIPPER_ZIP_CODE'			=>	$_POST['shipperzipcode'],
						'SHIPPER_COUNTRY_ID'		=>	$_POST['shipperCountryId'],
						'SHIPPER_STATE_ID'			=>	$_POST['shipperStateId'],
						'SHIPPER_CITY_ID'			=>	$_POST['shipperCityId'],
						'CONSIGNEE_NAME'			=>	$_POST['consigneername'],
						'CONSIGNEE_PHONE_NUMBER'	=>	$_POST['consigneephone'],
						'CONSIGNEE_ZIP_CODE'		=>	$_POST['consigneezipcode'],
						'CONSIGNEE_COUNTRY_ID'		=>	$_POST['consigneeCountryId'],
						'CONSIGNEE_STATE_ID'		=>	$_POST['consigneeStateId'],
						'CONSIGNEE_CITY_ID'			=>	$_POST['consigneeCityId'],
						'CONSIGNEE_ADDRESS'			=>	$_POST['consigneeaddress'],
						'CONSIGNEE_E_ADDRESS'		=>	$_POST['consigneeEmailAddress'],
						'CN_NUMBER'					=>	$lastProduct['CN_NUMBER'],
						'MAB_NUMBER'				=>	$_POST['mabNumber'],
						'BAG_NUMBER'				=>	$_POST['bagNumber'],
						'FORM_E_NUMBER'				=>	$_POST['formE'],
						'EORI_NUMBER'				=>	$_POST['eoriNumber'],
						'VAT_NUMBER'				=>	$_POST['vatNumber'],
						'CONSIGNEE_AMOUNT'			=>	$_POST['receivedamount'],
						'BALANCE_AMOUNT'			=>	$_POST['balanceamount'],
						'QUANTITY'					=>	$_POST['noofpieces'],
						'EXT_TRACKING_NUMBER'		=>	$_POST['exttrackingno'],
						'TRACKING_STATUS'			=>	$_POST['trackingStatus'],
						'PRODUCT_STATUS'			=>	$_POST['productStatus'],
						'E_USER_ID'					=>	$token['id'],
						'CLIENT_ID'					=>	$_POST['CLIENT_ID'],
						'E_DATE_TIME'				=>	getDateOffset()
					);

					

	   //         	// to cretae a record and return last id 
				 	$result = $this->common->createRecords( $data, 'product');

					


				// 	// adding payment

				// 	$ledger = array(
				// 		'CLIENT_ID' 	=> 	$_POST['CLIENT_ID'] , 
				// 		'PAYMENT'		=> 	$_POST['balanceamount'] ,
				// 		'RECIEVED'  	=> 	$_POST['receivedamount'],
				// 		'SHIPPER' 		=> 	$_POST['shippername'],
				// 		'PRODUCT_ID'	=> 	$result,
				// 		'USER_ID'   	=> 	$token['id'],
				// 		'NAME' 			=> 	$_POST['productname'],
				// 		'STATUS' 		=> 	$_POST['productStatus'],
				// 		'CN_NUMBER' 	=> 	$lastProduct['CN_NUMBER'],
				// 		'WEIGHT' 		=> 	$_POST['productnetweight']
				// 	);

				// 	$result1 = $this->product->Payment($ledger);

				// 	// $this->debug( $result );

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
					echo json_encode( array ( "code" => 403, 'message' => 'CN number already exist' ) );
				}
			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function getProductPagination( $page ) 
	{

		// $this->debug( getTokenData('token')['id'] );
		$roleId = $this->tokenData['role_id'];

		if ( isset( $_POST['cn_number'] ) ) 
		{
			$cnNumber = $_POST['cn_number'];
		}
		
		if( getTokenData('token')['id'] != 1 )
		{
    		if( $roleId != 6 ) 
    		{
    
    			$productTable = array(
    							'select'			=>	'*',
    							'table'	 			=>	'product',
    							'order_attribute' 	=>  'product.E_DATE_TIME',
    							'order_by' 			=>  'DESC',
    							'join'				=>	array (
    								'joined_table'			=>	'tracking_status',
    								'joined_condition'		=>	'product.TRACKING_STATUS = tracking_status.TRACKING_ID'
    							),
    							'condition'			=>	array(
    								'product.E_USER_ID'		=>	getTokenData('token')['id'],
    								"CN_NUMBER <>"			=>  "786121002"
    							)
    						);
    		}
    		else
    		{
    			$productTable = array(
    							'select'			=>	'*',
    							'table'	 			=>	'product',
    							'order_attribute' 	=>  'product.E_DATE_TIME',
    							'order_by' 			=>  'DESC',
    							'join'				=>	array (
    								'joined_table'			=>	'tracking_status',
    								'joined_condition'		=>	'product.TRACKING_STATUS = tracking_status.TRACKING_ID'
    							),
    							"condition" 		=> "CN_NUMBER <> 786121002"
    						);
    		}
		}
		else
		{
			$productTable = array(
							'select'			=>	'*',
							'table'	 			=>	'product',
							'order_attribute' 	=>  'product.E_DATE_TIME',
							'order_by' 			=>  'DESC',
							'join'				=>	array (
								'joined_table'			=>	'tracking_status',
								'joined_condition'		=>	'product.TRACKING_STATUS = tracking_status.TRACKING_ID'
							),
							"condition" 		=> "CN_NUMBER <> 786121002"
						);
		}


		if ( !empty( $cnNumber ) ) 
		{
			$productTable['condition'] = array(
				'CN_NUMBER' => $cnNumber
			);
		}
		
		$product = $this->common->getRecord( $productTable );
		// debug( $this->db->last_query());
		
		if ( !empty( $product ) ) 
		{
			$total_menu = count($product);
		}
		else
		{
			$total_menu = 0;
		}

		// $this->debug( $total_menu );

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
		
		if( getTokenData('token')['id'] != 1 ) 
		{
    		if( $roleId != 6 )
    		{
    			$paginationData = array(
    				'db'		=>	array(
    					'select' => 'product.*, tracking_status.TRACKING_ID, tracking_status.TRACKING_CODE',
    					'limit'	 =>	$config['per_page'],
    					'start'	 =>	$start,
    					'table'	 =>	'product',
    					'order_attribute' 	=> 'product.E_DATE_TIME',
    					'order_by' 			=> 'DESC',
    					'join'	=>	array (
    						'joined_table'			=>	'tracking_status',
    						'joined_condition'		=>	'product.TRACKING_STATUS = tracking_status.TRACKING_ID'
    					),
    					'condition'			=>	array(
    						'product.E_USER_ID'		=>	getTokenData('token')['id'],
    						"CN_NUMBER <>"			=>  "786121002"
    					)
    				),
    				'userData' => array(
    					'userId' => getTokenData('token')['id']
    					
    				)
    			);
    		}
    		else
    		{
    			$paginationData = array(
    				'db'		=>	array(
    					'select' => 'product.*, tracking_status.TRACKING_ID, tracking_status.TRACKING_CODE',
    					'limit'	 =>	$config['per_page'],
    					'start'	 =>	$start,
    					'table'	 =>	'product',
    					'order_attribute' 	=> 'product.E_DATE_TIME',
    					'order_by' 			=> 'DESC',
    					'join'	=>	array (
    						'joined_table'			=>	'tracking_status',
    						'joined_condition'		=>	'product.TRACKING_STATUS = tracking_status.TRACKING_ID'
    					),
    					"condition" => array(
    						"CN_NUMBER <>"			=>  "786121002"
    					)
    				),
    				'userData' => array(
    					'userId' => getTokenData('token')['id']
    				)
    			);
    		}
		
		}
		else
		{
			$paginationData = array(
				'db'		=>	array(
					'select' => 'product.*, tracking_status.TRACKING_ID, tracking_status.TRACKING_CODE',
					'limit'	 =>	$config['per_page'],
					'start'	 =>	$start,
					'table'	 =>	'product',
					'order_attribute' 	=> 'product.E_DATE_TIME',
					'order_by' 			=> 'DESC',
					'join'	=>	array (
						'joined_table'			=>	'tracking_status',
						'joined_condition'		=>	'product.TRACKING_STATUS = tracking_status.TRACKING_ID'
					),
					"condition" => array(
						"CN_NUMBER <>"			=>  "786121002"
					)
				),
				'userData' => array(
					'userId' => getTokenData('token')['id']
				)
			);
		}

		if ( !empty( $cnNumber ) ) 
		{
			$paginationData['db']['condition'] = array(
				'CN_NUMBER' => $cnNumber
			);
		}

		// $this->debug( $this->product->productPagination( $paginationData ) );

		$output = array(
			"ProductPaginationLink"	=>	$this->pagination->create_links(),
			"ProductList"		=>	$this->product->productPagination( $paginationData )
		);

		echo json_encode($output);

	}

	public function GetProductData()
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
					'select'			=> 	'product.*, tracking_status.*',
					'table'				=> 	'product',
					'condition'			=>	array(
						'PRODUCT_ID'	=>	$data['productId']
					),
					'order_attribute'	=>	'E_DATE_TIME',
					'order_by'			=>	'ASC',
					'join'				=>	array(
						'joined_table'		=>	'tracking_status',
						'joined_condition'	=>	'product.TRACKING_STATUS = tracking_status.TRACKING_ID'
					)
				);

				echo json_encode( array( 'code' => SUCCESS, 'productData' => $this->common->getRecord( $productTable )[0] ) );
				// $this->debug( $this->common->getRecord( $productTable ) );

			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function UpdateProduct()
	{

		header('Content-Type: application/json');

		$data = json_decode(file_get_contents('php://input'), TRUE);

		
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{

		    if($this->input->method(true) != 'POST')
		    {
		    	echo json_encode( array ( "code" => 403, 'message' => $this->msg['general_msg']['post_data_error'] ) );
		    }
		    else
			{

				if ( !empty ( $_FILES ) && isset( $_FILES ) )
				{
					$paths = '';

					$fileConfig = array(
						'fileName' 			=> $_FILES['file']['name'],
						'fileType' 			=> $_FILES['file']['type'],
						'fileSize'			=> $_FILES['file']['size'],
						'fileTempName'		=> $_FILES['file']['tmp_name'],
						'fileUploadPath' 	=> getcwd() . '/assets/uploads/products/',
						'fileExtension'		=> $_FILES['file']['name'],
						'allowedExtensions'	=> array("jpeg","jpg","png"),
						'dbFilePath'		=> base_url() . 'assets/uploads/products/'
					);

					$filePath = $this->common->uploadFile( $fileConfig );

					// $this->debug( $filePath );

					if ( !empty( $filePath ) ) 
					{
						if ( isset( $filePath['error'] ) && !empty( $filePath['erorr'] ) )
						{
							echo json_encode( array ( "code" => 403, 'message' => $filePath['error'] ) );
						}

						if ( sizeof( $filePath ) > 1 ) 
						{
							$paths = implode('|', $filePath);
						}
						else
						{
							$paths = $filePath[0];
						}
					}
					else
					{
						$paths = NULL;
					}
				}
				else
				{
					$paths = NULL;
				}
				
				// $this->debug( $paths );
				

				$token = getTokenData('token');

				$newProductData = array (
					'table'		=>	'product',
					'record'	=>	array (
						'PRODUCT_TYPE_ID'			=>	$data['productType'],
						'PRODUCT_CONDITION_ID'		=>	$data['productCondition'],
						'PRODUCT_NAME'				=>	$data['productname'],
						'PRODUCT_ACTUAL_PRICE'		=>	$data['productActualPrice'],
						'DESCRIPTION'				=>	$data['Description'],
						'PRODUCT_GROSS_WEIGHT'		=>	$data['productweight'],
						'PRODUCT_NET_WEIGHT'		=>	$data['productNetWeight'],
						'PRODUCT_DIMENSION'			=>	$data['productdimension'],
						'PRODUCT_IMAGE'				=>	$paths,
						'CLUB_NUMBER'				=>	$data['clubNumber'],
						'SHIPPER_NAME'				=>	$data['shipperName'],
						'SHIPPER_ADDRESS'			=>	$data['shipperaddress'],
						'SHIPPER_E_ADDRESS'			=>	$data['shipperEmailAddress'],
						'SHIPPER_PHONE'				=>	$data['shipperPhone'],
						'SHIPPER_ZIP_CODE'			=>	$data['shipperzipcode'],
						'SHIPPER_COUNTRY_ID'		=>	$data['shipperCountryId'],
						'SHIPPER_STATE_ID'			=>	$data['shipperStateId'],
						'SHIPPER_CITY_ID'			=>	$data['shipperCityId'],
						'CONSIGNEE_NAME'			=>	$data['consigneername'],
						'CONSIGNEE_PHONE_NUMBER'	=>	$data['consigneephone'],
						'CONSIGNEE_ZIP_CODE'		=>	$data['consigneezipcode'],
						'CONSIGNEE_COUNTRY_ID'		=>	$data['consigneeCountryId'],
						'CONSIGNEE_STATE_ID'		=>	$data['consigneeStateId'],
						'CONSIGNEE_CITY_ID'			=>	$data['consigneeCityId'],
						'CONSIGNEE_COUNTRY_ID'		=>	$data['consigneeCountryId'],
						'CONSIGNEE_STATE_ID'		=>	$data['consigneeStateId'],
						'CONSIGNEE_CITY_ID'			=>	$data['consigneeCityId'],
						'CONSIGNEE_ADDRESS'			=>	$data['consigneeaddress'],
						'CONSIGNEE_E_ADDRESS'		=>	$data['consigneeEmailAddress'],
						'CN_NUMBER'					=>	$data['cn_number'],
						'MAB_NUMBER'				=>	$data['mabNumber'],
						'BAG_NUMBER'				=>	$data['bagNumber'],
						'FORM_E_NUMBER'				=>	$data['formE'],
						'EORI_NUMBER'				=>	$data['eoriNumber'],
						'VAT_NUMBER'				=>	$data['vatNumber'],
						'CONSIGNEE_AMOUNT'			=>	$data['receivedamount'],
						'BALANCE_AMOUNT'			=>	$data['balanceamount'],
						'QUANTITY'					=>	$data['noofpieces'],
						'EXT_TRACKING_NUMBER'		=>	$data['exttrackingno'],
						'TRACKING_STATUS'			=>	$data['trackingStatus'],
						'PRODUCT_STATUS'			=>	$data['productStatus'],
						'U_USER_ID'					=>	$token['id'],
						'CLIENT_ID'					=>	$data['client'],
						'U_DATE_TIME'				=>	getDateOffset()
					),
					'condition'		=>	array(
						'PRODUCT_ID'	=>	$data['productId']
					)
				);

				$newClientData = array (
					'table'		=>	'payment',
					'record'	=>	array (
						'CLIENT_ID'	=>	$data['client'],
					),
					'condition'		=>	array(
					'PRODUCT_ID'	=>	$data['productId']
					)
				); 
				$this->common->updateRecord( $newClientData);


				if ( $this->common->updateRecord( $newProductData ) ) 
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

	public function DeleteProduct()
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
				if ( isset ( $data['productId'] ) ) 
				{
					$productData = array (
						'condition'		=>	array(
							'PRODUCT_ID'	=>	$data['productId']
						),
						'table'			=>	'product'
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

	public function ViewInvoiceSlip( $CNNumber )
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) && !empty( $this->tokenData['role_id'] ) ) 
		{
			$productTable = array(
				'select'			=> 	'	p.CN_NUMBER, 
											p.PRODUCT_NAME AS ORDER_NAME,
											p.PRODUCT_GROSS_WEIGHT,
											p.PRODUCT_NET_WEIGHT,
											p.SHIPPER_NAME,
											p.SHIPPER_ADDRESS,
											p.SHIPPER_PHONE,
											p.CONSIGNEE_NAME,
											p.CONSIGNEE_ADDRESS,
											p.CONSIGNEE_PHONE_NUMBER,
											p.DESCRIPTION,
											pm.PRODUCT_NAME AS PRODUCT_NAME,
											pm.PRODUCT_QUANTITY AS QUANTITY,
											pm.PRODUCT_PRICE AS PRICE,
											p.E_DATE_TIME',
				'table'				=> 	'`product` AS p',
				'order_attribute'	=>	'p.E_DATE_TIME',
				'order_by'			=>	'ASC',
				'join'				=>	array(
					'joined_table'		=>	'product_multiple AS pm ',
					'joined_condition'	=>	'p.CN_NUMBER = pm.PRODUCT_CN_NUMBER'
				),
				'condition'			=>	array(
					"p.CN_NUMBER"	=>	$CNNumber
				)
			);

			$productData = $this->common->getRecord($productTable);
			
			$data = array(
				'productRecord'		=>	$productData,
				'pageTitle'			=>	'Invoice Slip'
			);
			$this->load->view('products/reports/partial_views/_header_vw', $data);
			$this->load->view('products/reports/invoice_slip_vw', $data);
			$this->load->view('products/reports/partial_views/_footer_vw');
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}


	public function ViewCNSlip( $productId )
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) && !empty( $this->tokenData['role_id'] ) ) 
		{

			$query = "	SELECT 
						p.PRODUCT_ID, 
				        p.PRODUCT_CONDITION_ID,
				        p.PRODUCT_NAME,
				        p.PRODUCT_GROSS_WEIGHT,
				        p.PRODUCT_NET_WEIGHT,
				        p.PRODUCT_DIMENSION,
				        p.SHIPPER_NAME,
				        p.SHIPPER_E_ADDRESS,
				        p.SHIPPER_ADDRESS,
				        p.SHIPPER_PHONE,
				        p.SHIPPER_COUNTRY_ID,
				        p.SHIPPER_STATE_ID,
				        p.SHIPPER_CITY_ID,
				        p.CONSIGNEE_COUNTRY_ID,
				        p.CONSIGNEE_STATE_ID,
				        p.CONSIGNEE_CITY_ID,
				        p.CLUB_NUMBER,
				        p.DESCRIPTION,
				        p.QUANTITY,
				        p.CONSIGNEE_AMOUNT,
				        p.BALANCE_AMOUNT,
				        p.CN_NUMBER,
				        p.CONSIGNEE_NAME,
				        p.CONSIGNEE_ADDRESS,
				        p.CONSIGNEE_ZIP_CODE,
				        p.CONSIGNEE_PHONE_NUMBER,
				        p.QUANTITY,
				        pc.PRODUCT_CONDITION_ID, 
				        pc.PRODUCT_CONDITION,
				        c.COUNTRY_ID,
				        c.COUNTRY AS SHIPPER_COUNTRY,
				        c2.COUNTRY_ID,
				        c2.COUNTRY AS CONSIGNEE_COUNTRY,
				        st.STATE_ID,
				        st.STATE AS SHIPPER_STATE,
				        st2.STATE_ID,
				        st2.STATE AS CONSIGNEE_STATE,
				        ct.CITY_ID,
				        ct.CITY AS SHIPPER_CITY,
				        ct2.CITY_ID,
				        ct2.CITY AS CONSIGNEE_CITY,
				        us.FULL_NAME AS GENERATED_BY,
				        usg.FULL_NAME AS UPDATED_BY
				        
						FROM product AS p
						INNER JOIN 
						product_condition AS pc
						ON
						p.PRODUCT_CONDITION_ID = pc.PRODUCT_CONDITION_ID
						INNER JOIN
						country AS c
						ON
						p.SHIPPER_COUNTRY_ID = c.COUNTRY_ID
						INNER JOIN
						state AS st
						ON
						p.SHIPPER_STATE_ID = st.STATE_ID
						INNER JOIN
						city AS ct
						ON
						p.SHIPPER_CITY_ID = ct.CITY_ID
				        INNER JOIN
						country AS c2
						ON
						p.CONSIGNEE_COUNTRY_ID = c2.COUNTRY_ID
				        INNER JOIN
						state AS st2
						ON
						p.CONSIGNEE_STATE_ID = st2.STATE_ID
						
				        INNER JOIN
						city AS ct2
						ON
						p.CONSIGNEE_CITY_ID = ct2.CITY_ID
						
						LEFT JOIN
						users as us
						ON
						p.E_USER_ID = us.USER_ID
						
						LEFT JOIN
						users as usg
						ON
						p.U_USER_ID = usg.USER_ID
						
						WHERE
						p.PRODUCT_ID = " . $productId;

			$productData = $this->common->getRecordByCustomQuery($query)[0];

			$updateEditButtonStatus = array(
				'table' 	=> 'product',
				'record' 	=> array(
					'EDIT_BUTTON_STATUS' => 0
				),
				'condition' => array(
					'PRODUCT_ID' => $productId
				)
			);

			$this->common->updateRecord( $updateEditButtonStatus );
			
			// $this->debug( $productData );

			$totalPrice = $productData['QUANTITY'] * $productData['CONSIGNEE_AMOUNT'];

			$data = array(
				'productRecord'		=>	$productData,
				'totalPrice'		=>	$totalPrice,
				'pageTitle'			=>	'CN Slip'
			);
			$this->load->view('products/reports/partial_views/_header_vw', $data);
			$this->load->view('products/reports/cn_slip_vw', $data);
			$this->load->view('products/reports/partial_views/_footer_vw');
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function ViewProhibitedItems( $productId )
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) && !empty( $this->tokenData['role_id'] ) ) 
		{
			$productTable = array(
				'select'			=> 	'*',
				'table'				=> 	'product',
				'order_attribute'	=>	'E_DATE_TIME',
				'order_by'			=>	'ASC',
				'condition'			=>	array(
					"PRODUCT_ID"	=>	$productId
				)
			);

			$productData = $this->common->getRecord($productTable)[0];

			$totalPrice = $productData['QUANTITY'] * $productData['BALANCE_AMOUNT'];

			$data = array(
				'productRecord'		=>	$productData,
				'totalPrice'		=>	$totalPrice,
				'pageTitle'			=>	'Prohibited Items Slip'
			);
			$this->load->view('products/reports/partial_views/_header_vw', $data);
			$this->load->view('products/reports/prohibited_items_vw', $data);
			$this->load->view('products/reports/partial_views/_footer_vw');
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function ViewFragileGoods( $productId )
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) && !empty( $this->tokenData['role_id'] ) ) 
		{
			$productTable = array(
				'select'			=> 	'*',
				'table'				=> 	'product',
				'order_attribute'	=>	'E_DATE_TIME',
				'order_by'			=>	'ASC',
				'condition'			=>	array(
					"PRODUCT_ID"	=>	$productId
				)
			);

			$productData = $this->common->getRecord($productTable)[0];
			
			$productDate = date('Y/m/d', strtotime( $productData['E_DATE_TIME'] ) ) ;
			
			$data = array(
				'productRecord'		=>	$productData,
				'pageTitle'			=>	'Fragile Goods Slip',
				'productDate'		=>	$productDate
			);
			$this->load->view('products/reports/partial_views/_header_vw', $data);
			$this->load->view('products/reports/fragile_goods_vw', $data);
			$this->load->view('products/reports/partial_views/_footer_vw');
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}
	public function ViewCommercialInvoice( $CNNumber  )
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) && !empty( $this->tokenData['role_id'] ) ) 
		{
			$productTable = array(
				'select'			=> 	'	p.CN_NUMBER, 
											p.PRODUCT_NAME AS ORDER_NAME,
											p.PRODUCT_GROSS_WEIGHT,
											p.PRODUCT_NET_WEIGHT,
											p.SHIPPER_NAME,
											p.SHIPPER_ADDRESS,
											p.SHIPPER_PHONE,
											p.CONSIGNEE_NAME,
											p.CONSIGNEE_ADDRESS,
											p.CONSIGNEE_PHONE_NUMBER,
											p.DESCRIPTION,
											p.VAT_NUMBER,
											p.EORI_NUMBER,
											p.FORM_E_NUMBER,
											pm.PRODUCT_NAME AS PRODUCT_NAME,
											pm.PRODUCT_QUANTITY AS QUANTITY,
											pm.PRODUCT_PRICE AS PRICE,
											p.E_DATE_TIME',
				'table'				=> 	'`product` AS p',
				'order_attribute'	=>	'p.E_DATE_TIME',
				'order_by'			=>	'ASC',
				'join'				=>	array(
					'joined_table'		=>	'product_multiple AS pm ',
					'joined_condition'	=>	'p.CN_NUMBER = pm.PRODUCT_CN_NUMBER'
				),
				'condition'			=>	array(
					"p.CN_NUMBER"	=>	$CNNumber
				)
			);

			$productData = $this->common->getRecord($productTable);
			
			$data = array(
				'productRecord'		=>	$productData,
				'pageTitle'			=>	'Commerical Invoice Slip'
			);
			$this->load->view('products/reports/partial_views/_header_vw', $data);
			$this->load->view('products/reports/invoice_slip_commercial_vw', $data);
			$this->load->view('products/reports/partial_views/_footer_vw');
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} 
	}

	public function ViewInvoiceTerms( $productId )
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) && !empty( $this->tokenData['role_id'] ) ) 
		{
			$productTable = array(
				'select'			=> 	'*',
				'table'				=> 	'product',
				'order_attribute'	=>	'E_DATE_TIME',
				'order_by'			=>	'ASC',
				'join'				=>	array(
					'joined_table'		=>	'tracking_status',
					'joined_condition'	=>	'product.TRACKING_STATUS = tracking_status.TRACKING_ID'
				),
				'condition'			=>	array(
					"PRODUCT_ID"	=>	$productId
				)
			);

			$productData = $this->common->getRecord($productTable)[0];


			$totalPrice = $productData['QUANTITY'] * $productData['PRODUCT_ACTUAL_PRICE'];

			$data = array(
				'productRecord'		=>	$productData,
				'totalPrice'		=>	$totalPrice,
				'pageTitle'			=>	'Product Invoice Terms'
			);
			$this->load->view('products/reports/partial_views/_header_vw', $data);
			$this->load->view('products/reports/terms_vw', $data);
			$this->load->view('products/reports/partial_views/_footer_vw');
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function clientAutoFill()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) && !empty( $this->tokenData['role_id'] ) ) 
		{
			$id = $this->uri->segment(4);

				$data = array(
					'select'		=>	'*',
					'table' 		=>	'client',
					'condition'		=>	array(
					'CLIENT_ID'	    =>	$id
					)
				);
				echo json_encode( array( "code" => SUCCESS, 'record' => $this->common->getRecord( $data )[0]) );
			}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} 
	}
	
}