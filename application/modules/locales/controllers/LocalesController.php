<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: login
	Date 		: 02/10/2018
*/

class LocalesController extends MX_Controller 
{
	public function __construct() 
	{
		parent::__construct();

		$this->load->model('locales/Locales_mdl', 'locales');
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
					"pageName"		=>	'Locales'
				),
				"getCountry"		=>	$this->common->getRecord($countryDb),
				"getState"			=>	$this->common->getRecord($stateDb),
				"token"				=>	getTokenData('token'),
				"filepath"			=>	'locales/locales.js'

			);

			$this->load->view('common/header', $data);
			$this->load->view('common/sidebar', $data);
			$this->load->view('locales/Locales_vw', $data);
			$this->load->view('common/footer', $data);
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
			redirect(base_url());
		} // end of Role validation
	}

	/***********************
	START OF COUNTRY SECTION
	***********************/
	public function GetCountry() 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$data = json_decode(file_get_contents('php://input'), TRUE);

			$tableSetting = array(
				'select'	=>	'`COUNTRY_ID`, `COUNTRY`',
				'table'		=>	'country',
				'condition'	=>	array(
					'COUNTRY_ID'	=>	$data['countryId']
				)
			);

			echo json_encode( array( "code" => SUCCESS, 'record' => $this->common->getRecordById( $tableSetting )[0] ) );
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function AddCountry() 
	{
		// print_r($this->tokenData); 
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
		
			if ( isset ( $_POST['countryname'] )
				&& !empty( $_POST['countryname'] )
			 	) 
			{
				$checkData = array(
					'table'		=>	'country',
					'condition' => array(
						'COUNTRY'	=>	$_POST['countryname']
					)
				);
				
				if ( !$this->common->checkData( $checkData ) ) 
				{
					$dbData = array(
						"COUNTRY"		=>	$_POST['countryname'],
						"E_USER_ID"		=>	$this->tokenData['id'],
						"E_DATE_TIME"	=>	getDateOffset()
					);

					if ( $this->common->createRecord($dbData, 'country') )
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
					echo json_encode(array("code" => BAD_DATA, 'message' => 'Country already exist' ));
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

	public function UpdateCountry() 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			// $this->debug( $_POST );

			$updateData = array(
				'table' 		=>	'country',
				'condition'		=>	array(
					'COUNTRY_ID'	=>	$_POST['countryId']	
				),
				'record'		=>	array(
					'COUNTRY'		=>	$_POST['countryname'],
					'U_USER_ID'		=>	$this->tokenData['id'],
					'U_DATE_TIME'	=>	getDateOffset()
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

	public function DeleteCountry() 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$countryId = $this->uri->segment(3);

			if ( !empty( $countryId ) ) 
			{
				$data = array(
					'table' 		=>	'country',
					'condition'		=>	array(
						'COUNTRY_ID'	=>	$countryId
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
	public function GetCountryPagination ( $page ) 
	{
		$data = json_decode(file_get_contents('php://input'), TRUE);

		// $this->debug( $data );

		if ( isset( $_POST['countryName'] ) ) 
		{
			$countryName = $_POST['countryName'];
		}

		if ( isset ( $data['countryName'] ) )
		{
			$countryName = $data['countryName'];
		}

		$MenuDb = array(
						'select'			=>	'`COUNTRY_ID`, `COUNTRY`',
						'table'				=>	'country',
						'order_attribute'	=>	'COUNTRY',
						'order_by'			=>	'ASC'
					);

		if ( !empty( $countryName ) ) 
		{
			$MenuDb['like_condition'] = array (
				'match_attribute'	=>	'COUNTRY',
				'match_value'		=>	$countryName
			);
		}

		$menu = $this->common->getRecord( $MenuDb );

		if ( !empty( $menu ) ) 
		{
			$total_menu = count($menu);
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
			"full_tag_open"		=>	"<div class='pagination-wrapper'>
										<nav aria-label='Page navigation'>
											<ul class='pagination country-pagination pagination-circle pagination-primary'>",
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
				'table'	=>	'country'
			),
			
		);

		if ( !empty( $countryName ) ) 
		{
			$paginationData['db']['condition'] = array(
				'COUNTRY' => $countryName
			);
		}

		if ( !empty( $countryName ) ) 
		{
			$paginationData['db']['like_condition'] = array (
				'match_attribute'	=>	'COUNTRY',
				'match_value'		=>	$countryName
			);
		}

		$output = array(
			"countryPaginationLink"		=>	$this->pagination->create_links(),
			"CountryList"				=>	$this->locales->countryPagination( $paginationData ),
			"TotalRecords"				=>	$total_menu
		);

		echo json_encode($output);
	}

	/*********************
	END OF COUNTRY SECTION
	*********************/

	/*********************
	START OF STATE SECTION
	*********************/
	// Pagination
	public function GetStatePagination ( $page ) 
	{
		$data = json_decode(file_get_contents('php://input'), TRUE);

		// $this->debug( $data );

		if ( isset( $_POST['stateName'] ) ) 
		{
			$stateName = $_POST['stateName'];
		}

		if ( isset ( $data['stateName'] ) )
		{
			$stateName = $data['stateName'];
		}

		$stateDb = array(
						'select'	=>	'state.`STATE_ID`, state.`STATE`, state.COUNTRY_ID, state.`STATUS`, country.`COUNTRY_ID`',
						'table'		=>	'state',
						'join'				=>	array(
							'joined_table'		=>	'country',
							'joined_condition'	=>	'state.COUNTRY_ID = country.COUNTRY_ID'
						),
						'order_attribute'	=>	'state.`STATE`',
						'order_by'			=>	'ASC'
					);

		if ( !empty( $stateName ) ) 
		{
			$stateDb['like_condition'] = array (
				'match_attribute'	=>	'STATE',
				'match_value'		=>	$stateName
			);
		}

		$state = $this->common->getRecord( $stateDb );

		if ( !empty( $state ) ) 
		{
			$total_state = count($state);
		}
		else
		{
			$total_state = 0;
		}
		
		// $this->debug( $total_menu );

		$config = array(
			"base_url"			=>	"#",
			"attributes"		=> 	array('class' => 'page-link'),
			"total_rows"		=>	$total_state,
			"per_page"			=>	5,
			"uri_segment"		=>	4,
			"use_page_numbers"	=>	TRUE,
			"full_tag_open"		=>	"<div class='pagination-wrapper'>
										<nav aria-label='Page navigation'>
											<ul class='pagination state-pagination pagination-circle pagination-primary'>",
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
				'table'	=>	'state',
				'join'				=>	array(
					'joined_table'		=>	'country',
					'joined_condition'	=>	'state.COUNTRY_ID = country.COUNTRY_ID'
				)
			),
			
		);

		if ( !empty( $stateName ) ) 
		{
			$paginationData['db']['condition'] = array(
				'STATE' => $stateName
			);
		}

		if ( !empty( $stateName ) ) 
		{
			$paginationData['db']['like_condition'] = array (
				'match_attribute'	=>	'STATE',
				'match_value'		=>	$stateName
			);
		}

		$output = array(
			"StatePaginationLink"		=>	$this->pagination->create_links(),
			"StateList"				=>	$this->locales->statePagination( $paginationData ),
			"TotalRecords"				=>	$total_state
		);

		echo json_encode($output);
	}

	// ADD CITY 
	public function AddState() 
	{
		// print_r($this->tokenData); 
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			// $this->debug( $_POST );

			$config = 	array 
						(
				        	array 
				        	(
				            	'field' => 'stateName',
				                'label' => 'State Name',
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
				$checkCity = array(
					'table'		=>	'state',
					'condition' => array (
						'STATE'			=>	$_POST['stateName']
					)
				);

				if ( $this->common->checkData( $checkCity ) )
				{
					echo json_encode(	
										array
										(
											"code" => BAD_DATA, 
											'message' => 'State already exist' 
										)
									);
				}
				else
				{
					$dbData = array(
						"COUNTRY_ID"	=>	$_POST['countryId'],
						"STATE"			=>	$_POST['stateName'],
						"E_USER_ID"		=>	$this->tokenData['id'],
						"E_DATE_TIME"	=>	getDateOffset()
					);

					if ( $this->common->createRecord( $dbData, 'state' ) )
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
				}
			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	// GET CITY
	public function GetState() 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$data = json_decode(file_get_contents('php://input'), TRUE);

			$tableSetting = array(
				'select'	=>	'state.STATE_ID, state.`STATE`, state.`STATUS`, state.COUNTRY_ID, country.COUNTRY, state.STATE_ID, state.STATE',
				'table'		=>	'state',
				'join'		=>	array (
					'joined_table'		=>	'country',
					'joined_condition'	=>	"state.`COUNTRY_ID` = country.COUNTRY_ID"
				),
				'condition'	=>	array(
					'state.`STATE_ID`'	=>	$data['id']
				)
			);

			echo json_encode( 
								array
								( 
									"code" => SUCCESS, 
									'record' => $this->common->getRecord( $tableSetting )[0] 
								) 
							);
		}
		else
		{
			echo json_encode( 
								array
								( 
									"code" => BAD_DATA, 
									'message' => $this->msg['auth_msg']['auth_error']
								) 
							);
		} // end of Role validation
	}

	public function UpdateState() 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{

			// $this->debug( $_POST );

			$updateData = array(
				'table' 		=>	'state',
				'condition'		=>	array(
					'STATE_ID'	=>	$_POST['stateId']	
				),
				'record'		=>	array(
					'COUNTRY_ID'	=>	$_POST['countryId'],
					'STATE'			=>	$_POST['stateName'],
					'U_USER_ID'		=>	$this->tokenData['id'],
					'U_DATE_TIME'	=>	getDateOffset()
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

	public function DeleteState() 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$id = $this->uri->segment(3);

			if ( !empty( $id ) ) 
			{
				$data = array(
					'table' 		=>	'state',
					'condition'		=>	array(
						'STATE_ID'	=>	$id
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
	/*******************
	END OF STATE SECTION
	*******************/

	/*********************
	START OF CITY SECTION
	*********************/
	// Pagination
	public function GetCityPagination ( $page ) 
	{
		$data = json_decode(file_get_contents('php://input'), TRUE);

		// $this->debug( $data );

		if ( isset( $_POST['cityName'] ) ) 
		{
			$cityName = $_POST['cityName'];
		}

		if ( isset ( $data['cityName'] ) )
		{
			$cityName = $data['cityName'];
		}

		$cityDb = array(
						'select'			=>	'city.`CITY_ID`, city.`CITY`, city.`STATE_ID`, city.`STATUS`, state.STATE_ID',
						'table'				=>	'city',
						'join'				=>	array(
							'joined_table'		=>	'state',
							'joined_condition'	=>	'city.STATE_ID = state.STATE_ID'
						),
						'order_attribute'	=>	'city.`CITY`',
						'order_by'			=>	'ASC'
					);

		if ( !empty( $cityName ) ) 
		{
			$cityDb['like_condition'] = array (
				'match_attribute'	=>	'CITY',
				'match_value'		=>	$cityName
			);
		}

		$city = $this->common->getRecord( $cityDb );

		if ( !empty( $city ) ) 
		{
			$total_city = count($city);
		}
		else
		{
			$total_city = 0;
		}
		
		// $this->debug( $total_menu );

		$config = array(
			"base_url"			=>	"#",
			"attributes"		=> 	array('class' => 'page-link'),
			"total_rows"		=>	$total_city,
			"per_page"			=>	5,
			"uri_segment"		=>	4,
			"use_page_numbers"	=>	TRUE,
			"full_tag_open"		=>	"<div class='pagination-wrapper'>
										<nav aria-label='Page navigation'>
											<ul class='pagination city-pagination pagination-circle pagination-primary'>",
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
				'table'	=>	'city',
				'join'				=>	array(
					'joined_table'		=>	'state',
					'joined_condition'	=>	'city.STATE_ID = state.STATE_ID'
				)
			),
			
		);

		if ( !empty( $cityName ) ) 
		{
			$paginationData['db']['condition'] = array(
				'CITY' => $cityName
			);
		}

		if ( !empty( $cityName ) ) 
		{
			$paginationData['db']['like_condition'] = array (
				'match_attribute'	=>	'CITY',
				'match_value'		=>	$cityName
			);
		}

		$output = array(
			"CityPaginationLink"		=>	$this->pagination->create_links(),
			"CityList"				=>	$this->locales->cityPagination( $paginationData ),
			"TotalRecords"				=>	$total_city
		);

		echo json_encode($output);
	}

	// ADD CITY 
	public function AddCity() 
	{
		// print_r($this->tokenData); 
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			// $this->debug( $_POST );

			$config = 	array 
						(
				        	array 
				        	(
				            	'field' => 'stateName',
				                'label' => 'State Name',
				                'rules' => 'required',
				                'errors' => array (
				                	'required' => 'You must provide a %s'
			                	)
			        		),
			        		array 
				        	(
				            	'field' => 'cityName',
				                'label' => 'City Name',
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
				// $checkCity = array(
				// 	'table'		=>	'city',
				// 	'condition' => array (
				// 		'CITY'		=>	$_POST['cityName']
				// 	)
				// );

				// if ( $this->common->checkData( $checkCity ) )
				// {
				// 	echo json_encode(	
				// 						array
				// 						(
				// 							"code" => BAD_DATA, 
				// 							'message' => 'City already exist' 
				// 						)
				// 					);
				// }
				// else
				// {
				$dbData = array(
					"STATE_ID"		=>	$_POST['stateName'],
					"CITY"		=>	$_POST['cityName'],
					"E_USER_ID"		=>	$this->tokenData['id'],
					"E_DATE_TIME"	=>	getDateOffset()
				);

				if ( $this->common->createRecord( $dbData, 'city' ) )
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
				// }
			}
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	// GET CITY
	public function GetCity() 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$data = json_decode(file_get_contents('php://input'), TRUE);

			$tableSetting = array(
				'select'	=>	'city.CITY_ID, city.`CITY`, city.`STATE_ID`, city.STATUS, state.STATE_ID, state.STATE',
				'table'		=>	'city',
				'join'		=>	array (
					'joined_table'		=>	'state',
					'joined_condition'	=>	"city.`STATE_ID` = state.STATE_ID"
				),
				'condition'	=>	array(
					'city.`CITY_ID`'	=>	$data['id']
				)
			);

			echo json_encode( 
								array
								( 
									"code" => SUCCESS, 
									'record' => $this->common->getRecord( $tableSetting )[0] 
								) 
							);
		}
		else
		{
			echo json_encode( 
								array
								( 
									"code" => BAD_DATA, 
									'message' => $this->msg['auth_msg']['auth_error']
								) 
							);
		} // end of Role validation
	}

	public function UpdateCity() 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{

			// $this->debug( $_POST );

			$updateData = array(
				'table' 		=>	'city',
				'condition'		=>	array(
					'CITY_ID'	=>	$_POST['cityId']	
				),
				'record'		=>	array(
					'STATE_ID'	=>	$_POST['stateName'],
					'CITY'		=>	$_POST['cityName'],
					'U_USER_ID'		=>	$this->tokenData['id'],
					'U_DATE_TIME'	=>	getDateOffset()
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

	public function DeleteCity() 
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$id = $this->uri->segment(3);

			if ( !empty( $id ) ) 
			{
				$data = array(
					'table' 		=>	'city',
					'condition'		=>	array(
						'CITY_ID'	=>	$id
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
	/******************
	END OF CITY SECTION
	******************/

	/***********************************************
	START OF STATE SECTION VIA COUNTRY EVENT REQUEST
	***********************************************/

	public function GetAddStateData()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$id = $this->uri->segment(4);

			if ( !empty( $id ) ) 
			{
				$data = array(
					'select'		=>	'*',
					'table' 		=>	'state',
					'condition'		=>	array(
						'COUNTRY_ID'	=>	$id
					)
				);

				echo json_encode( 
									array
									( 
										"code" => SUCCESS, 
										'record' => $this->common->getRecord( $data )
									) 
								);
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

	public function GetAddCityData()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$id = $this->uri->segment(4);

			if ( !empty( $id ) ) 
			{
				$data = array(
					'select'		=>	'*',
					'table' 		=>	'city',
					'condition'		=>	array(
						'STATE_ID'	=>	$id
					)
				);


				echo json_encode( 
									array
									( 
										"code" => SUCCESS, 
										'record' => $this->common->getRecord( $data )
									) 
								);
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

	public function GetStateData()
	{
		// GetClientStateData
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$id = $this->uri->segment(4);

			$productId = $this->uri->segment(5);

			if ( !empty( $id ) ) 
			{
				$data = array(
					'select'		=>	'*',
					'table' 		=>	'state',
					'condition'		=>	array(
					'COUNTRY_ID'	=>	$id
					)
				);

				$productData = array (
					'select'		=>	'PRODUCT_ID, SHIPPER_STATE_ID, CONSIGNEE_STATE_ID',
					'table' 		=>	'product',
					'condition'		=>	array(
						'PRODUCT_ID'	=>	$productId
					)
				);

				echo json_encode( 
									array
									( 
										"code" => SUCCESS, 
										'record' => $this->common->getRecord( $data ),
										'productRecord' => $this->common->getRecord( $productData ) 
									) 
								);
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

	public function GetCityData()
	{
		// GetClientCityData
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$id = $this->uri->segment(4);

			$productId = $this->uri->segment(5);
			
			if ( !empty( $id ) ) 
			{
				$data = array(
					'select'		=>	'*',
					'table' 		=>	'city',
					'condition'		=>	array(
						'STATE_ID'	=>	$id
					)
				);

				$productData = array (
					'select'		=>	'PRODUCT_ID, SHIPPER_CITY_ID, CONSIGNEE_CITY_ID',
					'table' 		=>	'product',
					'condition'		=>	array(
						'PRODUCT_ID'	=>	$productId
					)
				);

				echo json_encode( 
									array
									( 
										"code" => SUCCESS, 
										'record' => $this->common->getRecord( $data ),
										'productRecord' => $this->common->getRecord( $productData ) 
									) 
								);
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


	public function GetClientStateData()
	{
		// 
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$id = $this->uri->segment(5);

			$productId = $this->uri->segment(6);

			if ( !empty( $id ) ) 
			{
				$data = array(
					'select'		=>	'*',
					'table' 		=>	'state',
					'condition'		=>	array(
					'COUNTRY_ID'	=>	$id
					)
				);

				$productData = array (
					'select'		=>	'CLIENT_ID, STATE_ID',
					'table' 		=>	'client',
					'condition'		=>	array(
						'CLIENT_ID'	=>	$productId
					)
				);

				echo json_encode( 
									array
									( 
										"code" => SUCCESS, 
										'record' => $this->common->getRecord( $data ),
										'productRecord' => $this->common->getRecord( $productData ) 
									) 
								);
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

	public function GetClientCityData()
	{
		// 
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$id = $this->uri->segment(5);

			$productId = $this->uri->segment(6);
			
			if ( !empty( $id ) ) 
			{
				$data = array(
					'select'		=>	'*',
					'table' 		=>	'city',
					'condition'		=>	array(
						'STATE_ID'	=>	$id
					)
				);

				$productData = array (
					'select'		=>	'CLIENT_ID, STATE_ID,CITY_ID',
					'table' 		=>	'client',
					'condition'		=>	array(
						'CLIENT_ID'	=>	$productId
					)

				);

				echo json_encode( 
									array
									( 
										"code" => SUCCESS, 
										'record' => $this->common->getRecord( $data ),
										'productRecord' => $this->common->getRecord( $productData ) 
									) 
								);
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
}