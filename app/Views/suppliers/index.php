<?= $this->extend("layouts/main")  ?>

<?= $this->section("content")  ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow rounded-6">
                <div class="card-header bg-white border-0 rounded-6 py-3">
                    <div class="d-flex">
                        <form action="" method="get">
                            <input type="search" name="q" placeholder="Cari.." id="search-bar" value="<?= esc($keyword)  ?>" class="form-control solid me-2">
                        </form>
                        <div class="ms-auto">
                            <?php if (session("role") == "admin") : ?>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-modal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-borderless table-dashed text-nowrap">
                            <thead class="text-gray-500 text-uppercase fw-600">
                                <tr>
                                    <th><?= lang("Supplier.name")  ?></th>
                                    <th><?= lang("Supplier.phoneNumber")  ?></th>
                                    <th><?= lang("Supplier.email")  ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 fw-500">
                                <?php foreach ($suppliers as $supplier) : ?>
                                    <tr>
                                        <td><?= esc($supplier->name);  ?></td>
                                        <td><?= esc($supplier->phone_number);  ?></td>
                                        <td><?= esc($supplier->email);  ?></td>
                                        <td>
                                            <?php if (session("role") == "admin") : ?>
                                                <button class="btn btn-light me-2 fw-500 btn-sm" onclick="editSupplier(`<?= $supplier->id  ?>`)">
                                                    Edit
                                                </button>
                                                <button class="btn btn-light-danger btn-sm" onclick="deleteSupplier(`<?= $supplier->id ?>`, `<?= $supplier->name ?>`)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?= $pager  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade modal-outer right-modal" id="create-modal" tabindex="-1" aria-labelledby="create-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title" id="create-modal-label"><?= lang("Supplier.title.create")  ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-0">
                <form action="<?= site_url("/suppliers") ?>" id="form-create" method="post">
                    <div class="mb-2">
                        <label for="create-name" class="col-form-label fw-500 text-gray-700"><?= lang("Supplier.name")  ?></label>
                        <input type="text" name="name" value="<?= old("name") ?>" id="create-name" class="fw-500 form-control solid <?= (isset($validation["name"]) ? "is-invalid" : "")  ?>">
                        <div class="invalid-feedback fw-500"><?= $validation["name"] ?? ""  ?></div>
                    </div>
                    <div class="mb-2">
                        <label for="create-phone-number" class="col-form-label fw-500 text-gray-700"><?= lang("Supplier.phoneNumber")  ?></label>
                        <input type="tel" name="phoneNumber" id="create-phone-number" value="<?= old("phoneNumber") ?>" class="form-control solid fw-500">
                    </div>
                    <div class="mb-2">
                        <label for="create-email" class="col-form-label fw-500 text-gray-700"><?= lang("Supplier.email")  ?></label>
                        <input type="email" name="email" id="create-email" class="form-control fw-500 solid" value="<?= old("email")  ?>">
                    </div>
                    <div class="mb-4">
                        <label for="create-address" class="col-form-label fw-500 text-gray-700"><?= lang("Supplier.address")  ?></label>
                        <textarea name="address" id="create-address" cols="" rows="3" class="form-control solid fw-500"><?= old("address")  ?></textarea>
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary fw-500"><?= lang("Supplier.save")  ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade outer-modal right-modal" id="edit-modal" tabindex="-1" aria-labelledby="edit-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title text-dark" id="edit-modal-label"><?= lang("Supplier.title.edit")  ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="" method="post" id="form-edit">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-2">
                        <label for="edit-name" class="col-form-label text-gray-700 fw-500"><?= lang("Supplier.name") ?></label>
                        <input type="text" name="name" id="edit-name" class="form-control fw-500 solid <?= (isset($validation["name"]) ? "is-invalid" : "")  ?>">
                        <div class="invalid-feedback fw-500"><?= $validation["name"] ?? ""  ?></div>
                    </div>
                    <div class="mb-2">
                        <label for="edit-phone-number" class="col-form-label fw-500 text-gray-700"><?= lang("Supplier.phoneNumber") ?></label>
                        <input type="tel" name="phoneNumber" id="edit-phone-number" class="form-control fw-500 solid">
                    </div>
                    <div class="mb-2">
                        <label for="edit-email" class="col-form-label fw-500 text-gray-700"><?= lang("Supplier.email") ?></label>
                        <input type="email" name="email" id="edit-email" class="form-control fw-500 solid">
                    </div>
                    <div class="mb-4">
                        <label for="edit-address" class="col-form-label fw-500 text-gray-700"><?= lang("Supplier.address") ?></label>
                        <textarea name="address" id="edit-address" cols="" rows="3" class="form-control fw-500 solid"></textarea>
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary fw-500"><?= lang("Supplier.save")  ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form action="" id="form-delete" method="post">
    <input type="hidden" name="_method" value="DELETE">
</form>

<?= $this->endSection()  ?>

<?= $this->section("script")  ?>

<script src="<?= base_url("/assets/plugins/sweetalert2/js/sweetalert2.all.min.js")  ?>"></script>
<script src="<?= base_url("/assets/plugins/axios/src/axios.min.js")  ?>"></script>
<script src="<?= base_url("/assets/js/alert.js")  ?>"></script>
<script src="<?= base_url("/assets/js/modal.js")  ?>"></script>

<?php if (session("successMessage")) : ?>

    <script>
        successAlert(`<?= session("successMessage")  ?>`);
    </script>

<?php endif; ?>

<script>
    const baseURL = `<?= site_url()  ?>`

    function editSupplier(id) {
        axios({
            url: `${baseURL}suppliers/${id}/edit`,
            method: "GET",
            responseType: "json",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        }).then(res => {
            const supplier = res.data;
            document.querySelector("#edit-name").value = supplier.name;
            document.querySelector("#edit-phone-number").value = supplier.phone_number;
            document.querySelector("#edit-email").value = supplier.email;
            document.querySelector("#edit-address").value = supplier.address;
            document.querySelector("#form-edit").setAttribute("action", `${baseURL}suppliers/${id}`);
            const editModal = new bootstrap.Modal(document.querySelector("#edit-modal"));
            editModal.show();
        })
    }

    function deleteSupplier(id, name) {
        Swal.fire({
            title: `Hapus ${name}`,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Hapus',
            denyButtonText: `Batal`,
        }).then(result => {
            if (result.isConfirmed) {
                const formDelete = document.forms["form-delete"];
                formDelete.setAttribute("action", `${baseURL}suppliers/${id}`);
                formDelete.submit();
            }
        })
    }
</script>

<?php if (session("validationErrorCreate")) : ?>

    <script>
        const createModal = new bootstrap.Modal(document.querySelector("#create-modal"));
        createModal.show();
    </script>

<?php endif; ?>

<?php if (session("validationErrorUpdate")) : ?>

    <script>
        editSupplier(`<?= session("validationErrorUpdate")  ?>`);
    </script>

<?php endif; ?>

<script>
    // Clear validation on modal 
    document.querySelector("#create-modal").addEventListener("hidden.bs.modal", function(e) {
        clearValidation("form-create", "form-edit");
    });

    document.querySelector("#edit-modal").addEventListener("hidden.bs.modal", function(e) {
        clearValidation("form-create", "form-edit");
    });
</script>

<?= $this->endSection()  ?>