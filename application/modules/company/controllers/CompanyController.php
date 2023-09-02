<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: login
	Date 		: 02/10/2018
*/

class CompanyController extends MX_Controller 
{
	public function __construct() 
	{
		parent::__construct();

		$this->load->model('company/Company_mdl', 'company');
		$this->load->library('Pagination');

	}
	public function index()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$parent_menu = $this->getMenu;

			$countryDb = array(
				'select'	=>	'`COUNTRY_ID`, `COUNTRY`',
				'table'		=>	'country'
			);

			$stateDb = array(
				'select'	=>	'`STATE_ID`, `STATE`, `COUNTRY_ID`, `STATUS`',
				'table'		=>	'state'
			);

			
			$data = array(
				"links"				=>	array(
					"show_menu"		=> 	$parent_menu
				),
				"headerData"		=>	array(
					"companyName"	=>	'FTE',
					"pageName"		=>	'Company'
				),
				"token"				=>	getTokenData('token'),
				"filepath"			=>	'company/company.js'

			);

			$this->load->view('common/header', $data);
			$this->load->view('common/sidebar', $data);
			$this->load->view('company/Company_vw', $data);
			$this->load->view('common/footer', $data);
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
			redirect(base_url());
		} // end of Role validation
	}

	public function AddCompany() 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			
			$config = 	array 
						(
				        	array 
				        	(
				            	'field' => 'companyName',
				                'label' => 'Company Name',
				                'rules' => 'required',
				                'errors' => array (
				                	'required' => 'You must provide a %s'
			                	)
			        		),
			        		array 
				        	(
				            	'field' => 'companyWebURL',
				                'label' => 'Company Web URL',
				                'rules' => 'required',
				                'errors' => array (
				                	'required' => 'You must provide a %s'
			                	)
			        		)
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
	        	$dbData = array (
							"COMPANY_NAME"		=>	$this->input->post('companyName'),
							"COMPANY_WEB_URL"	=>	$this->input->post('companyWebURL'),
							"E_USER_ID"			=>	$this->tokenData['id'],
							"E_DATE_TIME"		=>	getDateOffset()
						);

	        	// $this->debug( $dbData );

				if ( $this->common->createRecord( $dbData, 'company' ) )
				{
					echo json_encode(
										array
										(
												"code" => SUCCESS, 
												'message' => $this->msg['success_msg']['create']
										)
									);
				}
				else
				{
					echo json_encode(
										array
										(
											"code" => BAD_DATA, 
											'message' => $this->msg['error_msg']['create']
										)
									);
				}
	        } // end of if condition
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function UpdateCompany() 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
		    // $this->debug( $_POST );

			$updateData = array(
				'table' 		=>	'company',
				'condition'		=>	array(
					'COMPANY_ID'	=>	$_POST['companyId']	
				),
				'record'		=>	array(
					'COMPANY_NAME'		=>	$_POST['companyName'],
					'COMPANY_WEB_URL'	=>  $_POST['companyWebUrl'], 
					'U_USER_ID'			=>	$this->tokenData['id'],
					'U_DATE_TIME'		=>	getDateOffset()
				)
			);
		    if ( $this->common->updateRecord($updateData) )
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
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function DeleteCompany() 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			
			$data = json_decode(file_get_contents('php://input'), TRUE);

			if ( !empty( $data['id'] ) ) 
			{
				$data = array(
					'table' 		=>	'company',
					'condition'		=>	array(
						'COMPANY_ID'	=>	$data['id']
					)
				);
				$result = $this->common->deleteRecord( $data );
				
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
				echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['general_msg']['input_error']) );
			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	// Pagination
	public function GetCompanyPagination ( $page ) 
	{
		$companyDbData = array(
							'select'			=>	'*',
							'table'				=>	'company',
							'order_attribute' 	=> 	'COMPANY_NAME',
							'order_by'			=>	'ASC'
						);

		$company = $this->common->getRecord( $companyDbData );

		$total = count($company);

		$config = array(
			"base_url"			=>	"#",
			"attributes"		=> 	array('class' => 'page-link'),
			"total_rows"		=>	$total,
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
		
		$paginationData = array(
			'db'		=>	array(
				'limit'	=>	$config['per_page'],
				'start'	=>	$start,
				'table'	=>	'company'
			),
			
		);

		$output = array(
			"companyPaginationLink"		=>	$this->pagination->create_links(),
			"CompanyList"				=>	$this->company->companyPagination( $paginationData )
		);

		// $this->debug( $output );

		echo json_encode($output);
	}

	public function GetCompanyData()
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
					'table'				=> 	'company',
					'condition'			=>	array(
						'COMPANY_ID'	=>	$data['id']
					)
				);

				echo json_encode( array( 'code' => SUCCESS, 'data' => $this->common->getRecord( $productTable )[0] ) );
				// $this->debug( $this->common->getRecord( $productTable ) );

			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}
}