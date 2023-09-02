<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_mdl extends CI_Model 
{
	public function createRecord( array $data, $table)
	{
		if ( $this->db->insert($table, $data) ) 
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		// added by taimur shah to return last insert id
		// important for ledger report
	public function createRecords( array $data, $table)
	{
		$this->db->insert($table, $data); 
			$id = $this->db->insert_id();
	  		return (isset($id)) ? $id : FALSE;

	}



	public function getRecord( $data )
    {
        $this->db->select($data['select']);

        // if Joined Table exists 
        if ( isset ( $data['join']['joined_table'] ) ) 
        {
            $this->db->join( $data['join']['joined_table'], $data['join']['joined_condition'] );
        }       

        if ( isset ( $data['secondJoin']['joinTable'] ) && isset ( $data['secondJoin']['joinTableCondition'] ) ) 
        {
            $this->db->join( $data['secondJoin']['joinTable'], $data['secondJoin']['joinTableCondition'] );
        }

        if ( isset ( $data['thirdJoin']['joinTable'] ) && isset ( $data['thirdJoin']['joinTableCondition'] ) ) 
        {
            $this->db->join( $data['thirdJoin']['joinTable'], $data['thirdJoin']['joinTableCondition'] );
        }
        
        // if Condition exists 
        if( isset ( $data['condition'] ) ) 
        {
            $this->db->where($data['condition']);
        }
       

        $query = $this->db->get( $data['table'] );
          // if Order exists 
        if ( isset ( $data['order_attribute'] ) && isset( $data['order_by'] ) ) 
        {
            $this->db->order_by( $data['order_attribute'], $data['order_by'] );
        } 

             

        if ( $query->num_rows() > 0 ) 
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function getRecordByCustomQuery ( $query )
    {
    	$result = $this->db->query( $query );

    	if ( $result->num_rows() > 0 ) 
    	{
    		return $result->result_array();
    	}
    	else
    	{
    		return FALSE;
    	}
    }

	public function getRecordById( array $data )
	{
		$this->db->select($data['select']);
		
		$query = $this->db->get_where($data['table'], $data['condition']);

		if ( $query->num_rows() > 0 ) 
		{
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}

	public function updateRecord( array $data )
	{
		$this->db->where($data['condition']);
		
		if ( $this->db->update($data['table'], $data['record']) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function deleteRecord ( array $data ) 
	{
		$this->db->where($data['condition']);
		
		if ( $this->db->delete($data['table']) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}


	function paginationRecord( $data ) 
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
		<table class='table table-striped table-bordered pagination-table' style='width:100%'>
		<h2>Menu Listing</h2>
			<tr>
				<th>Menu Text</th>
				<th>Menu Icon</th>
				<th>Menu URL</th>
				<th>Parent</th>
				<th>User Role Id</th>
				<th>Action</th>
			</tr>";

		$i = 1;
		foreach ( $query->result_array() as $row ) 
		{
			$output .=    "<tr>" 
							. "<td>" . $row['MENU_TEXT'] ."</td>"
							. "<td>" . $row['MENU_URL'] ."</td>"
							. "<td><i class='" . $row['MENU_ICON'] . "'></i></td>" 
							. "<td>" . $row['PARENT_ID'] . "</td>"
							. "<td>" . $row['USER_ROLE_ID'] . "</td>"
							. "<td>
									<div class='btn-group' role='group' aria-label='Basic example'>
									  	<button type='button' class='btn btn-primary update-btn' style='margin:2%;' href='#' data-toggle='modal' data-target='#update-menu-modal'>
									  		<i class='fas fa-pencil-alt'></i>
									  		<input type='hidden' name='menuId' value='" . $row['MENU_ID'] . "'>
									  		<input type='hidden' name='userRoleId' value='" . $row['USER_ROLE_ID'] . "'>
									  	</button>
									  	<button type='button' class='btn btn-danger delete-btn' style='margin:2%;'>
									  		<i class='fa fa-trash'></i>
											<input type='hidden' name='menuId' class='menuId' value='" . $row['MENU_ID'] . "'>
									  	</button>
									</div>
								</td>"
						. "</tr>";	
			
			$i++;
		}

		$output .= "</table>";
		return $output;
	}

	/*================
		Show Menu
	================*/
	public function showMenu( $role_id ) 
	{
		$menus  = '';

		$menus .= $this->generate_multilevel_menus($role_id); 

		$menus = str_replace('<ul class="nav sidebar-nav-sub"></ul>', '', $menus);

		return $menus;
	} 

	/*================================
		Generate Multi Level Menu
	================================*/
	public function generate_multilevel_menus( $user_role_id = NULL, $parent_id = NULL )
	{
		$menu = '';
		$sql  = '';
		// echo $user_role_id;
		if ( is_null ( $parent_id ) ) 
		{
			$sql = 'SELECT * FROM user_menu WHERE PARENT_ID IS NULL ' . ' AND USER_ROLE_ID LIKE "%' . $user_role_id . '%"';
		}
		else
		{
			$sql = 'SELECT * FROM user_menu WHERE PARENT_ID = ' . $parent_id . ' AND USER_ROLE_ID LIKE "%' . $user_role_id . '%"';
		}

		$query = $this->db->query( $sql );

		$result = $query->result_array();
		
		foreach ( $result as $item ) 
		{
			if ( $item['MENU_URL'] ) 
			{
				$menu .= '<li class="sidebar-nav-item"><a href="' . base_url( $item['MENU_URL'] ) . '" class="sidebar-nav-link"><i class="' . $item['MENU_ICON'] . '"></i> ' . $item['MENU_TEXT'] . '</a>';
			}
			else
			{
				$menu .= '<li class="sidebar-nav-item with-sub"><a href="#" class="sidebar-nav-link"><i class="' . $item['MENU_ICON'] . ' "></i> ' . $item['MENU_TEXT'] . '</a>';
			}

			$menu .= '<ul class="nav sidebar-nav-sub">' . $this->generate_multilevel_menus( $user_role_id, $item['MENU_ID'] ) . '</ul>';

			$menu .= '</li>';
		} // end of foreach loop 

		return $menu;
	}

	public function checkUserRole ( $userRoleId ) 
	{
		$this->db->select('*');

		$this->db->from('user_menu');

		// $this->db->like('USER_ROLE_ID', $userRoleId);
		$where = "USER_ROLE_ID LIKE '%" . $userRoleId . "%'";

		$this->db->where($where);

		$query = $this->db->get();

		// $this->debug( $query->num_rows() );

		if ( $query->num_rows() > 0 ) 
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	// CHECK RECORD
    public function checkData( array $data )
    {
    	// if Condition exists 
        if( isset ( $data['condition'] ) ) 
        {
            $this->db->where($data['condition']);
        }

        if ( isset( $data['like_condition'] ) )
        {
        	$this->db->like( $data['like_condition']['match_attribute'], $data['like_condition']['match_value'] );
        }
        
        $query = $this->db->get( $data['table'] );

        if ( $query->num_rows() > 0 ) 
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
	public function uploadFile ( $config ) 
	{
		$extensions = [];
		
		$errors = [];
		
		if ( sizeof( $config['fileExtension'] ) > 1 ) 
		{
			for( $i = 0; $i < sizeof( $config['fileExtension'] ); $i++ ) : 

				$filename = $config['fileExtension'][$i];

				$fileExtension = explode('.', $filename );

				$fileExtension = strtolower( end($fileExtension) );

				array_push($extensions, $fileExtension);

			endfor;
		}
		else
		{
			$filename = $config['fileExtension'][0];

			$fileExtension = explode('.', $filename );

			$fileExtension = strtolower( end($fileExtension) );

			array_push($extensions, $fileExtension);
		}

		if ( sizeof( $extensions ) > 1 ) 
		{
			for ( $i = 0; $i < sizeof( $extensions ); $i++ ) :

				if ( in_array( $extensions[$i], $config['allowedExtensions'] ) === false )
				{
					$errors[]= "extension not allowed, please choose a JPEG or PNG file.";
				}

			endfor;
		}
		else
		{
			if ( in_array( $extensions[0], $config['allowedExtensions'] ) === false )
			{
				$errors['error']= "extension not allowed, please choose a JPEG or PNG file.";
			}
		}

		$paths = [];

		if( empty( $errors ) == true ) 
		{
			if ( sizeof( $config['fileName'] ) > 1 ) 
			{
				for ( $i = 0; $i < sizeof( $config['fileName'] ); $i++ ) :

					$uploadPath = $config['fileUploadPath'] . $config['fileName'][$i];

					$dbPath = $config['dbFilePath'] . $config['fileName'][$i];

					// echo $dbPath . '<br >';

					if ( move_uploaded_file( $config['fileTempName'][$i], $uploadPath ) )
					{
						array_push( $paths, $dbPath );	
					}
					else
					{
						return false;
					}
				endfor;

				return $paths;
			}
			else
			{
				$uploadPath = $config['fileUploadPath'] . $config['fileName'][0];

				$dbPath = $config['dbFilePath'] . $config['fileName'][0];

				if ( move_uploaded_file( $config['fileTempName'][0], $uploadPath ) )
				{
					array_push( $paths, $dbPath );

					return $paths;
				}
				else
				{
					return false;
				}
			}
		}
		else
		{
			return $errors;
		}
	}

	public function account_details($id)
	{
		$sql = $this->db->where('E_USER_ID',$id)->get('product');
	return $sql->result();
		 
	}


	public function debug ( $arg )
	{
		echo "<pre>";
		print_r($arg);
		echo "<pre>";
		exit();
	}
}