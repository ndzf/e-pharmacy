<?= $this->extend("layouts/main")  ?>

<?= $this->section("content")  ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow rounded-5">
                <div class="card-header bg-white py-3 border-0">
                    <div class="d-flex">
                        <form action="" method="get" class="me-2">
                            <input type="search" placeholder="Cari.." name="q" id="search-bar" value="<?= esc($keyword)  ?>" class="form-control solid">
                        </form>
                        <div class="ms-auto">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-modal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    
                </div>
                <div class="card-body py-0 pb-3">
                    <div class="table-responsive">
                        <table class="table table-dashed table-borderless align-middle">
                            <thead class="text-gray-400 text-uppercase">
                                <tr>
                                    <th><?= lang("User.name")  ?></th>
                                    <th><?= lang("User.username")  ?></th>
                                    <th><?= lang("User.phoneNumber")  ?></th>
                                    <th><?= lang("User.role")  ?></th>
                                    <th><?= lang("User.status")  ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800 fw-500">
                                <?php foreach($users as $user): ?>
                                    <tr>
                                        <td><?= esc($user->name)  ?></td>
                                        <td><?= esc($user->username)  ?></td>
                                        <td><?= (!($user->phone_number) ? "-" : esc($user->phone_number))  ?></td>
                                        <td><?= esc($user->role)  ?></td>
                                        <td>
                                            <?php if($user->status == "active"): ?>
                                                <span class="badge badge-light-success badge-table fw-500">
                                                    <?= $user->status;  ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-light btn-sm fw-600 me-2">Edit</button>
                                            <button class="btn btn-light-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="mt-4">
                            <?= $pager  ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create modal -->
<div class="modal fade modal-outer right-modal" id="create-modal" tabindex="-1" aria-labelledby="create-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="create-modal-label"><?= lang("User.title.create")  ?></h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url("users")  ?>" method="post" id="form-create">
                    <div class="mb-2">
                        <label for="create-name" class="col-form-label text-gray-800 fw-500"><?= lang("User.name")  ?> <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="create-name" class="form-control <?= (isset($validation["name"]) ? "is-invalid" : "") ?> solid fw-500" value="<?= old("name") ?>">
                        <div class="invalid-feedback"><?= $validation["name"] ?? ""  ?></div>
                    </div>
                    <div class="mb-2">
                        <label for="create-username" class="col-form-label text-gray-800 fw-500"><?= lang("User.username")  ?> <span class="text-danger">*</span></label>
                        <input type="text" name="username" onkeyup="forceLowerCase(this)" id="create-username" class="form-control <?= (isset($validation["username"]) ? "is-invalid" : "") ?> solid fw-500" value="<?= old("username") ?>">
                        <div class="invalid-feedback"><?= $validation["username"] ?? ""  ?></div>
                    </div>
                    <div class="mb-2">
                        <label for="create-phone-number" class="col-form-label text-gray-800 fw-500"><?= lang("User.phoneNumber")  ?></label>
                        <input type="tel" name="phoneNumber" id="create-phone-number" class="form-control solid fw-500" value="<?= old("phoneNumber") ?>">
                    </div>
                    <div class="mb-2">
                        <label for="create-role" class="col-form-label text-gray-800 fw-500 "><?= lang("User.role")  ?> <span class="text-danger">*</span></label>
                        <select name="role" id="create-role" class="form-select solid fw-500 <?= (isset($validation["role"]) ? "is-invalid" : "") ?>">
                            <option value="cashier"><?= lang("User.cashier")  ?></option>
                            <option value="admin"><?= lang("User.admin")  ?></option>
                        </select>
                        <div class="invalid-feedback"><?= $validation["role"] ?? ""  ?></div>
                    </div>
                    <div class="mb-4">
                        <label for="create-password" class="col-form-label text-gray-800 fw-500 "><?= lang("User.password")  ?> <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="create-password" class="form-control solid <?= (isset($validation["password"]) ? "is-invalid" : "") ?>">
                        <div class="invalid-feedback"><?= $validation["password"] ?? ""  ?></div>
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary fw-500" type="submit"><?= lang("User.save")  ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection()  ?>

<?= $this->section("script")  ?>

<!-- Sweetalert2 -->
<script src="<?= base_url("/assets/plugins/sweetalert2/js/sweetalert2.all.min.js")  ?>"></script>
<script src="<?= base_url("/assets/js/alert.js")  ?>"></script>
<script src="<?= base_url("/assets/js/modal.js")  ?>"></script>

<script>
    function forceLowerCase(element) {
        element.value = element.value.toLowerCase();
    }
</script>

<?php if(session("successMessage")): ?>
    <script>
        successAlert(`<?= session("successMessage")  ?>`);
    </script>
<?php endif; ?>

<?php if(session("validationErrorCreate")): ?>
    <script>
        const createModalEl = document.querySelector("#create-modal");
        const createModal = new bootstrap.Modal(createModalEl);
        createModal.show();
    </script>
<?php endif ?>

<script>
    document.querySelector("#create-modal").addEventListener("hidden.bs.modal", (e) => {
        clearValidation("form-create");
    });
</script>

<?= $this->endSection()  ?>