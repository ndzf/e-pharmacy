<?= $this->extend("layouts/main") ?>

<?= $this->section("style")  ?>

<style>
    .form-lens-type {
        opacity: 0;
        height: 0;
        transition: .3s ease-in;
    }

    .form-lens-type.active {
        opacity: 1;
        height: auto;
    }
</style>


<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow rounded-6">
                <div class="card-header border-0 bg-white rounded-6 py-3 d-flex">
                    <form action="" method="get">
                        <input type="hidden" name="type" value="<?= esc($inputs["type"]) ?>">
                        <input type="hidden" name="category" value="<?= esc($inputs["category"]) ?>">
                        <input type="search" name="q" id="search-bar" placeholder="<?= lang("General.search") ?>" class="form-control fw-500 solid" value="<?= esc($inputs["keyword"]) ?>">
                    </form>
                    <div class="ms-auto d-flex">
                        <div class="dropdown">
                            <!-- Dropdown Filter toggle -->
                            <button class="btn btn-light-light fw-500 me-2" id="dropdown-filter" data-bs-toggle="dropdown" aria-expanded="false" title="Filter data">
                                Filter
                            </button>
                            <div class="dropdown-menu pt-2 px-3 mt-2" aria-labelledby="dropdown-filter">
                                <form action="" method="get" id="form-filter">
                                    <input type="hidden" name="q" value="<?= esc($inputs["keyword"]) ?>">
                                    <div class="mb-2">
                                        <label for="filter-type" class="col-form-label text-gray-500 fw-500">
                                            <?= lang("Product.type") ?>
                                        </label>
                                        <select name="type" id="filter-type" class="form-control solid fw-500">
                                            <option value="">-</option>
                                            <option value="general" <?= ($inputs["type"] == "general") ? "selected" : "" ?>>
                                                <?= lang("Product.types.general") ?>
                                            </option>
                                            <option value="lens" <?= ($inputs["type"] == "lens") ? "selected" : "" ?>>
                                                <?= lang("Product.types.lens") ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="filter-category" class="col-form-label text-gray-500 fw-500">
                                            <?= lang("Product.category") ?>
                                        </label>
                                        <select name="category" id="filter-category" class="form-control solid fw-500">
                                            <option value="">-</option>
                                            <?= view_cell("App\Libraries\Category::getNames", "active={$inputs["category"]}") ?>
                                        </select>
                                    </div>
                                    <div class="mb-2 d-flex">
                                        <button type="reset" onclick="resetFormFilter()" class="btn btn-light-light text-primary btn-sm fw-500">
                                            <?= lang("General.reset") ?>
                                        </button>
                                        <div class="ms-auto">
                                            <button class="btn btn-primary btn-sm fw-500">
                                                <?= lang("General.apply") ?>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <button class="btn btn-light-primary fw-500 me-2" id="print-barcode">Barcode</button>

                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create" title="<?= lang("Product.title.create") ?>">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-borderless table-dashed text-nowrap align-middle">
                            <thead class="text-gray-400 fw-500 text-uppercase">
                                <tr>
                                    <th></th>
                                    <th><?= lang("Product.name") ?></th>
                                    <th><?= lang("Product.category") ?></th>
                                    <th><?= lang("Product.type") ?></th>
                                    <th><?= lang("Product.originalPrice") ?></th>
                                    <th><?= lang("Product.qty") ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 fw-500">
                                <?php foreach ($products as $product) : ?>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" name="products[]" value="<?= $product->id ?>" class="form-check-input">
                                            </div>
                                        </td>
                                        <td><?= esc($product->name) ?></td>
                                        <td>
                                            <?= isset($product->category) ? esc($product->category) : "-" ?>
                                        </td>
                                        <td><?= esc($product->type) ?></td>
                                        <td class="format-rupiah" data-format="<?= esc($product->original_price) ?>"><?= esc($product->original_price) ?></td>
                                        <td>
                                            <div class="badge fw-600 badge-table <?= ($product->qty <= $product->minimum_qty) ? "badge-light-danger" : "badge-light-primary" ?>">
                                                <?= esc($product->qty) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-light-light fw-500 btn-sm me-2" onclick="editProduct(`<?= $product->id ?>`)" title="<?= lang("Product.title.edit") ?>">
                                                Edit
                                            </button>
                                            <button class="btn btn-sm btn-light-danger" onclick="deleteProduct(`<?= $product->id ?>`)" title="<?= lang("Product.title.delete") ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?= $pager ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade modal-outer right-modal" id="modal-create" tabindex="-1" aria-labelledby="modal-create-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title text-gray-700" id="modal-create-label"><?= lang("Product.title.create") ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url("/products") ?>" id="form-create" method="post">
                    <div class="mb-2">
                        <label for="create-name" class="col-form-label text-gray-700 fw-500"><?= lang("Product.name") ?> <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="create-name" class="form-control fw-500 solid <?= (isset($validation["name"]) ? "is-invalid" : "") ?>" value="<?= old("name") ?>">
                        <div class="invalid-feedback fw-500"><?= $validation["name"] ?? "" ?></div>
                    </div>
                    <div class="mb-2">
                        <label for="create-supplier" class="col-form-label text-gray-700 fw-500"><?= lang("Product.supplier") ?></label>
                        <select name="supplier" id="create-supplier" class="form-select solid fw-500">
                            <?php $oldSupplier = old("supplier") ?>
                            <option value="">-</option>
                            <?= view_cell("App\Libraries\Supplier::getNames", "active=$oldSupplier") ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="create-category" class="col-form-label text-gray-700 fw-500"><?= lang("Product.category") ?></label>
                        <select name="category" id="create-category" class="form-select solid fw-500">
                            <?php $oldCategory = old("category") ?>
                            <option value="">-</option>
                            <?= view_cell("App\Libraries\Category::getNames", "active=$oldCategory") ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="create-code" class="col-form-label text-gray-700 fw-500"><?= lang("Product.code") ?></label>
                        <input type="text" name="code" id="create-code" class="form-control solid fw-500" value="<?= old("code") ?>">
                    </div>
                    <div class="mb-2">
                        <label for="create-type" class="col-form-label text-gray-700 fw-500"><?= lang("Product.type") ?> <span class="text-danger">*</span></label>
                        <select name="type" id="create-type" class="form-select solid fw-500" onchange="setLensDetail(this.value)">
                            <option value="general" <?= (old("type") == "general") ? "selected" : "" ?>>
                                <?= lang("Product.types.general") ?>
                            </option>
                            <option value="lens" <?= (old("type") == "lens") ? "selected" : "" ?>>
                                <?= lang("Product.types.lens") ?>
                            </option>
                        </select>
                    </div>
                    <div class="lens-detail" hidden>
                        <div class="input-group mb-2">
                            <span class="input-group-text border-0 bg-primary text-white rounded-2 fw-600 me-2">R</span>
                            <input type="text" name="rSph" id="create-r-sph" placeholder="SPH" value="<?= old("rSph") ?>" class="form-control solid rounded-2 me-2 fw-500">
                            <input type="text" name="rCyl" id="create-r-cyl" placeholder="CYL" value="<?= old("rCyl") ?>" class="form-control solid rounded-2 me-2 fw-500">
                            <input type="text" name="rAdd" id="create-r-add" placeholder="ADD" value="<?= old("rAdd") ?>" class="form-control solid rounded-2 fw-500">
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text border-0 bg-primary text-white rounded-2 fw-600 me-2">L</span>
                            <input type="text" name="lSph" id="create-l-sph" placeholder="SPH" value="<?= old("lSph") ?>" class="form-control solid rounded-2 me-2 fw-500">
                            <input type="text" name="lCyl" id="create-l-cyl" placeholder="CYL" value="<?= old("lCyl") ?>" class="form-control solid rounded-2 me-2 fw-500">
                            <input type="text" name="lAdd" id="create-l-add" placeholder="ADD" value="<?= old("lAdd") ?>" class="form-control solid rounded-2 fw-500">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="create-qty" class="col-form-label text-gray-700 fw-500"><?= lang("Product.qty") ?></label>
                        <input type="number" name="qty" id="create-qty" class="form-control solid fw-500" value="<?= old("qty") ?>">
                    </div>
                    <div class="mb-2">
                        <label for="create-minimum-qty" class="col-form-label text-gray-700 fw-500"><?= lang("Product.minimumQty") ?></label>
                        <input type="number" name="minimumQty" id="create-minimum-qty" class="form-control solid fw-500" value="<?= old("minimumQty") ?>">
                    </div>
                    <div class="mb-2">
                        <label for="create-original-price" class="col-form-label text-gray-700 fw-500"><?= lang("Product.originalPrice") ?> <span class="text-danger">*</span></label>
                        <input type="text" name="originalPrice" id="create-original-price" class="form-control solid fw-500 format-rupiah-input" value="<?= old("originalPrice") ?>" autocomplete="off" required>
                    </div>
                    <div class="mb-2">
                        <label for="create-selling-price" class="col-form-label text-gray-700 fw-500"><?= lang("Product.sellingPrice") ?> <span class="text-danger">*</span></label>
                        <input type="text" name="sellingPrice" id="create-selling-price" class="form-control solid fw-500 format-rupiah-input" value="<?= old("sellingPrice") ?>" autocomplete="off" required>
                    </div>
                    <div class="mb-2">
                        <label for="create-member-price" class="col-form-label text-gray-700 fw-500"><?= lang("Product.memberPrice") ?> <span class="text-danger">*</span></label>
                        <input type="text" name="memberPrice" id="create-member-price" class="form-control solid fw-500 format-rupiah-input" value="<?= old("memberPrice") ?>" autocomplete="off" required>
                    </div>
                    <div class="mb-4">
                        <label for="create-wholesale-price" class="col-form-label text-gray-700 fw-500"><?= lang("Product.wholesalePrice") ?> <span class="text-danger">*</span></label>
                        <input type="text" name="wholesalePrice" id="create-wholesale-price" class="form-control solid fw-500 format-rupiah-input" value="<?= old("wholesalePrice") ?>" autocomplete="off" required>
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary fw-500"><?= lang("General.save") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal modal-outer right-modal fade" id="modal-edit" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modal-edit-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title" id="modal-edit-labe"><?= lang("Product.title.edit") ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="" method="post" id="form-edit">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-2">
                        <label for="edit-name" class="col-form-label text-gray-700 fw-500"><?= lang("Product.name") ?> <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit-name" class="form-control solid fw-500 <?= (isset($validation["name"]) ? "is-invalid" : "") ?>">
                        <div class="invalid-feedback fw-500"><?= $validation["name"] ?? "" ?></div>
                    </div>
                    <div class="mb-2">
                        <label for="edit-supplier" class="col-form-label text-gray-700 fw-500"><?= lang("Product.supplier") ?></label>
                        <select name="supplier" id="edit-supplier" class="form-select solid fw-500">
                            <option value="">-</option>
                            <?= view_cell("App\Libraries\Supplier::getNames", "active=") ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="edit-category" class="col-form-label text-gray-700 fw-500"><?= lang("Product.category") ?></label>
                        <select name="category" id="edit-category" class="form-select solid fw-500">
                            <option value="">-</option>
                            <?= view_cell("App\Libraries\Category::getNames", "active=") ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="edit-code" class="col-form-label text-gray-700 fw-500"><?= lang("Product.code") ?></label>
                        <input type="text" name="code" id="edit-code" class="form-control solid fw-500">
                    </div>
                    <div class="mb-2">
                        <label for="edit-type" class="col-form-label text-gray-700 fw-500"><?= lang("Product.type") ?> <span class="text-danger">*</span></label>
                        <select name="type" id="edit-type" onchange="setLensDetail(this.value)" class="form-select solid fw-500">
                            <option value="general"><?= lang("Product.types.general") ?></option>
                            <option value="lens"><?= lang("Product.types.lens") ?></option>
                        </select>
                    </div>
                    <div class="lens-detail" hidden>
                        <div class="input-group mb-2">
                            <div class="input-group-text border-0 text-white bg-primary rounded-2 me-2">R</div>
                            <input type="text" name="rSph" id="edit-r-sph" placeholder="SPH" class="form-control solid fw-500 rounded-2 me-2">
                            <input type="text" name="rCyl" id="edit-r-cyl" placeholder="CYL" class="form-control solid fw-500 rounded-2 me-2">
                            <input type="text" name="rAdd" id="edit-r-add" placeholder="ADD" class="form-control solid fw-500 rounded-2">
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-text border-0 text-white bg-primary rounded-2 me-2">L</div>
                            <input type="text" name="lSph" id="edit-l-sph" placeholder="SPH" class="form-control solid fw-500 rounded-2 me-2">
                            <input type="text" name="lCyl" id="edit-l-cyl" placeholder="CYL" class="form-control solid fw-500 rounded-2 me-2">
                            <input type="text" name="lAdd" id="edit-l-add" placeholder="ADD" class="form-control solid fw-500 rounded-2">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="edit-qty" class="col-form-label text-gray-700 fw-500"><?= lang("Product.qty") ?></label>
                        <input type="number" name="qty" id="edit-qty" class="form-control solid fw-500">
                    </div>
                    <div class="mb-2">
                        <label for="edit-minimum-qty" class="col-form-label text-gray-700 fw-500"><?= lang("Product.minimumQty") ?></label>
                        <input type="number" name="minimumQty" id="edit-minimum-qty" class="form-control solid fw-500">
                    </div>
                    <div class="mb-2">
                        <label for="edit-original-price" class="col-form-label text-gray-700 fw-500"><?= lang("Product.originalPrice") ?> <span class="text-danger">*</span></label>
                        <input type="text" name="originalPrice" id="edit-original-price" class="form-control solid fw-500 format-rupiah-input">
                    </div>
                    <div class="mb-2">
                        <label for="edit-selling-price" class="col-form-label text-gray-700 fw-500"><?= lang("Product.sellingPrice") ?> <span class="text-danger">*</span></label>
                        <input type="text" name="sellingPrice" id="edit-selling-price" class="form-control solid fw-500 format-rupiah-input">
                    </div>
                    <div class="mb-2">
                        <label for="edit-member-price" class="col-form-label text-gray-700 fw-500"><?= lang("Product.memberPrice") ?> <span class="text-danger">*</span></label>
                        <input type="text" name="memberPrice" id="edit-member-price" class="form-control solid fw-500 format-rupiah-input">
                    </div>
                    <div class="mb-4">
                        <label for="edit-wholesale-price" class="col-form-label text-gray-700 fw-500"><?= lang("Product.wholesalePrice") ?> <span class="text-danger">*</span></label>
                        <input type="text" name="wholesalePrice" id="edit-wholesale-price" class="form-control solid fw-500 format-rupiah-input">
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary fw-500"><?= lang("General.save") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="form-delete" action="" method="post">
    <input type="hidden" name="_method" value="DELETE">
