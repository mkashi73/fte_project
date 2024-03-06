<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: login
	Date 		: 02/10/2018
*/

class Products_mdl extends CI_Model 
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

	public function getProduct () 
	{
		$query = "
					SELECT * 
					FROM 
						`product` AS `p`,
						`tracking_status` AS `ts`
					WHERE 
						`p`.`TRACKING_STATUS` = `ts`.`TRACKING_ID`";

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

	function productPagination( $data ) 
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
		<table class='table table-striped table-bordered product-table mt-2' style='width:100%; height: auto;'>
			
			<tr>
				<th>CN #</th>
				<th>Product Name</th>
				<th>Weight</th>
				<th>Dimension</th>
				<th>Tracking Status</th>
				<th>Date of Entry</th>
				<th>Updated On</th>
				<th>Action</th>
			</tr>";

		$i = 1;

		$userId = $data['userData']['userId'];

		if ( $query->num_rows() > 0 ) 
		{
			foreach ( $query->result_array() as $row ) 
			{
				if ( $row['EDIT_BUTTON_STATUS'] == 1 ||  $userId == 1 )
				{
					$editButtonHtml = "	<button type='button' class='btn btn-primary updateProduct' style='margin:2%;' href='#' data-toggle='modal' data-target='#update-product-modal'>
											<i class='fas fa-pencil-alt'></i>
											<input type='hidden' name='productId' class='productId' value='" . $row['PRODUCT_ID'] . "'>
										</button>";
					$deleteButtonHtml = "<button type='button' class='btn btn-danger delete-btn' style='margin:2%;'>
											<i class='fa fa-trash'></i>
											<input type='hidden' name='productId' class='productId' value='" . $row['PRODUCT_ID'] . "'>
										</button>";
				}
				else
				{
					if ( $row['EDIT_BUTTON_STATUS'] == 1 ||  $userId == 21 )
    				{
    					$editButtonHtml = "	<button type='button' class='btn btn-primary updateProduct' style='margin:2%;' href='#' data-toggle='modal' data-target='#update-product-modal'>
    											<i class='fas fa-pencil-alt'></i>
    											<input type='hidden' name='productId' class='productId' value='" . $row['PRODUCT_ID'] . "'>
    										</button>";
						$deleteButtonHtml = "";
    				}
    				else
    				{
    					if ( $row['EDIT_BUTTON_STATUS'] == 1 ||  $userId == 22 )
        				{
        					$editButtonHtml = "	<button type='button' class='btn btn-primary updateProduct' style='margin:2%;' href='#' data-toggle='modal' data-target='#update-product-modal'>
        											<i class='fas fa-pencil-alt'></i>
        											<input type='hidden' name='productId' class='productId' value='" . $row['PRODUCT_ID'] . "'>
        										</button>";
							$deleteButtonHtml = "";
        				}
        				else
        				{
        					if ( $row['EDIT_BUTTON_STATUS'] == 1 ||  $userId == 23 )
            				{
            					$editButtonHtml = "	<button type='button' class='btn btn-primary updateProduct' style='margin:2%;' href='#' data-toggle='modal' data-target='#update-product-modal'>
            											<i class='fas fa-pencil-alt'></i>
            											<input type='hidden' name='productId' class='productId' value='" . $row['PRODUCT_ID'] . "'>
            										</button>";
								$deleteButtonHtml = "";
            				}
            				else
            				{
            					$editButtonHtml = "";
								$deleteButtonHtml = "";
            				}
        				}
    				}
				}
				$output .=    "<tr>" 
								. "<td>" . $row['CN_NUMBER'] ."</td>"
								. "<td>" . $row['PRODUCT_NAME'] ."</td>"
								. "<td>" . $row['PRODUCT_GROSS_WEIGHT'] . "</td>" 
								. "<td>" . $row['PRODUCT_DIMENSION'] . "</td>"
								. "<td>" . $row['TRACKING_CODE'] . "</td>"
								. "<td>" . $row['E_DATE_TIME'] . "</td>"
								. "<td>" . $row['U_DATE_TIME'] . "</td>"
								. "<td>
										<div class='btn-group' role='group' aria-label='Basic example'>" . 
											$editButtonHtml . 
										"<div class='dropdown' style='margin:2%;'>
												<button class='btn btn-warning dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
													<i class='fas fa-eye'></i>
												</button>
												<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
													<a class='dropdown-item' href='" . base_url('product/report/invoice/') . $row['CN_NUMBER'] . "' target='_blank'>
															Invoice Slip Gift
													</a>
													<a class='dropdown-item cnClipReport' data-pid=" . $row['PRODUCT_ID'] . " href='" . base_url('product/report/cnslip/') . $row['PRODUCT_ID'] . "' target='_blank'>
															CN Slip
													</a>
													<a class='dropdown-item' href='" . base_url('product/report/fragile/goods/') . $row['PRODUCT_ID'] . "' target='_blank'>
															Fragile Goods Slip
													</a>
													<a class='dropdown-item' href='" . base_url('product/report/prohibited/items/') . $row['PRODUCT_ID'] . "' target='_blank'>
															Prohibited Item Slip
													</a>
													<a class='dropdown-item' href='" . base_url('product/report/invoice/commercial/') . $row['CN_NUMBER'] . "' target='_blank'>
															Invoice Slip Commercial
													</a>
													<a class='dropdown-item' href='" . base_url('product/report/terms/') . $row['PRODUCT_ID'] . "' target='_blank'>
															Terms and Cond
													</a>
												</div><!-- dropdown-menu -->
								            </div><!-- dropdown -->" . 
											$deleteButtonHtml .
										  	
										"</div>
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

	function productStatusPagination( $data ) 
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
		<h2>Product Status Listing</h2>
			<tr>
				<th>Product Status</th>
				<th>Action</th>
			</tr>";

		$i = 1;
		foreach ( $query->result_array() as $row ) 
		{
			$output .=    "<tr>" 
							. "<td>" . $row['PRODUCT_STATUS_NAME'] ."</td>"
							. "<td>
									<div class='btn-group' role='group' aria-label='Basic example'>
									  	<button type='button' class='btn btn-primary update-btn' style='margin:2%;' href='#' data-toggle='modal' data-target='#update-product-status-modal'>
									  		<i class='fas fa-pencil-alt'></i>
									  		<input type='hidden' name='productStatusId' class='productStatusId' value='" . $row['PRODUCT_STATUS_ID'] . "'>
									  	</button>
									  	<button type='button' class='btn btn-danger delete-btn' style='margin:2%;'>
									  		<i class='fa fa-trash'></i>
											<input type='hidden' name='productStatusId' class='productStatusId' value='" . $row['PRODUCT_STATUS_ID'] . "'>
									  	</button>
									</div>
								</td>"
						. "</tr>";	
			
			$i++;
		}

		$output .= "</table>";
		return $output;
	}

	function productTypePagination( $data ) 
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
		<h2>Product Type Listing</h2>
			<tr>
				<th>Product Type</th>
				<th>Action</th>
			</tr>";

		$i = 1;
		foreach ( $query->result_array() as $row ) 
		{
			$output .=    "<tr>" 
							. "<td>" . $row['PRODUCT_TYPE'] ."</td>"
							. "<td>
									<div class='btn-group' role='group' aria-label='Basic example'>
									  	<button type='button' class='btn btn-primary update-btn' style='margin:2%;' href='#' data-toggle='modal' data-target='#update-product-type-modal'>
									  		<i class='fas fa-pencil-alt'></i>
									  		<input type='hidden' name='productTypeId' class='productTypeId' value='" . $row['PRODUCT_TYPE_ID'] . "'>
									  	</button>
									  	<button type='button' class='btn btn-danger delete-btn' style='margin:2%;'>
									  		<i class='fa fa-trash'></i>
											<input type='hidden' name='productTypeId' class='productTypeId' value='" . $row['PRODUCT_TYPE_ID'] . "'>
									  	</button>
									</div>
								</td>"
						. "</tr>";	
			
			$i++;
		}

		$output .= "</table>";
		return $output;
	}

	/********************************
	GET SEARCH DATA FOR PRODUCT STAGE
	********************************/
	public function GetSearchProductData( $data ) 
	{
		// $output = ['productInformation', 'productStageDetail'];
		$product = '';

		$output = array(
			'productInformation' => '',
			'productStageDetail' => array()
		);
		
		if ( isset( $data['db']['select'] ) ) 
		{
			$this->db->select($data['db']['select']);
		}

		if ( isset ( $data['db']['limit'] ) )
		{
			$this->db->limit( $data['db']['limit'], $data['db']['start'] );
		}

		if ( isset ( $data['db']['join']['joined_table'] ) ) 
		{
			$this->db->join( $data['db']['join']['joined_table'], $data['db']['join']['joined_condition'] );
		}	

		if ( isset ( $data['db']['order_attribute'] ) && isset( $data['db']['order_by'] ) ) 
		{
			$this->db->order_by( $data['db']['order_attribute'], $data['db']['order_by'] );
		}	

		$query = $this->db->get_where( $data['db']['table'], $data['db']['condition'] );

		if ( $query->num_rows() > 0 )
		{
			foreach ( $query->result_array() as $row ) 
			{
				$output['productInformation'] .= '
						<label class="section-label-sm tx-gray-500">Product Information</label>
						<p class="invoice-info-row">
							<span>CN No</span>
							<span>' . $row['CN_NUMBER'] . '</span>
						</p>
						<p class="invoice-info-row">
							<span>Product Name</span>
							<span>' . $row['PRODUCT_NAME'] . '</span>
						</p>
						<p class="invoice-info-row">
							<span>Issue Date:</span>
							<span>' . $row['E_DATE_TIME'] . '</span>
						</p>
						<p class="invoice-info-row">
							<span>Current Status:</span>
							<span>' . $row['TRACKING_CODE'] . '</span>
						</p>
						<input type="hidden" id="productId" value="' . $row['PRODUCT_ID'] . '">
						';
			}
		}
		else
		{
			$output = FALSE;
		}

		return $output;
	}

	/***********************************
	GET SEARCH DATA FOR PRODUCT MULTIPLE
	***********************************/
	public function GetSearchMultipleProductData( $data ) 
	{
		// $output = ['productInformation', 'productStageDetail'];
		$product = '';

		$output = array(
			'productMultipleDetail' => '',
			'productMultipleListing'	=>	''
		);
		
		if ( isset( $data['db']['select'] ) ) 
		{
			$this->db->select($data['db']['select']);
		}

		if ( isset ( $data['db']['limit'] ) )
		{
			$this->db->limit( $data['db']['limit'], $data['db']['start'] );
		}

		if ( isset ( $data['db']['join']['joined_table'] ) ) 
		{
			$this->db->join( $data['db']['join']['joined_table'], $data['db']['join']['joined_condition'] );
		}	

		if ( isset ( $data['db']['order_attribute'] ) && isset( $data['db']['order_by'] ) ) 
		{
			$this->db->order_by( $data['db']['order_attribute'], $data['db']['order_by'] );
		}	

		$query = $this->db->get_where( $data['db']['table'], $data['db']['condition'] );

		$productMultipleQuery = $this->db->get_where( $data['productMultipleDb']['table'], $data['productMultipleDb']['condition'] );


		if ( $query->num_rows() > 0 )
		{
			foreach ( $query->result_array() as $row ) 
			{
				$output['productMultipleDetail'] .= '
						<label class="section-label-sm tx-gray-500">Product Information</label>
						<p class="invoice-info-row">
							<span>CN No</span>
							<span>' . $row['CN_NUMBER'] . '</span>
						</p>
						<p class="invoice-info-row">
							<span>Product Name</span>
							<span>' . $row['PRODUCT_NAME'] . '</span>
						</p>
						<p class="invoice-info-row">
							<span>Issue Date:</span>
							<span>' . $row['E_DATE_TIME'] . '</span>
						</p>
						<p class="invoice-info-row">
							<span>Current Status:</span>
							<span>' . $row['TRACKING_CODE'] . '</span>
						</p>
						<input type="hidden" id="productId" value="' . $row['PRODUCT_ID'] . '">
						';


				if ( $productMultipleQuery->num_rows() > 0 )
				{
					$output['productMultipleListing'] .= '
						<table id="example" class="table table-striped table-bordered" style="width:100%">
							<h2>Manage Product</h2>
							<br />
							<thead>
								<tr>
									<th style="width: 10%;">Product Name</th>
									<th style="width: 20%;">No of Pieces</th>
									<th style="width: 15%;">Unit Price</th>
									<th style="width: 20%;">Action</th>
								</tr>
							</thead>
							<tbody>';
					foreach( $productMultipleQuery->result_array() as $row ) :
						$output['productMultipleListing'] .= '
							<tr>
								<td>' . $row['PRODUCT_NAME'] . '</td>
								<td>' . $row['PRODUCT_QUANTITY'] . '</td>
								<td>' . $row['PRODUCT_PRICE'] . '</td>
								<td>          
									<div class="btn-group" role="group" aria-label="Basic example">
									  	<button type="button" class="btn btn-success edit-multiple-product" style="margin:2%;" href="#" data-toggle="modal" data-target="#modaleditmultipleproducts">
									  		<i class="fas fa-pencil-alt"></i>
									  		<input type="hidden" name="productTypeId" class="productTypeId" value="' . $row['PRODUCT_MULTIPLE_ID'] . '">
								  		</button>
									  	<button type="button" class="btn btn-danger delete-multiple-product" style="margin:2%;">
									  		<i class="fa fa-trash"></i>
									  		<input type="hidden" name="productTypeId" class="productTypeId" value="' . $row['PRODUCT_MULTIPLE_ID'] . '">
									  	</button>
									</div>
								</td>
							</tr>';
					endforeach;
					$output['productMultipleListing'] .= '
								</tbody>
							</table>';
				}
				
			}
		}
		else
		{
			$output = FALSE;
		}

		return $output;
	}

	public function GetSearchProductTrackingData( $data ) 
	{
		// $output = ['productInformation', 'productStageDetail'];
		$product = '';

		$output = array(
			'productInformation' => ''
		);
		
		if ( isset( $data['db']['select'] ) ) 
		{
			$this->db->select($data['db']['select']);
		}

		if ( isset ( $data['db']['limit'] ) )
		{
			$this->db->limit( $data['db']['limit'], $data['db']['start'] );
		}

		if ( isset ( $data['db']['join']['joined_table'] ) ) 
		{
			$this->db->join( $data['db']['join']['joined_table'], $data['db']['join']['joined_condition'] );
		}	

		if ( isset ( $data['db']['order_attribute'] ) && isset( $data['db']['order_by'] ) ) 
		{
			$this->db->order_by( $data['db']['order_attribute'], $data['db']['order_by'] );
		}	

		$productStageQuery = '	SELECT 
								p.`PRODUCT_ID`, 
								p.`PRODUCT_TYPE_ID`, 
								p.`PRODUCT_CONDITION_ID`, 
								p.`PRODUCT_NAME`, 
								p.`DESCRIPTION`, 
								p.`PRODUCT_GROSS_WEIGHT`, 
								p.`PRODUCT_NET_WEIGHT`, 
								p.`PRODUCT_DIMENSION`, 
								p.`PRODUCT_IMAGE`, 
								p.`CLUB_NUMBER`, 
								p.`SHIPPER_NAME`, 
								p.`SHIPPER_E_ADDRESS`, 
								p.`SHIPPER_ADDRESS`, 
								p.`SHIPPER_PHONE`,
								p.`SHIPPER_ZIP_CODE`, 
								p.`CONSIGNEE_NAME`, 
								p.`CONSIGNEE_PHONE_NUMBER`, 
								p.`CONSIGNEE_ZIP_CODE`,
								p.`CONSIGNEE_ADDRESS`, 
								p.`CONSIGNEE_E_ADDRESS`, 
								p.`CN_NUMBER`, 
								p.`BALANCE_AMOUNT`, 
								p.`CONSIGNEE_AMOUNT`, 
								p.`QUANTITY`, 
								p.`EXT_TRACKING_NUMBER`, 
								p.`TRACKING_STATUS`, 
								p.`PRODUCT_STATUS`, 
								psd.`PRODUCT_STAGE_ID`, 
								psd.`PRODUCT_ID`, 
								psd.`PRODUCT_STAGE_DETAIL`, 
								psd.`STATUS`, 
								psd.`REGISTRY_DATE`,
								psd.`E_USER_ID`, 
								psd.`E_DATE_TIME`, 
								psd.`U_USER_ID`, 
								psd.`U_DATE_TIME`, 
								ps.`P_STAGE_NAME` 
							FROM 
							`product` AS p
							INNER JOIN
							product_stage_detail as psd
							ON 
							psd.PRODUCT_ID = p.PRODUCT_ID
							INNER JOIN
							product_stage AS ps
							ON 
							psd.PRODUCT_STAGE_ID = ps.PRODUCT_STAGE_ID
							WHERE
							p.CN_NUMBER = "' . $data['db']['condition']['product.CN_NUMBER'] . '"';

		$queryResult = $this->db->query( $productStageQuery );

		$productStageRows = $queryResult->result_array();

		$query = $this->db->get_where( $data['db']['table'], $data['db']['condition'] );

		// PRODUCT QUERY FOR EXTERNAL NUMBER AND COMPANY NAME
		$productQuery = "
							SELECT *
							FROM
							product AS p
							INNER JOIN 
							company AS c
							ON 
							p.COMPANY_ID = c.COMPANY_ID
							AND p.CN_NUMBER = '" . $data['db']['condition']['product.CN_NUMBER'] . "'";
		
		$productQueryResult = $this->db->query($productQuery);

		if ( $productQueryResult->num_rows() > 0 )
		{	
			$productQueryData = $productQueryResult->result_array()[0];

			$extNumber = $productQueryData['EXT_TRACKING_NUMBER'];

			$companyName = '<strong>
								<a href="' . $productQueryData['COMPANY_WEB_URL'] . '" 
									title="' . $productQueryData['COMPANY_NAME'] . '" 
									target="_blank">' . $productQueryData['COMPANY_NAME'] . '
								</a>
							</strong>';
		}
		else
		{
			$extNumber = '';

			$companyName = '';
		}

		// END OF QUERY OPERATION 

		// print_r( $productQueryData );
		
		if ( $query->num_rows() > 0 )
		{
			foreach ( $query->result_array() as $row ) 
			{
				$output['productInformation'] .= '
													<div class="section-wrapper">
														<table  class="table table-striped table-bordered">
															<tr>
																<td>					
																	<h4 style="color: black">
																	Product Name: 
																		<label style="color: grey;" id="lblproductName">
																		' . $row['PRODUCT_NAME'] . '
																		</label>
																	</h4>					
																</td>
															</tr>
															<tr>
																<td>					
																	<h4 style="color: black;">CN Number: 
																		<label style="color: grey;" id="lblproductName">
																		' . $row['CN_NUMBER'] . '
																		</label>
																	</h4>						
																</td>
																
															</tr>	
															
														</table><br />
														
																	
														<span style="font-size: 20px;">Sender\'s Information--</span><br />
														<table  class="table table-striped table-bordered">
															<tr>
																<td>					
																	<span>Shipper Name: </span>
																	<label id="lblShipperName">
																	' . $row['SHIPPER_NAME'] . '
																	</label>
																	<br />					
																</td>
																<td>					
																	<span>Shipper Phone: </span>
																	<label id="lblShipperPhone">
																	' . $row['SHIPPER_PHONE'] . '
																	</label>
																	<br />					
																</td>
															</tr>
															<tr>
																<td>					
																	<span>Shipper Email: </span>
																	<label id="lblShipperEmail">
																	' . $row['SHIPPER_E_ADDRESS'] . '
																	</label>
																	<br />					
																</td>
																<td>					
																	<span>Shipper ZipCode: </span>
																	<label id="lblShipperZipCode">
																	' . $row['SHIPPER_ZIP_CODE'] . '
																	</label>
																	<br />					
																</td>				
															</tr>
															<tr>
															<td colspan="2"  style="width: 300px; padding: 15px;">
																<span>Shipper Address: </span>
																<label id="lblShipperAddress">
																' . $row['SHIPPER_ADDRESS'] . '
																</label>
																<br />
															</td>
															</tr>
														</table><br />
														<span style="font-size: 20px;">Receiver Information--</span><br />
														<table  class="table table-striped table-bordered">
															<tr>
																<td>					
																	<span>Receiver Name: </span>
																	<label id="lblreceiverName">
																	' . $row['CONSIGNEE_NAME'] . '
																	</label>
																	<br />					
																</td>
																<td>					
																	<span>Receiver Phone: </span>
																	<label id="lblreceiverPhone">
																	' . $row['CONSIGNEE_PHONE_NUMBER'] . '
																	</label>
																	<br />					
																</td>
															</tr>
															<tr>
																<td>					
																	<span>Receiver Email: </span>
																	<label id="lblreceiverEmail">
																	' . $row['CONSIGNEE_E_ADDRESS'] . '
																	</label>
																	<br />					
																</td>
																<td>					
																	<span>Receiver ZipCode: </span>
																	<label id="lblreceiverZipCode">
																	' . $row['CONSIGNEE_ZIP_CODE'] . '
																	</label>
																	<br />					
																</td>				
															</tr>
															<tr>
															<td colspan="2">
																<span>Receiver Adress: </span>
																<label id="lblreceiverAddress">
																' . $row['CONSIGNEE_ADDRESS'] . '
																</label>
																<br />
															</td>
															</tr>
														</table><br />
														<span style="font-size: 20px;">External Tracking Information--</span><br />
														<table  class="table table-striped table-bordered">
															<tr>
																<td style="width: 47%">					
																	<span>External Tracking: </span>
																	<label id="lblexternalTracking">
																	' . $extNumber . '
																	</label>
																	<br />					
																</td>
																<td style="width: 53%">					
																	<span>Company: </span>
																	<label id="lblcompnayName">
																	' . $companyName . '
																	</label>
																	<br />					
																</td>
															</tr>
															
														</table><br />
														<span style="font-size: 20px;">Parcel Movement--</span><br />
														<table  class="table table-striped table-bordered">';
				if ( $queryResult->num_rows() > 0 ) 
				{
					$i = 0;
					foreach( $productStageRows as $row ) 
					{
						// print_r( $row );

						$output['productInformation'] .=	'<tr>
																<td>					
																	<label id="lblStage">
																		' . $row['P_STAGE_NAME'] . '
																	</label>					
																</td>
																<td>					
																	<label id="lblRemarks">
																		' . $row['PRODUCT_STAGE_DETAIL'] . '
																	</label>	
																	<br />
																</td>
																<td>					
																	<strong>' . $row['REGISTRY_DATE'] . '</strong>			
																</td>
															</tr>';
						$i++;
					}
				}
				else
				{
					$output['productInformation'] .= '<tr>
														<td style="color: red; font-style: italic; font-weight : bold">Your parcel is in process</td>
													  </tr>';
				}
				
				$output['productInformation'] .=   		'</table>
													</div>';
			}
		}
		else
		{
			$output = FALSE;
		}
		return $output;
	}
	public function getProductStage( $productId )
	{
		$product = '';

		$productStageQuery = $this->db->get('product_stage');

		$companyQuery = $this->db->get('company');

		$companyRecord = $companyQuery->result_array();

		if ( $productStageQuery->num_rows() > 0 ) 
		{
			$record = $productStageQuery->result_array();

			$i = 1;
			foreach( $record as $row ) :
				$condition = array(
					'PRODUCT_ID' => $productId,
					'PRODUCT_STAGE_ID' => $row['PRODUCT_STAGE_ID']
				);

				$productStageRecord = $this->db->get_where('product_stage_detail', $condition);

				if ( $productStageRecord->num_rows() == 0 ) :

					$product .= '
					<div id="accordion" class="accordion-one product-stage" role="tablist" aria-multiselectable="true">
						<div class="card">
							<div class="card-header" role="tab" id="heading' . $row['PRODUCT_STAGE_ID'] . '">
								<a class="collapsed tx-gray-800 transition" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $row['PRODUCT_STAGE_ID'] . '" aria-expanded="false" aria-controls="collapse' . $row['PRODUCT_STAGE_ID'] . '">
									Stage ' . $row['PRODUCT_STAGE_ID'] . '
								</a>
							</div>
							<div id="collapse' . $row['PRODUCT_STAGE_ID'] . '" class="collapse" role="tabpanel" aria-labelledby="heading' . $row['PRODUCT_STAGE_ID'] . '">
								<div class="card-body">
									<form class="add-product-stage-form">
										<div class="row no-gutters">
											<div class="col-md-4">
												<h3>' . $row['P_STAGE_NAME'] .'</h3>
												<input type="hidden" name="productStageId" class="productStageId" value="' . $row['PRODUCT_STAGE_ID'] . '">
											</div>
											<div class="col-md-3">
												<button type="submit" class="btn-demo btn btn-success" style="width: 70%">
													<i class="fa fa-paper-plane mg-r-5"></i> 
													Update
												</button>
												<div class="wd-200 mg-b-30" style="margin-top: 5px;">
												  <div class="input-group">
													<div class="input-group-prepend">
													  <div class="input-group-text">
														<i class="icon ion-calendar tx-16 lh-0 op-6"></i>
													  </div>
													</div>
													<input type="text" name="productStageDate" class="form-control fc-datepicker" placeholder="DD-MM-YYYY">
												  </div>
												</div><!-- wd-200 -->
											</div>
											<div class="col-md-5">
												<textarea class="form-control" name="productStageDetail" placeholder="Remarks"></textarea>
											</div>
										</div><!-- Row -->
									</form>
								</div>
							</div>
						</div>
					</div>	
					<br />';
				endif;
				$i++;
			endforeach;
		}

		// PRODUCT RESULT FOR EXTERNAL NUMBER
		$condition = array(
			'PRODUCT_ID'	=>	$productId
		);

		$productRecord = $this->db->get_where('product', $condition);

		$productResult = $productRecord->result_array()[0];

		// EXTERNAL NUMBER & COMPANY FETCH DATA
		$product .= '<form id="update-product-data">
						<div class="row no-gutters">
							<div class="col-md-3">					
								<input style="width: 98%;" type="text" name="extNumber" class="form-control" value="' . $productResult['EXT_TRACKING_NUMBER'] . '" placeholder="External CN"> 
							</div>
							<div class=" col-md-3">
								<select class="form-control" name="companyId">
									<option value=""><-- Select Company --></option>';
									// FETCH COMPANIES
									foreach( $companyRecord as $row ) 
									{
										if ( $productResult['COMPANY_ID']  == $row['COMPANY_ID'] ) 
										{
											$product .= '<option value="' . $row['COMPANY_ID'] . '" selected="selected">' . $row['COMPANY_NAME'] . '</option>';
										}
										else
										{
											$product .= '<option value="' . $row['COMPANY_ID'] . '">' . $row['COMPANY_NAME'] . '</option>';
										}
									}
							$product .=	'</select>
							</div>
							<input type="hidden" name="productId" value="' . $productId . '" />
							<div class="col-md-3 offset-md-2">
								<button type="submit" class="btn btn-success mg-b-10 update-data" style="width:90%">Update</button>	
							</div>
						</div>
					</form>';
		return $product;
	}

	// ADDED BY TAIMUR FOR GETTNG PAYMENT AND GENERATING LEDGER

public function Payment($ledger)
    {
    	
    	   	$c_id    	= 	$ledger['CLIENT_ID'];
			$payment 	=	$ledger['PAYMENT'];
			$recieved 	=	$ledger['RECIEVED'];
			$shipper 	= 	$ledger['SHIPPER'];
			$ProductId 	= 	$ledger['PRODUCT_ID'];
			$u_id 		=	$ledger['USER_ID'];
			$name 		=	$ledger['NAME'];
			$status 	=	$ledger['STATUS'];
			$last 		=	$ledger['CN_NUMBER'];
		 	$net_weight =	$ledger['WEIGHT'];
					 

    	$query ="select * from payment  where CLIENT_ID = '".$c_id."' order by PAY_ID desc limit 1  ";
    	$sql = $this->db->query($query);
 
	 	if ($sql->num_rows() > 0) {
	 		foreach ($sql->result() as $key) {

	 		$rem = $key->TOTAL_PENDING;
	 		$cri = $key->CREDIT;
	 		}


	 		if ($cri > $rem ) {

	 			$now = $cri - $payment;

	 			if ($now > 0 ) {

		 			$data =  array(
		 			'PAY_NUMBER' 		=> 	$last, 
		 			'SHIPPER_NAME' 		=> $shipper,
		 			'PAY_REMARKS'		=>	$name,
		 			'NET_WEIGHT'		=>  $net_weight,
		 			'PAY_TYPE'			=>  $status,
		 			'PAY_PENDING'		=>	$payment, 
		 			'PAY_RECEIVE'		=>	$payment,
		 			'TOTAL_PENDING' 	=>	'0',
		 			'CREDIT' 			=>	$now,
		 			'CLIENT_ID' 		=>	$c_id, 
		 			'PRODUCT_ID'		=>  $ProductId,
		 			'USER_ID'			=>  $u_id,
		 			'DATE'				=>	getDateOffset()
		 			);

	 				return $this->db->insert('payment', $data);

	 			}
	 			else{
	 				$a = '-1';
	 				$new1 = $now * $a; 
	 			$data =  array(
	 				'PAY_NUMBER' 		=> 	$last, 
	 				'SHIPPER_NAME' 		=> $shipper,
		 			'PAY_REMARKS'		=>	$name,
		 			'NET_WEIGHT'		=>  $net_weight,
		 			'PAY_TYPE'			=>  $status,
		 			'PAY_PENDING'		=>	$payment, 
		 			'PAY_RECEIVE'		=>	$recieved,
		 			'TOTAL_PENDING' 	=>	$new1,
		 			'CREDIT' 			=>	'0',
		 			'CLIENT_ID' 		=>	$c_id , 
			 		'PRODUCT_ID'		=> $ProductId,
			 		'USER_ID'	        => $u_id,
		 			'DATE'				=>	getDateOffset()
	 			);

	 			return $this->db->insert('payment', $data);
	 		}


	 		}
	 		else{

	 			$newTotal = $rem+$payment;

	 			$data =  array(
	 				'PAY_NUMBER' 		=> 	$last, 
	 				'SHIPPER_NAME' 		=> $shipper,
		 			'PAY_REMARKS'		=>	$name,
		 			'NET_WEIGHT'		=>  $net_weight,
		 			'PAY_TYPE'			=>  $status,
		 			'PAY_PENDING'		=>	$payment, 
		 			'PAY_RECEIVE'		=>	$recieved,
		 			'TOTAL_PENDING' 	=>	$newTotal,
		 			'CREDIT' 			=>	'0',
		 			'CLIENT_ID' 		=>	$c_id ,
			 		'PRODUCT_ID'		=> $ProductId,
			 		'USER_ID'	        => $u_id,


	 				'DATE'				=>	getDateOffset()
	 			);

	 			return $this->db->insert('payment', $data);

	 		}

	 	}
	 	else{

	 		$data =  array(
	 				'PAY_NUMBER' 		=> 	$last, 
	 				'SHIPPER_NAME'		=> $shipper,
		 			'PAY_REMARKS'		=>	$name,
		 			'NET_WEIGHT'		=>  $net_weight,
		 			'PAY_TYPE'			=>  $status,
		 			'PAY_PENDING'		=>	$payment, 
		 			'PAY_RECEIVE'		=>	$recieved,
		 			'TOTAL_PENDING' 	=>	$payment,
		 			'CREDIT' 			=>	'0',
		 			'CLIENT_ID' 		=>	$c_id ,
			 		'PRODUCT_ID'		=> $ProductId,
			 		'USER_ID'	        => $u_id,


	 			'DATE'				=>	getDateOffset()
	 			);
	 		return $this->db->insert('payment', $data);

	 	}
    } 

	
}