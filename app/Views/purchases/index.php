<?= $this->extend("layouts/main") ?>

<?= $this->section("content") ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card border-0 shadow-sm">
				<div class="card-header py-3 bg-white border-0 d-flex align-middle">
					<h2 class="text-gray-700 fw-500 mt-2" style="font-size: 1.5rem;">Data Pembelian</h2>
					<div class="ms-auto">
						<button class="btn btn-primary" onclick="createPurchase()">
							<i class="fas fa-plus"></i>
						</button>
					</div>
				</div>
				<div class="card-body pt-0">
					<div class="table-responsive">
						<table class="table table-borderless table-dashed align-middle text-nowrap">
							<thead class="text-gray-500 fw-500 text-uppercase">
								<tr>
									<th>Tanggal</th>
									<th>User</th>
									<th>Total Belanja</th>
									<th>Status</th>
									<th>Status Pembayaran</th>
									<th></th>
								</tr>
							</thead>
							<tbody class="text-gray-700 fw-500">
								<?php foreach ($purchases as $purchase) : ?>
									<tr>
										<td><?= esc($purchase->date->toLocalizedString("dd MMM y")) ?></td>
										<td><?= esc($purchase->user) ?></td>
										<td class="format-rupiah" data-format="<?= esc($purchase->grand_total) ?>">
											<?= esc($purchase->grand_total) ?>
										</td>
										<td><?= esc($purchase->status) ?></td>
										<td>
											<span class="badge badge-table fw-600 badge-light-<?= ($purchase->payment_status == "debt") ? "danger" : "success" ?>">
												<?= esc($purchase->payment_status) ?>
											</span>
										</td>
										<td>
											<button class="btn btn-light btn-sm me-2" onclick="showPurchaseDetail(<?= $purchase->id ?>)">
												<i class="fas fa-search"></i>
											</button>
											<?php if ($purchase->status == "done") : ?>
												<button class="btn btn-light-danger btn-sm me-2" title="Hapus" onclick="deletePurchase(`<?= $purchase->id ?>`)">
													<i class="fas fa-trash"></i>
												</button>
											<?php endif; ?>
											<?php if ($purchase->payment_status == "debt") : ?>
												<button class="btn btn-light btn-sm" onclick="createPayment(`<?= $purchase->id ?>`)">
													<i class="fas fa-dollar"></i>
												</button>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<!-- Pagination -->
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal modal-outer right-modal fade" id="modal-detail" tabindex="-1" aria-labelledby="modal-detail-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-gray-600 py-3" id="modal-detail-label">Detail Pembelian</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body pt-0">
				<div class="mb-2">
					<label for="detail-date" class="col-form-label text-gray-600 fw-500">Tanggal</label>
					<input type="text" name="date" id="detail-date" class="form-control solid fw-500" disabled="disabled">
				</div>
				<div class="mb-2">
					<label for="detail-user" class="col-form-label text-gray-500 fw-600">User</label>
					<input type="text" name="user" id="detail-user" class="form-control solid fw-500" disabled="disabled">
				</div>
				<div class="mb-2">
					<label for="detail-status" class="col-form-label text-gray-600 fw-500">Status</label>
					<input type="text" name="status" id="detail-status" class="form-control solid fw-500" disabled="disabled">
				</div>
				<div class="mb-2">
					<label for="detail-discount" class="col-form-label text-gray-600 fw-500">Discount</label>
					<input type="text" name="discount" id="detail-discount" class="form-control solid fw-500" disabled="disabled">
				</div>
				<div class="mb-2">
					<label for="detail-grand-total" class="col-form-label text-gray-600 fw-500">Grand Total</label>
					<input type="text" name="grandTotal" id="detail-grand-total" class="form-control solid fw-500" disabled="disabled">
				</div>
				<div class="mb-2">
					<label for="detail-payment-status" class="col-form-label text-gray-600 fw-500">Status Pembayaran</label>
					<input type="text" name="paymentStatus" id="detail-payment-status" class="form-control solid fw-500" disabled="disabled">
				</div>
				<div class="py-2">
					<h5 class="modal-title text-gray-600 py-3">Produk</h5>
					<div id="details-products"></div>
				</div>
				<div class="py-2">
					<h5 class="modal-title text-gray-600 py-3">Pembayaran</h5>
					<div id="details-payments"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal modal-outer right-modal fade" id="modal-create-payment" tabindex="-1" aria-labelledby="modal-create-payment-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-gray-600 fw-500 py-3" id="modal-create-payment-label">Tambah Pembayaran</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body pt-0">
				<form action="<?= site_url("/purchase-payments") ?>" method="post">
					<input type="hidden" name="purchaseID" id="create-payment-purchase-id">
					<div class="mb-2">
						<label for="create-payment-grand-total" class="col-form-label text-gray-600 fw-500">Grand Total</label>
						<input type="text" name="grandTotal" id="create-payment-grand-total" class="form-control fw-500 solid" readonly>
					</div>
					<div class="mb-4">
						<label for="create-payment-nominal" class="col-form-label text-gray-600 fw-500">Nominal</label>
						<input type="text" name="nominal" required value="<?= old("nominal") ?>" id="create-payment-nominal" class="form-control solid fw-500 format-rupiah-input">
					</div>
					<div class="mb-4 d-flex">
						<div class="ms-auto">
							<button class="btn btn-primary fw-500">
								<?= lang("General.save") ?>
							</button>
						</div>
					</div>
				</form>

				<div id="payment-history-wrapper">
					<div id="payments-history-title"></div>
					<div id="payments-history"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<form action="<?= site_url("purchases") ?>" method="post" id="form-create"></form>

