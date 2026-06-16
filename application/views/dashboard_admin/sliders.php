  <!-- Content wrapper -->
  <div class="content-wrapper">
  	<!-- Content -->

  	<div class="container-xxl flex-grow-1 container-p-y">
  		<hr class="my-5" />

  		<!-- Hoverable Table rows -->
  		<div class="card">
  			<h5 class="card-header">Data Slider</h5>
  			<div class="table-responsive text-nowrap">
  				<div class="d-flex justify-content-between align-items-center">
  					<div class="d-flex flex-row align-items-center ms-3">
  						<!-- Tombol untuk membuka modal -->
  						<button type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#backDropModal">
  							<span class="tf-icons bx bx-book-add"></span>
  							Add Slider
  						</button>
  					</div>
  				</div>
  				<!-- Button trigger modal -->
  				<table class="table table-hover">
  					<thead>
  						<tr>
  							<th>No</th>
  							<th>slider</th>
  							<th>title Slider</th>
  							<th>description Slider</th>
  							<th>Actions</th>
  						</tr>
  					</thead>
  					<tbody class="table-border-bottom-0">
  						<?php if (!empty($sliders)): ?>
  							<?php
								$no = 1;
								foreach ($sliders as $sld): ?>
  								<tr>
  									<td><?= $no++ ?></td>
  									<!-- Tampilkan image_path -->
  									<td>
  										<?php if (!empty($sld->image_path)): ?>
  											<img src="<?= base_url('./slider/' . $sld->image_path) ?>" alt="<?= $sld->title ?>" width="65" class="rounded">
  										<?php else: ?>
  											<p class="text-muted">Tidak ada image_path</p>
  										<?php endif; ?>
  									</td>
  									<!-- Tipe Kamar -->
  									<td>
  										<i class="fab fa-react fa-lg text-info me-3"></i>
  										<strong><?= htmlspecialchars($sld->title) ?></strong>
  									</td>
  									<td>
  										<?= strlen($sld->description) > 150 ? substr($sld->description, 0, 150) . '...' : $sld->description; ?>
  									</td>
  									<!-- Status -->
  									<td><span class="badge bg-label-success me-1">Completed</span></td>

  									<!-- Aksi -->
  									<td>
  										<div class="dropdown">
  											<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
  												<i class="bx bx-dots-vertical-rounded"></i>
  											</button>
  											<div class="dropdown-menu">
  												<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $sld->id_slider ?>">
  													<i class="bx bx-edit-alt me-1"></i> Edit
  												</a>
  												<a class="dropdown-item" href="<?= base_url('sliders/delete?id=' . $sld->id_slider) ?>" onclick="return confirm('Yakin ingin menghapus data ini?');"><i class="bx bx-trash me-1"></i> Delete</a>
  											</div>
  										</div>
  									</td>
  								</tr>
  							<?php endforeach; ?>
  						<?php else: ?>
  							<tr>
  								<td colspan="6" class="text-center">Data slider tidak tersedia.</td>
  							</tr>
  						<?php endif; ?>
  					</tbody>

  				</table>
  				<!-- Small Pagination -->

  			</div>
  		</div>
  		<!-- Modal add -->
  		<div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
  			<div class="modal-dialog">
  				<form class="modal-content" action="<?= base_url('sliders/tambah_slider') ?>" enctype="multipart/form-data" method="post">
  					<div class="modal-header">
  						<h5 class="modal-title" id="backDropModalTitle">Modal title</h5>
  						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  					</div>
  					<div class="modal-body">
  						<div class="row g-6">
  							<div class="col mb-0">
  								<label for="titleBackdrop" class="form-label">title</label>
  								<input type="text" id="titleBackdrop" name="title" class="form-control" placeholder="Enter Name">
  							</div>
  							<div class="col mb-0">
  								<label for="descriptionBackdrop" class="form-label">description</label>
  								<input type="text" name="description" id="descriptionBackdrop" class="form-control" placeholder="xxxx@xxx.xx">
  							</div>
  						</div>
  						<div class="col-md-6">
  							<label for="image_pathBackdrop" class="form-label">image_path kamar</label>
  							<input type="file" name="userfile" class="form-control" id="image_pathBackdrop" onchange="previewImage();">
  							<img id="image-preview" src="" alt="Preview image_path" style="display:none; max-width:200px; margin-top:10px;" />
  						</div>
  					</div>
  					<div class="modal-footer">
  						<button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
  						<button type="submit" class="btn btn-primary">Save</button>
  					</div>
  				</form>
  			</div>
  		</div>
  		<!-- end Modal add -->

  		<!-- Modal edit -->
  		<div class="modal fade" id="modalEdit<?= $sld->id_slider ?>" tabindex="-1" aria-labelledby="modalEditLabel<?= $sld->id_slider ?>" aria-hidden="true">
  			<div class="modal-dialog">
  				<form class="modal-content" action="<?= base_url('sliders/update_edit/'  . $sld->id_slider) ?>" enctype="multipart/form-data" method="post">
  					<div class="modal-header">
  						<h5 class="modal-title" id="modalEditLabel<?= $sld->id_slider ?>"></h5>Edit Modal</h5>
  						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  					</div>
  					<div class="modal-body">
  						<div class="row">
  							<div class="col mb-6">
  								<label for="titleBackdrop" class="form-label">title</label>
  								<input type="text" id="titleBackdrop" name="title" class="form-control" placeholder="Enter Name" value="<?= $sld->title ?>">
  							</div>
  							<div class="col mb-0">
  								<label for="descriptionBackdrop" class="form-label">description</label>
  								<input type="text" name="description" id="descriptionBackdrop" class="form-control" placeholder="xxxx@xxx.xx" value="<?= $sld->description ?>">
  							</div>
  						</div>
  						<div class="col-md-6">
  							<label for="image_pathBackdrop">image_path E-Slider</label>
  							<input type="file" name="userfile" class="form-control" id="image_pathBackdrop" onchange="previewImage();">
  							<img id="image-preview" src="<?= base_url('upload/' . $sld->image_path) ?>" alt="Preview image_path" style="display:none; max-width:200px; margin-top:10px;" />
  						</div>
  					</div>
  					<div class="modal-footer">
  						<button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
  						<button type="submit" class="btn btn-primary">Save</button>
  					</div>
  				</form>
  				<script>
  					function previewImage() {
  						const input = document.getElementById('image_pathBackdrop');
  						const preview = document.getElementById('image-preview');
  						const file = input.files[0];

  						if (file) {
  							const reader = new FileReader();

  							reader.onload = function(e) {
  								preview.src = e.target.result;
  							};

  							reader.readAsDataURL(file); // Membaca file sebagai URL
  						}
  					}
  				</script>
  			</div>
  		</div>
  		<!-- end Modal edit -->
  		<!--/ Hoverable Table rows -->
  	</div>
  	<!-- / Content -->
