<?= $this->extend("layouts/main") ?>

<?= $this->section("style") ?>

<!-- Selectize -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.6/css/selectize.bootstrap5.min.css">

<style>
	.selectize-input.full {
		font-weight: 500;
		background-color: var(--input-solid-bg);
		border-color: var(--input-solid-bg);
		color: var(--input-solid-color);
	}
	.selectize-control.single .selectize-input.input-active, .selectize-input {
		background-color: var(--input-solid-bg);
		box-shadow: none;
	}

	.selectize-dropdown-content {
		padding: .5em 0px;
	}

	.selectize-dropdown, .selectize-input, .selectize-input input {
		background-color: var(--input-solid-bg);
		font-weight: 500;
		color: var(--input-solid-color);
		border: none;
	}

    .transaction-title {
        font-size: 1.5rem;
    }

    .product-title {
        font-size: 1.1rem;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card border-0 shadow rounded-3">
				<div class="card-header border-0 d-flex py-3 bg-white d-flex">
                    <h2 class="transaction-title text-gray-700 fw-500 mt-2">Data Penjualan</h2>
					<div class="ms-auto">
						<button class="btn btn-primary" id="create-button" onclick="createTransaction()">
							<div class="spinner-border text-white spinner-border-sm" hidden id="spinner" role="status">
								<span class="visually-hidden">Loading...</span>
							</div>
							<i class="fas fa-plus"></i>
						</button>
					</div>
				</div>
				<div class="card-body pt-0">
					<div class="table-responsive">
						<table class="table table-borderless table-dashed text-nowrap align-middle">
							<thead class="text-gray-500 fw-500 text-uppercase">
								<tr>
									<th>Tanggal</th>
									<th>User</th>
									<th>Customer</th>
									<th>Total Belanja</th>
									<th>Status</th>
									<th>Status Pembayaran</th>
									<th></th>
								</tr>
							</thead>
							<tbody class="text-gray-700 fw-500">
								<?php foreach($transactions as $transaction): ?>
									<tr>
										<td>
											<?= esc($transaction->date->toLocalizedString("dd MMM yyyy")) ?>
										</td>
										<td><?= esc($transaction->user) ?></td>
										<td><?= esc($transaction->customer) ?></td>
										<td class="format-rupiah" data-format="<?= esc($transaction->grand_total) ?>">
											<?= esc($transaction->grand_total) ?>
										</td>
										<td><?= esc($transaction->status) ?></td>
										<td>
											<span class="badge badge-table fw-500 badge-light-<?= ($transaction->payment_status == "cash") ? "success" : "danger" ?>">
												<?= esc($transaction->payment_status) ?>
											</span>
										</td>
										<td>
											<button class="btn btn-light btn-sm me-2" onclick="showTransactionDetail(`<?= esc($transaction->id) ?>`)">
												<i class="fas fa-search"></i>
											</button>
											<button class="btn btn-light btn-sm me-2">
												<i class="fas fa-print"></i>
											</button>
											<?php if($transaction->payment_status == "debt"): ?>
												<button class="btn btn-light btn-sm" onclick="createPayment(`<?= $transaction->id ?>`)">
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

<!-- Modal Create -->

<div class="modal modal-outer right-modal fade" id="modal-create" tabindex="-1" aria-labelledby="modal-create-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-create-label">Pilih Customer</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="" method="post" id="form-create">
					<div class="mb-2">
						<label class="col-form-label" for="customer"><?= lang("Transaction.customer") ?></label>
						<select id="customer" class="" name="customer" required>
							<?php foreach($customers as $customer): ?>
							<option value="<?= $customer->id ?>" <?= (old("customer") == $customer->id) ? "selected" : "" ?>>
								<?= esc($customer->role) ?>
								-
								<?= esc($customer->name) ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="mb-3">
						<button class="btn btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Detail Modal -->
<div class="modal modal-outer right-modal fade" id="modal-detail" tabindex="-1" aria-labelledby="modal-detail-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-gray-600 py-3" id="modal-detail-label">Detail Transaksi</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body pt-0">
				<div class="mb-2">
					<label for="detail-date" class="col-form-label text-gray-600 fw-500">Tanggal</label>
					<input type="text" name="date" id="detail-date" class="form-control solid fw-500" disabled="disabled">
				</div>
				<div class="mb-2">
					<label for="detail-customer" class="col-form-label text-gray-600 fw-500">Customer</label>
					<input type="text" name="customer" id="detail-customer" class="form-control solid fw-500" disabled="disabled">
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

<!-- Modal Create Payment -->
<div class="modal modal-outer right-modal fade" id="modal-create-payment" tabindex="-1" aria-labelledby="modal-create-payment-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-gray-600 fw-500 py-3" id="modal-create-payment-label">Tambah Pembayaran</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body pt-0">
				
				
				<form action="<?= site_url("transaction-payments") ?>" method="post">
					<input type="hidden" name="transactionID" id="create-payment-transaction-id">
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

<?= $this->endSection() ?>

<?= $this->section("script") ?>

<!-- Jquery -->
<script src="<?= base_url("/assets/plugins/jquery/jquery.min.js") ?>"></script>
<!-- Selectize -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.6/js/standalone/selectize.min.js"></script>
<!-- Sweetalert -->
<script src="<?= base_url("/assets/plugins/sweetalert2/js/sweetalert2.all.min.js") ?>"></script>
<!-- Alert -->
<script src="<?= base_url("/assets/js/alert.js") ?>"></script>
<!-- Format Rupiah -->
<script src="<?= base_url("/assets/js/currency.js") ?>"></script>
<!-- Transactions -->
<script src="<?= base_url("/assets/js/transactions.js") ?>"></script>

<script>
	$("#customer").selectize({
		"allowemptyoption": false,
	});
</script>

<script>
	const baseURL = `<?= site_url() ?>`;
	const spinner = document.querySelector("#spinner");
	const createButtonIcon = document.querySelector("#create-button i");

	function showSpinner() {
		createButtonIcon.setAttribute("hidden", true);
		spinner.removeAttribute("hidden");
	}

	function hideSpinner() {
		spinner.setAttribute("hidden", true);
		createButtonIcon.removeAttribute("hidden");
	}

	function createTransaction() {
		$.ajax({
			"url": `${baseURL}/transactions/check-current-transaction`,
			"method": "GET",
			"dataType": "JSON",
			"headers": {
				"X-Requested-With": "XMLHttpRequest",
				"Content-type": "application/json",
			},
			"success": function(res) {
				if (res) {
					window.location = `${baseURL}transactions/create`;
				} else {
					const modalCreate = new bootstrap.Modal(document.querySelector("#modal-create"));
					modalCreate.show();
				}
			},
			"error": function(error) {
				console.log(error);
			}, 
			"beforeSend": showSpinner,
			"complete": hideSpinner,
			});

	}
</script>

<?php if(session("validationErrorCreate")): ?>
	<script>
		const modalCreate = bootstrap.Modal(document.querySelector("#modal-create"));
		modalCreate.show();
	</script>
<?php endif; ?>


<!-- Details -->
<script>
	function showTransactionDetail(id) {
		$.ajax({
			"method": "GET",
			"url": `${baseURL}transactions/${id}`,
			"dataType": "JSON",
			"headers": {
				"X-Requested-With": "XMLHttpRequest",
				"Content-Type": "application/json"
			},
			"success": fillDetails,
			"error": function(error) {
				console.log(error);
			}
		});

		const modalDetail = new bootstrap.Modal(document.querySelector("#modal-detail"));
		modalDetail.show();
	}
</script>

<script>
	// Create payment
	function createPayment(id) {
		$.ajax({
			"method": "GET",
			"url": `${baseURL}transactions/${id}/payments`,
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

<?php if(session("successMessage")): ?>
	<script>
		successAlert(`<?= session("successMessage") ?>`);
	</script>
<?php endif; ?>

<?= $this->endSection() ?>

