<?= $this->extend("layouts/main") ?>

<?= $this->section("content") ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header py-3 bg-white border-0">
                    <button class="btn btn-primary" onclick="createPurchase()">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>

<form action="<?= site_url("purchases") ?>" method="post" id="form-create"></form>

<?= $this->endSection() ?>

<?= $this->section("script") ?>

<script>
    // Create purchase
    function createPurchase() {
        document.forms["form-create"].submit();
    }
</script>

<?= $this->endSection() ?>