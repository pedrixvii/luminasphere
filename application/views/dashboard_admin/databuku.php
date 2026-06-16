  <!-- Content wrapper -->
  <div class="content-wrapper">
  	<!-- Content -->

  	<div class="container-xxl flex-grow-1 container-p-y">
  		<hr class="my-5" />

  		<!-- Hoverable Table rows -->
  		<div class="card">
  			<h5 class="card-header">Data E-book</h5>
  			<div class="table-responsive text-nowrap">

  				<button type="button" class="btn btn-outline-primary ms-3 mb-3" data-bs-toggle="modal" data-bs-target="#backDropModal">
  					<i class="bx bx-book-add"></i> Add Book
  				</button>
  				<!-- Button trigger modal -->
  				<table class="table table-hover">
  					<thead>
  						<tr>
  							<th>No</th>
  							<th>thumbnail Buku</th>
  							<th>ISBN</th>
  							<th>title Buku</th>
  							<th>authors</th>
  							<th>publisher</th>
  							<th>description Buku</th>
  							<th>Stock</th>
  							<th>Tahun Terbit</th>
  							<th>Jenis Buku</th>
  							<th>Genre</th>
  							<th>Actions</th>
  						</tr>
  					</thead>
  					<tbody class="table-border-bottom-0">
  						<?php
							$no = 1;
							foreach ($buku as $bku) :
							?>
  							<tr>
  								<td><?= $no++ ?></td>
  								<!-- Tampilkan thumbnail -->
  								<td>
  									<?php if ($bku->thumbnail): ?>
  										<img src="<?= base_url('upload/thumbnails/' . $bku->thumbnail) ?>" alt="<?= $bku->title ?>" width="65" class="rounded">
  									<?php else: ?>
  										<p class="text-muted">Tidak ada thumbnail</p>
  									<?php endif; ?>
  								</td>
  								<td><?= $bku->isbn ?></td>
  								<td>
  									<i class="fab fa-react fa-lg text-info me-3"></i>
  									<strong><?= $bku->title ?></strong>
  								</td>
  								<td><?= $bku->authors ?></td>
  								<td><?= $bku->publisher ?></td>
  								<!-- description -->
  								<td>
  									<?= strlen($bku->description) > 150 ? substr($bku->description, 0, 150) . '...' : $bku->description; ?>
  								</td>
  								<!-- stock -->
  								<td><?= $bku->stock ?></td>
  								<!-- Tahun terbit -->
  								<td><span class="badge bg-label-success me-1"><?= $bku->published_date ?></span></td>
  								<td><?= $bku->jenis_buku ?></td>
  								<td><?= $bku->genre ?></td>

  								<!-- Aksi -->
  								<td>
  									<div class="dropdown">
  										<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton<?= $bku->id_buku ?>" data-bs-toggle="dropdown" aria-expanded="false">
  											Aksi
  										</button>
  										<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $bku->id_buku ?>">
  											<!-- Tombol Edit -->
  											<li>
  												<a href="#" class="dropdown-item edit-button"
  													data-id="<?= $bku->id_buku ?>"
  													data-isbn="<?= $bku->isbn ?>"
  													data-title="<?= $bku->title ?>"
  													data-authors="<?= $bku->authors ?>"
  													data-publisher="<?= $bku->publisher ?>"
  													data-description="<?= htmlspecialchars($bku->description) ?>"
  													data-stock="<?= $bku->stock ?>"
  													data-published_date="<?= $bku->published_date ?>"
  													data-jenis_buku="<?= $bku->jenis_buku ?>"
  													data-thumbnail="<?= base_url('upload/thumbnails/' . $bku->thumbnail) ?>"
  													data-ebook="<?= base_url('upload/ebooks/' . $bku->file_ebook) ?>"
  													data-id_genre="<?= $bku->id_genre ?>"
  													data-bs-toggle="modal" data-bs-target="#modalEdit">
  													<i class="bx bx-edit-alt me-1"></i> Edit
  												</a>

  											</li>
  											<!-- Tombol Delete -->
  											<li>
  												<a href="<?= base_url('buku/delete/' . $bku->id_buku) ?>" class="dropdown-item text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
  													<i class="bx bx-trash me-1"></i> Hapus
  												</a>
  											</li>
  										</ul>
  									</div>
  								</td>

  							</tr>
  						<?php endforeach; ?>
  					</tbody>
  				</table>
  				<?php if ($this->session->flashdata('success')) : ?>
  					<div class="alert alert-success">
  						<?= $this->session->flashdata('success'); ?>
  					</div>
  				<?php endif; ?>
  			</div>
  		</div>
  		<nav aria-label="Page navigation" class="mt-4 ">
  			<?= $pagination; ?>
  		</nav>
  		<!-- Modal Edit -->
  		<!-- Modal Edit Buku -->
  		<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
  			<div class="modal-dialog">
  				<form class="modal-content" action="<?= base_url('buku/update_edit') ?>" enctype="multipart/form-data" method="post">
  					<div class="modal-header">
  						<h5 class="modal-title">Edit Buku</h5>
  						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  					</div>
  					<div class="modal-body">
  						<input type="hidden" id="edit-id" name="id_buku">

  						<div class="mb-3">
  							<label class="form-label">ISBN</label>
  							<input type="text" id="edit-isbn" name="isbn" class="form-control" required>
  						</div>

  						<div class="mb-3">
  							<label class="form-label">Judul</label>
  							<input type="text" id="edit-title" name="title" class="form-control" required>
  						</div>

  						<div class="mb-3">
  							<label class="form-label">Jenis Buku</label>
  							<select name="jenis_buku" id="edit-jenis_buku" class="form-control" required>
  								<option value="">Pilih Jenis Buku</option>
  								<option value="offline">Offline</option>
  								<option value="online">Online</option>
  							</select>
  						</div>

  						<div class="mb-3">
  							<label class="form-label">Genre</label>
  							<select name="id_genre" id="genreBackdrop" class="form-control">
  								<option value="">Pilih Genre</option>
  								<?php foreach ($genre as $gr) : ?>
  									<option value="<?= $gr['id_genre']; ?>"><?= $gr['genre']; ?></option>
  								<?php endforeach; ?>
  							</select>
  						</div>

  						<!-- Thumbnail -->
  						<div class="mb-3">
  							<label class="form-label">Thumbnail E-book</label>
  							<input type="file" name="thumbnail" class="form-control" id="edit-thumbnail">
  							<img id="edit-image-preview" src="" alt="Preview thumbnail" style="max-width:200px; margin-top:10px;">
  							<p class="mt-2">Thumbnail saat ini: <span id="current-thumbnail"></span></p>
  						</div>

  						<!-- File eBook -->
  						<div class="mb-3">
  							<label class="form-label">File eBook</label>
  							<input type="file" name="file_ebook" class="form-control" id="edit-ebook">
  							<p class="mt-2">File eBook saat ini: <span id="current-ebook"></span></p>
  						</div>

  						<div class="mb-3">
  							<label class="form-label">Penulis</label>
  							<input type="text" id="edit-authors" name="authors" class="form-control" required>
  						</div>

  						<div class="mb-3">
  							<label class="form-label">Penerbit</label>
  							<input type="text" id="edit-publisher" name="publisher" class="form-control" required>
  						</div>

  						<div class="mb-3">
  							<label class="form-label">Deskripsi</label>
  							<textarea id="edit-description" name="description" class="form-control" required></textarea>
  						</div>

  						<div class="mb-3">
  							<label class="form-label">Stock</label>
  							<input type="number" id="edit-stock" name="stock" class="form-control" required>
  						</div>

  						<div class="mb-3">
  							<label class="form-label">Tahun Terbit</label>
  							<input type="date" id="edit-published_date" name="published_date" class="form-control" required>
  						</div>
  					</div>

  					<div class="modal-footer">
  						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
  						<button type="submit" class="btn btn-primary">Simpan Perubahan</button>
  					</div>
  				</form>
  			</div>
  		</div>

  		<!-- Modal add -->
  		<!-- Modal Tambah Buku -->
  		<div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
  			<div class="modal-dialog modal-lg">
  				<form class="modal-content" action="<?= base_url('buku/tambah_buku') ?>" enctype="multipart/form-data" method="post">
  					<div class="modal-header">
  						<h5 class="modal-title">Tambah Buku</h5>
  						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
  					</div>
  					<div class="modal-body">
  						<div class="row g-3">
  							<label class="form-label">ISBN</label>
  							<input type="text" id="isbnBackdrop" name="isbn" class="form-control" required>
  						</div>
  						<div class="row g-3">
  							<div class="col-md-6">
  								<label for="titleBackdrop" class="form-label">Judul</label>
  								<input type="text" id="titleBackdrop" name="title" class="form-control" placeholder="Masukkan judul buku" required>
  							</div>
  							<div class="col-md-6">
  								<label for="stockBackdrop" class="form-label">Stock</label>
  								<input type="number" name="stock" id="stockBackdrop" class="form-control" placeholder="Masukkan jumlah stok" required>
  							</div>
  						</div>
  						<div class="row g-3 mt-2">
  							<div class="col-md-6">
  								<label for="thumbnailBackdrop" class="form-label">Thumbnail</label>
  								<input type="file" name="thumbnail" class="form-control" id="thumbnailBackdrop" accept="image/*" onchange="previewThumbnail();">
  								<img id="image-thumbnail-preview" src="" alt="Preview thumbnail" style="display:none; max-width:200px; margin-top:10px;">
  							</div>
  							<div class="col-md-6">
  								<label for="file-ebookBackdrop" class="form-label">File eBook</label>
  								<input type="file" name="file_ebook" class="form-control" id="file-ebookBackdrop" accept=".pdf,.epub,.mobi">
  								<small class="text-muted">Format: PDF, EPUB, MOBI | Max: 5MB</small>
  							</div>
  						</div>

  						<div class="row g-3 mt-2">
  							<div class="col-md-6">
  								<label for="authorsBackdrop" class="form-label">Penulis</label>
  								<input type="text" name="authors" id="authorsBackdrop" class="form-control" placeholder="Masukkan nama penulis" required>
  							</div>
  							<div class="col-md-6">
  								<label for="publisherBackdrop" class="form-label">Penerbit</label>
  								<input type="text" name="publisher" id="publisherBackdrop" class="form-control" placeholder="Masukkan penerbit" required>
  							</div>
  						</div>

  						<div class="row g-3 mt-2">
  							<div class="col-md-6">
  								<label for="descriptionBackdrop" class="form-label">Deskripsi</label>
  								<textarea name="description" id="descriptionBackdrop" class="form-control" rows="3" placeholder="Masukkan deskripsi buku" required></textarea>
  							</div>
  							<div class="col-md-6">
  								<label for="published_dateBackdrop" class="form-label">Tanggal Terbit</label>
  								<input type="date" name="published_date" id="published_dateBackdrop" class="form-control" required>
  							</div>
  						</div>

  						<div class="row g-3 mt-2">
  							<div class="col-md-6">
  								<label for="genreBackdrop" class="form-label">Genre</label>
  								<select name="id_genre" id="genreBackdrop" class="form-control" required>
  									<option value="">Pilih Genre</option>
  									<?php foreach ($genre as $gr) : ?>
  										<option value="<?= $gr['id_genre']; ?>"><?= $gr['genre']; ?></option>
  									<?php endforeach; ?>
  								</select>
  							</div>
  							<div class="col-md-6">
  								<label class="form-label">Jenis Buku</label>
  								<select name="jenis_buku" id="jenis_bukuBackdrop" class="form-control" required>
  									<option value="">Pilih Jenis Buku</option>
  									<option value="offline">Offline</option>
  									<option value="online">Online</option>
  								</select>
  							</div>
  						</div>
  					</div>
  					<div class="modal-footer">
  						<button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
  						<button type="submit" class="btn btn-primary">Simpan</button>
  					</div>
  				</form>
  			</div>
  		</div>

  		<!-- end Modal add -->

  		<script>
  			document.addEventListener("DOMContentLoaded", function() {
  				document.querySelectorAll(".edit-button").forEach(button => {
  					button.addEventListener("click", function() {
  						let id = this.getAttribute("data-id");
  						let isbn = this.getAttribute("data-isbn");
  						let title = this.getAttribute("data-title");
  						let authors = this.getAttribute("data-authors");
  						let publisher = this.getAttribute("data-publisher");
  						let description = this.getAttribute("data-description");
  						let stock = this.getAttribute("data-stock");
  						let published_date = this.getAttribute("data-published_date");
  						let jenis_buku = this.getAttribute("data-jenis_buku");
  						let thumbnail = this.getAttribute("data-thumbnail");
  						let file_ebook = this.getAttribute("data-file_ebook");
  						let id_genre = this.getAttribute("data-id_genre");

  						// Isi modal dengan data yang sesuai
  						document.getElementById("edit-id").value = id;
  						document.getElementById("edit-isbn").value = isbn;
  						document.getElementById("edit-title").value = title;
  						document.getElementById("edit-authors").value = authors;
  						document.getElementById("edit-publisher").value = publisher;
  						document.getElementById("edit-description").value = description;
  						document.getElementById("edit-stock").value = stock;
  						document.getElementById("edit-published_date").value = published_date;

  						// Pilih jenis buku
  						document.getElementById("edit-jenis_buku").value = jenis_buku;

  						// Pilih genre yang sesuai
  						document.getElementById("genreBackdrop").value = id_genre;

  						// Tampilkan thumbnail lama
  						let preview = document.getElementById("edit-image-preview");
  						if (thumbnail) {
  							preview.src = thumbnail;
  						} else {
  							preview.src = "";
  						}

  						// Tampilkan file eBook lama
  						let ebookElement = document.getElementById("current-ebook");
  						if (ebook) {
  							ebookElement.innerHTML = `<a href="${file_ebook}" target="_blank">${file_ebook.split('/').pop()}</a>`;
  						} else {
  							ebookElement.innerHTML = "Tidak ada file eBook";
  						}
  					});
  				});
  			});


  			function previewImage(id) {
  				console.log("Preview Image for: " + id); // Debugging
  				var input = document.getElementById('thumbnail' + id);
  				var preview = document.getElementById('image-preview' + id);

  				if (input.files && input.files[0]) {
  					var reader = new FileReader();

  					reader.onload = function(e) {
  						preview.src = e.target.result;
  					};

  					reader.readAsDataURL(input.files[0]);
  				}
  			}
  		</script>
  	</div>
  	<!-- / Content -->
