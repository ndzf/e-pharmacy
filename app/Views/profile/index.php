<?= $this->extend("layouts/main") ?>

<?= $this->section("content") ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="<?= site_url("/profile/$user->id") ?>" method="post" autocomplete="off">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="currentUsername" value="<?= $user->username ?>" id="current-username">
                        <div class="mb-2">
                            <label for="name" class="col-form-label text-gray-500 fw-500">Nama</label>
                            <input type="text" name="name" id="name" class="form-control solid fw-500" value="<?= old("name", $user->name) ?>" autocomplete="off">
                        </div>
                        <div class="mb-2">
                            <label for="username" class="col-form-label text-gray-500 fw-500">Username</label>
                            <input type="text" name="username" id="username" class="form-control solid fw-500 <?= (isset($validation["username"]) ? "is-invalid" : "") ?>" autocomplete="off" value="<?= old("username", $user->username) ?>">
                        </div>
                        <div class="mb-2">
                            <label for="phone-number" class="col-form-label text-gray-500 fw-500">No. Tlp</label>
                            <input type="tel" name="phoneNumber" id="phone-number" autocomplete="off" class="form-control solid fw-500" value="<?= old("phoneNumber", $user->phone_number) ?>">
                        </div>
                        <div class="mb-4">
                            <label for="password" class="col-form-label text-gray-500 fw-500">Password</label>
                            <input type="password" name="password" minlength="5" id="password" class="form-control solid fw-500" autocomplete="new-password">
                        </div>
                        <div class="mb-2 d-flex justify-content-end">
                            <button class="btn btn-primary fw-500" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("script")  ?>

<script src="<?= base_url("/assets/plugins/sweetalert2/js/sweetalert2.all.min.js") ?>"></script>
<script src="<?= base_url("/assets/js/alert.js") ?>"></script>

<?php if (session("successMessage")) : ?>

    <script>
        successAlert(`<?= session("successMessage") ?>`);
    </script>

<?php endif; ?>

<?= $this->endSection() ?>