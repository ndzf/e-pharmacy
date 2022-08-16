<?= $this->extend("layouts/main") ?>

<?= $this->section("content") ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-2">
                    <form action="<?= site_url("/store/$store->id") ?>" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="mb-2">
                            <label for="name" class="col-form-label text-gray-500 fw-500">Nama Toko</label>
                            <input type="text" name="name" id="name" class="form-control solid fw-500" value="<?= old("name", $store->name) ?>" required="required">
                        </div>
                        <div class="mb-2">
                            <label for="phone-number" class="col-form-label text-gray-500 fw-500">No. Tlp</label>
                            <input type="tel" name="phoneNumber" id="phone-number" class="form-control solid fw-500" value="<?= old("phoneNumber", $store->phone_number) ?>">
                        </div>
                        <div class="mb-2">
                            <label for="email" class="col-form-label text-gray-500 fw-500">Email</label>
                            <input type="email" name="email" id="email" class="form-control solid fw-500" value="<?= old("email", $store->email) ?>">
                        </div>
                        <div class="mb-4">
                            <label for="address" class="col-form-label text-gray-500 fw-500">Address</label>
                            <textarea name="address" id="address" rows="3" class="form-control solid fw-500"><?= old("address", $store->address) ?></textarea>
                        </div>
                        <div class="mb-2 d-flex justify-content-end">
                            <button class="btn btn-primary fw-500">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("script")  ?>

<!-- Sweetalert2 -->
<script src="<?= base_url("/assets/plugins/sweetalert2/js/sweetalert2.all.min.js") ?>"></script>
<script src="<?= base_url("/assets/js/alert.js") ?>"></script>

<?php if (session("successMessage")) : ?>

    <script>
        successAlert(`<?= session("successMessage") ?>`);
    </script>

<?php endif; ?>

<?php if (session("errorMessage")) : ?>

    <script>
        errorAlert(`<?= session("errorMessage") ?>`);
    </script>

<?php endif; ?>

<?= $this->endSection() ?>