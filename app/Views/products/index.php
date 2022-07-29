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

                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create" title="<?= lang("Product.title.create") ?>">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-borderless table-dashed">
                            <thead class="text-gray-400 fw-500 text-uppercase">
                                <tr>
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
                                        <td><?= esc($product->name) ?></td>
                                        <td><?= esc($product->category) ?></td>
                                        <td><?= esc($product->type) ?></td>
                                        <td><?= esc($product->original_price) ?></td>
                                        <td><?= esc($product->qty) ?></td>
                                        <td></td>
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

<!-- Modal create -->
<div class="modal modal-outer right-modal fade" data-bs-backdrop="static" id="modal-create" tabindex="-1" aria-labelledby="modal-create-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title text-gray-700" id="modal-create-label"><?= lang("Product.title.create") ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="<?= site_url("/products") ?>" id="form-create" method="post">
                    <div class="mb-2">
                        <label for="create-name" class="col-form-label text-gray-700 fw-500"><?= lang("Product.name") ?> <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="create-name" value="<?= old("name") ?>" class="form-control solid fw-500 <?= (isset($validation["name"])) ? "is-invalid" : "" ?>">
                        <div class="invalid-feedback fw-500"><?= $validation["name"] ?? "" ?></div>
                    </div>
                    <div class="mb-2">
                        <label for="create-supplier" class="col-form-label text-gray-700 fw-500"><?= lang("Product.supplier") ?></label>
                        <select name="supplier" id="create-supplier" class="form-control solid fw-500">
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
                        <select name="type" onchange="setCreateLensType(this.value)" id="create-type" class="form-select solid fw-500" required>
                            <option value="general" <?= (old("type") == "general") ? "selected" : "" ?>>
                                <?= lang("Product.types.general") ?>
                            </option>
                            <option value="lens" <?= (old("type") == "lens") ? "selected" : "" ?>>
                                <?= lang("Product.types.lens") ?>
                            </option>
                        </select>
                    </div>
                    <div id="create-lens-type" hidden>
                        <div class="input-group mb-2">
                            <span class="input-group-text me-2 border-0 rounded-2 bg-primary fw-600 text-white">R</span>
                            <input type="text" name="createRSph" value="<?= old("createRSph") ?>" placeholder="SPH" class="form-control solid fw-500 rounded-2 me-2">
                            <input type="text" name="createRCyl" value="<?= old("createRCyl") ?>" placeholder="CYL" class="form-control solid fw-500 rounded-2 me-2">
                            <input type="text" name="createRAdd" value="<?= old("createRAdd") ?>" placeholder="ADD" class="form-control solid fw-500 rounded-2">
                        </div>
                        <div class="input-group">
                            <span class="input-group-text me-2 border-0 rounded-2 bg-primary fw-600 text-white">L</span>
                            <input type="text" name="createLSph" value="<?= old("createLSph") ?>" placeholder="SPH" class="form-control solid fw-500 rounded-2 me-2">
                            <input type="text" name="createLCyl" value="<?= old("createLCyl") ?>" placeholder="CYL" class="form-control solid fw-500 rounded-2 me-2">
                            <input type="text" name="createLAdd" value="<?= old("createLAdd") ?>" placeholder="ADD" class="form-control solid fw-500 rounded-2">
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
                        <label for="create-original-price" class="col-form-label text-gray-700 fw-500"><?= lang("Product.originalPrice") ?></label>
                        <input type="text" name="originalPrice" id="create-original-price" class="form-control solid fw-500" value="<?= old("originalPrice") ?>">
                    </div>
                    <div class="mb-2">
                        <label for="create-selling-price" class="col-form-label text-gray-700 fw-500"><?= lang("Product.sellingPrice") ?></label>
                        <input type="text" name="sellingPrice" id="create-selling-price" class="form-control solid fw-500" value="<?= old("sellingPrice") ?>">
                    </div>
                    <div class="mb-2">
                        <label for="create-member-price" class="col-form-label text-gray-700 fw-500"><?= lang("Product.memberPrice") ?></label>
                        <input type="text" name="memberPrice" id="create-member-price" class="form-control solid fw-500" value="<?= old("memberPrice") ?>">
                    </div>
                    <div class="mb-4">
                        <label for="create-wholesale-price" class="col-form-label text-gray-700 fw-500"><?= lang("Product.wholesalePrice") ?></label>
                        <input type="text" name="wholesalePrice" id="create-wholesale-price" class="form-control solid" value="<?= old("wholesalePrice") ?>">
                    </div>
                    <div class="mb-4 d-flex justify-content-end">
                        <button class="btn btn-primary fw-500">
                            <?= lang("General.save") ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("script") ?>

<!-- Sweetalert2 -->
<script src="<?= base_url("/assets/plugins/sweetalert2/js/sweetalert2.all.min.js") ?>"></script>
<!-- Alert -->
<script src="<?= base_url("/assets/js/alert.js") ?>"></script>
<!-- Forms -->
<script src="<?= base_url("/assets/js/forms.js") ?>"></script>

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

    function setCreateLensType(value) {
        const createLensType = document.querySelector("#create-lens-type");
        if (value == "lens") {
            createLensType.removeAttribute("hidden");
        } else {
            createLensType.setAttribute("hidden", true);
        }
    }

</script>

<?php if(session("validationErrorCreate")): ?>
    <script>
        // Form Lens Details
        const createType = document.querySelector("#create-type");
        setCreateLensType(createType.value);

        const modalCreate = new bootstrap.Modal(document.querySelector("#modal-create"));
        modalCreate.show();
    </script>
<?php endif; ?>

<?php if(session("successMessage")): ?>
    <script>
        successAlert(`<?= session("successMessage") ?>`);
    </script>
<?php endif; ?>

<script>
    const modalCreateEl = document.querySelector("#modal-create");
    modalCreateEl.addEventListener("hidden.bs.modal", function(e) {
        clearValidation("#form-create");
        resetSelectedOptions("#create-supplier", true);
        resetSelectedOptions("#create-category", true);
        resetSelectedOptions("#create-type", true);
        setCreateLensType(document.querySelector("#create-type").value);
    });
</script>

<?= $this->endSection() ?>