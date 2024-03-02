<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Muhammad Kashif
	Controller 	: Accounts
	Date 		: 26/8/2023
*/

class PrvController extends MX_Controller 
{
	public function __construct() 
	{
		parent::__construct();

		$this->load->model('Prv_mdl', 'prv');
		$this->load->library('Pagination');
		ini_set('memory_limit', '-1');
	}

	public function index()
	{
	    $roleId = $this->tokenData['role_id'];
	    
		if ( $this->common->checkUserRole( $roleId ) ) 
		{
			$parent_menu = $this->getMenu;
			if( $roleId != 1 ) 
			{
				$prvTable = array(
					'select'			=> 	'*',
					'table'				=> 	'payment_receipt_voucher',
					'order_attribute'	=>	'E_DATE_TIME',
					'order_by'			=>	'DESC',
					'condition'			=>	array(
						'payment_receipt_voucher.E_USER_ID'		=>	getTokenData('token')['id']
					)				

				);
			}
			else
			{
				$prvTable = array(
					'select'			=> 	'*',
					'table'				=> 	'payment_receipt_voucher',
					'order_attribute'	=>	'E_DATE_TIME',
					'order_by'			=>	'DESC'
				);
			}
			// to get data in dropdown	// 
			$data = array(
				"links"				=>	array(
					"show_menu"		=> 	$parent_menu
				),
				"headerData"		=>	array(
					"companyName"	=>	'FTE',
					"pageName"		=>	'Payment Received Voucher'
				),
				"token"				=>	getTokenData('token'),
				"prv"			=>	$this->common->getRecord( $prvTable ),				
				"filepath"			=>	'prv/prv.js'
			);

			

			$this->load->view('common/header', $data);
			$this->load->view('common/sidebar', $data);
			$this->load->view('accounts/prv_vw', $data);
			$this->load->view('common/footer', $data);
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
			redirect(base_url());
		} // end of Role validation
	}

	public function AddPrv()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			extract($_POST);
			
			// $this->debug( $_POST );

			$token = getTokenData('token');

			$config = 	array 
						(
				        	array 
				        	(
				            	'field' => 'receivedFrom',
				                'label' => 'Received From',
				                'rules' => 'required',
				                'errors' => array (
				                	'required' => 'You must provide a %s'
			                	)
			        		),
			        		array 
				        	(
				            	'field' => 'receivedAmount',
				                'label' => 'Received Amount',
				                'rules' => 'required',
				                'errors' => array (
				                	'required' => 'You must provide a %s'
			                	)
							),
							array 
				        	(
				            	'field' => 'prvType',
				                'label' => 'PRV Type',
				                'rules' => 'required',
				                'errors' => array (
				                	'required' => 'You must provide a %s'
			                	)
							),
							array 
				        	(
				            	'field' => 'accountOf',
				                'label' => 'Account Of',
				                'rules' => 'required',
				                'errors' => array (
				                	'required' => 'You must provide a %s'
			                	)
							),
						);
			$this->form_validation->set_rules($config);
			
