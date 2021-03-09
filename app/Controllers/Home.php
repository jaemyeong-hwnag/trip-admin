<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		if($this->session->get('admin_id') == null) {
			$view = view('admin/login');
		} else {
			$view = view('dashboard/dashboard');
		}

		return $view;
	}

	//--------------------------------------------------------------------

}
