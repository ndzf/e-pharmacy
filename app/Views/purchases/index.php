<?= $this->extend("layouts/main") ?>

<?= $this->section("content") ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header py-3 bg-white border-0 d-flex align-middle">
                    <h2 class="text-gray-700 fw-500 mt-2" style="font-size: 1.5rem;">Data Penjualan</h2>
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
                                <?php foreach($purchases as $purchase): ?>
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
                                            <button class="btn btn-light btn-sm me-2">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <button class="btn btn-light btn-sm">
                                                <i class="fas fa-print"></i>
                                            </button>
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

<form action="<?= site_url("purchases") ?>" method="post" id="form-create"></form>

<?= $this->endSection() ?>

<?= $this->section("script") ?>

<!-- Currency -->
<script src="<?= base_url("/assets/js/currency.js") ?>"></script>

<script>
    // Create purchase
    function createPurchase() {
        document.forms["form-create"].submit();
    }
</script>

<?= $this->endSection() ?>