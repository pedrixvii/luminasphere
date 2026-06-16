 <!-- Normal Breadcrumb Begin -->
 <section class="normal-breadcrumb set-bg" data-setbg="img/normal-breadcrumb.jpg">
 	<div class="container">
 		<div class="row">
 			<div class="col-lg-12 text-center">
 				<div class="normal__breadcrumb__text">
 					<img src="<?= base_url('assets/logo') ?>/logowebsiteperpusukk.png" alt="" style="width: 200px;">
 					<h2>Setting Account</h2>
 				</div>
 				<div class="card">
 					<div class="card-body">
 						<h5 class="card-title"><span class="icon_wallet"></span> Poin Anda </h5>
 						<h3 class="text-primary"><?= number_format($poin, 0, ',', '.'); ?> Poin</h3>
 					</div>

 				</div>
 			</div>
 		</div>
 	</div>
 </section>
 <!-- Normal Breadcrumb End -->

 <!-- Login Section Begin -->
 <section class="login spad">
 	<div class="container">
 		<div class="row">
 			<div class="col-lg-6">
 				<div class="login__form">
 					<h3>Setting Account</h3>
 					<form action="<?= base_url('Usersettings/update_profile'); ?>" method="post" enctype="multipart/form-data">
 						<div class="mb-3 text-center">
 							<!-- Menampilkan foto profil -->
 							<img id="previewFoto" src="<?= base_url('upload/foto_user/' . $user->foto); ?>" alt="Foto Profil" class="rounded-circle" width="120" height="120">
 						</div>

 						<div class="mb-3">
 							<label for="foto" class="form-label">Foto Profil</label>
 							<input type="file" name="foto" id="foto" class="form-control" onchange="previewImage(event)">
 						</div>

 						<label>Username:</label>
 						<input type="text" name="username" value="<?= $user->username; ?>" required class="form-control"><br>

 						<label>Email:</label>
 						<input type="email" name="email" value="<?= $user->email; ?>" required class="form-control"><br>

 						<label>Nama Lengkap:</label>
 						<input type="text" name="namalengkap" value="<?= $user->namalengkap; ?>" required class="form-control"><br>

 						<label>NIS:</label>
 						<input type="text" name="nis" value="<?= $user->nis; ?>" required class="form-control"><br>

 						<label>Alamat:</label>
 						<input type="text" name="alamat" value="<?= $user->alamat; ?>" required class="form-control"><br>

 						<label>Kelas:</label>
 						<select name="kelas" class="form-control" required>
 							<option value="RPL-10" <?= ($user->kelas == 'RPL-10') ? 'selected' : ''; ?>>RPL-10</option>
 							<option value="RPL-11" <?= ($user->kelas == 'RPL-11') ? 'selected' : ''; ?>>RPL-11</option>
 							<option value="RPL-12" <?= ($user->kelas == 'RPL-12') ? 'selected' : ''; ?>>RPL-12</option>
 							<option value="MM-10" <?= ($user->kelas == 'MM-10') ? 'selected' : ''; ?>>MM-10</option>
 							<option value="MM-11" <?= ($user->kelas == 'MM-11') ? 'selected' : ''; ?>>MM-11</option>
 							<option value="MM-12" <?= ($user->kelas == 'MM-12') ? 'selected' : ''; ?>>MM-12</option>
 							<option value="BC-10" <?= ($user->kelas == 'BC-10') ? 'selected' : ''; ?>>BC-10</option>
 							<option value="BC-11" <?= ($user->kelas == 'BC-11') ? 'selected' : ''; ?>>BC-11</option>
 							<option value="BC-12" <?= ($user->kelas == 'BC-12') ? 'selected' : ''; ?>>BC-12</option>
 						</select>

 						<button type="submit" class="btn btn-primary mt-3">Update Profil</button>
 					</form>
 				</div>
 			</div>
 			<div class="col-lg-6">
 				<div class="login__form">
 					<h3>Setting Password</h3>
 					<form action="<?= site_url('UserSettings/change_password') ?>" method="POST">
 						<div class="input__item">
 							<input type="password" name="old_password" placeholder="Old Password" required>
 							<span>
 								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-unlock-fill" viewBox="0 0 16 16">
 									<path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2" />
 								</svg>
 							</span>
 						</div>
 						<div class="input__item">
 							<input type="password" name="old_password" placeholder="New Password" required>
 							<span>
 								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
 									<path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2" />
 								</svg>
 							</span>
 						</div>
 						<button type="submit" class="site-btn">Done</button>
 					</form>
 					<?php if ($this->session->flashdata('success')): ?>
 						<p style="color:green;"><?= $this->session->flashdata('success') ?></p>
 					<?php endif; ?>

 					<?php if ($this->session->flashdata('error')): ?>
 						<p style="color:red;"><?= $this->session->flashdata('error') ?></p>
 					<?php endif; ?>
 				</div>
 			</div>
 			<script>
 				function previewImage(event) {
 					var reader = new FileReader();
 					reader.onload = function() {
 						var output = document.getElementById('previewFoto');
 						output.src = reader.result;
 					}
 					reader.readAsDataURL(event.target.files[0]);
 				}
 				$(document).ready(function() {
 					// Tampilkan notifikasi jika ada flashdata
 					<?php if ($this->session->flashdata('success')): ?>
 						toastr.success("<?= $this->session->flashdata('success'); ?>");
 					<?php endif; ?>

 					<?php if ($this->session->flashdata('error')): ?>
 						toastr.error("<?= $this->session->flashdata('error'); ?>");
 					<?php endif; ?>
 				});
 			</script>
 		</div>
 	</div>
 </section>
 <!-- Login Section End -->
