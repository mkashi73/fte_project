<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: login
	Date 		: 02/10/2018
*/

class DashboardController extends MX_Controller 
{
	public function __construct() 
	{
		parent::__construct();
	}

	public function index()
	{
		$parent_menu = $this->getMenu;

		$data['headerData'] = array
		(
			"companyName"	=>	'FTE',
			"pageName"		=>	'Welcome Page'
		);

		$data['links'] = array(
			"show_menu"		=> 	$parent_menu,
		);
		
		$data['token'] = getTokenData('token');

		$this->load->view('common/header', $data);
		$this->load->view('common/sidebar');
		$this->load->view('dashboard/landingPage', $data);
		$this->load->view('common/footer');
	}
}