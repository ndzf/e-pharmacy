<?= $this->extend("layouts/main")  ?>

<?= $this->section("content")  ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow rounded-6">
                <div class="card-header bg-white d-flex border-0 rounded-6 py-3">
                    <form action="" method="get">
                        <input type="search" name="q" id="search-bar" placeholder="Cari.." value="<?= esc($keyword)  ?>" class="form-control solid fw-500">
                    </form>
                    <div class="ms-auto">
                        <?php if (session("role") == "admin") : ?>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create">
                                <i class="fas fa-plus"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-borderless table-dashed text-nowrap align-middle">
                            <thead class="text-gray-400 fw-600 text-uppercase">
                                <tr>
                                    <th><?= lang("Customer.name")  ?></th>
                                    <th><?= lang("Customer.phoneNumber")  ?></th>
                                    <th><?= lang("Customer.email")  ?></th>
                                    <th><?= lang("Customer.role")  ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="fw-500 text-gray-700">
                                <?php foreach ($customers as $customer) : ?>
                                    <tr>
                                        <td><?= esc($customer->name)  ?></td>
                                        <td><?= esc($customer->phone_number)  ?></td>
                                        <td><?= esc($customer->email)  ?></td>
                                        <td>
                                            <div class="badge badge-table <?= $customer->getBadgeTheme() ?> fw-500">
                                                <?= lang("Customer.roles.{$customer->role}")  ?>
                                            </div>
                                        </td>
                                        <th>
                                            <a href="<?= site_url("/customers/$customer->id/print") ?>" type="button" class="btn btn-light btn-sm">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <?php if (session("role") == "admin") : ?>
                                                <button class="btn btn-light btn-sm fw-500 me-2" onclick="editCustomer(`<?= $customer->id ?>`)">
                                                    Edit
                                                </button>
                                                <button class="btn btn-light-danger btn-sm" onclick="deleteCustomer(`<?= $customer->id  ?>`)" title="<?= lang("Customer.title.delete")  ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </th>
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

<!-- Modal Create -->
<div class="modal modal-outer right-modal fade" id="modal-create" tabindex="-1" aria-labelledby="modal-create-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title text-dark" id="modal-create-label"><?= lang("Customer.title.create")  ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="<?= site_url("/customers") ?>" id="form-create" method="post">
                    <div class="mb-2">
                        <label for="create-name" class="col-form-label text-gray-800 fw-500"><?= lang("Customer.name") ?> <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="<?= old("name") ?>" id="create-name" class="form-control fw-500 solid <?= (isset($validation["name"]) ? "is-invalid" : "")  ?>">
                        <div class="invalid-feedback fw-500"><?= $validation["name"] ?? ""  ?></div>
                    </div>
                    <div class="mb-2">
                        <label for="create-phone-number" class="col-form-label text-gray-800 fw-500"><?= lang("Customer.phoneNumber")  ?></label>
                        <input type="tel" value="<?= old("phoneNumber") ?>" name="phoneNumber" id="create-phone-number" class="form-control solid fw-500">
                    </div>
                    <div class="mb-2">
                        <label for="create-email" class="col-form-label text-gray-800 fw-500"><?= lang("Customer.email")  ?></label>
                        <input type="email" value="<?= old("email") ?>" name="email" id="create-email" class="form-control solid fw-500">
                    </div>
                    <div class="mb-2">
                        <label for="create-role" class="col-form-label text-gray-800 fw-500"><?= lang("Customer.role") ?> <span class="text-danger">*</span></label>
                        <select name="role" id="create-role" class="form-select solid fw-500">
                            <option value="customer" <?= (old("role") == "customer") ? "selected" : ""  ?>><?= lang("Customer.roles.customer")  ?></option>
                            <option value="member" <?= (old("role") == "member") ? "selected" : ""  ?>><?= lang("Customer.roles.member")  ?></option>
                            <option value="reseller" <?= (old("role") == "reseller") ? "selected" : ""  ?>><?= lang("Customer.roles.reseller")  ?></option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="create-address" class="col-form-label text-gray-800 fw-500"><?= lang("Customer.address") ?></label>
                        <textarea name="address" id="create-address" rows="2" class="form-control solid fw-500"><?= old("address")  ?></textarea>
                    </div>
                    <div class="mb-2 d-flex justify-content-end">
                        <button class="btn btn-primary fw-500"><?= lang("Customer.save")  ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade outer-modal right-modal" id="modal-edit" tabindex="-1" aria-labelledby="modal-edit-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title text-dark" id="modal-edit-label"><?= lang("Customer.title.edit")  ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="" id="form-edit" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-2">
                        <label for="edit-name" class="col-form-label text-gray-800 fw-500"><?= lang("Customer.name")  ?></label>
                        <input type="text" name="name" id="edit-name" class="form-control fw-500 solid <?= (isset($validation["name"]) ? "is-invalid" : "")  ?>">
                        <div class="invalid-feedback fw-500"><?= $validation["name"] ?? ""  ?></div>
                    </div>
                    <div class="mb-2">
                        <label for="edit-phone-number" class="col-form-label text-gray-800 fw-500"><?= lang("Customer.phoneNumber")  ?></label>
                        <input type="tel" name="phoneNumber" id="edit-phone-number" class="form-control solid fw-500">
                    </div>
                    <div class="mb-2">
                        <label for="edit-email" class="col-form-label text-gary-800 fw-500"><?= lang("Customer.email")  ?></label>
                        <input type="email" name="email" id="edit-email" class="form-control solid fw-500">
                    </div>
                    <div class="mb-2">
                        <label for="edit-role" class="col-form-label text-gray-800 fw-500"><?= lang("Customer.role")  ?></label>
                        <select name="role" id="edit-role" class="form-select solid fw-500">
                            <option value="customer"><?= lang("Customer.roles.customer")  ?></option>
                            <option value="member"><?= lang("Customer.roles.member")  ?></option>
                            <option value="reseller"><?= lang("Customer.roles.reseller")  ?></option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="edit-address" class="col-form-label text-gray-800 fw-500"><?= lang("Customer.address")  ?></label>
                        <textarea name="address" id="edit-address" cols="2" rows="0" class="form-control fw-500 solid"></textarea>
                    </div>
                    <div class="mb-2 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit"><?= lang("Customer.save")  ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Form Delete -->
