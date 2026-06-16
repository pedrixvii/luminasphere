<!-- Hero Section Begin -->
<section class="hero">
	<div class="container">
		<div class="hero__slider owl-carousel">
			<?php if (!empty($sliders) && is_array($sliders)): ?>
				<?php foreach ($sliders as $sld): ?>
					<div class="hero__items set-bg" data-setbg="<?= base_url('slider/' . $sld->image_path) ?>">
						<div class="row">
							<div class="col-lg-6">
								<div class="hero__text">
									<h2><?= $sld->title ?></h2>
									<p><?= $sld->description ?></p>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Hero Section End -->
<section class="product spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="trending__product">
					<?php if (!empty($buku_by_genre) && is_array($buku_by_genre)): ?>
						<?php foreach ($buku_by_genre as $genre => $buku): ?>
							<?php $genre = !empty($genre) ? $genre : 'Tanpa Genre'; ?>

							<div class="row">
								<div class="col-lg-8 col-md-8 col-sm-8">
									<div class="section-title">
										<h4><?= htmlspecialchars($genre) ?></h4>
									</div>
								</div>
							</div>

							<div class="row">
								<?php foreach ($buku as $bku): ?>
									<?php if (!isset($bku->thumbnail)) continue; ?>

									<div class="col-lg-4 col-md-6 col-sm-6">
										<div class="product__item">
											<div class="product__item__pic set-bg" data-setbg="<?= base_url('upload/thumbnails/' . $bku->thumbnail) ?>">

												<!-- Jika buku offline, tampilkan stok -->
												<?php if ($bku->jenis_buku === 'offline') : ?>
													<span class="badge-stock">Stok: <?= htmlspecialchars($bku->stock) ?></span>
												<?php endif; ?>

												<!-- Rating di Sudut Kanan Atas -->
												<?php if (isset($bku->rating) && $bku->rating > 0): ?>
													<span class="badge-rating"><?= number_format($bku->rating, 1) ?> ★</span>
												<?php else: ?>
													<span class="badge-rating no-rating">Belum Ada Rating</span>
												<?php endif; ?>

												<!-- Komentar & View di Bagian Bawah -->
												<div class="comment"><i class="fa fa-comments"></i> <?= isset($bku->comment_count) ? htmlspecialchars($bku->comment_count) : 0; ?></div>
												<div class="view"><i class="fa fa-eye"></i> <?= htmlspecialchars($bku->views) ?> </div>
											</div>
											<div class="product__item__text">
												<ul>
													<li><?= isset($bku->genre) ? htmlspecialchars($bku->genre) : 'Tanpa Genre' ?></li>
												</ul>
												<h5><a href="<?= base_url('buku/detail/' . $bku->id_buku) ?>"><?= htmlspecialchars($bku->title) ?></a></h5>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endforeach; ?>
					<?php else: ?>
						<p class="text-center">Tidak ada buku tersedia.</p>
					<?php endif; ?>
				</div>
			</div>
