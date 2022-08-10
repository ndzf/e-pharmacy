<?= $this->extend("layouts/main") ?>

<?= $this->section("style") ?>

<style>
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
        <div class="col-lg-8 col-12 mb-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 rounded-4 py-3 d-flex">
                    <h2 class="transaction-title text-gray-700 fw-500 mt-2">Pembelian</h2>
                    <div class="ms-auto">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-search">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-borderless table-dashed text-nowrap">
                            <thead class="text-gray-500 fw-500 text-uppercase">
                                <tr>
                                    <th>Produk</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 fw-500">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 rounded-4 py-3 d-flex">
                    <h2 class="transaction-title text-gray-700 fw-500 mt-2">Checkout</h2>
                </div>
                <div class="card-body pt-0">
                    <form action="" method="post" id="form-checkout">
                        <div class="mb-4">
                            <label for="checkout-grand-total" class="col-form-label text-gray-600 fw-500">Grand Total</label>
                            <input type="text" name="grandTotal" id="checkout-grand-total" class="form-control format-rupiah-input solid fw-500" readonly>
                        </div>
                        <div class="mb-2 d-flex">
                            <button class="btn btn-light-danger fw-500">
                                <i class="fas fa-trash me-1"></i>
                                <span>Batal</span>
                            </button>
                            <div class="ms-auto">
                                <button class="btn btn-primary fw-500">Checkout</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Search -->
<div class="modal modal-outer right-modal fade" id="modal-search" tabindex="-1" aria-labelledby="modal-search-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title text-gray-600 fw-500" id="modal-search-label">Cari Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="search" autocomplete="off" onkeyup="searchProducts(this.value)" id="search-bar" class="form-control solid fw-500">
                <div class="d-flex justify-content-center my-2">
                    <div class="spinner-border text-primary" id="search-spinner" hidden role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                
                <div id="search-result"></div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("script") ?>

<!-- Ajax -->
<script src="<?= base_url("/assets/plugins/jquery/jquery.min.js") ?>"></script>
<!-- Sweetalert2 -->
<script src="<?= base_url("/assets/plugins/sweetalert2/js/sweetalert2.all.min.js") ?>"></script>
<!-- Alert -->
<script src="<?= base_url("/assets/js/alert.js") ?>"></script>
<!-- Currency -->
<script src="<?= base_url("/assets/js/currency.js") ?>"></script>
<!-- Purchase -->
<script src="<?= base_url("/assets/js/purchases.js") ?>"></script>

<script>
    const baseURL = `<?= site_url() ?>`;

    function searchProducts(keyword) {
        $.ajax({
            "method": "GET",
            "url": `${baseURL}products/search?keyword=${keyword}`,
            "dataType": "JSON",
            "headers": {
                "X-Requested-With": "XMLHttpRequest",
                "Content-Type": "application/json",
            },
            "success": fillSearchModal,
            "beforeSend": showSearchSpinner,
            "complete": hideSearchSpinner,
            "error": function(error) {
                errorAlert(error.responseJSON.message);
            }
        });
    }

</script>

<?= $this->endSection() ?>