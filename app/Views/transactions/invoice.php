<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?= base_url("/assets/plugins/bootstrap/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("/assets/css/style.css") ?>">
    <title>Invoice</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');



        @page {
            /* dimensions for the whole page */
            size: A5;
            margin: 0;
        }

        html {
            /* off-white, so body edge is visible in browser */
            background: #eee;
        }

        body {
            /* A5 dimensions */
            /* height: 210mm; */
            width: 148.5mm;
            font-family: "inter" !important;
            margin: 0;
            -webkit-print-color-adjust: exact;
        }

        /* fill half the height with each face */
        .face {
            height: 50%;
            width: 100%;
            position: relative;
        }

        /* the back face */
        .face-back {
            /* background: #f6f6f6; */
            /* background-color: #fff; */
            background-color: #f5f8ff;
            border: 1px solid black;
        }

        /* the front face */
        .face-front {
            background: #fff;
            background-color: #f5f8ff;
        }

        /* an image that fills the whole of the front face */
        .face-front img {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
        }

        table.products {
            width: 100%;
            border-spacing: 0;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        table.products th {
            padding: .5em;
            border-collapse: separate;
            background-color: #0834a9;
            color: white;
            -webkit-print-color-adjust: exact;
            text-align: left;
            font-weight: 500;
        }

        table.products td {
            padding: .5em;
            border-bottom: 1px solid var(--dark);
            -webkit-print-color-adjust: exact;
            color: var(--dark);
        }

        table.detail {
            border-spacing: 2px !important;
            border-collapse: collapse;
        }

        .detail>:not(caption)>*>* {
            padding: 0;
        }

        table.detail td {
            font-weight: 500;
            color: var(--dark);
            -webkit-print-color-adjust: exact;
            padding-bottom: 5px;
        }


        table.detail th {
            background-color: #0834a9;
            font-weight: 500;
            color: white;
            -webkit-print-color-adjust: exact;
        }

        .bg-primary {
            background-color: #0834a9 !important;
            -webkit-print-color-adjust: exact;
        }

        h1 {
            font-size: 2rem;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="face face-front">
        <section class="content p-2">
            <h1 class="text-center mb-3"><?= config("App")->appName ?></h1>
            <div class="info" style="margin-bottom: .5rem;">
                <table class="table-info">
                    <tbody class="text-dark fw-500">
                        <tr>
                            <td>Tanggal</td>
                            <td class="ps-3 pe-2">:</td>
                            <td><?= $transaction->date->toLocalizedString("dd MMM y") ?></td>
                        </tr>
                        <tr>
                            <td>Kasir</td>
                            <td class="ps-3 pe-2">:</td>
                            <td><?= esc($user->name) ?></td>
                        </tr>
                        <tr>
                            <td>Pelanggan</td>
                            <td class="ps-3 pe-2">:</td>
                            <td><?= esc($customer->name) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <table class="products table table-borderless mb-4">
                <thead class="text-white fw-500">
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody class="text-dark fw-500">
                    <?php $grandTotal = 0; ?>
                    <?php foreach ($products as $product) : ?>
                        <?php $grandTotal += $product->product_price ?>
                        <tr>
                            <td><?= $product->product_name ?></td>
                            <td><?= $product->qty ?></td>
                            <td class="format-rupiah" data-format="<?= $product->product_price ?>"><?= $product->product_price ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php foreach ($products as $product) : ?>
                <?php if ($product->type == "lens") : ?>
                    <!-- <div class="text-dark fw-500"><?= $product->product_name ?></div> -->
                    <table class="detail table table-borderless">
                        <thead>
                            <tr>
                                <th class="bg-transparent"></th>
                                <th class="ps-4">SPH</th>
                                <th>CYL</th>
                                <th>ADD</th>
                                <th>AXIS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="bg-primary text-white text-center text-center fw-600">R</td>
                                <td class="ps-4"><?= $product->r_sph ?></td>
                                <td><?= $product->r_cyl ?></td>
                                <td><?= $product->r_add ?></td>
                                <td><?= $product->r_axis ?></td>
                            </tr>
                            <tr>
                                <td class="bg-primary text-white text-center fw-600">L</td>
                                <td class="ps-4"><?= $product->l_sph ?></td>
                                <td><?= $product->l_cyl ?></td>
                                <td><?= $product->l_add ?></td>
                                <td><?= $product->l_axis ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="mt-3 d-flex">
                <div class="50" style="width:60%"></div>
                <table>
                    <tr>
                        <td class="fw-600">Total</td>
                        <td>:</td>
                        <td class="fw-500 format-rupiah" data-format="<?= $grandTotal ?>"><?= $grandTotal ?></td>
                    </tr>
                    <tr>
                        <td class="fw-600">Diskon</td>
                        <td>:</td>
                        <td class="fw-500"><?= $transaction->discount ?> %</td>
                    </tr>
                    <tr>
                        <td class="fw-600">Grand Total</td>
                        <td>:</td>
                        <td class="fw-500 format-rupiah" data-format="<?= $transaction->grand_total ?>"><?= $transaction->grand_total ?></td>
                    </tr>
                </table>
            </div>
        </section>
    </div>

    <script src="<?= base_url("/assets/js/currency.js") ?>"></script>
</body>

</html>