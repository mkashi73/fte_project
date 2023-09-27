<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: login
	Date 		: 02/10/2018
*/
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductManifestController extends MX_Controller 
{
	public function __construct() 
	{
		parent::__construct();

		$this->load->model('Products_mdl', 'product');
		$this->load->library('Pagination');

		
	}

	public function index()
	{
		if ( $this->common->checkUserRole( $this->tokenData['role_id'] ) ) 
		{
			$parent_menu = $this->getMenu;
			
			$tokenData = getTokenData('token');

			// $this->debug(getTokenData('token'));
			if ( $tokenData['id'] == 1 || $tokenData['id'] == 21 || $tokenData['id'] == 22 || $tokenData['id'] == 23 )
			{
				$userDbData = array(
					'select'	=> 	'*',
					'table'		=>	'users',
				);
			}
			else
			{
				$userDbData = array(
					'select'	=> 	'*',
					'table'		=>	'users',
					'condition'	=>	'USER_ID != 1 AND USER_ID = ' . $tokenData['id']
				);
			}
			

			$data = array(
				"links"				=>	array(
					"show_menu"		=> 	$parent_menu
				),
				"headerData"		=>	array(
					"companyName"	=>	'FTE',
					"pageName"		=>	'Product Manifest'
				),
				"users"				=>	$this->common->getRecord($userDbData),
				"token"				=>	$tokenData,
				"filepath"			=>	'product_manifest/product_manifest.js'
			);

			$this->load->view('common/header', $data);
			$this->load->view('common/sidebar', $data);
			$this->load->view('products/product_manifest_vw', $data);
			$this->load->view('common/footer', $data);
		}
		else
		{
			echo json_encode( array( "code" => BAD_DATA, 'message' => $this->msg['auth_msg']['auth_error']) );
		} // end of Role validation
	}

	public function GenerateManifest()
	{	
		$tokenData = getTokenData('token');

		if ( !empty ( $_POST['mabNumber'] ) ) 
		{
			$mabNumber = ' AND p.MAB_NUMBER = "' . $_POST['mabNumber'] . '"';
		}
		else
		{
			$mabNumber = '';
		}

		// USA id
		if( $_POST['countryId'] == 224 ) 
		{
			$countryQuery = "p.CONSIGNEE_COUNTRY_ID IN ( '9', '30', '31', '38', '41', '48', '63', '92', '176', '168', '198', '223', '228', '25', '32', '52', '108', '97', '61', '173', '214', '224', '187' )";
		}
		// UK id
		else if ( $_POST['countryId'] == 77 )
		{
			$countryQuery = "p.CONSIGNEE_COUNTRY_ID IN ( '241', '242', '10', '16', '17', '27', '19', '26', '23', '96', '55', '243', '60', '68', '70', '73', '78', '57', '86', '98', '105', '102', '107', '244', '245', '129', '124', '127', '128', '140', '133', '246', '159', '138', '160', '172', '175', '181', '182', '194', '247', '199', '200', '67', '201', '40', '216', '221', '77', '226' , '56')";
		}
		
		// UK All Countries
		else if ( $_POST['countryId'] == 01 )
		{
			$countryQuery = "p.CONSIGNEE_COUNTRY_ID IN ( '182', '15', '163', '117', '150', '99', '169', '231', '42', '93', '208', '218', '187', '216', '221', '241', '27', '26', '23', '55', '56', '68', '80', '98', '105', '110', '172')";
		}
		else
		{
			$countryQuery = "";
		}

		if( !empty( $_POST['userID'] ) ) 
		{
			$userId = ' AND p.E_USER_ID =' . $_POST['userID'];
		}
		else
		{
			$userId = '';
		}

		if ( !empty ( $_POST ['fromDate'] ) ) 
		{
			$fromDate = getDateForDatabase ( $_POST ['fromDate'] );
		}
		else
		{
			$fromDate = '';
		}

		if ( !empty ( $_POST ['toDate'] ) ) 
		{   
			$toDate = getDateForDatabase ( $_POST ['toDate'] );
		}
		else
		{
			$toDate = '';
		}

		// FROM DATE
		if ( !empty ( $fromDate ) && !empty ( $toDate ) ) 
		{
			$fromDate = getDateForDatabase( $fromDate );


			$toFromDate = " AND ( p.E_DATE_TIME >  '{$fromDate} 00:00:00' AND p.E_DATE_TIME < DATE_ADD( '{$toDate} 23:59:59', INTERVAL 5 HOUR) )"; 
		}
		else
		{
			$toFromDate = '';
			$fromDate = '';
			$toDate = '';
		}

		if (
				!empty( $countryQuery )
				|| !empty ( $mabNumber ) 
				|| !empty ( $userId )
				|| !empty ( $toFromDate )
				|| !empty ( $fromDate )
				|| !empty ( $toDate )
			) 
		{
			$whereClause = ' WHERE ';
		}
		else
		{
			$whereClause = '';
		}

		// USA id
		if  ( !empty( $countryQuery )
			  || !empty ( $mabNumber ) 
			  || !empty ( $userId )
			  || !empty( $toFromDate )
			  || !empty( $fromDate )
			  || !empty( $toDate )
			) 
		{

			if ( $tokenData['id'] == 1 || $tokenData['id'] == 21 || $tokenData['id'] == 22 || $tokenData['id'] == 23  ) 
			{
				$query = "
					SELECT 
					p.CN_NUMBER, 
					p.EXT_TRACKING_NUMBER,
					p.MAB_NUMBER, 
					p.PRODUCT_NAME, 
					p.SHIPPER_NAME,
					p.SHIPPER_ADDRESS,
					p.SHIPPER_PHONE,
					p.BAG_NUMBER, 
					p.CONSIGNEE_NAME,
					p.CONSIGNEE_ADDRESS, 
					p.QUANTITY, 
					p.PRODUCT_DIMENSION, 
					p.PRODUCT_NET_WEIGHT, 
					p.MAB_NUMBER,
					p.E_USER_ID, 
					p.E_DATE_TIME 
					FROM 
					product AS p " .
					$whereClause . 
					$countryQuery . 
					$mabNumber . 
					$userId .
					$toFromDate;
			}
			else 
			{
				$query = "
				SELECT 
				p.CN_NUMBER, 
				p.EXT_TRACKING_NUMBER,
				p.MAB_NUMBER, 
				p.PRODUCT_NAME, 
				p.SHIPPER_NAME,
				p.CONSIGNEE_NAME,
				p.SHIPPER_ADDRESS, 
				p.SHIPPER_PHONE,
				p.BAG_NUMBER, 
				p.CONSIGNEE_ADDRESS, 
				p.QUANTITY, 
				p.PRODUCT_DIMENSION, 
				p.PRODUCT_NET_WEIGHT, 
				p.MAB_NUMBER,
				p.E_USER_ID, 
				p.E_DATE_TIME 
				FROM 
				product AS p " .
				$whereClause . 
				$countryQuery .
				$mabNumber . 
				$toFromDate . 
				" AND p.E_USER_ID = " . $tokenData['id'];
			} 
    
    
            
			$data['result'] = $this->common->getRecordByCustomQuery( $query );
		
			$data['total_bags'] = '';
			$data['total_parcels'] = '';

			if ( $data['result'] ) 
			{
				foreach( $data['result'] AS $record ) 
				{
					$data['total_bags'] .= $record['BAG_NUMBER'] . ',';
					$data['total_parcels'] .= $record['CN_NUMBER'] . ',';
				}

				$data['total_bags'] = rtrim($data['total_bags'], ',');
				$data['total_parcels'] = rtrim($data['total_parcels'], ',');
				

				$data['total_bags'] = sizeOf( explode( ',', $data['total_bags'] ) );
				$data['total_parcels'] = sizeOf( explode( ',', $data['total_parcels'] ) );
			}
			else if ( empty ( $data['result'] ) )
			{
				echo json_encode ( 
					array 
					(
						'code'	=>	403,
						'message' => 'No record found'
					)
				);

				exit();
			}

		}
		else
		{
			echo json_encode ( 
					array 
					(
						'code'	=>	403,
						'message' => 'No record found'
					)
				);
			exit();
		}
		// $this->debug( $data );
		$this->load->view('products/reports/product_manifest_vw', $data );

	}

	public function GenerateManifestExcel()
	{
		$tokenData = getTokenData('token');

		if ( !empty ( $_POST['mabNumber'] ) ) 
		{
			$mabNumber = ' AND p.MAB_NUMBER = "' . $_POST['mabNumber'] . '"';
		}
		else
		{
			$mabNumber = '';
		}

		// USA id
		if( $_POST['countryId'] == 224 ) 
		{
			$countryQuery = "p.CONSIGNEE_COUNTRY_ID IN ( '9', '30', '31', '38', '41', '48', '63', '92', '176', '168', '198', '223', '228', '25', '32', '52', '108', '97', '61', '173', '214', '224', '187' )";
		}
		// UK id
		else if ( $_POST['countryId'] == 77 )
		{
			$countryQuery = "p.CONSIGNEE_COUNTRY_ID IN ( '241', '242', '10', '16', '17', '27', '19', '26', '23', '96', '55', '243', '60', '68', '70', '73', '78', '57', '86', '98', '105', '102', '107', '244', '245', '129', '124', '127', '128', '140', '133', '246', '159', '138', '160', '172', '175', '181', '182', '194', '247', '199', '200', '67', '201', '40', '216', '221', '77', '226', '56' )";
		}
		// UK All Countries
		else if ( $_POST['countryId'] == 01 )
		{
			$countryQuery = "p.CONSIGNEE_COUNTRY_ID IN ( '182', '15', '163', '117', '150', '99', '169', '231', '42', '93', '208', '218', '187', '216', '221', '241', '27', '26', '23', '55', '56', '68', '80', '98', '105', '110', '172')";
		}
		else
		{
			$countryQuery = "";
		}

		if( !empty( $_POST['userID'] ) ) 
		{
			$userId = ' AND p.E_USER_ID =' . $_POST['userID'];
		}
		else
		{
			$userId = '';
		}

		if ( !empty ( $_POST ['fromDate'] ) ) 
		{
			$fromDate = getDateForDatabase ( $_POST ['fromDate'] );
		}
		else
		{
			$fromDate = '';
		}

		if ( !empty ( $_POST ['toDate'] ) ) 
		{
			$toDate = getDateForDatabase ( $_POST ['toDate'] );
		}
		else
		{
			$toDate = '';
		}

		// FROM DATE
		if ( !empty ( $fromDate ) && !empty ( $toDate ) ) 
		{
			$fromDate = getDateForDatabase( $fromDate );


			$toFromDate = ' AND ( p.E_DATE_TIME > "' . $fromDate . ' 00:00:00" AND p.E_DATE_TIME < "' . $toDate . ' 23:59:59" )'; 
		}
		else
		{
			$toFromDate = '';
			$fromDate = '';
			$toDate = '';
		}
		
		

		if (
				!empty( $countryQuery )
				|| !empty ( $mabNumber ) 
				|| !empty ( $userId )
				|| !empty ( $toFromDate )
				|| !empty ( $fromDate )
				|| !empty ( $toDate )
			) 
		{
			$whereClause = ' WHERE ';
		}
		else
		{
			$whereClause = '';
		}

		// USA id
		if  ( !empty( $countryQuery )
			  || !empty ( $mabNumber ) 
			  || !empty ( $userId )
			  || !empty( $toFromDate )
			  || !empty( $fromDate )
			  || !empty( $toDate )
			) 
		{

			if ( $tokenData['id'] == 1 || $tokenData['id'] == 21 || $tokenData['id'] == 22 || $tokenData['id'] == 23  ) 
			{
				$query = "
					SELECT 
					p.CN_NUMBER, 
					p.EXT_TRACKING_NUMBER,
					p.MAB_NUMBER, 
					p.PRODUCT_NAME, 
					p.SHIPPER_NAME,
					p.SHIPPER_ADDRESS,
					p.SHIPPER_PHONE,
					p.DESCRIPTION,
					p.CONSIGNEE_AMOUNT,
					p.BAG_NUMBER, 
					p.CLUB_NUMBER,
					p.CONSIGNEE_NAME,
					p.CONSIGNEE_ADDRESS, 
					p.CONSIGNEE_ZIP_CODE,
					p.CONSIGNEE_COUNTRY_ID,
					p.CONSIGNEE_STATE_ID,
					p.CONSIGNEE_CITY_ID,
					p.CONSIGNEE_PHONE_NUMBER,
					p.QUANTITY, 
					p.PRODUCT_DIMENSION, 
					p.PRODUCT_NET_WEIGHT, 
					p.MAB_NUMBER,
					p.E_USER_ID, 
					p.E_DATE_TIME,
					
				        c2.COUNTRY_ID,
				        c2.COUNTRY AS CONSIGNEE_COUNTRY,
				        
				        st2.STATE_ID,
				        st2.STATE AS CONSIGNEE_STATE,
				        
				        ct2.CITY_ID,
				        ct2.CITY AS CONSIGNEE_CITY
					FROM 
					product AS p 
					
						
						
						
				        INNER JOIN
						country AS c2
						ON
						p.CONSIGNEE_COUNTRY_ID = c2.COUNTRY_ID
						
						INNER JOIN
						state AS st2
						ON
						p.CONSIGNEE_STATE_ID = st2.STATE_ID
				        
				        INNER JOIN
						city AS ct2
						ON
						p.CONSIGNEE_CITY_ID = ct2.CITY_ID
					" .
					$whereClause . 
					$countryQuery . 
					$mabNumber . 
					$userId .
					$toFromDate;
			}
			else 
			{
				$query = "
				SELECT 
				p.CN_NUMBER, 
				p.EXT_TRACKING_NUMBER,
				p.MAB_NUMBER, 
				p.PRODUCT_NAME, 
				p.SHIPPER_NAME,
				p.CONSIGNEE_NAME,
				p.SHIPPER_ADDRESS, 
				p.SHIPPER_PHONE,
				p.DESCRIPTION,
				p.CONSIGNEE_AMOUNT,
				p.BAG_NUMBER, 
				p.CLUB_NUMBER,
				p.CONSIGNEE_ADDRESS, 
				p.CONSIGNEE_ZIP_CODE,
				p.CONSIGNEE_COUNTRY_ID,
				p.CONSIGNEE_STATE_ID,
				p.CONSIGNEE_CITY_ID,
				p.CONSIGNEE_PHONE_NUMBER,
				p.QUANTITY, 
				p.PRODUCT_DIMENSION, 
				p.PRODUCT_NET_WEIGHT, 
				p.MAB_NUMBER,
				p.E_USER_ID, 
				p.E_DATE_TIME,
				
				c2.COUNTRY_ID,
				c2.COUNTRY AS CONSIGNEE_COUNTRY,
				
				st2.STATE_ID,
				st2.STATE AS CONSIGNEE_STATE,
				
				ct2.CITY_ID,
				ct2.CITY AS CONSIGNEE_CITY
				FROM 
				product AS p 
				        INNER JOIN
						country AS c2
						ON
						p.CONSIGNEE_COUNTRY_ID = c2.COUNTRY_ID
						
						INNER JOIN
						state AS st2
						ON
						p.CONSIGNEE_STATE_ID = st2.STATE_ID
				        
				        INNER JOIN
						city AS ct2
						ON
						p.CONSIGNEE_CITY_ID = ct2.CITY_ID
						
						
				" .
				$whereClause . 
				$countryQuery .
				$mabNumber . 
				$toFromDate . 
				" AND p.E_USER_ID = " . $tokenData['id'];
				
			} 
    
            
			$data['result'] = $this->common->getRecordByCustomQuery( $query );
			
			
			$data['total_bags'] = '';
			$data['total_parcels'] = '';

			if ( $data['result'] ) 
			{
				foreach( $data['result'] AS $record ) 
				{
					$data['total_bags'] .= $record['BAG_NUMBER'] . ',';
					$data['total_parcels'] .= $record['CN_NUMBER'] . ',';
				}

				$data['total_bags'] = rtrim($data['total_bags'], ',');
				$data['total_parcels'] = rtrim($data['total_parcels'], ',');
				

				$data['total_bags'] = sizeOf( explode( ',', $data['total_bags'] ) );
				$data['total_parcels'] = sizeOf( explode( ',', $data['total_parcels'] ) );
			}
			else if ( empty ( $data['result'] ) )
			{
				echo json_encode ( 
					array 
					(
						'code'	=>	403,
						'message' => 'No record found'
					)
				);

				exit();
			}


			// debug($data);

			$spreadsheet = new Spreadsheet();
			//  = $spreadsheet->getActiveSheet();
			$cell_name = "A1";

			$styleArray = [
				'font' => [
					'bold' => true,
				],
				'borders' => [
					'allBorders' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
						'color' => ['argb' => '00000000'],
					],
				],
			];

			$detaiStyleArray = [
				'borders' => [
					'allBorders' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
						'color' => ['argb' => '00000000'],
					],
				],
			];
			// $sheet->setCellValue('A1', 'Hello World !');
			// DATE
			$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(8);
			
			// NUMBER OF PARCELS
			$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(8);
			$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(12);
			$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(12);
			$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(8);
			$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(12);
			$spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(8);
			$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(8);
			$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(8);
			$spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(8);
			$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
			$spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(8);
			

			// DATE
			$spreadsheet->getActiveSheet()->setCellValue('A1', "Dated: ({$data['result'][0]['E_DATE_TIME']})")->getStyle('A1')->applyFromArray($styleArray);
			
			// NUMBER OF PARCELS
			$spreadsheet->getActiveSheet()->setCellValue('B1', "No of Parcels: ({$data['total_parcels']})")->getStyle('B1')->applyFromArray($styleArray);
			
			// MAWB NUMBER
			$spreadsheet->getActiveSheet()->setCellValue('C1', "MAWB #: ({$data['result'][0]['MAB_NUMBER']})")->getStyle('C1')->applyFromArray($styleArray);
			
			// TOTAL BAGS
			$spreadsheet->getActiveSheet()->setCellValue('D1', "Total Bags: ({$data['total_bags']})")->getStyle('D1')->applyFromArray($styleArray);
			
			// SERIEL NUMBER
			$spreadsheet->getActiveSheet()->setCellValue('A3', "Sr No ")->getStyle('A3')->applyFromArray($styleArray);

			// AWB / CN NUMBER
			$spreadsheet->getActiveSheet()->setCellValue('B3', "AWB #")->getStyle('B3')->applyFromArray($styleArray);

			// CLUB NUMBER
			$spreadsheet->getActiveSheet()->setCellValue('C3', "Club #")->getStyle('C3')->applyFromArray($styleArray);

			
			
			// SHIPPER NAME
			$spreadsheet->getActiveSheet()->setCellValue('D3', "Shipper Name")->getStyle('D3')->applyFromArray($styleArray);
			
			// SHIPPER DETAIL
			$spreadsheet->getActiveSheet()->setCellValue('E3', "Shipper Detail")->getStyle('E3')->applyFromArray($styleArray);
			
			// DESCRIPTION
			$spreadsheet->getActiveSheet()->setCellValue('F3', "Description")->getStyle('F3')->applyFromArray($styleArray);
			
			// PIECES
			$spreadsheet->getActiveSheet()->setCellValue('G3', "PCS")->getStyle('G3')->applyFromArray($styleArray);
			
			// WEIGHT
			$spreadsheet->getActiveSheet()->setCellValue('H3', "Weight")->getStyle('H3')->applyFromArray($styleArray);
			
			// DIMENSION
			$spreadsheet->getActiveSheet()->setCellValue('I3', "Dimension")->getStyle('I3')->applyFromArray($styleArray);
			
			// BAG NO
			$spreadsheet->getActiveSheet()->setCellValue('J3', "Bag no")->getStyle('J3')->applyFromArray($styleArray);
			
			// CONSIGNEE NAME
			$spreadsheet->getActiveSheet()->setCellValue('K3', "Consignee Name")->getStyle('K3')->applyFromArray($styleArray);
			
			// CONSIGNEE DETAIL
			$spreadsheet->getActiveSheet()->setCellValue('L3', "Consignee Detail")->getStyle('L3')->applyFromArray($styleArray);
			
            // Consignee City
			$spreadsheet->getActiveSheet()->setCellValue('M3', "City")->getStyle('M3')->applyFromArray($styleArray);
			
			// Consignee State
			$spreadsheet->getActiveSheet()->setCellValue('N3', "State")->getStyle('N3')->applyFromArray($styleArray);
			
			// Consignee Country
			$spreadsheet->getActiveSheet()->setCellValue('O3', "Country")->getStyle('O3')->applyFromArray($styleArray);
			
			
			// Zip Code
			$spreadsheet->getActiveSheet()->setCellValue('P3', "ZIP Code")->getStyle('P3')->applyFromArray($styleArray);
			
			// Zip Code
			$spreadsheet->getActiveSheet()->setCellValue('Q3', "Consignee Phone")->getStyle('Q3')->applyFromArray($styleArray);
			
			// EXTERNAL TRACKING NUMBER
			$spreadsheet->getActiveSheet()->setCellValue('R3', "External Tracking")->getStyle('R3')->applyFromArray($styleArray);

			// Amount
			$spreadsheet->getActiveSheet()->setCellValue('S3', "Amount")->getStyle('S3')->applyFromArray($styleArray);

			// Entry Date
			$spreadsheet->getActiveSheet()->setCellValue('T3', "Created At")->getStyle('T3')->applyFromArray($styleArray);
			
			// $i = 4 because we have 3 rows before that
			$i = 4;
			$serialNo = 1;
			//QUANTITY,  PRODUCT_NET_WEIGHT, PRODUCT_DIMENSION, BAG_NUMBER, CONSIGNEE_NAME, EXT_TRACKING_NUMBER

			foreach( $data['result'] AS $data ) {
				$spreadsheet->getActiveSheet()->setCellValue("A{$i}", "{$serialNo}")->getStyle("A{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("B{$i}", "{$data['CN_NUMBER']}")->getStyle("B{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("C{$i}", "{$data['CLUB_NUMBER']}")->getStyle("C{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("D{$i}", "{$data['SHIPPER_NAME']}")->getStyle("D{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("E{$i}", "{$data['SHIPPER_ADDRESS']}")->getStyle("E{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("F{$i}", "{$data['DESCRIPTION']}")->getStyle("F{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("G{$i}", "{$data['QUANTITY']}")->getStyle("G{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("H{$i}", "{$data['PRODUCT_NET_WEIGHT']}")->getStyle("H{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("I{$i}", "{$data['PRODUCT_DIMENSION']}")->getStyle("I{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("J{$i}", "{$data['BAG_NUMBER']}")->getStyle("J{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("K{$i}", "{$data['CONSIGNEE_NAME']}")->getStyle("K{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("L{$i}", "{$data['CONSIGNEE_ADDRESS']}")->getStyle("L{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("M{$i}", "{$data['CONSIGNEE_CITY']}")->getStyle("M{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("N{$i}", "{$data['CONSIGNEE_STATE']}")->getStyle("N{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("O{$i}", "{$data['CONSIGNEE_COUNTRY']}")->getStyle("O{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("P{$i}", "{$data['CONSIGNEE_ZIP_CODE']}")->getStyle("P{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("Q{$i}", "{$data['CONSIGNEE_PHONE_NUMBER']}")->getStyle("Q{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("R{$i}", "{$data['EXT_TRACKING_NUMBER']}")->getStyle("R{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("S{$i}", "{$data['CONSIGNEE_AMOUNT']}")->getStyle("S{$i}")->applyFromArray($detaiStyleArray);
				$spreadsheet->getActiveSheet()->setCellValue("T{$i}", "{$data['E_DATE_TIME']}")->getStyle("T{$i}")->applyFromArray($detaiStyleArray);
				// debug($data);
				$serialNo++;
				$i++;
			}

			$writer = new Xlsx($spreadsheet);
	
			$filename = time();
			
			// debug($filename);

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');
			
			$writer->save('php://output'); // download file 
		}
		else
		{
			echo json_encode ( 
					array 
					(
						'code'	=>	403,
						'message' => 'No record found'
					)
				);
			exit();
		}

		
	}
}