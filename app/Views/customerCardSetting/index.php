<?= $this->extend("layouts/main") ?>

<?= $this->section("content") ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-6 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="mb-0 text-gray-700 h5 mb-3">Pengaturan Kartu Member</h2>
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

<?= $this->section("script") ?>

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