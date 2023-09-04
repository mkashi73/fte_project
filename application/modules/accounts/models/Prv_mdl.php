<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Muhammad Kashif
	Controller 	: PRV
	Date 		: 28/08/2023
*/

class Prv_mdl extends CI_Model 
{
	public function __construct() {
		$this->load->helper('common');
	}

	public function getData( $table ) 
	{
		$query = $this->db->get($table);

		if ( $query->num_rows() > 0 ) 
		{
			return $query->result_array();
		}
		else
		{
			return "No record found";
		}

	}

	public function getPrv () 
	{
		$query = "
					SELECT * 
					FROM 
						`payment_receipt_voucher` AS `p`";

		$result = $this->db->query($query);

		if ( $result->num_rows() > 0 )
		{
			return $result->result_array();
		}
		else
		{	
			return FALSE;
		}
	}

	function prvPagination( $data ) 
	{	
		$output = "";
		
		// $this->debug( $data );

		if ( isset( $data['db']['select'] ) ) 
		{
			$this->db->select($data['db']['select']);
		}

		$this->db->limit( $data['db']['limit'], $data['db']['start'] );

		if ( isset ( $data['db']['join']['joined_table'] ) ) 
		{
			$this->db->join( $data['db']['join']['joined_table'], $data['db']['join']['joined_condition'] );
		}	

		if ( isset ( $data['db']['order_attribute'] ) && isset( $data['db']['order_by'] ) ) 
		{
			$this->db->order_by( $data['db']['order_attribute'], $data['db']['order_by'] );
		}	

		if ( isset( $data['db']['condition'] ) ) 
		{
			$this->db->where( $data['db']['condition'] );
		}

		$query = $this->db->get( $data['db']['table'] );
		// $this->debug( $query->result_array() );

		$output .= "
		<table class='table table-striped table-bordered prv-table mt-2' style='width:100%; height: auto;'>
			
			<tr>
				<th>PRV ID</th>
				<th>STATION Name</th>
				<th>Received From</th>
				<th>Received Amount</th>
				<th>PRV Type</th>
				<th>Account Of</th>
				<th>Create Time</th>
				<th>Update Time</th>
				<th>Action</th>
			</tr>";

		$i = 1;

		// $userId = $data['userData']['userId'];

		if ( $query->num_rows() > 0 ) 
		{
			foreach ( $query->result_array() as $row ) 
			{
				
				
				$output .=    "<tr>" 
								. "<td>" . $row['PRV_ID'] ."</td>"
								. "<td>" . $row['STATION_NAME'] ."</td>"
								. "<td>" . $row['RECEIVED_FROM'] ."</td>"
								. "<td>" . $row['RECEIVED_AMOUNT'] . "</td>" 
								. "<td>" . $row['PRV_TYPE'] . "</td>"
								. "<td>" . $row['ACCOUNT_OF'] . "</td>"
								. "<td>" . $row['E_DATE_TIME'] . "</td>"
								. "<td>" . $row['U_DATE_TIME'] . "</td>"								
								. "<td>
									<div class='btn-group' role='group' aria-label='Basic example'>
										<button type='button' class='btn btn-success edit-btn' style='margin:2%;' data-target='#update-prv-modal' data-toggle='modal'>
											<i class='fas fa-pencil-alt'></i>
											<input type='hidden' name='prvId' value='" . $row['PRV_ID'] . "'>
										</button>
										<div class='dropdown' style='margin:2%;'>
												<button class='btn btn-warning dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
													<i class='fas fa-eye'></i>
												</button>
												<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
													<a class='dropdown-item' href='" . base_url('prv/report/prv_report/') . $row['PRV_ID'] . "' target='_blank'>
															Download PRV
													</a>													
												</div><!-- dropdown-menu -->
								            </div>
										<button type='button' class='btn btn-danger delete-btn' style='margin:2%;'>
											<i class='fa fa-trash'></i>
											<input type='hidden' name='[prvId' value='" . $row['PRV_ID'] . "'>
										</button>
									</div>
								</td>"								
							. "</tr>";	
				
				$i++;
			}
		}
		else
		{
			$output .= '<h5 style="color : red">No Record found</h5>';
		}

		$output .= "</table>";

		return $output;
	}


	public function getUsersDistinctData () 
	{
		$query = "
					SELECT DISTINCT STATION_NAME
					FROM 
					users WHERE STATION_NAME != ''";

		$result = $this->db->query($query);

		if ( $result->num_rows() > 0 )
		{
			return $result->result_array();
		}
		else
		{	
			return FALSE;
		}
	}
}