<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <!-- Style -->
    <style>
        :root {
            --text-color: <?= $setting->text_color ?>;
        }

        @media print {
            #btn-print {
                display: none;
            }
        }

        @page {
            /* dimensions for the whole page */
            size: A5 !important;
            margin: 0;
        }

        html {
            /* off-white, so body edge is visible in browser */
            background: #eee;
        }

        body {
            /* A5 dimensions */
            height: 210mm !important;
            width: 148mm !important;
            margin: 0;
            background-color: inherit !important;
            color: var(--text-color);
        }

        /* fill half the height with each face */
        .face {
            height: 50%;
            width: 100%;
            position: relative;
        }

        /* the back face */
        .face-back {
            background: #f6f6f6;
        }

        /* the front face */
        .face-front {
            background: #fff;
        }

        .fw-500 {
            font-weight: 500 !important;
        }

        .header {
            border-bottom: 2px solid var(--text-color);
            padding-bottom: .5rem;
        }

        .content {
            border-bottom: 2px solid var(--text-color);
        }

        .content .left {
            border-right: 1px solid var(--text-color);
            width: 50%;
            overflow-x: hidden;
            text-overflow: ellipsis;
            padding-right: .3rem;
            padding-top: .5rem;
            padding-bottom: .3rem;
        }

        .content .right {
            border-left: 1px solid var(--text-color);
            width: 50%;
            padding-left: .5rem;
            padding-top: .5rem;
            padding-bottom: .3rem;
        }

        .info .table>:not(caption)>*>* {
            padding: 0;
        }

        p {
            margin: 0;
        }

        .table-products {
            color: var(--text-color);
        }

        .table-products.table>:not(caption)>*>* {
            padding: 0 .2rem;
        }

        .table-products thead th {
            font-weight: 400 !important;
        }

        .table-products tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-color: var(--text-color);
        }

        .table-inline th {
            font-weight: 500 !important;
        }

        .r-90 {
            transform: rotate(90deg);
        }
    </style>
    <title>Document</title>
</head>

<body>
    <div class="face face-front">
        <div class="container-fluid">
            <div class="row">
                <div class="header d-flex mt-2 align-items-center">
                    <!-- Logo -->
                    <img src="<?= base_url("/assets/images/invoice_banner/$store->invoice_banner") ?>" alt="Logo" width="90px" class="me-2" height="70px">
                    <div class="header-text d-flex flex-column">
                        <h1 class="h5 mb-1"><?= $store->name ?></h1>
                        <p class="fw-500 mb-0"><?= $store->address ?></p>
                        <div class="d-flex mb-0">
                            <div class="me-3 fw-500">
                                <i class="fas fa-phone r-90"></i>
                                <span><?= $store->phone_number ?></span>
                            </div>
                            <div class="fw-500 me-3">
                                <i class="fab fa-whatsapp"></i>
                                <span><?= $store->whatsapp_number ?></span>
                            </div>
                            <div class="fw-500">
                                <i class="fab fa-instagram"></i>
                                <span><?= $store->instagram ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="content d-flex">
                    <div class="left ">
                        <div class="info d-flex flex-column">
                            <table class="table table-borderless table-inline mb-1">
                                <tr>
                                    <th>Tgl</th>
                                    <th>:</th>
                                    <td>&NegativeMediumSpace; <?= esc($transaction->date->toLocalizedString("dd-MM-YYYY")) ?></td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <th>:</th>
                                    <td>&NegativeMediumSpace; <?= esc($customer->name) ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <th>:</th>
                                    <td class="text-truncate">&NegativeMediumSpace; <?= esc($customer->address) ?></td>
                                </tr>
                            </table>
                            <table class="table table-products table-bordered mb-1">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>SPH</th>
                                        <th>CYL</th>
                                        <th>AXIS</th>
                                        <th>ADD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $lens = []; ?>
                                    <?php foreach ($products as $product) : ?>
                                        <?php if ($product->lens_type == "progressive") : ?>
                                            <?php array_push($lens, "progressive") ?>
                                            <tr>
                                                <td>R</td>
                                                <td><?= esc($product->r_sph) ?></td>
                                                <td><?= esc($product->r_cyl) ?></td>
                                                <td><?= esc($product->r_axis) ?></td>
                                                <td><?= esc($product->r_add) ?></td>
                                            </tr>
                                            <tr>
                                                <td>L</td>
                                                <td><?= esc($product->l_sph) ?></td>
                                                <td><?= esc($product->l_cyl) ?></td>
                                                <td><?= esc($product->l_axis) ?></td>
                                                <td><?= esc($product->l_add) ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($product->lens_type == "regular") : ?>
                                            <?php array_push($lens, "regular") ?>
                                            <tr>
                                                <td></td>
                                                <td>1,4</td>
                                                <td>1,4</td>
                                                <td>1,4</td>
                                                <td>1,4</td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td style="border-right-width: 0;">PD</td>
                                        <td style="border-left-width: 0;" colspan="4"><?= $transaction->pd ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <table class="table table-inline table-borderless mb-0">
                                <tr>
                                    <th>Lensa</th>
                                    <th>:</th>
                                    <td>&NegativeMediumSpace; <?= implode(",", $lens) ?></td>
                                </tr>
                                <tr>
                                    <th>Resep</th>
                                    <th>:</th>
                                    <td>&NegativeMediumSpace; <?= esc($transaction->recipe ?? "-") ?></td>
                                </tr>
                                <tr>
                                    <th>Pelayan</th>
                                    <th>:</th>
                                    <td class="text-truncate">&NegativeMediumSpace; <?= esc($user->name ?? "-") ?></td>
                                </tr>
                                <tr>
                                    <th>Faced</th>
                                    <th>:</th>
                                    <td class="text-truncate">&NegativeMediumSpace; <?= esc($user->faced ?? "-") ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="right">
                        <h2 class="h6">Pembelian Barang</h2>
                        <table class="table table-products table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Barang</th>
                                    <th>Jml</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php $total = 0; ?>
                                <?php foreach ($products as $product) : ?>
                                    <?php $subTotal = $product->qty * $product->product_price ?>
                                    <?php $total += $subTotal ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($product->product_name) ?></td>
                                        <td><?= $product->qty ?></td>
                                        <td><?= $subTotal ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="border-right-width: 0;">
                                        Total
                                    </td>
                                    <td colspan="1" style="border-left-width: 0;">
                                        <?= $total; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="border-right-width: 0;">
                                        Bayar
                                    </td>
                                    <td colspan="1" style="border-left-width: 0;">
                                        <?= $payment ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="border-right-width: 0;">
                                        Sisa
                                    </td>
                                    <td colspan="1" style="border-left-width: 0;">
                                        <?php $sisa = $transaction->grand_total - $payment; ?>
                                        <?= ($sisa >= 0) ? $sisa : "-" ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-primary mt-4" id="btn-print" onclick="window.print()">Print</button>
</body>

</html>