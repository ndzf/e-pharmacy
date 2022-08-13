<?= $this->extend("layouts/main") ?>

<?= $this->section("style") ?>

<!-- Selectize -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.6/css/selectize.bootstrap5.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<style>
    .transaction-title {
        font-size: 1.5rem;
    }

    .product-title {
        font-size: 1.1rem;
    }

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
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 fw-500">
                                <?php $grandTotal = 0; ?>
                                <?php foreach($purchaseDetails as $purchaseDetail): ?>
                                    <?php $grandTotal += $purchaseDetail->price * $purchaseDetail->qty ?>
                                    <?php $total = $purchaseDetail->qty * $purchaseDetail->price ?>
                                    <tr>
                                        <td><?= esc($purchaseDetail->product_name) ?></td>
                                        <td><?= esc($purchaseDetail->qty) ?></td>
                                        <td class="format-rupiah" data-format="<?= $purchaseDetail->price ?>"><?= esc($purchaseDetail->price) ?></td>
                                        <td class="format-rupiah" data-format="<?= esc($total) ?>">
                                            <?= esc($total) ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
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
                    <form action="<?= site_url("/purchases/$purchase->id/checkout") ?>" method="post" id="form-checkout">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="mb-2">
                            <label for="checkout-grand-total" class="col-form-label text-gray-600 fw-500">Grand Total</label>
                            <input type="text" name="grandTotal" id="checkout-grand-total" class="form-control format-rupiah-input solid fw-500" readonly>
                        </div>
                        <div class="mb-2">
                            <label for="discount" class="col-form-label text-gray-600 fw-500">Discount</label>
                            <input type="number" name="discount" id="discount" class="form-control solid fw-500">
                        </div>
                        <div class="mb-2">
                            <label for="checkout-nominal" class="col-form-label text-gray-600 fw-500">Uang yang dibayar</label>
                            <input type="text" name="nominal" id="checkout-nominal" class="form-control solid fw-500 format-rupiah-input">
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

<!-- Modal Create -->
<div class="modal modal-outer right-modal fade" id="modal-create" tabindex="-1" aria-labelledby="modal-create-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title text-gray-600 fw-500" id="modal-create-label">Tambahkan Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="<?= site_url("/purchase-details") ?>" id="form-create" method="post">
                    <input type="hidden" name="productID" id="create-product-id">
                    <div class="mb-2">
                        <label for="create-product-name" class="col-form-label text-gray-600 fw-500">Nama Produk</label>
                        <input type="text" name="productName" id="create-product-name" class="form-control solid fw-500" readonly="readonly">
                    </div>
                    <div class="mb-2">
                        <label for="create-price" class="col-form-label text-gray-600 fw-500">Harga</label>
                        <select name="price" class="form-select solid fw-500" required id="create-price"></select>
                    </div>
                    <div class="mb-4">
                        <label for="create-qty" class="col-form-label text-gray-600 fw-500">Qty</label>
                        <input type="number" min="1" name="qty" id="create-qty" class="form-control solid fw-500" required>
                    </div>
                    <div class="mb-2 d-flex justify-content-end">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
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
<!-- Selectize -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.6/js/standalone/selectize.min.js"></script>
<!-- Alert -->
<script src="<?= base_url("/assets/js/alert.js") ?>"></script>
<!-- Currency -->
<script src="<?= base_url("/assets/js/currency.js") ?>"></script>
<!-- Purchase -->
<script src="<?= base_url("/assets/js/purchases.js") ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

    function getProducts(id) {
        $.ajax({
            "url": `${baseURL}products/${id}/details`,
            "method": "GET",
            "dataType": "JSON",
            "headers": {
                "X-Requested-With": "XMLHttpRequest",
                "Content-Type": "application/json",
            },
            "success": fillAddProduct,
            "error": function(error) {
                errorAlert(error.responseJSON.message);
            }
        })
    }

</script>

<script>
    function addProduct(id) {
        // Hide search modal
        const modalSearchEl = document.querySelector("#modal-search");
        const modalSearch = bootstrap.Modal.getOrCreateInstance(modalSearchEl);
        modalSearch.hide();

        getProducts(id);

        const modalCreate = new bootstrap.Modal(document.querySelector("#modal-create"));
        modalCreate.show();
    }
</script>

<!-- Discount -->
<script>
    const grandTotal = parseInt(`<?= $grandTotal ?>`);
    const discountInputEl = document.querySelector("#discount");

    function countDiscount(discount, initialPrice) {
        if (discount == false || isNaN(discount)) {
            return initialPrice;
        }

        if (discount > 100) {
            document.querySelector("#checkout-grand-total").value = 0;
            return false;
        }

        percent = parseInt(discount);
        const discountTotal = (percent / 100) * initialPrice;
        return initialPrice - discountTotal;
    }

    discountInputEl.addEventListener("keyup", e => {
        const total = countDiscount(parseInt(e.target.value), grandTotal)
        document.querySelector("#checkout-grand-total").value = formatRupiah(total.toString());
    });

    document.addEventListener("DOMContentLoaded", () => {
        total = countDiscount(parseInt(discountInputEl.value), grandTotal);
        document.querySelector("#checkout-grand-total").value = formatRupiah(total.toString());
    });
</script>

<?= $this->endSection() ?>