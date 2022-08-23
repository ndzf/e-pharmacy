<?= $this->extend("layouts/main") ?>

<?= $this->section("content") ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-6 col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h3 class="mb-2 text-gray-700">Edit Data Produk</h3>
                    <form action="<?= site_url("/products/{$product->id}") ?>" method="post" id="form-create">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="mb-2">
                            <label for="name" class="col-form-label text-gray-700 fw-500">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" required value="<?= old("name", $product->name) ?>" class="form-control solid fw-500 text-gray-700">
                        </div>
                        <div class="mb-2">
                            <label for="code" class="col-form-label text-gray-700 fw-500">Kode Produk</label>
                            <input type="number" name="code" id="code" value="<?= old("code", $product->code) ?>" class="form-control solid fw-500 text-gray-700">
                        </div>
                        <div class="mb-2">
                            <label for="supplier" class="col-form-label text-gray-700 fw-500">Supplier</label>
                            <select name="supplier_id" id="supplier" required class="form-select solid fw-500 text-gray-700">
                                <?php foreach ($suppliers as $supplier) : ?>
                                    <option value="<?= $supplier->id ?>" <?= ($supplier->id == $product->supplier_id) ? "selected" : "" ?>>
                                        <?= esc($supplier->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="category" class="col-form-label text-gray-700 fw-500">Kategori</label>
                            <select name="category_id" id="category" required class="form-select solid fw-500 text-gray-700" required>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?= $category->id ?>" <?= ($category->id == $product->category_id) ? "selected" : "" ?>>
                                        <?= esc($category->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="category" class="col-form-label text-gray-700 fw-500">Tipe <span class="text-danger">*</span></label>
                            <select name="type" id="type" required class="form-select solid fw-500 text-gray-700" required>
                                <option value="general" <?= ($product->type == "general") ? "selected" : "" ?>>General</option>
                                <option value="lens" <?= ($product->type == "lens") ? "selected" : "" ?>>Lens</option>
                            </select>
                        </div>
                        <div class="mb-2" id="lens-type-wrapper" hidden>
                            <label for="lens-type" class="col-form-label text-gray-700 fw-500">Tipe Lensa </label>
                            <select name="lens_type" id="lens-type" class="form-select solid fw-500 text-gray-700" required>
                                <option value="regular" <?= ($product->lens_type == "regular") ? "selected" : "" ?>>
                                    Regular
                                </option>
                                <option value="progressive" <?= ($product->lens_type == "progressive") ? "selected" : "" ?>>
                                    Progressive
                                </option>
                            </select>
                        </div>
                        <div class="mb-2 row" id="lens-type-regular-wrapper" hidden>
                            <div class="col">
                                <label for="sph" class="col-form-label text-gray-700 fw-500">SPH</label>
                                <input type="text" name="sph" value="<?= old("sph", $product->sph) ?>" id="sph" class="form-control solid fw-500 text-gray-700">
                            </div>
                            <div class="col">
                                <label for="cyl" class="col-form-label text-gray-700 fw-500">CYL</label>
                                <input type="text" name="cyl" id="cyl" value="<?= old("cyl", $product->cyl) ?>" class="form-control solid fw-500 text-gray-700">
                            </div>
                            <div class="col">
                                <label for="add" class="col-form-label text-gray-700 fw-500">ADD</label>
                                <input type="text" name="add" id="add" value="<?= old("add", $product->add) ?>" class="form-control solid fw-500 text-gray-700">
                            </div>
                        </div>
                        <div class="mb-2 row" id="lens-type-progressive-wrapper" hidden>
                            <div class="input-group mb-2">
                                <span class="input-group-text border-0 bg-primary text-white rounded-2 fw-600 me-2">R</span>
                                <input type="text" name="r_sph" id="r-sph" placeholder="SPH" value="<?= old("r_sph", $product->r_sph) ?>" class="form-control solid text-gray-700 me-2 fw-500">
                                <input type="text" name="r_cyl" id="r-cyl" placeholder="CYL" value="<?= old("r_cyl", $product->r_cyl) ?>" class="form-control solid text-gray-700 me-2 fw-500">
                                <input type="text" name="r_add" id="r-add" placeholder="ADD" value="<?= old("r_add", $product->r_add) ?>" class="form-control solid text-gray-700 fw-500">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text border-0 bg-primary text-white rounded-2 fw-600 me-2">L</span>
                                <input type="text" name="l_sph" id="l-sph" placeholder="SPH" value="<?= old("l_sph", $product->l_sph) ?>" class="form-control solid text-gray-700 me-2 fw-500">
                                <input type="text" name="l_cyl" id="l-cyl" placeholder="CYL" value="<?= old("l_cyl", $product->l_cyl) ?>" class="form-control solid text-gray-700 me-2 fw-500">
                                <input type="text" name="l_add" id="l-add" placeholder="ADD" value="<?= old("l_add", $product->l_add) ?>" class="form-control solid text-gray-700 fw-500">
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="minimum-qty" class="col-form-label text-gray-700 fw-500">Minimum Qty</label>
                            <input type="number" name="minimum_qty" value="<?= old("qty", $product->minimum_qty) ?>" id="minimum-qty" class="form-control solid fw-500 text-gray-700">
                        </div>
                        <div class="mb-2">
                            <label for="qty" class="col-form-label text-gray-700 fw-500">Qty</label>
                            <input type="number" name="qty" value="<?= old("qty", $product->qty) ?>" id="qty" disabled class="form-control solid fw-500 text-gray-700">
                        </div>
                        <div class="mb-2">
                            <label for="original-price" class="col-form-label text-gray-700 fw-500">Harga Asli <span class="text-danger">*</span></label>
                            <input type="text" name="original_price" value="<?= old("original_price", $product->original_price) ?>" id="original-price" required class="form-control solid fw-500 text-gray-700 format-rupiah-input">
                        </div>
                        <div class="mb-2">
                            <label for="selling-price" class="col-form-label text-gray-700 fw-500">Harga Jual <span class="text-danger">*</span></label>
                            <input type="text" name="selling_price" value="<?= old("selling_price", $product->selling_price) ?>" id="selling-price" required class="form-control solid fw-500 text-gray-700 format-rupiah-input">
                        </div>
                        <div class="mb-2">
                            <label for="member-price" class="col-form-label text-gray-700 fw-500">Harga Member <span class="text-danger">*</span></label>
                            <input type="text" name="member_price" value="<?= old("member_price", $product->member_price) ?>" id="member-price" required class="form-control solid fw-500 text-gray-700 format-rupiah-input">
                        </div>
                        <div class="mb-4">
                            <label for="wholesale-price" class="col-form-label text-gray-700 fw-500">Harga Grosir <span class="text-danger">*</span></label>
                            <input type="text" name="wholesale_price" value="<?= old("wholesale_price", $product->wholesale_price) ?>" id="wholesale-price" required class="form-control solid fw-500 text-gray-700 format-rupiah-input">
                        </div>
                        <div class="mb-2 d-flex">
                            <a href="<?= site_url("/products") ?>" class="btn btn-danger fw-500" type="button">Batal</a>
                            <div class="ms-auto">
                                <button type="submit" class="btn btn-primary fw-500">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("script") ?>

<!-- Currency -->
<script src="<?= base_url("/assets/js/currency.js") ?>"></script>
<!-- Products create -->
<script src="<?= base_url("/assets/js/products.create.js") ?>"></script>

<script>
    const formatRupiahEls = document.querySelectorAll(".format-rupiah-input");
    for (formatRupiahEl of formatRupiahEls) {
        formatRupiahEl.value = formatRupiah(formatRupiahEl.value);
    }
</script>

<?= $this->endSection() ?>