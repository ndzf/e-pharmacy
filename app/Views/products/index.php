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

                        <a href="<?= site_url("/products/new") ?>" class="btn btn-primary" type="button">
                            <i class="fas fa-plus"></i>
                        </a>
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
                                            <a href="<?= site_url("/products/{$product->id}/edit") ?>" class="btn btn-light-light fw-500 btn-sm me-2" type="button">
                                                Edit
                                            </a>
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