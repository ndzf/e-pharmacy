<?= $this->extend("layouts/main") ?>

<?= $this->section("content") ?>

<div class="container-fluid">
    <div class="row">
        <div class=" mb-3 col-12 col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-2">
                    <h3 class="text-gray-600 mb-0 mt-2">Data Toko</h3>
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
                        <div class="mb-2">
                            <label for="address" class="col-form-label text-gray-500 fw-500">Address</label>
                            <textarea name="address" id="address" rows="3" class="form-control solid fw-500"><?= old("address", $store->address) ?></textarea>
                        </div>
                        <div class="mb-2">
                            <label for="instagram" class="col-form-label text-gray-500 fw-500">Instagram</label>
                            <input type="text" name="instagram" id="instagram" class="form-control fw-500 solid" value="<?= old("instagram", $store->instagram) ?>">
                        </div>
                        <div class="mb-4">
                            <label for="whatsapp_number" class="col-form-label text-gray-500 fw-500">Whatsapp Number</label>
                            <input type="number" name="whatsapp_number" id="whatsapp_number" value="<?= old("whatsapp_number", $store->whatsapp_number) ?>" class="form-control solid fw-500">
                        </div>
                        <div class="mb-2 d-flex justify-content-end">
                            <button class="btn btn-primary fw-500">Simpan</button>
                        </div>
                    </form>
                    <form action="<?= site_url("/store/invoice-setting") ?>" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="mb-4">
                            <label for="invoice-banner" class="col-form-label text-gray-500 fw-500">Logo Aplikasi</label>
                            <input type="file" name="invoice_banner" required id="invoice-banner" class="form-control solid fw-500">
                        </div>
                        <div class="mb-2 d-flex justify-content-end">
                            <button class="btn btn-primary fw-500">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 col-md-6">
            <div class="card border-0">
                <div class="card-body py-2">
                    <h3 class="text-gray-600 mb-0 mt-2 text-truncate">Pengaturan Kartu Pelanggan</h3>
                    <form action="<?= site_url("customer-card-setting/$setting->id") ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="mb-2">
                            <div class="row mb-2">
                                <div class="col">
                                    <label class="col-form-label col-form-label text-gray-700 fw-500">Warna Text</label>
                                    <input type="color" name="text_color" class="form-control form-control-color" value="<?= old("text_color", $setting->text_color) ?>">
                                </div>
                                <div class="col">
                                    <label class="col-form-label col-form-label text-gray-700 fw-500">Warna Primary</label>
                                    <input type="color" name="primary_color" class="form-control form-control-color" value="<?= old("primary_color", $setting->primary_color) ?>">
                                </div>
                                <div class="col">
                                    <label class="col-form-label col-form-label text-gray-700 fw-500">Warna Secondary</label>
                                    <input type="color" name="surface_color" class="form-control form-control-color" value="<?= old("surface_color", $setting->surface_color) ?>">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col">
                                    <label class="col-form-label col-form-label text-gray-700 fw-500">Background Image</label>
                                    <input type="file" name="background_image" class="form-control fw-500 text-gray-700">
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary float-end fw-500">Simpan</button>
                                <div class="clearfix"></div>
                            </div>
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