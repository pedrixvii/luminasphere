  <!-- Content wrapper -->
  <div class="content-wrapper">
  	<!-- Content -->

  	<div class="container-xxl flex-grow-1 container-p-y">
  		<hr class="my-5" />

  		<!-- Hoverable Table rows -->
  		<div class="card">
  			<h5 class="card-header">Data E-book</h5>
  			<div class="table-responsive text-nowrap">
  				<!-- Button trigger modal -->
  				<table class="table table-bordered">
  					<thead>
  						<tr>
  							<th>ID</th>
  							<th>Username</th>
  							<th>Judul Buku</th>
  							<th>Jenis Buku</th>
  							<th>Tanggal Peminjaman</th>
  							<th>Status</th>
  							<th>Denda</th>
  							<th>Poin Jika Buku Hilang</th>
  							<th>Waktu tersisa</th>
  							<th>Aksi</th>
  						</tr>
  					</thead>
  					<tbody>
  						<?php foreach ($peminjaman_pending as $p) : ?>
  							<?php
								// Konversi tanggal ke objek DateTime
								$tanggal_pengembalian = new DateTime($p->tanggal_pengembalian);
								$tanggal_sekarang = new DateTime();

								// Hitung selisih waktu
								$sisa_waktu = $tanggal_sekarang->diff($tanggal_pengembalian);
								$sisa_hari = $sisa_waktu->days;
								$sisa_jam = $sisa_waktu->h;
								$sisa_menit = $sisa_waktu->i;

								// Tentukan warna berdasarkan keterlambatan
								$warna_durasi = ($tanggal_sekarang > $tanggal_pengembalian) ? 'text-danger fw-bold' : 'text-warning fw-bold';
								?>
  							<tr>
  								<td><?= $p->id_peminjaman ?></td>
  								<td><?= $p->username ?></td>
  								<td><?= $p->title ?></td>
  								<td><?= ucfirst($p->jenis_buku) ?></td>
  								<td><?= $p->tanggal_peminjaman ?></td>
  								<td>
  									<?php if ($p->status == 'approved') : ?>
  										<span class="badge bg-label-success me-1">✅ Approved</span>
  									<?php elseif ($p->status == 'rejected') : ?>
  										<span class="badge bg-label-danger me-1">❌ Rejected</span>
  									<?php else : ?>
  										<span class="badge bg-label-warning me-1">⏳ Pending</span>
  									<?php endif; ?>
  								</td>

  								<!-- Tampilkan poin awal, poin setelah pinjam, denda jika telat, dan poin jika buku hilang -->
  								
  								<td><span class="badge bg-label-warning me-1">⚠️ <?= number_format($p->denda, 0, ',', '.') ?> Poin</span></td>
  								<td><span class="badge bg-label-danger me-1">🛑 <?= number_format($p->poin_jika_hilang, 0, ',', '.') ?> Poin</span></td>

  								<!-- Durasi Pengembalian -->
  								<td class="<?= $warna_durasi ?>">
  									<?php if ($tanggal_sekarang > $tanggal_pengembalian) : ?>
  										<span class="badge bg-label-danger me-1">❗ Telat <?= $sisa_hari ?> hari, <?= $sisa_jam ?> jam, <?= $sisa_menit ?> menit</span>
  									<?php else : ?>
  										<span class="badge bg-label-success me-1">⏳ <?= $sisa_hari ?> hari, <?= $sisa_jam ?> jam, <?= $sisa_menit ?> menit tersisa</span>
  									<?php endif; ?>
  								</td>

  								<!-- Tombol Approve / Reject -->
  								<td>
  									<a href="<?= site_url('approved/approve/' . $p->id_peminjaman) ?>" class="btn btn-success btn-sm">✔ Approve</a>
  									<a href="<?= site_url('approved/reject/' . $p->id_peminjaman) ?>" class="btn btn-danger btn-sm">✖ Reject</a>
  								</td>
  								<?php if ($this->session->flashdata('error')): ?>
  									<div class="alert alert-danger">
  										<?php echo $this->session->flashdata('error'); ?>
  									</div>
  								<?php endif; ?>
  							</tr>
  						<?php endforeach; ?>
  					</tbody>
  				</table>
  			</div>
  		</div>
  		<!--/ Hoverable Table rows -->
  	</div>
  	<!-- / Content -->
