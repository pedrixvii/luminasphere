<div class="container mt-4">
	<h3 class="text-center mb-4 text-light">📚 Buku yang Sedang Dipinjam</h3>
	<div class="row">
		<?php if (!empty($buku_dipinjam) && is_array($buku_dipinjam)): ?>
			<?php foreach ($buku_dipinjam as $buku): ?>
				<div class="col-lg-4 col-md-6 col-sm-6">
					<div class="product__item">
						<div class="product__item__pic set-bg" data-setbg="<?= base_url('upload/thumbnails/' . $buku->thumbnail) ?>">

							<!-- Stok Buku di Sudut Kiri Atas -->
							<span class="badge-stock">Stok: <?= htmlspecialchars($buku->stock) ?></span>

							<!-- Rating di Sudut Kanan Atas -->
							<?php if (isset($buku->rating) && $buku->rating > 0): ?>
								<span class="badge-rating"><?= number_format($buku->rating, 1) ?> ★</span>
							<?php else: ?>
								<span class="badge-rating no-rating">Belum Ada Rating</span>
							<?php endif; ?>

							<!-- Komentar & View di Bagian Bawah -->
							<div class="comment"><i class="fa fa-comments"></i> <?= isset($buku->comment_count) ? htmlspecialchars($buku->comment_count) : 0; ?></div>
							<div class="view"><i class="fa fa-eye"></i> <?= htmlspecialchars($buku->views) ?> </div>
						</div>
						<div class="product__item__text">
							<ul>
								<li><?= isset($buku->genre) ? htmlspecialchars($buku->genre) : 'Tanpa Genre' ?></li>
							</ul>
							<h5><a href="<?= base_url('buku/detail/' . $buku->id_buku) ?>"><?= htmlspecialchars($buku->title) ?></a></h5>
							<p class="text-white">Tanggal Peminjaman: <?= date('d M Y', strtotime($buku->tanggal_peminjaman)) ?></p>
							<p class="text-danger">Tanggal Pengembalian: <?= date('d M Y', strtotime($buku->tanggal_pengembalian)) ?></p>

							<!-- Tombol Kembalikan -->
							<a href="<?= base_url('peminjaman/kembalikan/' . $buku->id_peminjaman) ?>" class="btn btn-danger mt-2">
								<i class="fa fa-undo"></i> Kembalikan Buku
							</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php else: ?>
			<p class="text-center text-white">🚫 Tidak ada buku yang sedang dipinjam.</p>
		<?php endif; ?>
	</div>
</div>
