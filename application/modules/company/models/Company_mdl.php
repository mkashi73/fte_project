<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_mdl extends CI_Model 
{
	public function createRecord( array $data, $table)
	{
		$this->db->insert($table, $data);
		$insert_id = $this->db->insert_id();
   		return  $insert_id;
	}

	public function companyPagination ( array $data ) 
	{
		$output = "";
		
		// $this->debug( $data );

		$this->db->limit( $data['db']['limit'], $data['db']['start'] );
		$query = $this->db->get( $data['db']['table'] );
		// $this->debug( $query->result_array() );

		$output .= "
					<table class='table table-striped table-bordered pagination-table' style='width:100%'>
			          	<h2>Company Listing</h2>
			          	<thead>
			                <tr>
			                  <th style='width: 35%;'>Company Name</th>
			                  <th style='width: 40%;'>Company Web URL</th>
			                  <th style='width: 25%;'>Action</th>
			                </tr>
			            </thead>
			            <tbody>";

		foreach ( $query->result_array() as $row ) 
		{
			$output .=    "	<tr>
			                  <td><strong>" . $row['COMPANY_NAME'] . "</strong></td>
			                  <td>" . $row['COMPANY_WEB_URL'] . "</td>
			                  <td>          
			                    <div class='btn-group' role='group' aria-label='Basic example'>
			                      	<button type='button' class='btn btn-success edit-btn' style='margin:2%;' data-target='#update-company-modal' data-toggle='modal'>
		                      			<i class='fas fa-pencil-alt'></i>
		                      			<input type='hidden' name='companyId' value='" . $row['COMPANY_ID'] . "'>
		                      		</button>
									<button type='button' class='btn btn-danger delete-btn' style='margin:2%;'>
										<i class='fa fa-trash'></i>
										<input type='hidden' name='companyId' value='" . $row['COMPANY_ID'] . "'>
									</button>
			                    </div>
			                  </td>
			                </tr>";	
		}

		$output .= "<tbody>
				</table>";

		return $output;
	}
}