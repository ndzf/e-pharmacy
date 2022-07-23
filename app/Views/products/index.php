<?= $this->extend("layouts/main") ?>

<?= $this->section("content")  ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 rounded-6 shadow">
                <div class="card-header border-0 rounded-6 py-3 bg-white d-flex">
                    <form action="" method="get">
                        <input type="search" name="q" placeholder="Cari..." id="search-bar" class="form-control solid fw-500 me-2" value="<?= esc($keyword)  ?>">
                    </form>
                    <div class="ms-auto">
                        <?php if(session("role") == "admin"): ?>
                            <button class="btn btn-primary" title="<?= lang("Product.title.create")  ?>">
                                <i class="fas fa-plus"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-borderless table-dashed text-nowrap align-middle">
                            <thead class="text-gray-400 fw-500 text-uppercase">
                                <tr>
                                    <th><?= lang("Product.code")  ?></th>
                                    <th><?= lang("Product.name")  ?></th>
                                    <th><?= lang("Product.category")  ?></th>
                                    <th><?= lang("Product.originalPrice")  ?></th>
                                    <th><?= lang("Product.sellingPrice")  ?></th>
                                    <th><?= lang("Product.qty")  ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 fw-500">
                                <?php foreach($products as $product): ?>
                                    <tr>
                                        <td><?= esc($product->code) ?></td>
                                        <td><?= esc($product->name) ?></td>
                                        <td><?= esc($product->category) ?></td>
                                        <td><?= esc($product->original_price)  ?></td>
                                        <td><?= esc($product->selling_price)  ?></td>
                                        <td>
                                            <div class="badge badge-table fw-600 <?= ($product->qty > $product->minimum_qty) ? "badge-light-primary" : "badge-light-danger"; ?>">
                                                <?= esc($product->qty)  ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if(session("role") == "admin"): ?>
                                                <button class="btn btn-sm btn-light fw-500 me-2" title="<?= lang("Product.title.edit")  ?>">
                                                    Edit
                                                </button>
                                                <button class="btn btn-light-danger btn-sm" title="<?= lang("Product.title.delete")  ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?= $pager;  ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection()  ?>