<form action="" method="post" id="form-delete">
	<input type="hidden" name="_method" value="DELETE">
</form>

<?= $this->endSection() ?>

<?= $this->section("script") ?>

<!-- Ajax -->
<script src="<?= base_url("/assets/plugins/jquery/jquery.min.js") ?>"></script>
<!-- Sweetalert 2 -->
<script src="<?= base_url("/assets/plugins/sweetalert2/js/sweetalert2.all.min.js") ?>"></script>
<!-- Alert -->
<script src="<?= base_url("/assets/js/alert.js") ?>"></script>
<!-- Currency -->
<script src="<?= base_url("/assets/js/currency.js") ?>"></script>
<!-- Purchase -->
<script src="<?= base_url("/assets/js/purchases.js") ?>"></script>

<script>
	// Create purchase
	function createPurchase() {
		document.forms["form-create"].submit();
	}
</script>

<script>
	const baseURL = `<?= site_url() ?>`

	function showPurchaseDetail(id) {
		$.ajax({
			"method": "GET",
			"url": `${baseURL}purchases/${id}`,
			"dataType": "JSON",
			"headers": {
				"X-Requested-With": "XMLHttpRequest",
				"Content-Type": "application/json"
			},
			"success": fillPurchase,
			"error": function(error) {
				console.log(error);
			}
		});

		const modalDetail = new bootstrap.Modal(document.querySelector("#modal-detail"));
		modalDetail.show();
	}

	function createPayment(id) {
		$.ajax({
			"method": "GET",
			"url": `${baseURL}purchases/${id}/payments`,
			"dataType": "JSON",
			"headers": {
				"X-Requested-With": "XMLHttpRequest",
				"Content-Type": "application/json"
			},
			"success": fillCreatePayment,
			"error": function(error) {
				errorAlert(`${error.responseJSON.message}`);
			}
		});
	}
</script>

<?php if (session("successMessage")) : ?>
	<script>
		successAlert(`<?= session("successMessage") ?>`);
	</script>
<?php endif ?>

<script>
	function deletePurchase(id) {
		Swal.fire({
			title: `Hapus Data Pembelian?`,
			showDenyButton: true,
			showCancelButton: false,
			confirmButtonText: 'Hapus',
			denyButtonText: `Batal`,
		}).then((result) => {
			if (result.isConfirmed) {
				const formDelete = document.forms["form-delete"];
				formDelete.action = `${baseURL}purchases/${id}/destroy`;
				formDelete.submit();
			}
		})
	}
</script>

<?= $this->endSection() ?>