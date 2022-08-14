<?= $this->extend("layouts/main") ?>

<?= $this->section("style") ?>

<style>
    .icon-wrapper {
        width: 3.5em;
        height: 4em;
    }

    .card-wrapper h3 {
        font-size: 1rem;
    }

    .card-wrapper span {
        font-size: 1.2rem;
    }
</style>

<?= $this->endSection() ?>


<?= $this->section("content") ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body d-flex">
                    <div class="icon-wrapper bg-light-success rounded-4 d-flex me-2">
                        <i class="fas fa-dollar-sign fa-lg text-success" style="margin: auto;"></i>
                    </div>
                    <div class="card-wrapper d-flex flex-column justify-content-center">
                        <h3 class="text-gray-500 fw-500">Pendapatan Hari Ini</h3>
                        <span class="text-gray-600 fw-500 format-rupiah" data-format="<?= $purchaseNominal ?>">
                            <?= $purchaseNominal ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body d-flex">
                    <div class="icon-wrapper bg-light-danger rounded-4 d-flex me-2">
                        <i class="fas fa-dollar-sign fa-lg text-danger" style="margin: auto;"></i>
                    </div>
                    <div class="card-wrapper d-flex flex-column justify-content-center">
                        <h3 class="text-gray-500 fw-500">Pengeluaran Hari Ini</h3>
                        <span class="text-gray-600 fw-500 format-rupiah" data-format="<?= $transactionNominal ?>">
                            <?= $transactionNominal ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("script") ?>

<script src="<?= base_url("/assets/js/currency.js") ?>"></script>

<?= $this->endSection() ?>