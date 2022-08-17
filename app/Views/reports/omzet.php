<?= $this->extend("layouts/main") ?>

<?= $this->section("content") ?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<?= $this->endSection() ?>

<?= $this->section("content") ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header py-3 bg-white border-0 d-flex">
                    <form action="" class="d-flex" id="form-filter" method="get">
                        <input type="text" class="form-control solid fw-500 me-2" value="<?= $inputs["date"] ?>" name="daterange" id="daterange">
                        <input type="hidden" name="start" id="start">
                        <input type="hidden" name="end" id="end">
                    </form>
                    <div class="ms-auto">
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-borderless table-dashed text-nowrap">
                            <thead class="text-gray-400 fw-500 text-uppercase">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Product</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Qty</th>
                                    <th>Payment Status</th>
                                    <th>Omzet</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-500">
                                <?php $totalOmzet = 0; ?>
                                <?php foreach ($products as $product) : ?>
                                    <?php $omzet = ($product["product_price"] - $product["original_price"]) * $product["qty"] ?>
                                    <?php $totalOmzet += $omzet ?>
                                    <tr>
                                        <td><?= $product["date"]->toDateString() ?></td>
                                        <td><?= $product["product"] ?? $product["product_name"] ?></td>
                                        <td class="format-rupiah" data-format="<?= $product["original_price"] ?>">
                                            <?= $product["original_price"] ?>
                                        </td>
                                        <td class="format-rupiah" data-format="<?= $product["product_price"] ?>">
                                            <?= $product["product_price"] ?>
                                        </td>
                                        <td><?= $product["qty"] ?></td>
                                        <td><?= $product["payment_status"] ?></td>
                                        <td class="format-rupiah" data-format="<?= $omzet ?>">
                                            <?= $omzet ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="5"></td>
                                    <td class="text-end">Total Omzet</td>
                                    <td>
                                        <span class="format-rupiah" data-format="<?= $totalOmzet ?>">
                                            <?= $totalOmzet ?>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("script") ?>

<script src="<?= base_url("/assets/plugins/jquery/jquery.min.js") ?>"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="<?= base_url("/assets/js/currency.js") ?>"></script>

<script>
    const formFilter = document.forms["form-filter"];

    $(function() {
        $("#daterange").daterangepicker({
            singleDatePicker: false,
            locale: {
                format: "YYYY-MM-DD",
            }
        });
        $("#daterange").on("apply.daterangepicker", () => {
            const date = $("#daterange").val().split(" ");
            const [start, , end] = date;
            document.querySelector("#form-filter input[name=start]").value = start;
            document.querySelector("#form-filter input[name=end]").value = end;
            formFilter.submit();
        });
    })
</script>

<?= $this->endSection() ?>