			if ( $this->form_validation->run() == FALSE )
            {
                echo json_encode( array ( 'code' => '403', 'message' => strip_tags ( validation_errors() ) ) );
            }
            else
            {	
						
				$data = array(
					'STATION_NAME'			=>	$token['station_name'],
					'RECEIVED_FROM	'			=>	$_POST['receivedFrom'],
					'RECEIVED_AMOUNT	'			=>	$_POST['receivedAmount'],
					'PRV_TYPE	'			=>	$_POST['prvType'],
					'ACCOUNT_OF	'			=>	$_POST['accountOf'],					
					'E_USER_ID'					=>	$token['id'],
					'E_DATE_TIME'				=>	getDateOffset()
				);	

	   				// to cretae a record and return last id 
				 	$result = $this->common->createRecords( $data, 'payment_receipt_voucher');
				if ( !empty ($result) )
				{
					echo json_encode( array ( "code" => 200, 'message' => 'Record inserted successfully' ) );
				}
				else
				{
					echo json_encode( array ( "code" => 403, 'message' => 'There is some error while entering data' ) );
				}				
			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function getPrvPagination( $page ) 
	{

		// $this->debug( getTokenData('token')['id'] );
		$roleId = $this->tokenData['role_id'];

		if ( isset( $_POST['prv_id'] ) ) 
		{
			$prvNumber = $_POST['prv_id'];
		}
		
		if( $roleId == 1 ) 
		{
			$prvTable = array(
				'select'			=>	'*',
				'table'	 			=>	'payment_receipt_voucher',
				'order_attribute' 	=>  'payment_receipt_voucher.E_DATE_TIME',
				'order_by' 			=>  'DESC'						
			);
		}
		else
		{
			$prvTable = array(
				'select'			=>	'*',
				'table'	 			=>	'payment_receipt_voucher',
				'order_attribute' 	=>  'payment_receipt_voucher.E_DATE_TIME',
				'order_by' 			=>  'DESC',
				'condition'			=>	array(
					'payment_receipt_voucher.E_USER_ID'		=>	getTokenData('token')['id']
				)						
			);
		}
		
    		


		if ( !empty( $prvNumber ) ) 
		{
			$prvTable['condition'] = array(
				'PRV_ID' => $prvNumber
			);
		}
		
		$prv = $this->common->getRecord( $prvTable );
		
		if ( !empty( $prv ) ) 
		{
			$total_menu = count($prv);
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
		
		
		if( $roleId == 1 )
    	{
			$paginationData = array(
				'db'		=>	array(
					'select' => '*',
					'limit'	 =>	$config['per_page'],
					'start'	 =>	$start,
					'table'	 =>	'payment_receipt_voucher',
					'order_attribute' 	=> 'E_DATE_TIME',
					'order_by' 			=> 'DESC'  					
				),

				'userData' => array(
					'userId' => getTokenData('token')['id']
				)
			);
		}
		else {
			$paginationData = array(
				'db'		=>	array(
					'select' => '*',
					'limit'	 =>	$config['per_page'],
					'start'	 =>	$start,
					'table'	 =>	'payment_receipt_voucher',
					'order_attribute' 	=> 'E_DATE_TIME',
					'order_by' 			=> 'DESC'  ,
					'condition'			=>	array(
						'payment_receipt_voucher.STATION_NAME'		=>	getTokenData('token')['station_name']
					)   					
				),
				'userData' => array(
					'userId' => getTokenData('token')['id']
				)
			);
		}
		

		if ( !empty( $prvNumber ) ) 
		{
			$paginationData['db']['condition'] = array(
				'PRV_ID' => $prvNumber
			);
		}


		$output = array(
			"PrvPaginationLink"	=>	$this->pagination->create_links(),
			"PrvList"		=>	$this->prv->prvPagination( $paginationData )
		);

		echo json_encode($output);

	}

	public function GetPrvData()
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
				$prvTable = array(
					'select'			=> 	'*',
					'table'				=> 	'payment_receipt_voucher',
					'condition'			=>	array(
						'PRV_ID'	=>	$data['prv_id']
					),
					'order_attribute'	=>	'E_DATE_TIME',
					'order_by'			=>	'ASC'					
				);

				echo json_encode( array( 'code' => SUCCESS, 'prvData' => $this->common->getRecord( $prvTable )[0] ) );
			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function UpdatePrv()
	{

		header('Content-Type: application/json');


		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{

		    if($this->input->method(true) != 'POST')
		    {
		    	echo json_encode( array ( "code" => 403, 'message' => $this->msg['general_msg']['post_data_error'] ) );
		    }
		    else
			{

				$token = getTokenData('token');

				$updatePrvData = array (
					'table'		=>	'payment_receipt_voucher',
					'record'	=>	array (						
						'RECEIVED_FROM'		=>	$_POST['receivedFrom'],
						'RECEIVED_AMOUNT'	=>	$_POST['receivedAmount'],
						'PRV_TYPE'			=>	$_POST['prvType'],
						'ACCOUNT_OF'		=>	$_POST['accountOf'],
						'U_USER_ID'			=>	$token['id'],
						'U_DATE_TIME'		=>	getDateOffset()
					),
					'condition'		=>	array(
						'PRV_ID'	=>	$_POST['prvId']
					)
				);

				$result = $this->common->updateRecord( $updatePrvData );
				
				if ( !empty ($result) ) 
				{
					echo json_encode( array ( "code" => 200, 'message' => 'Record update successfully' ) );
				}
				else
				{
					echo json_encode( array ( "code" => 200, 'message' => 'Some error successfully' ) );
				}
			}

		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function DeletePrv()
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
				if ( isset ( $data['prvId'] ) ) 
				{
					$prvData = array (
						'condition'		=>	array(
							'PRV_ID'	=>	$data['prvId']
						),
						'table'			=>	'payment_receipt_voucher'
					);

					$result = $this->common->deleteRecord( $prvData );
				
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

	public function ViewPrvReport( $prvtId )
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) && !empty( $this->tokenData['role_id'] ) ) 
		{

			$query = "	SELECT 
						prv.*, us.FULL_NAME as created_by, usg.FULL_NAME as updated_by
						FROM payment_receipt_voucher as prv
						LEFT JOIN
						users as us
						ON
						prv.E_USER_ID = us.USER_ID
						
						LEFT JOIN
						users as usg
						ON
						prv.U_USER_ID = usg.USER_ID
						WHERE
						prv.PRV_ID = " . $prvtId;

			$prvData = $this->common->getRecordByCustomQuery($query)[0];
			$data = array(
				'prvRecord'		=>	$prvData,
				'pageTitle'			=>	'PAYMENT RECEIPT VOUCHER'
			);
			$this->load->view('accounts/reports/partial_views/_header_vw', $data);
			$this->load->view('accounts/reports/prv_report_vw', $data);
			$this->load->view('accounts/reports/partial_views/_footer_vw');
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function PrvDetailView(){
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$parent_menu = $this->getMenu;
			
			$tokenData = getTokenData('token');

			
			
			$data = array(
				"links"				=>	array(
					"show_menu"		=> 	$parent_menu
				),
				"headerData"		=>	array(
					"companyName"	=>	'FTE',
					"pageName"		=>	'Product Manifest'
				),
				"users"				=>	$this->prv->getUsersDistinctData(),
				"token"				=>	$tokenData,
				"filepath"			=>	'product_manifest/product_manifest.js',
				'userId' 			=> getTokenData('token')['id'],
				'station_name' 			=> getTokenData('token')['station_name'],
			);

			$this->load->view('common/header', $data);
			$this->load->view('common/sidebar', $data);
			$this->load->view('accounts/prv_detail_vw', $data);
			$this->load->view('common/footer', $data);
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function GeneratePrvDetailReport()
	{	
		$tokenData = getTokenData('token');

		if ( !empty ( $_POST['prv_id'] ) ) 
		{
			$prv_number = ' AND PRV_ID = "' . $_POST['prv_id'] . '"';
		}
		else
		{
			$prv_number = '';
		}

		if( $tokenData['role_id'] == 1 )
    	{
			if( !empty( $_POST['station'] ) ) 
			{
				$station_name = ' AND STATION_NAME = "' . $_POST['station']. '"';
			}
			else
			{
				$station_name = '';
			}
		}
		else
		{
			$station_name = ' AND STATION_NAME = "' . $tokenData['station_name']. '"';
		}

		if ( !empty ( $_POST ['fromDate'] ) ) 
		{
			$fromDate = getDateForDatabase ( $_POST ['fromDate'] );
		}
		else
		{
			$fromDate = '';
		}

		if ( !empty ( $_POST ['toDate'] ) ) 
		{   
			$toDate = getDateForDatabase ( $_POST ['toDate'] );
		}
		else
		{
			$toDate = '';
		}

		// FROM DATE
		if ( !empty ( $fromDate ) && !empty ( $toDate ) ) 
		{
			$fromDate = getDateForDatabase( $fromDate );


			$toFromDate = " AND ( E_DATE_TIME >  '{$fromDate} 00:00:00' AND E_DATE_TIME < DATE_ADD( '{$toDate} 23:59:59', INTERVAL 5 HOUR) )"; 
		}
		else
		{
			$toFromDate = '';
			$fromDate = '';
			$toDate = '';
		}

		
		$query = "
			SELECT 
			*
			FROM 
			payment_receipt_voucher
			where E_USER_ID  != ''
			" .
			$prv_number . 
			$station_name .
			$toFromDate;
    
    
            
			$data['result'] = $this->common->getRecordByCustomQuery( $query );

			if ( !empty ( $data['result']) ){
				$this->load->view('accounts/reports/prv_listing_report_vw', $data );
			}
			else 
			{
				echo json_encode ( 
					array 
					(
						'code'	=>	403,
						'message' => 'No record found'
					)
				);
			}

	}

	
	
}