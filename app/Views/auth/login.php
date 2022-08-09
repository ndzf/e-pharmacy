<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Custom Fonts -->
    <link rel="stylesheet" href="<?= base_url("/assets/css/inter.css")  ?>">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url("/assets/plugins/bootstrap/css/bootstrap.min.css")  ?>">
    <!-- Custom Style -->
    <link rel="stylesheet" href="<?= base_url("/assets/css/style.css")  ?>">
    <title>Login</title>
</head>
<body style="background-color: var(--app-background)">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-4 col-md-6 mt-4">
                <div class="card rounded-4 border-0 shadow">
                    <div class="card-body">
                        <form action="<?= site_url("/login")  ?>" method="post">
                            <div class="mb-3">
                                <label for="" class="col-form-label fw-500 text-gray-600 fs-6"><?= lang("User.username")  ?></label>
                                <input type="text" name="username" id="username" class="form-control solid">
                            </div>
                            <div class="mb-4">
                                <label for="" class="col-form-label fw-500 text-gray-600 fs-6"><?= lang("User.password")  ?></label>
                                <input type="password" name="password" id="password" class="form-control solid">
                            </div>
                            <div class="mb-3 d-flex">
                                <div class="ms-auto">
                                    <button class="btn btn-primary" type="submit">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>