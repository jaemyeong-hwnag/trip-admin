<?php namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table      = 'admin';
    public function checkadminId($data) {
        // 기본 셋팅
        $table = "admin";
        $db_result = array(); // return 데이터

        $admin_id = $data["admin_id"];

        // select
        $select_array = array();
        array_push($select_array, "*");

        // 쿼리문 셋팅
        $builder = $this->builder();

        $builder->select($select_array); // select
        
        $builder->where('admin_id', $admin_id, true); // where

        // 쿼리 실행
        $cnt = $builder->countAllResults(true);

        if($cnt > 0) {
			$result = false;
			$message = "사용 불가능한 아이디 입니다.";
		} else {
            $result = true;
			$message = "사용 가능한 아이디 입니다.";
        }

        $model_result = array();
		$model_result["result"] = $result;
		$model_result["message"] = $message;
		$model_result["data"] = $db_result;
        
        return $model_result;
    }

    /**
	 * @see 회원가입
	 * @param array $data - 데이터 입력
	 * @return array $model_result - 회원가입정보. DB입력 결과와 insert_id 반환
	 */
    public function procLogin($data) {
        // 기본 셋팅
        $table = "admin";
        $db_result = array(); // return 데이터

        $admin_id = $data["admin_id"];
		$admin_password = $data["admin_password"];

        // select
        $select_array = array();
        array_push($select_array, "*");

        // 쿼리문 셋팅
        $builder = $this->builder($table);

        $builder->select($select_array); // select
        $builder->where('admin_id', $admin_id, true); // where
        $builder->where('admin_password', $admin_password, true); // where

        // 쿼리 실행
        $cnt = $builder->countAllResults(false);
        $db_result = $this->first();

        if($cnt > 0) {
			$result = true;
			$message = "로그인 성공";
		} else {
            $result = false;
			$message = "로그인 실패";
        }

        $model_result = array();
		$model_result["result"] = $result;
		$model_result["message"] = $message;
		$model_result["data"] = getInfoAesDecrypt($db_result);
        
        return $model_result;
    }

    public function procRegister($data) {
        /** 아이디 다시 체크 */
        // 기본 셋팅
        $table = "admin";
        $result = true;
        $db_result = array(); // return 데이터

        $admin_id = $data["admin_id"];
        $admin_password = $data["admin_password"];
        $admin_name = $data["admin_name"];

        // select
        $select_array = array();
        array_push($select_array, "*");

        // 쿼리문 셋팅
        $builder = $this->builder($table);

        $builder->select($select_array); // select
        $builder->where('admin_id', $admin_id, true); // where

        // 쿼리 실행
        $cnt = $builder->countAllResults(true);

        /** 회원가입 */
        if($cnt <= 0) {
            $builder->set("admin_id", $admin_id, TRUE);
            $builder->set("admin_password", $admin_password, TRUE);
            $builder->set("admin_name", $admin_name, TRUE);

            $db_result = $builder->insert(); // insert
		} else {
			$result = false;
			$message = "사용 불가능한 아이디 입니다.";
        }

        if($result != false) {
            $result = $db_result;
            $insert_result = $db_result->resultID;
            $message = "회원가입 되었습니다.";

            $model_result["insert_result"] = $insert_result;
        }

        $model_result = array();
		$model_result["result"] = $result;
		$model_result["message"] = $message;
		$model_result["data"] = $db_result;
        
        return $model_result;
    }
}