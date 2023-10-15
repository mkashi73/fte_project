<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Muhammad Kashif
	Controller 	: Expense
	Date 		: 28/08/2023
*/

class Expense_mdl extends CI_Model 
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

	public function getExpense () 
	{
		$query = "
					SELECT * 
					FROM 
						`expense` AS `p`";

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

	function expensePagination( $data ) 
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
		<table class='table table-striped table-bordered expense-table mt-2' style='width:100%; height: auto;'>
			
			<tr>
				<th>Expense ID</th>
				<th>STATION Name</th>
				<th>Expense Amount</th>
				<th>Expense Type</th>
				<th>Create Time</th>
				<th>Update Time</th>
				<th>Action</th>
			</tr>";

		$i = 1;

		$userId = $data['userData']['userId'];

		if ( $query->num_rows() > 0 ) 
		{
			foreach ( $query->result_array() as $row ) 
			{
				if ( $userId == 1 )
				{
					$editButtonHtml = " <button type='button' class='btn btn-success edit-btn' style='margin:2%;' data-target='#update-expense-modal' data-toggle='modal'>
											<i class='fas fa-pencil-alt'></i>
											<input type='hidden' name='expenseId' value='" . $row['EXPENSE_ID'] . "'>
										</button>";
					$deleteButtonHtml = "<button type='button' class='btn btn-danger delete-btn' style='margin:2%;'>
											<i class='fa fa-trash'></i>
											<input type='hidden' name='expenseId' value='" . $row['EXPENSE_ID'] . "'>
										</button>";
				}
				else{
					$editButtonHtml = "";
					$deleteButtonHtml ="";
				}
				$output .=    "<tr>" 
								. "<td>" . $row['EXPENSE_ID'] ."</td>"
								. "<td>" . $row['STATION_NAME'] ."</td>"
								. "<td>" . $row['EXPENSE_AMOUNT'] ."</td>"
								. "<td>" . $row['EXPENSE_TYPE'] . "</td>" 
								. "<td>" . $row['E_DATE_TIME'] . "</td>"
								. "<td>" . $row['U_DATE_TIME'] . "</td>"								
								. "<td>
									<div class='btn-group' role='group' aria-label='Basic example'>"
										.
										$editButtonHtml
										.
										"
										<div class='dropdown' style='margin:2%;'>
												<button class='btn btn-warning dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
													<i class='fas fa-eye'></i>
												</button>
												<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
													<a class='dropdown-item' href='" . base_url('expense/report/expense_report/') . $row['EXPENSE_ID'] . "' target='_blank'>
															Download Expense Report
													</a>													
												</div><!-- dropdown-menu -->
								            </div>"
										.
										$deleteButtonHtml
										.
										"
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
}