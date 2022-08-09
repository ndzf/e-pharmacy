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
        <div class="col-12 col-lg-8 col-md-8 mb-3">
            <div class="card border-0 shadow rounded-4">
                <div class="card-header border-0 py-3 bg-white rounded-4 d-flex align-items-center">
                    <h2 class="transaction-title text-gray-700 fw-500 mt-2">Penjualan</h2>
                    <div class="ms-auto">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-search">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-dashed align-middle text-nowrap">
                            <thead class="text-gray-500 text-uppercase fw-500">
                                <tr>
                                    <th>Produk</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 fw-500">
                                <?php $grandTotal = 0; ?>
                                <?php foreach($transactionDetails as $transactionDetail): ?>
                                    <?php $grandTotal += $transactionDetail->qty * $transactionDetail->product_price ?>
                                    <tr>
                                        <td><?= $transactionDetail->product_name ?></td>
                                        <td><?= $transactionDetail->qty ?></td>
                                        <td class="format-rupiah" data-format="<?= esc($transactionDetail->product_price)  ?>">
                                            <?= $transactionDetail->product_price ?> 
                                        </td>
                                        <td>
                                            <button class="btn btn btn-light-light fw-500 me-2 btn-sm" onclick="detail(`<?= $transactionDetail->id ?>`)">
                                                Detail
                                            </button>
                                            <button class="btn btn-light-danger btn-sm" onclick="deleteTransactionDetail(`<?= $transactionDetail->id ?>`)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-md-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <form action="<?= site_url("/transactions/$transaction->id/checkout") ?>" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="mb-2">
                            <label for="customer" class="col-form-label text-gray-600 fw-500"><?= lang("Customer.name") ?></label>
                            <input type="text" name="customer" id="customer" value="<?= esc($customer->name) ?>" class="form-control solid fw-500" readonly="readonly">
                        </div>
                        <div class="mb-2">
                            <label for="customer-role" class="col-form-label text-gray-600 fw-500">Role Pelanggan</label>
                            <input type="text" name="customerRole" id="customer-role" value="<?= esc($customer->role) ?>" class="form-control solid fw-500" readonly="readonly">
                        </div>
                        <div class="mb-2">
                            <label for="discount" class="col-form-label text-gray-600 fw-500">Diskon</label>
                            <input type="number" name="discount" value="<?= old("discount") ?>" id="discount" max="100" class="form-control solid fw-500">
                        </div>
                        <div class="mb-2">
                            <label for="grand-total" class="col-form-label text-gray-600 fw-500">Grand Total</label>
                            <input type="text" name="grandTotal" id="grand-total" class="form-control solid fw-500" readonly="readonly">
                        </div>
                        <div class="mb-4">
                            <label for="nominal" class="col-form-label text-gray-600 fw-500">Uang Yang Dibayar</label>
                            <input type="text" name="nominal" id="nominal" value="<?= old("nominal") ?>" class="form-control format-rupiah-input solid text-gray-600 fw-500">
                        </div>
                        <div class="mb-3 d-flex">
                            <a href="<?= site_url("transactions/destroy") ?>" class="btn btn-danger fw-500 me-2">
                                Batal
                            </a>
                            <div class="ms-auto">
                                <button class="btn btn-primary fw-500" type="submit">
                                    Checkout
                                </button>
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
            <div class="modal-header">
                <h5 class="modal-title py-3" id="modal-search-label">Cari Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <div id="search-bar-products">
                    <input type="search" autocomplete="off" placeholder="Cari product.." name="q" onkeyup="search()" id="search-bar" class="form-control solid fw-500">
                </div>
                <div class="d-flex justify-content-center my-2">
                    <div class="spinner-border text-primary" id="search-spinner" hidden role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="search-result" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal create -->
