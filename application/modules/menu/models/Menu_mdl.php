<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_mdl extends CI_Model 
{
	public function getParentMenu()
	{	
		$query = $this->db->query('SELECT * FROM `user_menu` WHERE PARENT_ID IS NULL');

		if ( $query->num_rows() > 0 ) 
		{
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}

	public function getUserRole()
	{	
		$query = $this->db->get('user_roles');

		if ( $query->num_rows() > 0 ) 
		{
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}	

	public function getMenuRecords()
	{	
		$query = $this->db->get('user_menu');

		if ( $query->num_rows() > 0 ) 
		{
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}	

	public function addMenu ( $data ) 
	{
		$query = $this->db->insert('user_menu', $data);

		if ( $query ) 
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function deleteMenu ( $menuId ) 
	{
		$condition = array( 
			"MENU_ID" => $menuId
		);
		
		if ( $this->db->delete('user_menu', $condition) ) 
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}