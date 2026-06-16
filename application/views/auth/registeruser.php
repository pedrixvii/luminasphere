<!DOCTYPE html>
<html
	lang="en"
	class="light-style customizer-hide"
	dir="ltr"
	data-theme="theme-default"
	data-assets-path="<?= base_url('assets/sneat-1.0.0') ?>/assets/"
	data-template="vertical-menu-template-free">

<head>
	<meta charset="utf-8" />
	<meta
		name="viewport"
		content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

	<title>Login Basic - Pages | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

	<meta name="description" content="" />

	<!-- Favicon -->
	<link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link
		href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
		rel="stylesheet" />

	<!-- Icons. Uncomment required icon fonts -->
	<link rel="stylesheet" href="<?= base_url('assets/sneat-1.0.0') ?>/assets/vendor/fonts/boxicons.css" />

	<!-- Core CSS -->
	<link rel="stylesheet" href="<?= base_url('assets/sneat-1.0.0') ?>/assets/vendor/css/core.css" class="template-customizer-core-css" />
	<link rel="stylesheet" href="<?= base_url('assets/sneat-1.0.0') ?>/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
	<link rel="stylesheet" href="<?= base_url('assets/sneat-1.0.0') ?>/assets/css/demo.css" />

	<!-- Vendors CSS -->
	<link rel="stylesheet" href="<?= base_url('assets/sneat-1.0.0') ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

	<!-- Page CSS -->
	<!-- Page -->
	<link rel="stylesheet" href="<?= base_url('assets/sneat-1.0.0') ?>/assets/vendor/css/pages/page-auth.css" />
	<!-- Helpers -->
	<script src="<?= base_url('assets/sneat-1.0.0') ?>/assets/vendor/js/helpers.js"></script>

	<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
	<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
	<script src="<?= base_url('assets/sneat-1.0.0') ?>/assets/js/config.js"></script>
</head>

<body>
	<!-- Content -->
	<div class="container-xxl">
		<div class="authentication-wrapper authentication-basic container-p-y">
			<div class="authentication-inner">
				<!-- Register Card -->
				<div class="card">
					<div class="card-body">
						<!-- Logo -->
						<div class="app-brand justify-content-center">
							<a href="index.html" class="app-brand-link gap-2">
								<span class="app-brand-logo demo">
									<img src="<?= base_url('assets/logo') ?>/logowebsiteperpusukk.png" alt="Logo lumina" style="width: 300px;">
								</span>
							</a>
						</div>
						<!-- /Logo -->
						<h4 class="mb-2">Buat Akun Baru 🚀</h4>
						<p class="mb-4">Daftar sekarang dan nikmati akses ke berbagai eBook!</p>

						<form id="formAuthentication" class="mb-3" action="<?= site_url('auth/create_register_user'); ?>" method="POST" enctype="multipart/form-data">
							<div class="mb-3">
								<label class="form-label">Foto Profil</label>
								<input type="file" name="foto" class="form-control" required>
							</div>
							<div class="mb-3">
								<label for="username" class="form-label">Username</label>
								<input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
							</div>
							<div class="mb-3">
								<label for="email" class="form-label">Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
							</div>
							<div class="mb-3 form-password-toggle">
								<label class="form-label" for="password">Password</label>
								<div class="input-group input-group-merge">
									<input type="password" id="password" class="form-control" name="password" placeholder="••••••••" required>
									<span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
								</div>
							</div>
							<div class="mb-3">
								<label class="form-label">Nama Lengkap</label>
								<input type="text" name="namalengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
							</div>
							<div class="mb-3">
								<label class="form-label">NIS</label>
								<input type="text" name="nis" class="form-control" placeholder="Masukkan NIS" required>
							</div>
							<div class="mb-3">
								<label class="form-label">Alamat</label>
								<input type="text" name="alamat" class="form-control" placeholder="Masukkan alamat" required>
							</div>
							<div class="mb-3">
								<label class="form-label">Kelas</label>
								<select name="kelas" class="form-control" required>
									<option value="">Pilih Kelas</option>
									<option value="RPL-10">RPL-10</option>
									<option value="RPL-11">RPL-11</option>
									<option value="RPL-12">RPL-12</option>
									<option value="MM-10">MM-10</option>
									<option value="MM-11">MM-11</option>
									<option value="MM-12">MM-12</option>
									<option value="BC-10">BC-10</option>
									<option value="BC-11">BC-11</option>
									<option value="BC-12">BC-12</option>
								</select>
							</div>
							<div class="mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required>
									<label class="form-check-label" for="terms-conditions">
										Saya setuju dengan <a href="#">syarat & ketentuan</a>
									</label>
								</div>
							</div>
							<button class="btn btn-primary d-grid w-100" type="submit">Daftar</button>
						</form>

						<p class="text-center">
							<span>Sudah punya akun?</span>
							<a href="<?= site_url('auth/login'); ?>">
								<span>Masuk</span>
							</a>
						</p>
					</div>
				</div>
				<!-- Register Card -->
			</div>
		</div>
	</div>


	<!-- Core JS -->
	<!-- build:js assets/vendor/js/core.js -->
	<script src="<?= base_url('assets/sneat-1.0.0') ?>/assets/vendor/libs/jquery/jquery.js"></script>
	<script src="<?= base_url('assets/sneat-1.0.0') ?>/assets/vendor/libs/popper/popper.js"></script>
	<script src="<?= base_url('assets/sneat-1.0.0') ?>/assets/vendor/js/bootstrap.js"></script>
	<script src="<?= base_url('assets/sneat-1.0.0') ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

	<script src="<?= base_url('assets/sneat-1.0.0') ?>/assets/vendor/js/menu.js"></script>
	<!-- endbuild -->

	<!-- Vendors JS -->

	<!-- Main JS -->
	<script src="<?= base_url('assets/sneat-1.0.0') ?>/assets/js/main.js"></script>

	<!-- Page JS -->

	<!-- Place this tag in your head or just before your close body tag. -->
	<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
