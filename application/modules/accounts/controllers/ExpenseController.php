<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Muhammad Kashif
	Controller 	: Accounts
	Date 		: 26/8/2023
*/

class ExpenseController extends MX_Controller 
{
	public function __construct() 
	{
		parent::__construct();

		$this->load->model('Expense_mdl', 'expense');
		$this->load->library('Pagination');
		ini_set('memory_limit', '-1');
	}

	public function index()
	{
	    $roleId = $this->tokenData['role_id'];
	    
		if ( $this->common->checkUserRole( $roleId ) ) 
		{
			$parent_menu = $this->getMenu;

			$expenseTable = array(
				'select'			=> 	'*',
				'table'				=> 	'expense',
				'order_attribute'	=>	'E_DATE_TIME',
				'order_by'			=>	'ASC'
				

			);
			// to get data in dropdown	// 
			$data = array(
				"links"				=>	array(
					"show_menu"		=> 	$parent_menu
				),
				"headerData"		=>	array(
					"companyName"	=>	'FTE',
					"pageName"		=>	'Expense'
				),
				"token"				=>	getTokenData('token'),
				"expense"			=>	$this->common->getRecord( $expenseTable ),				
				"filepath"			=>	'expense/expense.js'
			);

			

			$this->load->view('common/header', $data);
			$this->load->view('common/sidebar', $data);
			$this->load->view('accounts/expense_vw', $data);
			$this->load->view('common/footer', $data);
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
			redirect(base_url());
		} // end of Role validation
	}

	public function AddExpense()
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
				            	'field' => 'expenseAmount',
				                'label' => 'Expense Amount',
				                'rules' => 'required',
				                'errors' => array (
				                	'required' => 'You must provide a %s'
			                	)
			        		),
			        		array 
				        	(
				            	'field' => 'expenseType',
				                'label' => 'Expense Type',
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
					'EXPENSE_AMOUNT'			=>	$_POST['expenseAmount'],
					'EXPENSE_TYPE'			=>	$_POST['expenseType'],
										
					'E_USER_ID'					=>	$token['id'],
					'E_DATE_TIME'				=>	getDateOffset()
				);	

	   				// to cretae a record and return last id 
				 	$result = $this->common->createRecords( $data, 'expense');
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

	public function getExpensePagination( $page ) 
	{

		// $this->debug( getTokenData('token')['id'] );
		$roleId = $this->tokenData['role_id'];

		if ( isset( $_POST['expense_id'] ) ) 
		{
			$expenseNumber = $_POST['expense_id'];
		}
		
		
		$expenseTable = array(
						'select'			=>	'*',
						'table'	 			=>	'expense',
						'order_attribute' 	=>  'expense.E_DATE_TIME',
						'order_by' 			=>  'DESC'							
					);
		
    		


		if ( !empty( $expenseNumber ) ) 
		{
			$expenseTable['condition'] = array(
				'EXPENSE_ID' => $expenseNumber
			);
		}
		
		$expense = $this->common->getRecord( $expenseTable );
		
		if ( !empty( $expense ) ) 
		{
			$total_menu = count($expense);
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
					'table'	 =>	'expense',
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
					'table'	 =>	'expense',
					'order_attribute' 	=> 'E_DATE_TIME',
					'order_by' 			=> 'DESC'  ,
					'condition'			=>	array(
						'expense.STATION_NAME'		=>	getTokenData('token')['station_name']
					)   					
				),
				'userData' => array(
					'userId' => getTokenData('token')['id']
				)
			);
		}
		

		if ( !empty( $expenseNumber ) ) 
		{
			$paginationData['db']['condition'] = array(
				'EXPENSE_ID' => $expenseNumber
			);
		}


		$output = array(
			"ExpensePaginationLink"	=>	$this->pagination->create_links(),
			"ExpenseList"		=>	$this->expense->expensePagination( $paginationData )
		);

		echo json_encode($output);

	}

	public function GetExpenseData()
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
				$expenseTable = array(
					'select'			=> 	'*',
					'table'				=> 	'expense',
					'condition'			=>	array(
						'EXPENSE_ID'	=>	$data['expense_id']
					),
					'order_attribute'	=>	'E_DATE_TIME',
					'order_by'			=>	'ASC'					
				);

				echo json_encode( array( 'code' => SUCCESS, 'expenseData' => $this->common->getRecord( $expenseTable )[0] ) );
			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function UpdateExpense()
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

				$updateExpenseData = array (
					'table'		=>	'expense',
					'record'	=>	array (						
						'EXPENSE_AMOUNT'		=>	$_POST['expenseAmount'],
						'EXPENSE_TYPE'	=>	$_POST['expenseType'],
						'U_USER_ID'			=>	$token['id'],
						'U_DATE_TIME'		=>	getDateOffset()
					),
					'condition'		=>	array(
						'EXPENSE_ID'	=>	$_POST['expenseId']
					)
				);

				$result = $this->common->updateRecord( $updateExpenseData );
				
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

	public function DeleteExpense()
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
				if ( isset ( $data['expenseId'] ) ) 
				{
					$expenseData = array (
						'condition'		=>	array(
							'EXPENSE_ID'	=>	$data['expenseId']
						),
						'table'			=>	'expense'
					);

					$result = $this->common->deleteRecord( $expenseData );
				
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

	public function ViewExpenseReport( $expensetId )
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) && !empty( $this->tokenData['role_id'] ) ) 
		{

			$query = "	SELECT 
						expense.*, us.FULL_NAME as created_by, usg.FULL_NAME as updated_by
						FROM expense as expense
						LEFT JOIN
						users as us
						ON
						expense.E_USER_ID = us.USER_ID
						
						LEFT JOIN
						users as usg
						ON
						expense.U_USER_ID = usg.USER_ID
						WHERE
						expense.EXPENSE_ID = " . $expensetId;

			$expenseData = $this->common->getRecordByCustomQuery($query)[0];
			$data = array(
				'expenseRecord'		=>	$expenseData,
				'pageTitle'			=>	'PAYMENT RECEIPT VOUCHER'
			);
			$this->load->view('accounts/reports/partial_views/_header_vw', $data);
			$this->load->view('accounts/reports/expense_report_vw', $data);
			$this->load->view('accounts/reports/partial_views/_footer_vw');
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function ExpenseDetailView(){
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
				"users"				=>	$this->expense->getUsersDistinctData(),
				"token"				=>	$tokenData,
				"filepath"			=>	'product_manifest/product_manifest.js',
				'userId' 			=> getTokenData('token')['id'],
				'station_name' 			=> getTokenData('token')['station_name'],
			);

			$this->load->view('common/header', $data);
			$this->load->view('common/sidebar', $data);
			$this->load->view('accounts/expense_detail_vw', $data);
			$this->load->view('common/footer', $data);
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function GenerateExpenseDetailReport()
	{	
		$tokenData = getTokenData('token');

		if ( !empty ( $_POST['expense_id'] ) ) 
		{
			$expense_number = ' AND EXPENSE_ID = "' . $_POST['expense_id'] . '"';
		}
		else
		{
			$expense_number = '';
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
			expense
			where E_USER_ID  != ''
			" .
			$expense_number . 
			$station_name .
			$toFromDate;
    
    
            
			$data['result'] = $this->common->getRecordByCustomQuery( $query );

			if ( !empty ( $data['result']) ){
				$this->load->view('accounts/reports/expense_listing_report_vw', $data );
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