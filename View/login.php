<section class="ftco-section">
	<div class="container" style="height: 100vh;">
		<div class="row justify-content-center" style="height: 100vh;">
			<div class="col-md-6 col-lg-5 align-self-center">
				<div class="login-wrap py-5 bg-dark p-5">
					<h1 class="text-center my-5">Login</h1>
					<div class="my-5 pt-4">
						<h3 class="text-center mb-0">Welcome</h3>
						<p class="text-center mb-0">Sign in by entering the information below</p>
					</div>
					<form action="index.php?ctrl=UserController&action=handle_login" class="login-form" method="POST">
						<!-- Email -->
						<div class="form-group">
							<div class="row">
								<div class="col-1">
									<span class="fa fa-envelope mt-2 pt-1"></span>
								</div>
								<div class="col-11">
									<input type="text" name="email" class="form-control" placeholder="Email" required>
								</div>
							</div>
						</div>
						<!-- Password -->
						<div class="form-group">
							<div class="row">
								<div class="col-1">
									<span class="fa fa-lock mt-2 pt-1"></span>
								</div>
								<div class="col-11">
									<input type="password" name="password" class="form-control" placeholder="Password" required>
								</div>
							</div>
						</div>

						<div class="form-group d-md-flex">
							<div class="w-100 text-md-right">
								<a href="index.php?ctrl=UserController&action=view_forget_password">Forgot Password</a>
							</div>
						</div>
						<div class="form-group">
							<input type="submit" class="btn form-control btn-yellow rounded submit px-3 mt-4 text-dark">Get Started</input>
						</div>
					</form>
					<div class="w-100 text-center mt-4 text">
						<p class="mb-0">Don't have an account?</p>
						<a href="index.php?ctrl=UserController&action=view_register">Sign Up</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>