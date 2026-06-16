<div class="col-lg-4 col-md-6 col-sm-8">
	<div class="product__sidebar">
		<div class="product__sidebar__view">
			<div class="section-title">
				<h5>Top Views</h5>
			</div>
			<div class="filter__gallery">
				<?php foreach ($top_views as $book) : ?>
					<div class="product__sidebar__view__item set-bg" data-setbg="<?= base_url('upload/thumbnails/' . $book['thumbnail']); ?>">
						<div class="view"><i class="fa fa-eye"></i> <?= $book['views']; ?></div>
						<h5><a href="<?= base_url('buku/detail/' . $book['id_buku']); ?>"><?= $book['title']; ?></a></h5>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	



</div>
</div>
</div>
</div>
</section>
