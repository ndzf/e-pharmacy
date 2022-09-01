<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url("/assets/plugins/fontawesome-free/css/all.min.css") ?>">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <style>
        :root {
            ---text-color: <?= $setting->text_color ?>;
            ---text-white: #fff;
            --primary: <?= $setting->primary_color ?>;
            --surface: <?= $setting->surface_color ?>;
        }

        @page {
            /* dimensions for the whole page */
            size: A5;
            margin: 0;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        html {
            /* off-white, so body edge is visible in browser */
            background: #eee;
        }

        body {
            /* A5 dimensions */
            height: 210mm;
            width: 148.5mm;

            margin: 0;
        }

        /* fill half the height with each face */
        .face {
            height: 50%;
            width: 100%;
            position: relative;
        }

        /* the front face */
        .face-front {
            background-image: url("<?= "/assets/customer-card/" . $setting->background_image ?>");
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        .header-box {
            background-color: var(--primary);
            width: 60%;
            position: absolute;
            right: 0;
            z-index: 1;
        }

        .logo-wrapper {
            background-color: var(--surface);
            padding: 1rem;
            position: absolute;
            width: 100%;
            top: 2rem;
        }

        .customer-box {
            top: 8rem;
            position: absolute;
            z-index: 2;
        }

        .description-box {
            background-color: var(--surface);
            position: absolute;
            bottom: 0;
            width: 70%;
            height: 9rem;
        }

        .info span {
            font-weight: bold;
        }
    </style>
</head>

<body onload="window.printx()">
    <div class="face face-front p-relative">
        <div class="header-box ">
            <h2 class="text-white pt-2 ps-3 h4 pb-1">Kartu Member</h2>
        </div>
        <div class="logo-wrapper d-flex">
            <img src="<?= base_url("/assets/images/invoice_banner/$store->invoice_banner") ?>" height="50px" height="50px" alt="Logo">
            <div class="ms-auto mt-2" style="width: 60%">
                <div class="d-flex flex-column">
                    <div class="info">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?= $store->address ?></span>
                    </div>
                    <div class="info d-flex">
                        <div class="one me-2">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?= $store->phone_number ?></span>
                        </div>
                        <!-- <div class="">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>-</span>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="content  customer-box">
            <div class="d-flex ms-3 flex-column mt-3">
                <h2>Nama: <?= $customer->name ?></h2>
                <h2>Alamat: <?= $customer->address ?></h2>
            </div>
        </div>
        <div class="description-box p-2">
            <h2 class="h5 text-primary">Harap bawa kartu ini saat melakukan transaksi di Optik AVIVA.</h2>
            <h2 class="h5 text-primary">Kartu hanya berlaku untuk nama yang Tercantum di dalam kartu ini.</h2>
        </div>
    </div>
</body>

</html>