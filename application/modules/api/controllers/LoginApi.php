<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 
	Author 		: Salman Bukhari
	Controller 	: login
	Date 		: 02/10/2018
*/

class LoginApi extends MX_Controller 
{
	public function index()
	{
		$this->load->view('welcome_message');
	}
}