</form>

<form action="<?= site_url("/products/print-barcode") ?>" method="post" id="form-print-barcode"></form>

<?= $this->endSection() ?>

<?= $this->section("script") ?>

<!-- Axios -->
<script src="<?= base_url("/assets/plugins/axios/src/axios.min.js") ?>"></script>
<!-- Sweetalert2 -->
<script src="<?= base_url("/assets/plugins/sweetalert2/js/sweetalert2.all.min.js") ?>"></script>
<!-- Alert -->
<script src="<?= base_url("/assets/js/alert.js") ?>"></script>
<!-- Forms -->
<script src="<?= base_url("/assets/js/forms.js") ?>"></script>
<!-- Currency -->
<script src="<?= base_url("/assets/js/currency.js") ?>"></script>
<!-- Product -->
<script src="<?= base_url("/assets/js/products.js") ?>"></script>

<script>
    function resetFormFilter() {
        const formFilter = document.forms["form-filter"];
        for (input of formFilter) {
            if (input.type == "select-one") {
                input.value = "";
            }
        }

        formFilter.submit();
    }
</script>

<script>
    const lensDetailElements = document.querySelectorAll(".lens-detail");

    function showLensDetail() {
        for (lensDetailElement of lensDetailElements) {
            lensDetailElement.removeAttribute("hidden");
        }
    }

    function hideLensDetail() {
        for (lensDetailElement of lensDetailElements) {
            lensDetailElement.setAttribute("hidden", true);
        }
    }

    function setLensDetail(type) {
        (type == "lens") ? showLensDetail(): hideLensDetail();
    }
