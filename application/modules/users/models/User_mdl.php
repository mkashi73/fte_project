<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class User_mdl extends CI_Model 
{
	public function getUserRoleData() 
	{
		$query = "	SELECT 
							u.`USER_ID`, 
					        u.`FULL_NAME`, 
					        u.`EMAIL_ADDRESS`, 
					        u.`ENCRYPTED_PWD`, 
					        u.`U_ROLE_ID`, 
					        u.`IS_ACTIVE`, 
					        ur.`USER_ROLE_ID`, 
					        ur.`ROLE`
					FROM 
						`users` AS `u`, 
						`user_roles` as `ur`  
					WHERE 
						`u`.`U_ROLE_ID` = `ur`.`USER_ROLE_ID`";

		$result = $this->db->query($query);

		if ( $result->num_rows() > 0 ) 
		{
			return $this->db->query($query)->result_array();
		}
		else
		{
			return FALSE;
		}
	}

	public function getUsername( $user_id )
	{
		$query = $this->db->get_where('users', array('USER_ID' => $user_id));

		if ( $query->num_rows() > 0 ) 
		{
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}
	function userPagination( $data ) 
	{	
		$output = "";
		
		// $this->debug( $data );

		$this->db->limit( $data['db']['limit'], $data['db']['start'] );

		if ( isset ( $data['db']['join']['joined_table'] ) ) 
		{
			$this->db->join( $data['db']['join']['joined_table'], $data['db']['join']['joined_condition'] );
		}	

		if ( isset ( $data['db']['order_attribute'] ) && isset( $data['db']['order_by'] ) ) 
		{
			$this->db->order_by( $data['db']['order_attribute'], $data['db']['order_by'] );
		}	

		$query = $this->db->get( $data['db']['table'] );
		// $this->debug( $query->result_array() );

		$output .= "
		<table class='table table-striped table-bordered user-table' style='width:100%'>
		<h2>Product Listing</h2>
			<tr>
				<th>FULL NAME</th>
				<th>EMAIL ID</th>
				<th>ROLE</th>
				<th>STATUS</th>
				<th>Action</th>
			</tr>";

		$i = 1;
		foreach ( $query->result_array() as $row ) 
		{
			$output .=    "<tr>" 
							. "<td>" . $row['FULL_NAME'] ."</td>"
							. "<td>" . $row['EMAIL_ADDRESS'] ."</td>"
							. "<td>" . $row['ROLE'] ."</td>"
							. "<td>" . $row['IS_ACTIVE'] ."</td>"
							. "<td>
									<div class='btn-group' role='group' aria-label='Basic example'>
									  	<button type='button' class='btn btn-primary update-btn' style='margin:2%;' href='#' data-toggle='modal' data-target='#update-user-roles'>
									  		<i class='fas fa-pencil-alt'></i>
									  		<input type='hidden' name='userId' value='" . $row['USER_ID'] . "'>
									  	</button>
									  	<button type='button' class='btn btn-danger delete-btn' style='margin:2%;'>
									  		<i class='fa fa-trash'></i>
											<input type='hidden' name='userId' value='" . $row['USER_ID'] . "'>
									  	</button>
									</div>
								</td>"
						. "</tr>";	
			
			$i++;
		}

		$output .= "</table>";
		return $output;
	}

	function userRolesPagination( $data ) 
	{	
		$output = "";
		
		// $this->debug( $data );

		$this->db->limit( $data['db']['limit'], $data['db']['start'] );

		if ( isset ( $data['db']['join']['joined_table'] ) ) 
		{
			$this->db->join( $data['db']['join']['joined_table'], $data['db']['join']['joined_condition'] );
		}	

		if ( isset ( $data['db']['order_attribute'] ) && isset( $data['db']['order_by'] ) ) 
		{
			$this->db->order_by( $data['db']['order_attribute'], $data['db']['order_by'] );
		}	

		$query = $this->db->get( $data['db']['table'] );
		// $this->debug( $query->result_array() );

		$output .= "
		<table class='table table-striped table-bordered user-roles-table' style='width:100%'>
		<h2>Product Listing</h2>
			<tr>
				<th>User Roles</th>
				<th>Action</th>
			</tr>";

		$i = 1;
		foreach ( $query->result_array() as $row ) 
		{
			$output .=    "<tr>" 
							. "<td>" . $row['ROLE'] ."</td>"
							. "<td>
									<div class='btn-group' role='group' aria-label='Basic example'>
									  	<button type='button' class='btn btn-primary updateUserRole' style='margin:2%;' href='#' data-toggle='modal' data-target='#update-roles'>
									  		<i class='fas fa-pencil-alt'></i>
									  		<input type='hidden' name='userRoleId' class='userRoleId' value='" . $row['USER_ROLE_ID'] . "'>
									  	</button>
									  	<button type='button' class='btn btn-danger delete-btn' style='margin:2%;'>
									  		<i class='fa fa-trash'></i>
											<input type='hidden' name='userRoleId' class='userRoleId' value='" . $row['USER_ROLE_ID'] . "'>
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