<form action="" id="form-delete" method="post">
    <input type="hidden" name="_method" value="DELETE">
</form>

<?= $this->endSection()  ?>

<?= $this->section("script")  ?>

<!-- Axios -->
<script src="<?= base_url("/assets/plugins/axios/src/axios.min.js")  ?>"></script>
<!-- Sweetalert2 -->
<script src="<?= base_url("/assets/plugins/sweetalert2/js/sweetalert2.all.min.js")  ?>"></script>
<!-- Alert -->
<script src="<?= base_url("/assets/js/alert.js")  ?>"></script>
<!-- Modal -->
<script src="<?= base_url("/assets/js/modal.js")  ?>"></script>

<?php if (session("successMessage")) : ?>

    <script>
        successAlert(`<?= session("successMessage")  ?>`);
    </script>

<?php endif; ?>

<script>
    const baseURL = `<?= site_url() ?>`;

    function editCustomer(id) {
        axios({
            method: "GET",
            url: `${baseURL}customers/${id}/edit`,
            responseType: "json",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        }).then(res => {
            const customer = res.data;
            document.querySelector("#edit-name").value = customer.name;
            document.querySelector("#edit-phone-number").value = customer.phone_number;
            document.querySelector("#edit-email").value = customer.email;
            document.querySelector("#edit-address").innerHTML = customer.address;
            const roleOptions = document.querySelector("#edit-role").options;
            for (roleOption of roleOptions) {
                (roleOption.value == customer.role) ? roleOption.setAttribute("selected", true): roleOption;
            }
            document.querySelector("#form-edit").setAttribute("action", `${baseURL}customers/${id}`);
            const editModal = new bootstrap.Modal(document.querySelector("#modal-edit"));
            editModal.show();
        }).catch(error => {
            console.error(error);
        });
    }

    function deleteCustomer(id) {
        const formDelete = document.forms["form-delete"];
        console.log(formDelete);
        formDelete.setAttribute("action", `${baseURL}customers/${id}`);
        formDelete.submit();
    }
</script>

<?php if (session("validationErrorCreate")) : ?>

    <script>
        const modalCreate = new bootstrap.Modal(document.querySelector("#modal-create"));
        modalCreate.show();
    </script>

<?php endif;  ?>

<?php if (session("validationErrorUpdate")) : ?>

    <script>
        editCustomer(`<?= session("validationErrorUpdate")  ?>`);
    </script>

<?php endif; ?>

<script>
    document.querySelector("#modal-create").addEventListener("hidden.bs.modal", (e) => {
        const roleOptionsCreate = document.querySelector("#create-role").options;
        clearValidation("form-create", "form-edit");
        for (roleOptionCreate of roleOptionsCreate) {
            roleOptionCreate.removeAttribute("selected");
        }
        roleOptionsCreate[0].setAttribute("selected", true);

        const roleOptionsEdit = document.querySelector("#edit-role").options;
        clearValidation("form-create", "form-edit");
        for (roleOptionEdit of roleOptionsEdit) {
            roleOptionEdit.removeAttribute("selected");
        }
    });

    document.querySelector("#modal-edit").addEventListener("hidden.bs.modal", (e) => {
        const roleOptionsCreate = document.querySelector("#create-role").options;
        clearValidation("form-create", "form-edit");
        for (roleOptionCreate of roleOptionsCreate) {
            roleOptionCreate.removeAttribute("selected");
        }
        roleOptionsCreate[0].setAttribute("selected", true);

        const roleOptionsEdit = document.querySelector("#edit-role").options;
        clearValidation("form-create", "form-edit");
        for (roleOptionEdit of roleOptionsEdit) {
            roleOptionEdit.removeAttribute("selected");
        }
    });
</script>

<?= $this->endSection()  ?>