<div class="modal modal-outer right-modal fade" id="modal-create" tabindex="-1" aria-labelledby="modal-create-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title py-3 text-gray-600" id="modal-create-label">Tambahkan produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="<?= site_url("/transaction-details") ?>" method="post">
                    <input type="hidden" name="productID" id="create-product-id">
                    <div class="mb-2">
                        <label for="create-name" class="col-form-label text-gray-700 fw-500"><?= lang("Product.name") . " Produk" ?></label>
                        <input type="text" name="productName" id="create-name" class="form-control solid fw-500" readonly>
                    </div>
                    <div class="mb-2">
                        <label for="price" class="col-form-label text-gray-700 fw-500"><?= lang("Product.price") ?></label>
                        <input type="text" name="productPrice" id="create-product-price" class="fw-500 form-control solid format-rupiah-input" readonly>
                    </div>
                    <div class="mb-2">
                        <label for="create-qty" class="col-form-label text-gray-700 fw-500"><?= lang("Product.qty") ?></label>
                        <input type="number" name="qty" value="<?= old("qty") ?>" required id="create-qty" class="form-control solid fw-500" >
                    </div>
                    <div id="create-lens-details">
                        <table class="table table-borderless table-dashed align-middle">
                            <thead class="text-gray-500 fw-500 text-uppercase">
                                <tr>
                                    <th></th>
                                    <th>SPH</th>
                                    <th>CYL</th>
                                    <th>ADD</th>
                                    <th>AXIS</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 fw-500">
                                <tr>
                                    <td class="text-primary">R</td>
                                    <td>
                                        <input type="text" name="rSph" id="create-r-sph" placeholder="SPH" class="form-control solid rounded-2 me-2 fw-500" disabled>
                                    </td>
                                    <td>
                                        <input type="text" name="rCyl" id="create-r-cyl" placeholder="CYL" class="form-control solid rounded-2 me-2 fw-500" disabled>
                                    </td>
                                    <td>
                                        <input type="text" name="rAdd" id="create-r-add" placeholder="ADD" class="form-control solid rounded-2 fw-500" disabled>
                                    </td>
                                    <td>
                                        <input type="text" name="rAxis" id="create-r-axis" value="<?= old("rAxis") ?>" class="form-control solid rounded-2 fw-500">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-primary">L</td>
                                    <td>
                                        <input type="text" name="lSph" id="create-l-sph" disabled class="form-control solid rounded-2 me-2 fw-500">
                                    </td>
                                    <td>
                                        <input type="text" name="lCyl" id="create-l-cyl" disabled class="form-control solid rounded-2 me-2 fw-500">
                                    </td>
                                    <td>
                                        <input type="text" name="lAdd" id="create-l-add" disabled class="form-control solid rounded-2 fw-500">
                                    </td>
                                    <td>
                                        <input type="text" name="lAxis" id="create-l-axis" value="<?= old("lAxis") ?>" class="form-control solid rounded-2 fw-500">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal modal-outer right-modal fade" id="modal-detail" tabindex="-1" aria-labelledby="modal-detail-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title text-gray-600" id="modal-detail-label">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="mb-2">
                    <label for="detail-name" class="col-form-label text-gray-600 fw-500">Produk</label>
                    <input type="text" name="name" id="detail-name" class="form-control solid fw-500" disabled="disabled">
                </div>
                <div class="mb-2">
                    <label for="detail-type" class="col-form-label text-gray-600 fw-500">Tipe Produk</label>
                    <input type="text" name="type" id="detail-type" class="form-control solid fw-500" disabled="disabled">
                </div>
                <div class="mb-2">
                    <label for="detail-price" class="col-form-label text-gray-600 fw-500">Harga</label>
                    <input type="text" name="price" id="detail-price" class="form-control solid fw-500" disabled="disabled">
                </div>
                <div class="mb-4">
                    <label for="detail-qty" class="col-form-label text-gray-600 fw-500">Qty</label>
                    <input type="text" name="qty" id="detail-qty" class="form-control solid fw-500" disabled="disabled">
                </div>
                <div id="lens-type-details">
                    <div class="table-responsive">
                        <table class="table table-borderless table-dashed text-nowrap">
                            <thead class="text-gray-400 fw-500 text-uppercase">
                                <tr>
                                    <th></th>
                                    <th>SPH</th>
                                    <th>CYL</th>
                                    <th>ADD</th>
                                    <th>Axis</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 fw-500">
                                <tr>
                                    <td class="text-primary">R</td>
                                    <td id="detail-r-sph"></td>
                                    <td id="detail-r-cyl"></td>
                                    <td id="detail-r-add"></td>
                                    <td id="detail-r-axis"></td>
                                </tr>
                                <tr>
                                    <td class="text-primary">L</td>
                                    <td id="detail-l-sph"></td>
                                    <td id="detail-l-cyl"></td>
                                    <td id="detail-l-add"></td>
                                    <td id="detail-l-axis"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<form action="" method="post" id="form-delete-transaction-detail">
    <input type="hidden" name="_method" value="DELETE">
</form>

