<?php namespace App\Controllers;

use App\Models\AdminModel;

class Admin extends BaseController
{
    public function registerView() {
        $data = array();
        $view = view("admin/register");
        
        return $view;
    }

    public function loginview()
	{
		$view = view('admin/login');
		return $view;
	}

    public function loginProc()
	{
        $admin_model = new AdminModel();
        $request = $this->request; // 리퀘스트 객체 생성

		$admin_id = $request->getPost("admin_id", FILTER_SANITIZE_SPECIAL_CHARS);
		$admin_password = $request->getPost("admin_password", FILTER_SANITIZE_SPECIAL_CHARS);

        $data = array();
		$data["admin_id"] = getAesEncrypt($admin_id);
		$data["admin_password"] = getAesEncrypt($admin_password);

        $model_result = $admin_model->procLogin($data);

        if($model_result["result"] == true) {
            $db_data = $model_result["data"];
    
            $admin_id = $db_data["admin_id"];
            $admin_name = $db_data["admin_name"];

            $this->session->set("admin_id", $admin_id);
            $this->session->set("admin_name", $admin_name);
        }

        echo json_encode($model_result);
	}

    public function adminIdCheck() {
        $admin_model = new AdminModel();
        $request = $this->request; // 리퀘스트 객체 생성

		$admin_id = $request->getPost("admin_id", FILTER_SANITIZE_SPECIAL_CHARS);

        $data = array();
		$data["admin_id"] = getAesEncrypt($admin_id);

        $model_result = $admin_model->checkAdminId($data);

        echo json_encode($model_result);
    }

    public function registerProc() {
        $admin_model = new AdminModel();
        $request = $this->request; // 리퀘스트 객체 생성
        $result = true;

		$admin_id = $request->getPost("admin_id", FILTER_SANITIZE_SPECIAL_CHARS);
		$admin_name = $request->getPost("admin_name", FILTER_SANITIZE_SPECIAL_CHARS);
		$admin_password = $request->getPost("admin_password", FILTER_SANITIZE_SPECIAL_CHARS);

        if($admin_id == null) {
            $result = false;
            $message = "아이디를 입력해주세요";
        }

        if($admin_name == null) {
            $result = false;
            $message = "이름을 입력해주세요";
        }

        if($admin_password == null) {
            $result = false;
            $message = "비밀번호를 입력해주세요";
        }
        
        if($result == true) {
            $data = array();
            $data["admin_id"] = getAesEncrypt($admin_id);
            $data["admin_name"] = getAesEncrypt($admin_name);
            $data["admin_password"] = getAesEncrypt($admin_password);

            $model_result = $admin_model->procRegister($data);
        } else {
            $model_result["result"] = $result;
            $model_result["message"] = $message;
        }

        echo json_encode($model_result);
    }
}