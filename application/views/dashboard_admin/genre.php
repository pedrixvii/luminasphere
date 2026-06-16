  <!-- Content wrapper -->
  <div class="content-wrapper">
  	<!-- Content -->

  	<div class="container-xxl flex-grow-1 container-p-y">
  		<hr class="my-5" />

  		<!-- Hoverable Table rows -->
  		<div class="card">
  			<h5 class="card-header">Data E-book</h5>
  			<div class="table-responsive text-nowrap">
  				<button type="button" class="btn btn-outline-primary ms-3 mb-3" data-bs-toggle="modal" data-bs-target="#addGenreModal">
  					<span class="tf-icons bx bx-book-add"></span>
  					Add Genre
  				</button>

  				<table class="table table-hover">
  					<thead>
  						<tr>
  							<th>id</th>
  							<th>Nama Genre</th>
  							<th>Aksi</th>
  						</tr>
  					</thead>
  					<tbody class="table-border-bottom-0">
  						<?php foreach ($genres as $g) : ?>
  							<tr>
  								<td><?= $g['id_genre']; ?></td>
  								<td><?= $g['genre']; ?></td>
  								<td>
  									<button class="btn btn-warning btn-sm edit-btn" data-id="<?= $g['id_genre']; ?>" data-name="<?= $g['genre']; ?>" data-bs-toggle="modal" data-bs-target="#editGenreModal">Edit</button>
  									<a href="<?= base_url('genre/delete/' . $g['id_genre']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
  								</td>
  							</tr>
  						<?php endforeach; ?>
  					</tbody>
  				</table>
  				<!-- Small Pagination -->
  			</div>
  		</div>
  		<!-- Modal add -->
  		<div class="modal fade" id="addGenreModal" tabindex="-1">
  			<div class="modal-dialog">
  				<div class="modal-content">
  					<div class="modal-header">
  						<h5 class="modal-title">Tambah Genre</h5>
  						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  					</div>
  					<div class="modal-body">
  						<form action="<?= base_url('genre/add'); ?>" method="post">
  							<div class="mb-3">
  								<label class="form-label">Nama Genre</label>
  								<input type="text" class="form-control" name="genre" required>
  							</div>
  							<button type="submit" class="btn btn-primary">Simpan</button>
  						</form>
  					</div>
  				</div>
  			</div>
  		</div>
  		<!-- end Modal add -->

  		<!-- Modal edit -->
  		<div class="modal fade" id="editGenreModal" tabindex="-1">
  			<div class="modal-dialog">
  				<div class="modal-content">
  					<div class="modal-header">
  						<h5 class="modal-title">Edit Genre</h5>
  						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  					</div>
  					<div class="modal-body">
  						<form action="<?= base_url('genre/edit'); ?>" method="post">
  							<input type="hidden" name="id_genre" id="edit-id">
  							<div class="mb-3">
  								<label class="form-label">Nama Genre</label>
  								<input type="text" class="form-control" name="genre" id="edit-name" required>
  							</div>
  							<button type="submit" class="btn btn-primary">Update</button>
  						</form>
  					</div>
  				</div>
  			</div>
  		</div>

  		<!-- end Modal edit -->
  		<!--/ Hoverable Table rows -->
  	</div>
  	<!-- / Content -->