<?= $this->endSection() ?>

<?= $this->section("script") ?>

<!-- Sweetalert2 -->
<script src="<?= base_url("/assets/plugins/sweetalert2/js/sweetalert2.all.min.js") ?>"></script>
<!-- Alert -->
<script src="<?= base_url("/assets/js/alert.js") ?>"></script>
<!-- Jquery -->
<script src="<?= base_url("/assets/plugins/jquery/jquery.min.js") ?>"></script>
<!-- Currency -->
<script src="<?= base_url("/assets/js/currency.js") ?>"></script>
<!-- Search Products -->
<script src="<?= base_url("/assets/js/search-products.js") ?>"></script>
<!-- Transaction -->
<script src="<?= base_url("/assets/js/transactions.js") ?>"></script>
<!-- Transaction Detail -->
<script src="<?= base_url("/assets/js/transaction-details.js") ?>"></script>


<!-- Delete this  -->
<script>
    const searchSpinner = document.querySelector("#search-spinner");

    function showSearchSpinner() {
        searchSpinner.removeAttribute("hidden");
    }

    function hideSearchSpinner() {
        searchSpinner.setAttribute("hidden", true);
    }
</script>

<script>
    const baseURL = `<?= site_url() ?>`;

    function searchProducts(keyword = "", category = "", type = "") {
        $.ajax({
            "url": `${baseURL}products/search?keyword=${keyword}`,
            "method": "GET",
            "dataType": "JSON",
            "headers": {
                "X-Requested-With": "XMLHttpRequest",
                "Content-Type": "application/json"
            },
            "success": printResult,
            "beforeSend": showSearchSpinner,
            "complete": hideSearchSpinner,
        })
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
            "success": function(res) {
                const customerRole = `<?= $customer->role ?>`
                fillCreateTransactionForm(res, customerRole);
            },
            "error": function(error) {
                errorAlert(error.responseJSON.message);
            }
        })
    }

</script>

<script>
    const searchBar = document.querySelector("#search-bar");

    function search() {
        searchProducts(searchBar.value);
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

<?php if(session("errorMessage")): ?>

    <script>
        errorAlert(`<?= session("errorMessage") ?>`);
    </script>

<?php endif ?>

<?php if(session("successMessage")): ?>
    <script>
        successAlert(`<?= session("successMessage") ?>`);
    </script>
<?php endif; ?>

<!-- Grand Total Format Rupiah -->

<script>
</script>

<script>
    const grandTotal = parseInt(`<?= $grandTotal ?>`);
    const discountInputEl = document.querySelector("#discount");
    const nominalInputEl = document.querySelector("#nominal");

    function countDiscount(discount, initialPrice) {
        if (discount == false || isNaN(discount)) {
            return initialPrice;
        }

        if (discount > 100) {
            document.querySelector("#grand-total").value = 0;
            return false;
        }

        percent = parseInt(discount);
        const discountTotal = (percent / 100) * initialPrice;
        return initialPrice - discountTotal;
    }

    // discountInputEl.addEventListener("keyup", countDiscount);
    document.querySelector("#discount").addEventListener("keyup", function(e) {
        const total = countDiscount(parseInt(e.target.value), grandTotal);
        document.querySelector("#grand-total").value = formatRupiah(total.toString());
    });

    document.addEventListener("DOMContentLoaded", function() {
        const discount = document.querySelector("#discount");
        const total = countDiscount(parseInt(discount.value), grandTotal);
        document.querySelector("#grand-total").value = formatRupiah(total.toString());
    });
    
</script>

<script>
    function deleteTransactionDetail(id) {
        const deleteTransactionDetailEl = document.forms["form-delete-transaction-detail"];
        deleteTransactionDetailEl.setAttribute("action", `<?= site_url() ?>transaction-details/${id}`);
        deleteTransactionDetailEl.submit();
    }
</script>

<script>
    function detail(id) {
        $.ajax({
            "url": `${baseURL}transaction-details/${id}`,
            "method": "GET",
            "dataType": "JSON",
            "headers": {
                "X-Requested-With": "XMLHttpRequest",
                "Content-Type": "application/json",
            },
            "success": fillDetailModal,
            "error": function(error) {
                errorAlert(error.responseJSON.message);
            }
        })
        const modalDetail = new bootstrap.Modal(document.querySelector("#modal-detail"));
        modalDetail.show();
    }

</script>

<?= $this->endSection() ?>