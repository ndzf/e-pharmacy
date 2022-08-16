<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

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
            height: 210mm;
            width: 148.5mm;
            font-family: sans-serif;
            margin: 0;
            font-family: "Roboto", sans-serif;

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
        }

        /* the front face */
        .face-front {
            background: #fff;
            background-color: black;
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

        .face-front {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        h1 {
            font-size: 2rem;
            font-weight: 500;
        }

        h3 {
            font-size: 1.3rem;
        }

        .text-color {
            color: <?= $store->text_color ?>;
        }
    </style>
</head>

<body>
    <div class="face face-front d-flex flex-column" style="background-image: url(<?= site_url("/assets/print-customer/$store->banner") ?>) !important; background-position: center; background-size: cover;">
        <div class="top p-2 text-white d-flex flex-grow-1 flex-column justify-content-center border">
            <h1 class="fw-normal text-color"><?= $store->name ?></h1>
            <h3 class="text-color"><?= $customer->name ?></h3>
        </div>
    </div>
</body>

</html>