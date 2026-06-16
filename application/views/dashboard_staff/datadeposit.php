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
  				<table class="table table-hover">
  					<thead>
  						<tr>
  							<th>No</th>
  							<th>Username</th>
  							<th>Saldo</th>
  							<th>Bukti Deposit</th>
  							<th>Actions</th>
  						</tr>
  					</thead>
  					<tbody class="table-border-bottom-0">
  						<?php if (!empty($deposit)) : ?>
  							<?php $no = 1;
								foreach ($deposit as $d) : ?>
  								<tr>
  									<td><?= $no++ ?></td>
  									<td><?= $d->username ?></td>
  									<td>Rp <?= number_format($d->jumlah) ?></td>
  									<td><a href="<?= base_url('upload/deposit/' . $d->bukti_transfer) ?>" target="_blank">Lihat</a></td>
  									<td>
  										<a href="<?= base_url('deposit/konfirmasi_deposit/' . $d->id_deposit . '/approved') ?>" class="btn btn-success">Setujui</a>
  										<a href="<?= base_url('deposit/konfirmasi_deposit/' . $d->id_deposit . '/rejected') ?>" class="btn btn-danger">Tolak</a>
  									</td>
  								</tr>
  							<?php endforeach; ?>
  						<?php else : ?>
  							<tr>
  								<td colspan="5" class="text-center">Tidak ada data deposit.</td>
  							</tr>
  						<?php endif; ?>
  					</tbody>
  				</table>
  			</div>
  		</div>
  		<!--/ Hoverable Table rows -->
  	</div>
  	<!-- / Content -->
