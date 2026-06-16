<!-- Content wrapper -->
<div class="content-wrapper">
	<!-- Content -->

	<div class="container-xxl flex-grow-1 container-p-y">
		<div class="row">
			<div class="col-12 col-md-8 col-lg-12 order-3 order-md-2">
				<div class="row">
					<div class="col-6 mb-3">
						<div class="card h-80">
							<div class="card-body">
								<p class="mb-1">Jumlah Buku</p>
								<h4 class="card-title mb-3"><i class='bx bxs-book'></i> <?= $jumlah_ebook; ?></h4>
								<small class="<?= ($ebook_change > 0) ? 'text-success' : 'text-danger'; ?> fw-medium">
									<i class='bx <?= ($ebook_change > 0) ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt'; ?>'></i>
									<?= ($ebook_change > 0) ? "+$ebook_change" : "$ebook_change"; ?>
								</small>
							</div>
						</div>
					</div>
					<div class="col-6 mb-6">
						<div class="card h-80">
							<div class="card-body">
								<p class="mb-1">Genre</p>
								<h4 class="card-title mb-3"><i class='bx bx-category-alt'></i> <?= $jumlah_genre; ?></h4>
								<small class="<?= ($genre_change > 0) ? 'text-success' : 'text-danger'; ?> fw-medium">
									<i class='bx <?= ($genre_change > 0) ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt'; ?>'></i>
									<?= ($genre_change > 0) ? "+$genre_change" : "$genre_change"; ?>
								</small>
							</div>
						</div>
					</div>
					<div class="col-6 mb-6">
						<div class="card h-80" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalBukuTertinggi">
							<div class="card-body">
								<p class="mb-1">Jumlah Buku Rating Tertinggi</p>
								<h4 class="card-title mb-3"><?= $jumlah_buku_tertinggi; ?></h4>
								<p class="mb-0">Rating: <strong><?= $rating_tertinggi; ?> </strong><i class='bx bx-star'></i></p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 mb-4 mt-3"> <!-- Tambahkan mt-3 untuk memberi jarak -->
					<div class="card">
						<div class="card-body py-4"> <!-- Tambahkan padding atas & bawah -->
							<div class="d-flex justify-content-between flex-sm-row flex-column gap-4">
								<div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
									<div class="card-title" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#userPinjamModal">
										<h5 class="text-nowrap mb-2">Jumlah Peminjam Buku</h5>
										<span class="badge bg-label-warning">YEAR 2025</span>
									</div>
									<div class="mt-sm-auto">
										<small class="<?= ($user_change > 0) ? 'text-success' : 'text-danger'; ?> fw-medium">
											<i class='bx <?= ($user_change > 0) ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt'; ?>'></i>
											<?= ($user_change > 0) ? "+$user_change" : "$user_change"; ?>
										</small>
										<h4 class="mb-0"><?= $jumlah_user_pinjam; ?></h4>
									</div>
								</div>
								<div id="profileReportChart"></div>
							</div>
							<!-- Tombol Lihat Daftar Peminjam -->
							<div class="text-center mt-3">
								<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userPinjamModal">
									Lihat Daftar Peminjam
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal Buku dengan Rating Tertinggi -->
		<div class="modal fade" id="modalBukuTertinggi" tabindex="-1" aria-labelledby="modalBukuTertinggiLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalBukuTertinggiLabel">Daftar Buku dengan Rating Tertinggi</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<table class="table table-bordered">
							<thead class="table-dark">
								<tr>
									<th>Judul Buku</th>
									<th>Rating</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($buku_tertinggi)) : ?>
									<?php foreach ($buku_tertinggi as $buku) : ?>
										<tr>
											<td><?= $buku->title; ?></td>
											<td class="text-warning fw-bold">⭐ <?= $buku->rating; ?></td>
										</tr>
									<?php endforeach; ?>
								<?php else : ?>
									<tr>
										<td colspan="2" class="text-center">Tidak ada buku dengan rating tertinggi.</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Daftar User yang Meminjam -->
		<div class="modal fade" id="userPinjamModal" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Daftar Peminjam</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Username</th>
									<th>Email</th>
									<th>Tanggal Peminjaman</th>
									<th>Tanggal Pengembalian</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($user_peminjam)) : ?>
									<?php foreach ($user_peminjam as $peminjam) : ?>
										<tr>
											<td><?= htmlspecialchars($peminjam->username); ?></td>
											<td><?= htmlspecialchars($peminjam->email); ?></td>
											<td><?= htmlspecialchars($peminjam->tanggal_peminjaman); ?></td>
											<td><?= htmlspecialchars($peminjam->tanggal_pengembalian); ?></td>
										</tr>
									<?php endforeach; ?>
								<?php else : ?>
									<tr>
										<td colspan="4" class="text-center">Tidak ada peminjam saat ini.</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- / Content -->
