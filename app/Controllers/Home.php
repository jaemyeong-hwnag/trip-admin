<?php namespace App\Controllers;

class Home extends BaseController
{
    /**
     * 관리자 메인페이지 설정
	 * 
	 * @author 황재명
	 * @param null
	 * 
     */
	public function index()
	{
		$session = session(); // 세션

		// 세션에 저장된 아이디 확인
		if($session->get('admin_id') == null) {
			$view = view('admin/login'); // 없으면 로그인 페이지로
		} else {
			$view = view('dashboard/dashboard'); // 있으면 대쉬보드로
		}

		return $view;
	}
}
