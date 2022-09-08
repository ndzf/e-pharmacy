<?= $this->extend("layouts/main")  ?>

<?= $this->section("content")  ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow border-7">
                <div class="card-header p-3 bg-white border-0">
                    <div class="d-flex">
                        <form action="" method="get">
                            <input type="search" name="q" id="search-bar" value="<?= esc($keyword)  ?>" placeholder="Cari..." class="form-control solid me-2">
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
                        <table class="table table-dashed table-borderless">
                            <thead class="text-gray-500 text-uppercase fw-600">
                                <tr>
                                    <th><?= lang("Category.name")  ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 fw-500">
                                <?php foreach ($categories as $category) : ?>
                                    <tr>
                                        <td><?= esc($category->name)  ?></td>
                                        <td>
                                            <?php if (session("role") == "admin") : ?>
                                                <button class="btn btn-light btn-sm fw-500 me-2" onclick="editCategory(`<?= $category->id  ?>`)">
                                                    Edit
                                                </button>
                                                <button class="btn btn-light-danger btn-sm" onclick="deleteCategory(`<?= $category->id  ?>`, `<?= $category->name ?>`)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
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

<!-- Create Modal -->
<div class="modal fade outer-modal right-modal" id="create-modal" tabindex="-1" aria-labelledby="create-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header py-3">
                <h5 class="modal-title text-dark" id="create-modal-label"><?= lang("Category.title.create")  ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-0">
                <form action="<?= site_url("/categories") ?>" id="form-create" method="post">
                    <div class="mb-4">
                        <label for="create-name" class="col-form-label text-gray-800 fw-500"><?= lang("Category.name")  ?></label>
                        <input type="text" name="name" id="create-name" value="<?= old("name")  ?>" class="form-control solid fw-500 <?= isset($validation["name"]) ? "is-invalid" : ""  ?>">
                        <div class="invalid-feedback"><?= $validation["name"] ?? ""  ?></div>
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary fw-500">
                            <?= lang("Category.save")  ?>
                        </button>
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
                <h5 class="modal-title text-dark" id="edit-modal-label"><?= lang("Category.title.edit")  ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-0">
                <form action="" id="form-edit" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-4">
                        <label for="edit-name" class="col-form-label text-gray-800 fw-500"><?= lang("Category.name")  ?></label>
                        <input type="text" name="name" id="edit-name" value="" class="form-control solid fw-500 <?= isset($validation["name"]) ? "is-invalid" : ""  ?>">
                        <div class="invalid-feedback"><?= $validation["name"] ?? ""  ?></div>
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary fw-500" type="submit">
                            <?= lang("Category.save")  ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Form Delete -->

<form action="" method="post" id="form-delete">
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
    const baseURL = `<?= site_url()  ?>`;

    function editCategory(id) {
        axios({
            method: "GET",
            url: `${baseURL}categories/${id}/edit`,
            responseType: "json",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        }).then(res => {
            const category = res.data;

            document.querySelector("#edit-name").value = category.name;
            document.querySelector("#form-edit").setAttribute("action", `${baseURL}categories/${id}`);
            const editModal = new bootstrap.Modal(document.querySelector("#edit-modal"));
            editModal.show();

        }).catch(error => {
            errorAlert(error.response.data.message);
        });
    }

    function deleteCategory(id, name) {
        Swal.fire({
            title: `Hapus ${name}`,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Hapus',
            denyButtonText: `Batal`,
        }).then(result => {
            if (result.isConfirmed) {
                const formDelete = document.querySelector("#form-delete");
                formDelete.setAttribute("action", `${baseURL}categories/${id}`);
                formDelete.submit();
            }
        })
    }
</script>

<?php if (session("validationErrorCreate")) : ?>

    <script>
        const createModalEl = document.querySelector("#create-modal");
        const createModal = new bootstrap.Modal(createModalEl);
        createModal.show();
    </script>

<?php endif; ?>

<?php if (session("validationErrorUpdate")) : ?>

    <script>
        editCategory(`<?= session("validationErrorUpdate")  ?>`);
    </script>

<?php endif; ?>

<script>
    document.querySelector("#create-modal").addEventListener("hidden.bs.modal", function(e) {
        clearValidation("form-create", "form-edit");
    });

    document.querySelector("#edit-modal").addEventListener("hidden.bs.modal", function(e) {
        clearValidation("form-create", "form-edit");
    });
</script>

<?= $this->endSection()  ?>