<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_mdl extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param  $table - The database table to query.
	 * @param  $condition - The condition provided by developer to apply on query
	**/
	public function getData( $table, $condition )
	{
		if ( !empty ( $condition ) ) 
		{
			$query = $this->db->get_where( $table , $condition);
		} 
		else
		{
			$query = $this->db->get( $table );
		}

		if ( $query->num_rows() > 0 ) 
		{
			return json_encode( array( 'data' => $query->result_array() ) );
		}
		else
		{
			return json_encode( array ( 'error' => 'Please check your username or password' ) );
		}
		
	}
}