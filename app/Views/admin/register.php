<?php include_once APPPATH . "Views/layout/header.php"; ?>

<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">회원가입</h3></div>
                            <div class="card-body">
                                <form id="register_frm" onSubmit="return false;">
                                    <div class="form-group">
                                        <label class="small mb-1">이름</label>
                                        <input class="form-control py-4" name="admin_name" type="text" placeholder="이름" />
                                    </div>
                                    <div class="form-row" >
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label class="small mb-1">아이디</label>
                                                <input class="form-control py-4" name="admin_id" placeholder="아이디" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mt-4">
                                                <button class="btn btn-primary" onClick="javascript:adminIdCheck();">중복체크</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="small mb-1">비밀번호</label>
                                        <input class="form-control py-4" name="admin_password" type="password" placeholder="비밀번호" />
                                    </div>
                                    <div class="form-group mt-4 mb-0">
                                        <a class="btn btn-primary btn-block" onClick="javascript:registerProc();">회원가입</a>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center">
                                <div class="small"><a href="login.html">Have an account? Go to login</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="layoutAuthentication_footer">
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website 2020</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<script>
    var user_id_check = false; // 중복체크 확인

    function registerProc() {
        if(user_id_check == false) {
            Swal.fire({
                icon: "error",
                title: "아이디 중복체크를 해주세요",
                confirmButtonText: "확인"
            });
        } else {
            $.ajax({
                url: "/admin/registerProc",
                type: "POST",
                dataType: "json",
                async: false,
                data: $("#register_frm").serialize(),
                success: function(proc_result) {
                    var result = proc_result.result;
                    var message = proc_result.message;
                    
                    if(result == false) {
                        Swal.fire({
                            icon: "error",
                            title: message,
                            confirmButtonText: "확인"
                        });
                    } else {
                        Swal.fire({
                            title: message,
                            confirmButtonText: "확인"
                        }).then((result) => {
                            location.href="/admin/loginview";
                        });;
                    }
                }
            });
        }
    }

function adminIdCheck() {
		$.ajax({
			url: "/admin/adminIdCheck",
			type: "POST",
			dataType: "json",
			async: false,
			data: $("#register_frm").serialize(),
			success: function(proc_result) {
				var result = proc_result.result;
				var message = proc_result.message;
                
				if(result == false) {
					Swal.fire({
						icon: "error",
						title: message,
						confirmButtonText: "확인"
					});
				} else {
					Swal.fire({
						title: message,
						confirmButtonText: "확인"
					});
					user_id_check = true;
				}
			}
		});
	}
</script>

<?php include_once APPPATH . "Views/layout/footer.php"; ?>