</script>

<script>
    const baseURL = `<?= site_url() ?>`;

    function editProduct(id) {
        axios({
                "url": `${baseURL}products/${id}/edit`,
                "method": "GET",
                "responseType": "json",
                "headers": {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(setEditForm)
            .catch(error => {
                console.log(error);
            })
    }

    function deleteProduct(id) {
        const formDelete = document.forms["form-delete"];
        formDelete.setAttribute("action", `${baseURL}products/${id}`);
        formDelete.submit();
    }
</script>

<?php if (session("successMessage")) : ?>
    <script>
        successAlert(`<?= session("successMessage") ?>`);
    </script>
<?php endif; ?>

<?php if (session("validationErrorCreate")) : ?>

    <script>
        const modalCreate = new bootstrap.Modal(document.querySelector("#modal-create"));
        const createType = document.querySelector("#create-type");
        setLensDetail(createType.value);
        modalCreate.show();
    </script>

<?php endif; ?>

<?php if (session("validationErrorUpdate")) : ?>

    <script>
        editProduct(`<?= session("validationErrorUpdate") ?>`);
    </script>

<?php endif; ?>

<script>
    function clear() {
        // Create
        clearValidation("#form-create", "#form-edit");
        resetSelectedOptions("#create-supplier", true);
        resetSelectedOptions("#create-category", true);
        resetSelectedOptions("#create-type", true);
        setLensDetail("general");
        // Update
        resetSelectedOptions("#edit-supplier", false);
        resetSelectedOptions("#edit-category", false);
        resetSelectedOptions("#edit-type", false);
        setLensDetail("general");
    }
    const modalCreateEl = document.querySelector("#modal-create");
    modalCreateEl.addEventListener("hidden.bs.modal", clear);

    const modalEditEl = document.querySelector("#modal-edit");
    modalEditEl.addEventListener("hidden.bs.modal", clear);
</script>

<script>
    document.querySelector("#print-barcode").addEventListener("click", function() {
        const formPrintBarcode = document.querySelector("#form-print-barcode");
        formPrintBarcode.innerHTML = '';

        const [...productsInputs] = document.querySelectorAll(".form-check-input");

        const products = productsInputs.filter((product) => product.checked == true).map(product => {
            return `<input type="text" name="products[]" value="${product.value}" hidden class="form-control">`
        });

        if (products.length == 0) {
            errorAlert("Silahkan pilih produk terlebih dahulu");
            return false;
        }

        formPrintBarcode.innerHTML = products.join('');
        formPrintBarcode.submit();

    });
</script>

<?= $this->endSection() ?>