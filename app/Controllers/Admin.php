<?php namespace App\Controllers;

use App\Models\AdminModel;

class Admin extends BaseController
{
    /**
     * 회원가입 페이지
     * 
     * @author 황재명
     * @param null
     * @return view
     */
    public function registerView() {
        $data = array();
        $view = view("admin/register");
        
        return $view;
    }

    /**
     * 로그인 페이지
     * 
     * @author 황재명
     * @param null
     * @return view
     */
    public function loginview()
	{
		$view = view('admin/login');
		return $view;
	}

    /**
     * 로그인 하기
     * 
     * @author 황재명
     * @param post admin_id 관리자 아이디
     * @param post admin_password 관리자 비밀번호
     * @return json
     */
    public function loginProc()
	{
        $admin_model = new AdminModel(); // AdminModel 생성
        $request = $this->request; // 리퀘스트 객체 생성
        $session = session(); // 세션

		$admin_id = $request->getPost("admin_id", FILTER_SANITIZE_SPECIAL_CHARS);
		$admin_password = $request->getPost("admin_password", FILTER_SANITIZE_SPECIAL_CHARS);

        $data = array(); // 리턴 기본값
		$data["admin_id"] = getAesEncrypt($admin_id); // 관리아 아이디 암호화
		$data["admin_password"] = getAesEncrypt($admin_password); // 관리자 비밀번호 복호화

        $model_result = $admin_model->procLogin($data); // 관리자 정보 DB에서 확인

        // DB에서 정보가 일치 할 경우 로그인 정보 세션에 등록
        if($model_result["result"] == true) {
            $db_data = $model_result["data"];
    
            $admin_id = $db_data["admin_id"]; // 아이디
            $admin_name = $db_data["admin_name"]; // 이름

            $session->set("admin_id", $admin_id); // 세션제 저장
            $session->set("admin_name", $admin_name); // 세션에 저장
        }

        echo json_encode($model_result); // json으로 결과 리턴
	}

    /**
     * 가입시 아이디 중복 체크
     * 
     * @author 황재명
     * @param post admin_id 가입할 관리자 아이디
     * @return json
     */
    public function adminIdCheck() {
        $admin_model = new AdminModel(); // AdminModel 생성
        $request = $this->request; // 리퀘스트 객체 생성

		$admin_id = $request->getPost("admin_id", FILTER_SANITIZE_SPECIAL_CHARS); // 체크 할 아이디

        $data = array(); // 기본 리턴 값
		$data["admin_id"] = getAesEncrypt($admin_id); // 관리자 아이디 암호화

        $model_result = $admin_model->checkAdminId($data); // DB에서 정보 체크

        echo json_encode($model_result); // 괄과 json형태로 리턴
    }

    /**
     * 회원가입 하기
     * 
     * @author 황재명
     * @param post admin_id 가입할 관리자 아이디
     * @param post admin_name 가입할 관리자 이름
     * @param post admin_password 가입할 관리자 비밀번호
     * @return json
     */
    public function registerProc() {
        $admin_model = new AdminModel();
        $request = $this->request; // 리퀘스트 객체 생성
        $result = true;

		$admin_id = $request->getPost("admin_id", FILTER_SANITIZE_SPECIAL_CHARS); // 관리자 아이디
		$admin_name = $request->getPost("admin_name", FILTER_SANITIZE_SPECIAL_CHARS); // 관리자 이름
		$admin_password = $request->getPost("admin_password", FILTER_SANITIZE_SPECIAL_CHARS); // 관리자 비밀번호

        // 아이디 확인
        if($admin_id == null) {
            $result = false;
            $message = "아이디를 입력해주세요";
        }

        // 이름 확인
        if($admin_name == null) {
            $result = false;
            $message = "이름을 입력해주세요";
        }

        // 비밀번호 확인
        if($admin_password == null) {
            $result = false;
            $message = "비밀번호를 입력해주세요";
        }
        
        // 확인이 정상
        if($result == true) {
            $data = array();
            $data["admin_id"] = getAesEncrypt($admin_id); // 저장 할 아이디 암호화
            $data["admin_name"] = getAesEncrypt($admin_name); // 저장 할 이름 암호화
            $data["admin_password"] = getAesEncrypt($admin_password); // 저장 할 비밀번호 암호화

            $model_result = $admin_model->procRegister($data);
        } else { // 필수 값이 누락 시
            $model_result["result"] = $result; // 결과
            $model_result["message"] = $message; // 메시지
        }

        echo json_encode($model_result); // json형태로 리턴
    }
}