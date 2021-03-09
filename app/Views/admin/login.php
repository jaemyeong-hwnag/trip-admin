<?php include_once APPPATH . "Views/layout/header.php"; ?>

<div id="layoutAuthentication">
	<div id="layoutAuthentication_content">
		<main>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-5">
						<div class="card shadow-lg border-0 rounded-lg mt-5">
							<div class="card-header"><h3 class="text-center font-weight-light my-4">로그인</h3></div>
							<div class="card-body">
								<form id="admin_login"  onSubmit="return false;">
									<div class="form-group">
										<input class="form-control py-4" name="admin_id" placeholder="아이디" />
									</div>
									<div class="form-group">
										<input class="form-control py-4" name="admin_password" type="password" placeholder="비밀번호" />
									</div>
									<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
										<button class="btn btn-primary" id="login" name="login">로그인</button>
									</div>
								</form>
							</div>
							<div class="card-footer text-center">
								<div class="small"><a href="/admin/registerView">회원가입</a></div>
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
<script type="text/javascript">
	$("#login").click(function(){
		$.ajax({
			url: "/admin/loginProc",
			type: "POST",
			dataType: "json",
			async: true,
			data: $("#admin_login").serialize(),
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
					location.href="/";
				}
			}
		});
	});
</script>

<?php include_once APPPATH . "Views/layout/footer.php"; ?>