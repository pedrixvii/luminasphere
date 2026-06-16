<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcrumb__links">
					<a href="<?= base_url('dashboard/user') ?>"><i class="fa fa-home"></i> Home</a>

					<?php if (!empty($buku['genre'])) : ?>
						<a href="<?= base_url('kategori/' . urlencode($buku['genre'])) ?>">
							<?= $buku['genre']; ?>
						</a>
					<?php endif; ?>

					<span><?= $buku['title']; ?></span>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Breadcrumb End -->

<!-- Anime Section Begin -->
<section class="anime-details spad">
	<div class="container">
		<div class="anime__details__content">
			<div class="row">
				<div class="col-lg-3">
					<div class="anime__details__pic set-bg" data-setbg="<?= base_url('upload/thumbnails/' .  $buku['thumbnail']); ?>">
					</div>
				</div>
				<div class="col-lg-9">
					<div class="anime__details__text">
						<div class="anime__details__title">
							<h3><?= $buku['title']; ?></h3>
							<span>Authors: <?= $buku['authors']; ?></span>
						</div>
						<p><?= strlen($buku['description']) > 350 ? substr($buku['description'], 0, 350) . '...' : $buku['description']; ?></p>
						<div class="anime__details__widget">
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<ul>
										<li><span>Publisher:</span><?= $buku['publisher']; ?></li>
										<li><span>Published Date:</span><?= $buku['published_date']; ?></li>
								
									</ul>
								</div>
								<div class="col-lg-6 col-md-6">
									<ul>
										<li><span>Genre:</span> <?= isset($buku['genre']) ? $buku['genre'] : 'Tidak ada genre'; ?></li>
										<li><span>Rating:</span> <?= isset($buku['rating']) ? number_format($buku['rating'], 1) . ' / 10' : 'Belum ada rating'; ?></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="anime__details__btn d-flex flex-wrap gap-2">
							<?php if ($sudah_dipinjam) : ?>
								<?php if ($status == 'approved') : ?>
									<?php if ($buku['jenis_buku'] === 'online') : ?>
										<!-- Jika Buku Online, Tampilkan Tombol Baca & Kembalikan -->
										<?php if (!empty($buku['file_ebook']) && file_exists(FCPATH . 'upload/ebooks/' . $buku['file_ebook'])) : ?>
											<button class="btn btn-primary btn-baca-pdf" data-pdf="<?= base_url('upload/ebooks/' . $buku['file_ebook']); ?>">
												<i class="fa fa-file-pdf"></i> Baca eBook (PDF)
											</button>
											<button id="pdf-close" class="btn btn-secondary" style="display: none;">
												<i class="fa fa-times"></i> Tutup PDF
											</button>
										<?php else : ?>
											<button class="btn btn-secondary" disabled>
												<i class="fa fa-file-pdf"></i> File eBook Tidak Tersedia
											</button>
										<?php endif; ?>

										<!-- Tombol Kembalikan Buku Online -->
										<a href="<?= base_url('peminjaman/kembalikan/' . $id_peminjaman); ?>" class="btn btn-danger">
											<i class="fa fa-undo"></i> Kembalikan eBook
										</a>

									<?php else : ?>
										<!-- Jika Buku Offline, Tampilkan Tombol Kembalikan -->
										<a href="<?= base_url('peminjaman/kembalikan/' . $id_peminjaman); ?>" class="btn btn-danger">
											<i class="fa fa-undo"></i> Kembalikan Buku
										</a>
									<?php endif; ?>
								<?php elseif ($status == 'rejected') : ?>
									<button class="btn btn-danger" disabled>
										❌ Peminjaman Ditolak
									</button>
								<?php else : ?>
									<button class="btn btn-warning" disabled>
										⏳ Menunggu Persetujuan Staff
									</button>
								<?php endif; ?>

							<?php else : ?>
								<?php
								// Ambil poin terbaru user
								$id_user = $this->session->userdata('id_user');
								$user = $this->db->select('poin')->where('id_user', $id_user)->get('user')->row();

								// Pastikan user ditemukan sebelum mengakses poin
								$user_poin = ($user) ? $user->poin : 0;

								// Cek apakah user masuk antrian
								$user_in_queue = $this->db->where('id_user', $id_user)
									->where('id_buku', $buku['id_buku'])
									->where('status', 'menunggu')
									->get('antrian_peminjaman')
									->num_rows() > 0;
								?>

								<?php if ($buku['stock'] <= 0 && $buku['jenis_buku'] === 'offline') : ?>
									<!-- Jika Stok Habis untuk Buku Offline, Tampilkan Tombol "Menunggu Antrian" -->
									<?php if ($user_in_queue) : ?>
										<button class="btn btn-secondary" disabled>
											<i class="fa fa-clock"></i> Menunggu Antrian
										</button>
									<?php else : ?>
										<a href="<?= base_url('peminjaman/antri/' . $buku['id_buku']); ?>" class="btn btn-warning">
											<i class="fa fa-list"></i> Masuk Antrian
										</a>
									<?php endif; ?>

								<?php else : ?>
									<!-- Jika Buku Offline -->
									<?php if ($buku['jenis_buku'] === 'offline') : ?>
										<?php if ($user_poin >= 10) : ?>
											<a href="<?= base_url('peminjaman/pinjam/' . $buku['id_buku']); ?>" class="btn btn-success">
												<i class="fa fa-book"></i> Pinjam Buku (-10 Poin)
											</a>
										<?php else : ?>
											<button class="btn btn-danger" disabled>
												<i class="fa fa-exclamation-circle"></i> Poin Tidak Cukup
											</button>
										<?php endif; ?>

									<?php else : ?>
										<!-- Jika Buku Online -->
										<a href="<?= base_url('peminjaman/pinjam/' . $buku['id_buku']); ?>" class="btn btn-success">
											<i class="fa fa-book"></i> Pinjam Buku (-10 Poin)
										</a>
									<?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

			<br>
			<div class="row">
				<div class="col-lg-8 col-md-8">
					<div class="anime__details__review">
						<div class="section-title">
							<h5>Reviews</h5>
						</div>
						<?php if (!empty($comment)): ?>
							<?php foreach ($comment as $com): ?>
								<div class="anime__review__item">
									<div class="anime__review__item__pic">
										<img src="<?= base_url('./upload/foto_user/') . (!empty($com['foto']) ? $com['foto'] : 'default.jpg') ?>" alt="User Profile">

									</div>
									<div class="anime__review__item__text">
										<h6><?= htmlspecialchars($com['username']); ?>
											<span> <?= date('d M Y, H:i', strtotime($com['created_at'])); ?></span>
										</h6>
										<p><?= htmlspecialchars($com['comment']); ?></p>
										<!-- Menampilkan rating -->
										<p>Rating: <?= isset($com['rating']) ? number_format($com['rating'], 1) : '0.0' ?> ⭐</p>
									</div>
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<p class="text-white">No comments yet. Be the first to comment!</p>
						<?php endif; ?>
					</div>
					<div class="anime__details__form">
						<div class="section-title">
							<h5>Your Comment</h5>
						</div>
						<form action="<?= base_url('comment/add'); ?>" method="POST">
							<input type="hidden" name="id_buku" value="<?= $buku['id_buku']; ?>"> <!-- ID buku -->
							<textarea name="comment" placeholder="Your Comment" required></textarea> <!-- Komentar -->
							<!-- Input Rating -->
							<div class="rating-container">
								<div class="section-title">
									<h5>Your Rating</h5>
								</div>
								<div class="rating">
									<input type="radio" id="star5" name="rating" value="5" />
									<label for="star5" title="Sangat Baik">★</label>

									<input type="radio" id="star4" name="rating" value="4" />
									<label for="star4" title="Baik">★</label>

									<input type="radio" id="star3" name="rating" value="3" />
									<label for="star3" title="Cukup Baik">★</label>

									<input type="radio" id="star2" name="rating" value="2" />
									<label for="star2" title="Kurang Baik">★</label>

									<input type="radio" id="star1" name="rating" value="1" />
									<label for="star1" title="Sangat Buruk">★</label>
								</div>
							</div>
							<button type="submit"><i class="fa fa-location-arrow"></i> Review</button>
						</form>

					</div>
				</div>
				<!-- <div class="col-lg-4 col-md-4">
					<div class="anime__details__sidebar">
						<div class="section-title">
							<h5>you might like...</h5>
						</div>
						<div class="product__sidebar__view__item set-bg" data-setbg="img/sidebar/tv-1.jpg">
							<div class="ep">18 / ?</div>
							<div class="view"><i class="fa fa-eye"></i> 9141</div>
							<h5><a href="#">Boruto: Naruto next generations</a></h5>
						</div>
						<div class="product__sidebar__view__item set-bg" data-setbg="img/sidebar/tv-2.jpg">
							<div class="ep">18 / ?</div>
							<div class="view"><i class="fa fa-eye"></i> 9141</div>
							<h5><a href="#">The Seven Deadly Sins: Wrath of the Gods</a></h5>
						</div>
						<div class="product__sidebar__view__item set-bg" data-setbg="img/sidebar/tv-3.jpg">
							<div class="ep">18 / ?</div>
							<div class="view"><i class="fa fa-eye"></i> 9141</div>
							<h5><a href="#">Sword art online alicization war of underworld</a></h5>
						</div>
						<div class="product__sidebar__view__item set-bg" data-setbg="img/sidebar/tv-4.jpg">
							<div class="ep">18 / ?</div>
							<div class="view"><i class="fa fa-eye"></i> 9141</div>
							<h5><a href="#">Fate/stay night: Heaven's Feel I. presage flower</a></h5>
						</div>
					</div>
				</div> -->
			</div>
		</div>
		<!-- Modal PDF Viewer -->
		<div class="modal fade" id="pdf-modal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Baca eBook</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body text-center">
						<canvas id="pdfCanvas" style="width: 100%; height: auto;"></canvas>
					</div>
					<div class="modal-footer d-flex justify-content-between">
						<button id="prevPage" class="btn btn-secondary">⬅️ Sebelumnya</button>
						<span>Halaman <span id="currentPage">1</span> dari <span id="totalPages">?</span></span>
						<button id="nextPage" class="btn btn-secondary">Selanjutnya ➡️</button>
					</div>
				</div>
			</div>
		</div>


		<script>
			// 🔒 Mencegah Print & Save As
			document.addEventListener("keydown", function(event) {
				if (event.ctrlKey && (event.code === "KeyP" || event.code === "KeyS")) {
					alert("Fitur print dan save tidak diperbolehkan!");
					event.preventDefault();
					return false;
				}
			});

			let pdfDoc = null;
			let currentPage = 1;
			let totalPages = 0;
			let pdfUrl = "";

			// Fungsi untuk merender halaman PDF
			function renderPage(pageNumber) {
				pdfDoc.getPage(pageNumber).then(function(page) {
					let canvas = document.getElementById("pdfCanvas");
					let context = canvas.getContext("2d");
					let viewport = page.getViewport({
						scale: 1.5
					});

					canvas.width = viewport.width;
					canvas.height = viewport.height;

					let renderContext = {
						canvasContext: context,
						viewport: viewport
					};

					page.render(renderContext);
					document.getElementById("currentPage").textContent = pageNumber;
				});
			}

			// Fungsi untuk menampilkan PDF
			function showPDF(url) {
				pdfUrl = url;
				pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
					pdfDoc = pdf;
					totalPages = pdf.numPages;
					document.getElementById("totalPages").textContent = totalPages;
					renderPage(currentPage);
				}).catch(function(error) {
					console.error("Gagal memuat PDF:", error);
					alert("Gagal memuat eBook.");
				});
			}

			// Klik tombol "Baca eBook"
			$(document).on("click", ".btn-baca-pdf", function() {
				let url = $(this).data("pdf");
				if (url) {
					currentPage = 1;
					showPDF(url);
					$("#pdf-modal").modal("show");
				} else {
					alert("File eBook tidak tersedia.");
				}
			});

			// Navigasi halaman
			document.getElementById("prevPage").addEventListener("click", function() {
				if (currentPage > 1) {
					currentPage--;
					renderPage(currentPage);
				}
			});

			document.getElementById("nextPage").addEventListener("click", function() {
				if (currentPage < totalPages) {
					currentPage++;
					renderPage(currentPage);
				}
			});

			// Bersihkan saat modal ditutup
			$("#pdf-modal").on("hidden.bs.modal", function() {
				let canvas = document.getElementById("pdfCanvas");
				let context = canvas.getContext("2d");
				context.clearRect(0, 0, canvas.width, canvas.height);
			});


			$(document).ready(function() {
				// 🔔 Konfigurasi toastr
				toastr.options = {
					closeButton: true,
					progressBar: true,
					positionClass: "toast-top-center",
					timeOut: 4000,
					showMethod: "fadeIn",
					hideMethod: "fadeOut"
				};

				// 📢 Fungsi cek notifikasi peminjaman
				function cekNotifikasi() {
					$.ajax({
						url: "<?= base_url('approved/cek_approve'); ?>",
						method: "GET",
						dataType: "json",
						success: function(response) {
							if (response.status === "success" && response.message) {
								if (!$(".toast-message:contains('Peminjaman telah disetujui!')").length) {
									toastr.success(response.message);
									clearInterval(notifInterval); // Hentikan pengecekan jika sudah ditampilkan
								}
							}
						},
						error: function(xhr, status, error) {
							console.error("AJAX Error (approve): ", error);
						}
					});

					$.ajax({
						url: "<?= base_url('approved/cek_reject') ?>",
						type: "GET",
						dataType: "json",
						success: function(response) {
							console.log(response);
							if (response.status === "rejected") {
								alert(response.message);
								location.reload();
							}
						},
						error: function(xhr, status, error) {
							console.log("AJAX Error:", error);
						}
					});
				}

				let notifInterval = setInterval(cekNotifikasi, 5000);

				// Pastikan toastr tidak muncul dua kali
				if (!$(".toast-message:contains('Peminjaman berhasil')").length) {
					<?php if ($this->session->flashdata('success')): ?>
						toastr.success("<?= $this->session->flashdata('success'); ?>");
					<?php endif; ?>

					<?php if ($this->session->flashdata('error')): ?>
						toastr.error("<?= $this->session->flashdata('error'); ?>");
					<?php endif; ?>

					<?php if ($this->session->flashdata('info')): ?>
						toastr.info("<?= $this->session->flashdata('info'); ?>");
					<?php endif; ?>

					<?php if ($this->session->flashdata('reject')): ?>
						toastr.warning("<?= $this->session->flashdata('reject'); ?>");
					<?php endif; ?>
				}

				// 📖 Fungsi untuk membaca PDF (Modal Viewer)
				$(document).on("click", ".btn-baca-pdf", function() {
					var pdfUrl = $(this).data("pdf");

					if (pdfUrl) {
						console.log("Membuka PDF:", pdfUrl);
						$("#pdfViewer").attr("src", pdfUrl);
						$("#pdf-modal").modal("show");
					} else {
						alert("File eBook tidak tersedia.");
					}
				});

				// Bersihkan modal saat ditutup
				$("#pdf-modal").on("hidden.bs.modal", function() {
					$("#pdfViewer").attr("src", "");
				});
			});
		</script>
</section>
<!-- Anime Section End -->
