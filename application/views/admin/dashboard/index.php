<section class="content">
	<!-- Info boxes -->
	<div class="row">

		<!-- fix for small devices only -->
		<div class="clearfix visible-sm-block"></div>


		<div class="col-md-3 col-sm-6 col-xs-12">
			<a href="#">
				<div class="info-box">
					<span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Omzet</span>
						<span class="info-box-number">IDR : <?php echo number_format($tunai + $hutang); ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</a>
		</div>
		<!-- /.col -->


		<div class="col-md-3 col-sm-6 col-xs-12">
			<a href="#" id="listTunaiD">
				<div class="info-box">
					<span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Laba </span>
						<span class="info-box-number">IDR : <?php echo number_format($laba); ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
			</a>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->


		<!-- fix for small devices only -->
		<div class="clearfix visible-sm-block"></div>

		<div class="col-md-3 col-sm-6 col-xs-12">
			<a href="#" id="profit">
				<div class="info-box">
					<span class="info-box-icon bg-blue"><i class="fa fa-money"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Tunai </span>
						<span class="info-box-number">IDR : <?php echo number_format($tunai); ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
			</a>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->


		<!-- fix for small devices only -->
		<div class="clearfix visible-sm-block"></div>


		<div class="col-md-3 col-sm-6 col-xs-12">
			<a href="#" id="listDebit">
				<div class="info-box">
					<span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Bayar Piutang </span>
						<span class="info-box-number">IDR : <?php echo number_format($pelunasan); ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
			</a>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->

	</div>
	<!-- /.row -->


	<!-- Info boxes -->
	<div class="row">

		<!-- fix for small devices only -->
		<div class="clearfix visible-sm-block"></div>


		<div class="col-md-3 col-sm-3 col-xs-12">
			<a href="#">
				<div class="info-box">
					<span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Pembelian</span>
						<span class="info-box-number">IDR : <?php echo number_format($pembelian); ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</a>
		</div>
		<!-- /.col -->


		<div class="col-md-3 col-sm-3 col-xs-12">
			<a href="#" id="listTunaiD">
				<div class="info-box">
					<span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Pengeluaran </span>
						<span class="info-box-number">IDR : <?php echo number_format($pengeluaran); ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
			</a>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->

		<div class="col-md-3 col-sm-3 col-xs-12">
			<a href="#" id="listTunaiD">
				<div class="info-box">
					<span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Bayar Hutang </span>
						<span class="info-box-number">IDR : <?php echo number_format($bayarhutang); ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
			</a>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->


		<div class="col-md-3 col-sm-3 col-xs-12">
			<a href="#" id="listTunaiD">
				<div class="info-box">
					<span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Sisa Hutang </span>
						<span class="info-box-number">IDR : <?php echo number_format($sisahutang); ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
			</a>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->


		<!-- fix for small devices only -->
		<div class="clearfix visible-sm-block"></div>



	</div>
	<!-- /.row -->






	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Priode Laporan Tanggal : <?php echo $priode; ?></h3>
				</div>
				<div class="row">
					<!-- Hutang --->

					<div class="col-md-12">
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<div class="col-md-6">
									<p class="text-center">
										<strong>Bayar Piutang (Pelanggan)</strong>
									</p>
									<div class="chart">
										<table class="table table-hover table-striped table-bordered">
											<thead>
												<tr>
													<th>No</th>
													<th>Nama Pelanggan</th>
													<th>Total Bayar</th>
													<th>Status</th>
													<th>Sisa Piutang</th>
												</tr>
											</thead>
											<tbody>
												<?php $no = 1; ?>
												<?php $total = 0; ?>
												<?php foreach ($rincibayarpiutang as $t) {; ?>
													<?php $total = $total + $t->bayarhutang; ?>
													<tr>
														<td><?php echo $no++; ?></td>
														<td><?php echo $t->namapelanggan; ?></td>
														<td><?php echo "Rp." . number_format($t->bayarhutang); ?></td>
														<td><?php echo $t->sisahutang <= 0 ? 'Pelunasan' : 'Cicilan'; ?></td>
														<td><?php echo "Rp." . number_format($t->sisahutang); ?></td>

													</tr>
												<?php }; ?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="2"><b>Total</b></td>
													<td><b><?php echo "Rp." . number_format($total); ?></b></td>
													<td><b></b></td>
													<td></td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>

								<div class="col-md-6">
									<p class="text-center">
										<strong>Bayar Hutang (Suplayer)</strong>
									</p>
									<div class="chart">
										<table class="table table-hover table-striped table-bordered">
											<thead>
												<tr>
													<th>No</th>
													<th>Nama Suplayer</th>
													<th>Total Bayar</th>
													<th>Status</th>
													<th>Sisa Hutang</th>
												</tr>
											</thead>
											<tbody>
												<?php $no = 1; ?>
												<?php $total = 0; ?>
												<?php foreach ($rincibayarhutang as $t) {; ?>
													<?php $total = $total + $t->bayarhutang; ?>
													<tr>
														<td><?php echo $no++; ?></td>
														<td><?php echo $t->namasuplayer; ?></td>
														<td><?php echo "Rp." . number_format($t->bayarhutang); ?></td>
														<td><?php echo $t->sisahutang <= 0 ? 'Pelunasan' : 'Cicilan'; ?></td>
														<td><?php echo "Rp." . number_format($t->sisahutang); ?></td>

													</tr>
												<?php }; ?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="2"><b>Total</b></td>
													<td><b><?php echo "Rp." . number_format($total); ?></b></td>
													<td><b></b></td>
													<td></td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>

							</div>
						</div>
						<!-- /.box -->
					</div>




					<div class="col-md-12">
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<div class="col-md-6">
									<p class="text-center">
										<strong>Pembelian</strong>
									</p>
									<div class="chart">
										<table class="table table-hover table-striped table-bordered">
											<thead>
												<tr>
													<th>No</th>
													<th>Nama Suplayer</th>
													<th>Total Barang</th>
													<th>Total Pembelian</th>
												</tr>
											</thead>
											<tbody>
												<?php $no = 1; ?>
												<?php $jsuplayer = 0; ?>
												<?php $jtotal = 0; ?>
												<?php foreach ($jlmPembelian as $t) {; ?>
													<?php $jtotal = $jtotal + $t->totalharga; ?>
													<tr>
														<td><?php echo $no++; ?></td>
														<td><?php echo $t->namasuplayer; ?></td>
														<td><?php echo $t->totalqty; ?></td>
														<td><?php echo "Rp." . number_format($t->totalharga); ?></td>


													</tr>
												<?php }; ?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="2"><b>Total</b></td>
													<td><b></b></td>
													<td><b><?php echo "Rp." . number_format($jtotal); ?></b></td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>

								<div class="col-md-6">
									<p class="text-center">
										<strong>Penjualan</strong>
									</p>
									<div class="chart">
										<table class="table table-hover table-striped table-bordered">
											<thead>
												<tr>
													<th>No</th>
													<th>Nama Pelanggan</th>
													<th>Total Barang</th>
													<th>Total Penjualan</th>
													<th>Total Laba</th>
												</tr>
											</thead>
											<tbody>
												<?php $no = 1; ?>
												<?php $jpelanggan = 0; ?>
												<?php $jtotal = 0; ?>
												<?php $totalLaba = 0; ?>
												<?php foreach ($jlmPenjualan as $t) {; ?>
													<tr>
														<td><?php echo $no++; ?></td>
														<td><?php echo $t->namapelanggan; ?></td>
														<td><?php echo $t->totalqty; ?></td>
														<td><?php echo "Rp." . number_format($t->totalharga); ?></td>
														<td><?php echo "Rp." . number_format($t->laba); ?></td>

													</tr>
													<?php $totalLaba = $totalLaba + $t->laba; ?>
													<?php $jtotal = $jtotal + $t->totalharga; ?>

												<?php }; ?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="3"><b>Total</b></td>
													<td><b><?php echo "Rp." . number_format($jtotal); ?></b></td>
													<td><b><?php echo "Rp." . number_format($totalLaba); ?></b></td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>

							</div>
						</div>
						<!-- /.box -->
					</div>

					<!--- Barang -->
					<div class="col-md-12">
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-6">
									<p class="text-center">
										<strong>Pembelian Barang</strong>
									</p>
									<div class="col-md-12">

										<table class="table table-hover table-striped table-bordered">
											<thead>
												<tr>
													<th>No</th>
													<th>ID</th>
													<th>T</th>
													<th>L</th>
													<th>P</th>
													<th>Qty</th>
													<th>Total Harga</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no = 1;
												$jmTotal = 0;
												$jmTotalHarga = 0;
												foreach ($pembelianBarang as $p) {; ?>
													<?php $jmTotal = $jmTotal + $p->totalpcs; ?>
													<?php $jmTotalHarga = $jmTotalHarga + $p->totalharga; ?>

													<tr>
														<td><?php echo $no++; ?></td>
														<td><?php echo $p->idbarang; ?></td>
														<td><?php echo $p->t; ?></td>
														<td><?php echo $p->l; ?></td>
														<td><?php echo $p->p; ?></td>
														<td><?php echo $p->totalpcs; ?></td>
														<td><?php echo number_format($p->totalharga); ?></td>
													</tr>
												<?php }; ?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="5"><b>Total</b></td>
													<td><b><?php echo $jmTotal; ?></b></td>
													<td><b><?php echo number_format($jmTotalHarga); ?></b></td>
												</tr>
											</tfoot>
										</table>


									</div>


								</div>
								<!-- /.row -->

								<!-- /.col -->
								<div class="col-md-6">
									<p class="text-center">
										<strong>Penjualan Barang</strong>
									</p>
									<div class="col-md-12">

										<table class="table table-hover table-striped table-bordered">
											<thead>
												<tr>
													<th>No</th>
													<th>ID</th>
													<th>T</th>
													<th>L</th>
													<th>P</th>
													<th>Qty</th>
													<th>Total Harga</th>
													<th>Total Laba</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no = 1;
												$jmTotal = 0;
												$jmTotalHarga = 0;
												$totalLaba = 0;
												foreach ($penjualanBarang as $p) {; ?>
													<?php $jmTotal = $jmTotal + $p->totalpcs; ?>
													<?php $jmTotalHarga = $jmTotalHarga + $p->totalharga; ?>
													<?php $totalLaba = $totalLaba + $p->laba; ?>

													<tr>
														<td><?php echo $no++; ?></td>
														<td><?php echo $p->idbarang; ?></td>
														<td><?php echo $p->t; ?></td>
														<td><?php echo $p->l; ?></td>
														<td><?php echo $p->p; ?></td>
														<td><?php echo $p->totalpcs; ?></td>
														<td><?php echo number_format($p->totalharga); ?></td>
														<td><?php echo number_format($p->laba); ?></td>
													</tr>
												<?php }; ?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="5"><b>Total</b></td>
													<td><b><?php echo $jmTotal; ?></b></td>
													<td><b><?php echo number_format($jmTotalHarga); ?></b></td>
													<td><b><?php echo number_format($totalLaba); ?></b></td>
												</tr>
											</tfoot>
										</table>


									</div>


								</div>
								<!-- /.row -->

							</div>
						</div>
						<!-- /.box -->
					</div>
				</div>
			</div>
			<!-- /.col -->
		</div>
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Persentasi Penjualan Barang</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<div style="height:250px; overflow:scroll;padding:5px">
								<?php $nomber = 1; ?>
								<?php foreach ($banyakBarang as $bar) {; ?>

									<?php

									$j = $bar->totalpcs;
									$persen = ($j * 100) / $jmTotal;; ?>

									<div class="progress-group">
										<span class="progress-text">
											<table style="width:100px">
												<tr>
													<td rowspan="2"><?php echo $nomber++; ?></td>
													<td>T</td>
													<td>L</td>
													<td>P</td>
												</tr>
												<tr>
													<td><?php echo $bar->t; ?></td>
													<td><?php echo $bar->l; ?></td>
													<td><?php echo $bar->p; ?></td>
												</tr>
											</table>
										</span>
										<span class="progress-number"><b><?php echo substr($persen, 0, 4); ?>%</span>

										<div class="progress sm">
											<div class="progress-bar progress-bar-aqua" style="width: <?php echo (int)$persen; ?>%"></div>
										</div>
									</div>
									<!-- /.progress-group -->
								<?php }; ?>
							</div>
						</div>
						<!-- /.col -->
					</div>
				</div>
			</div>
		</div>
	</div>

</section>

<?php echo $this->session->flashdata('massage'); ?>




<script type="text/javascript">
	$('.table').DataTable({
		"scrollY": "200px",
		"scrollX": "auto",
		"searching": false,
		"info": false,
		"bPaginate": false,


	});
</script>