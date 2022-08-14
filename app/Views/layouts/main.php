<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Custom Fonts -->
    <link rel="stylesheet" href="<?= base_url("/assets/css/inter.css")  ?>">
    <link rel="stylesheet" href="<?= base_url("/assets/plugins/fontawesome-free/css/all.min.css")  ?>">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url("/assets/plugins/bootstrap/css/bootstrap.min.css")  ?>">
    <?= $this->renderSection("style")  ?>
    <!-- Custom Style -->
    <link rel="stylesheet" href="<?= base_url("/assets/css/style.css")  ?>">
    <title><?= $title ?? config("App")->appName ?></title>
</head>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
            </a>

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url("") ?>" title="Dashboard">
                    <i class="fas fa-fire me-2"></i>
                    <span>Dashboard</span></a>
            </li>
            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url("categories") ?>" title="<?= lang("Category.title.index") ?>">
                    <i class="fas fa-tag me-2"></i>
                    <span>Kategori</span></a>
            </li>

            <li class="nav-item">
                <a href="<?= site_url("suppliers") ?>" class="nav-link" title="<?= lang("Supplier.title.index") ?>">
                    <i class="fas fa-truck-ramp-box me-2"></i>
                    <span>Supplier</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= site_url("products") ?>" title="<?= lang("Product.title.index") ?>">
                    <i class="fas fa-boxes me-1"></i>
                    <span>Produk</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= site_url("transactions") ?>" title="Data Penjualan">
                    <i class="fas fa-table me-2"></i>
                    <span>Penjualan</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= site_url("purchases") ?>" title="Data Pembelian">
                    <i class="fas fa-table me-2"></i>
                    <span>Pembelian</span>
                </a>
            </li>
            <?php if (session("role") == "admin") : ?>
                <li class="nav-item">
                    <a href="<?= site_url("users") ?>" class="nav-link" title="<?= lang("User.title.index")  ?>">
                        <i class="fas fa-user me-2"></i>
                        <span><?= lang("User.title.index") ?></span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <a href="<?= site_url("customers") ?>" class="nav-link" title="<?= lang("Customer.title.index") ?>">
                    <i class="fas fa-address-card me-1"></i>
                    <span><?= lang("Customer.title.index") ?></span>
                </a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand-lg topbar bg-white mb-3 shadow-sm">
                    <div class="container-fluid">
                        <a href="javascript:void(0)" id="sidebar-toggle" class="text-danger me-2">
                            <i class="fas fa-bars"></i>
                        </a>
                        <a class="navbar-brand text-gray-700 fw-500" href="#"><?= ($title ?? config("App")->appName)  ?></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="ms-auto">

                        </div>
                    </div>
                </nav>

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <main>
                    <?= $this->renderSection("content")  ?>
                </main>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer mt-3">
                <div class="container-fluid">
                    <div class="d-flex flex-row p-2">
                        <div class="app-name my-auto fw-500 text-danger">Apotek</div>
                        <div class="copyright ms-auto fw-500 text-dark">
                            <span>Copyright <span class="text-danger">&copy;</span> <span id="copyright-year"></span></span>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- Scripts -->
    <script src="<?= base_url("/assets/plugins/bootstrap/js/bootstrap.bundle.min.js")  ?>"></script>
    <script>
        const sidebarToggle = document.getElementById("sidebar-toggle");
        sidebarToggle.addEventListener("click", function(e) {
            const body = document.querySelector("body");
            const sidebar = document.querySelector(".sidebar");
            if (body.classList.contains("sidebar-toggled")) {
                body.classList.remove("sidebar-toggled");
                sidebar.classList.remove("toggled");
            } else {
                body.classList.add("sidebar-toggled");
                sidebar.classList.add("toggled");
            }
        });

        const copyrightYear = document.querySelector("#copyright-year");
        const date = new Date;
        copyrightYear.textContent = date.getFullYear();

        const pathname = window.location.pathname.split("/")[1];
        const sidebarItems = document.querySelectorAll("li.nav-item a");
        for (sidebarItem of sidebarItems) {
            if (sidebarItem.href.split("/")[3] == pathname) {
                sidebarItem.parentNode.classList.toggle("active");
            }
        }
    </script>
    <!-- Custom script -->
    <?= $this->renderSection("script")  ?>
</body>

</html>