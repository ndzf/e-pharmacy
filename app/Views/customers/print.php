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

        @media print {
            #btn-print {
                display: none;
            }
        }

        .qr-code-wrapper {
            position: absolute;
            right: 9px;
            top: 5px;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        html {
            /* off-white, so body edge is visible in browser */
            background: #eee;
            font-size: 8px;
        }

        .h7 {
            font-size: 1rem;
        }

        .h8 {
            font-size: 1rem;
        }

        body {
            height: 9cm;
            width: 6cm;
            background-color: inherit;
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
            background-position-x: center;
            background-position-y: center;
            background-size: cover;
            background-repeat: no-repeat;
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
            width: 100%;
        }

        .description-box {
            background-color: var(--surface);
            position: absolute;
            bottom: 0;
            width: 70%;
            height: 6.5rem;
        }

        .info span {
            font-weight: bold;
        }
    </style>
</head>

<body onload="">
    <div class="face face-front p-relative">
        <div class="header-box ">
            <h2 class="text-white pt-2 ps-3 h4 pb-1">Kartu Member</h2>
        </div>
        <div class="logo-wrapper d-flex">
            <img src="<?= base_url("/assets/images/invoice_banner/$store->invoice_banner") ?>" height="24px" height="24px" alt="Logo">
            <div class="ms-auto mt-2" style="width: 60%">
                <div class="d-flex flex-column">
                    <div class="info">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?= $store->address ?></span>
                    </div>
                    <div class="info d-flex">
                        <div class="one me-2">
                            <i class="fas fa-phone"></i>
                            <span><?= $store->phone_number ?></span>
                        </div>
                        <div class="">
                            <i class="fab fa-whatsapp"></i>
                            <span><?= $store->whatsapp_number ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content  customer-box">
            <div class="d-flex ms-3 flex-column mt-3">
                <h2 class="h7">No. ID: <?= $customer->code ?></h2>
                <h2 class="h7">Nama: <?= $customer->name ?></h2>
                <h2 class="h7">Alamat: <?= $customer->address ?></h2>

            </div>
            <div class="qr-code-wrapper">
                <img src="<?= $qrCode ?>" alt="qr-code">
            </div>
        </div>
        <div class="description-box p-2">
            <h2 class="h8 text-primary">Harap bawa kartu ini saat melakukan transaksi di Optik AVIVA.</h2>
            <h2 class="h8 text-primary">Kartu hanya berlaku untuk nama yang Tercantum di dalam kartu ini.</h2>
        </div>
    </div>
    <button class="btn btn-primary mt-3" id="btn-print" onclick="window.print()">Print</button>
</body>

</html>