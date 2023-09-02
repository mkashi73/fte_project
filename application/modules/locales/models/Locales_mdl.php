<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class Locales_mdl extends CI_Model 
{
	public function createRecord( array $data, $table)
	{
		$this->db->insert($table, $data);
		$insert_id = $this->db->insert_id();
   		return  $insert_id;
	}

	// COUNTRY PAGINATION
	public function countryPagination ( array $data ) 
	{
		$output = "";
		
		// $this->debug( $data );

		$this->db->limit( $data['db']['limit'], $data['db']['start'] );
		
		if ( isset( $data['db']['like_condition'] ) )
        {
        	$this->db->like( $data['db']['like_condition']['match_attribute'], $data['db']['like_condition']['match_value'] );
        }

		$query = $this->db->get( $data['db']['table'] );

		$output .= "
		<table class='table table-striped table-bordered pagination-table' style='width:100%'>
		
			<tr>
				<th>COUNTRY</th>
				<th>ACTION</th>
			</tr>";

		$i = 1;
		foreach ( $query->result_array() as $row ) 
		{
			$output .=    "<tr>" 
							. "<td>" . $row['COUNTRY'] ."</td>"
							. "<td>
									<div class='btn-group' role='group' aria-label='Basic example'>
									  	<button type='button' class='btn btn-success edit-btn' style='margin:2%;' href='' data-toggle='modal' data-target='#update-country-modal'>
									  		<i class='fas fa-pencil-alt'></i>
									  		<input type='hidden' name='countryId' class='countryId' value='" . $row['COUNTRY_ID'] . "'>
									  	</button>
									  	<button type='button' class='btn btn-danger delete-btn' style='margin:2%;'>
									  		<i class='fa fa-trash'></i>
											<input type='hidden' name='countryId' class='countryId' value='" . $row['COUNTRY_ID'] . "'>
									  	</button>
									</div>
								</td>"
						. "</tr>";	
			
			$i++;
		}

		$output .= "</table>";

		return $output;
	}

	// CITY PAGINATION
	public function cityPagination ( array $data ) 
	{
		$output = "";
		
		// $this->debug( $data );

		$this->db->limit( $data['db']['limit'], $data['db']['start'] );
		
		if ( isset ( $data['db']['join']['joined_table'] ) ) 
		{
			$this->db->join( $data['db']['join']['joined_table'], $data['db']['join']['joined_condition'] );
		}

		if ( isset( $data['db']['like_condition'] ) )
        {
        	$this->db->like( $data['db']['like_condition']['match_attribute'], $data['db']['like_condition']['match_value'] );
        }

		$query = $this->db->get( $data['db']['table'] );

		$output .= "
		<table class='table table-striped table-bordered city-table' style='width:100%'>
		
			<tr>
				<th>CITY NAME</th>
				<th>STATE NAME</th>
				<th>STATUS</th>
				<th>Action</th>
			</tr>";

		$i = 1;
		foreach ( $query->result_array() as $row ) 
		{
			if ( $row['STATUS'] == 1 )
			{
				$row['STATUS'] = 'Active';
			}
			else
			{
				$row['STATUS']	= 'In Active';
			}

			$output .=    "<tr>" 
							. "<td>" . $row['CITY'] ."</td>"
							. "<td>" . $row['STATE'] ."</td>"
							. "<td>" . $row['STATUS'] ."</td>"
							. "<td>
									<div class='btn-group' role='group' aria-label='Basic example'>
									  	<button type='button' class='btn btn-success edit-city-btn' style='margin:2%;' href='' data-toggle='modal' data-target='#update-city-modal'>
									  		<i class='fas fa-pencil-alt'></i>
									  		<input type='hidden' name='id' class='id' value='" . $row['CITY_ID'] . "'>
									  	</button>
									  	<button type='button' class='btn btn-danger delete-city-btn' style='margin:2%;'>
									  		<i class='fa fa-trash'></i>
											<input type='hidden' name='id' class='id' value='" . $row['CITY_ID'] . "'>
									  	</button>
									</div>
								</td>"
						. "</tr>";	
			
			$i++;
		}

		$output .= "</table>";

		return $output;
	}

	// STATE PAGINATION
	public function statePagination ( array $data ) 
	{
		$output = "";
		
		// $this->debug( $data );

		$this->db->limit( $data['db']['limit'], $data['db']['start'] );
		
		if ( isset ( $data['db']['join']['joined_table'] ) ) 
		{
			$this->db->join( $data['db']['join']['joined_table'], $data['db']['join']['joined_condition'] );
		}

		if ( isset( $data['db']['like_condition'] ) )
        {
        	$this->db->like( $data['db']['like_condition']['match_attribute'], $data['db']['like_condition']['match_value'] );
        }

		$query = $this->db->get( $data['db']['table'] );

		$output .= "
		<table class='table table-striped table-bordered state-table' style='width:100%'>
		
			<tr>
				<th>STATE NAME</th>
				<th>COUNTRY NAME</th>
				<th>STATUS</th>
				<th>Action</th>
			</tr>";

		$i = 1;
		foreach ( $query->result_array() as $row ) 
		{
			if ( $row['STATUS'] == 1 )
			{
				$row['STATUS'] = 'Active';
			}
			else
			{
				$row['STATUS']	= 'In Active';
			}

			$output .=    "<tr>" 
							. "<td>" . $row['STATE'] ."</td>"
							. "<td>" . $row['COUNTRY'] ."</td>"
							. "<td>" . $row['STATUS'] ."</td>"
							. "<td>
									<div class='btn-group' role='group' aria-label='Basic example'>
									  	<button type='button' class='btn btn-success edit-state-btn' style='margin:2%;' href='' data-toggle='modal' data-target='#update-state-modal'>
									  		<i class='fas fa-pencil-alt'></i>
									  		<input type='hidden' name='id' class='id' value='" . $row['STATE_ID'] . "'>
									  	</button>
									  	<button type='button' class='btn btn-danger delete-state-btn' style='margin:2%;'>
									  		<i class='fa fa-trash'></i>
											<input type='hidden' name='id' class='id' value='" . $row['STATE_ID'] . "'>
									  	</button>
									</div>
								</td>"
						. "</tr>";	
			
			$i++;
		}

		$output .= "</table>";

		return $output;
	}
}