<?= $this->extend("layouts/main") ?>

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
                        
                        <button class="btn btn-primary" title="<?= lang("Product.title.create") ?>">
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
                                    <th><?= lang("Product.qty") ?></th>
                                    <th><?= lang("Product.originalPrice") ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 fw-500">
                                <?php foreach($products as $product): ?>
                                    <tr>
                                        <td><?= esc($product->name) ?></td>
                                        <td><?= esc($product->category) ?></td>
                                        <td><?= esc($product->type) ?></td>
                                        <td><?= esc($product->qty) ?></td>
                                        <td><?= esc($product->original_price) ?></td>
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

<?= $this->endSection() ?>

<?= $this->section("script") ?>

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

<?= $this->endSection() ?>