<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ["filter" => "isLoggedIn:admin,cashier"]);
$routes->get("/logout", "AuthController::logout");


$routes->group("/login", function ($routes) {

    $routes->get("/", "AuthController::login");
    $routes->post("/", "AuthController::attemptLogin");
});

$routes->group("/users", ["filter" => "isLoggedIn:admin"], function ($routes) {

    $routes->get("/", "UserController::index");
    $routes->post("/", "UserController::create");
    $routes->get("(:num)/edit", "UserController::edit/$1");
    $routes->put("(:num)", "UserController::update/$1");
    $routes->delete("(:num)", "UserController::delete/$1");
});

$routes->group("/categories", function ($routes) {

    $routes->get("/", "CategoryController::index", ["filter" => "isLoggedIn:admin,cashier"]);
    $routes->post("/", "CategoryController::create", ["filter" => "isLoggedIn:admin"]);
    $routes->put("(:num)", "CategoryController::update/$1", ["filter" => "isLoggedIn:admin"]);
    $routes->get("(:num)/edit", "CategoryController::edit/$1", ["filter" => "isLoggedIn:admin"]);
    $routes->delete("(:num)", "CategoryController::delete/$1", ["filter" => "isLoggedIn:admin"]);
});

$routes->group("/suppliers", function ($routes) {

    $routes->get("/", "SupplierController::index", ["filter" => "isLoggedIn:admin,cashier"]);
    $routes->post("/", "SupplierController::create", ["filter" => "isLoggedIn:admin"]);
    $routes->get("(:num)/edit", "SupplierController::edit/$1", ["filter" => "isLoggedIn:admin"]);
    $routes->put("(:num)", "SupplierController::update/$1", ["filter" => "isLoggedIn:admin"]);
    $routes->delete("(:num)", "SupplierController::delete/$1", ["filter" => "isLoggedIn:admin"]);
});

$routes->group("/customers", function ($routes) {

    $routes->get("/", "CustomerController::index", ["filter" => "isLoggedIn:admin,cashier"]);
    $routes->get("(:num)/edit", "CustomerController::edit/$1", ["filter" => "isLoggedIn:admin"]);
    $routes->post("/", "CustomerController::create", ["filter" => "isLoggedIn:admin"]);
    $routes->put("(:num)", "CustomerController::update/$1", ["filter" => "isLoggedIn:admin"]);
    $routes->delete("(:num)", "CustomerController::delete/$1", ["filter" => "isLoggedIn:admin"]);
    $routes->get("(:num)/print", "CustomerController::print/$1", ["filter" => "isLoggedIn:admin,cashier"]);
});


$routes->group("/products", function ($routes) {

    $routes->get("/", "ProductController::index", ["filter" => "isLoggedIn:admin,cashier"]);
    $routes->get("new", "ProductController::create", ["filter" => "isLoggedIn:admin"]);
    $routes->post("/", "ProductController::store", ["filter" => "isLoggedIn:admin"]);
    $routes->get("(:num)/edit", "ProductController::edit/$1", ["filter" => "isLoggedIn:admin"]);
    $routes->get("(:num)/details", "ProductController::details/$1", ["filter" => "isLoggedIn:admin,cashier"]);
    $routes->put("(:num)", "ProductController::update/$1", ["filter" => "isLoggedIn:admin"]);
    $routes->delete("(:num)", "ProductController::delete/$1", ["filter" => "isLoggedIn:admin"]);
    $routes->get("search", "ProductController::search", ["filter" => "isLoggedIn:admin,cashier"]);
    $routes->post("print-barcode", "ProductController::printBarcode", ["filter" => "isLoggedIn:admin,cashier"]);
});

$routes->group("transactions", function ($routes) {

    $routes->get("/", "TransactionController::index", ["filter" => "isLoggedIn:admin,cashier"]);
    $routes->post("/", "TransactionController::store");
    $routes->get("create", "TransactionController::create", ["filter" => "transaction:admin,cashier"]);
    $routes->get("check-current-transaction", "TransactionController::checkCurrentTransaction");
    // FIXME: change destroy to DELETE HTTP Method
    $routes->get("destroy", "TransactionController::destroy", ["filter" => "transaction:admin,cashier"]);
    $routes->get("(:num)", "TransactionController::show/$1", ["filter" => "isLoggedIn:admin,cashier"]);
    $routes->get("(:num)/print", "TransactionController::print/$1", ["filter" => "isLoggedIn:admin,cashier"]);
    $routes->put("(:num)/checkout", "TransactionController::checkout/$1", ["filter" => "transaction:admin,cashier"]);
    $routes->get("(:num)/payments", "TransactionController::payments/$1", ["filter" => "isLoggedIn:admin,cashier"]);
    $routes->delete("(:num)", "TransactionController::delete/$1", ["filter" => "isLoggedIn:admin,cashier"]);
});

$routes->group("transaction-details", function ($routes) {
    $routes->post("/", "TransactionDetailController::create", ["filter" => "transaction:admin,cashier"]);
    $routes->delete("(:num)", "TransactionDetailController::delete/$1", ["filter" => "transaction:admin,cashier"]);
    $routes->get("(:num)", "TransactionDetailController::show/$1", ["filter" => "transaction:admin,cashier"]);
});

$routes->group("transaction-payments", function ($routes) {

    $routes->post("/", "TransactionPaymentController::create", ["filter" => "isLoggedIn:admin,cashier"]);
});

$routes->group("purchases", function ($routes) {
    $routes->get("/", "PurchaseController::index", ["filter" => "isLoggedIn:admin,cashier"]);
    $routes->post("/", "PurchaseController::store", ["filter" => "isLoggedIn:admin,cashier"]);
    $routes->put("(:num)/checkout", "PurchaseController::checkout/$1", ["filter" => "purchase:admin,cashier"]);
    $routes->get("create", "PurchaseController::create", ["filter" => "purchase:admin,cashier"]);
    $routes->get("clear", "PurchaseController::clear", ["filter" => "isLoggedIn:admin,cashier"]);
    $routes->delete("(:num)", "PurchaseController::destroy/$1", ["filter" => "purchase:admin,cashier"]);
    $routes->get("(:num)", "PurchaseController::show/$1", ["filter" => "isLoggedIn:admin,cashier"]);
    $routes->get("(:num)/payments", "PurchaseController::payments/$1", ["filter" => "isLoggedIn:admin,casher"]);
    $routes->delete("(:num)/destroy", "PurchaseController::delete/$1", ["filter" => "isLoggedIn:admin,cashier"]);
});

$routes->group("purchase-details", function ($routes) {
    $routes->post("/", "PurchaseDetailController::create", ["filter" => "purchase:admin,cashier"]);
    $routes->delete("(:num)", "PurchaseDetailController::delete/$1", ["filter" => "purchase:admin,cashier"]);
    $routes->get("(:num)", "PurchaseDetailController::show/$1", ["filter" => "purchase:admin,cashier"]);
});

$routes->group("purchase-payments", function ($routes) {
    $routes->post("/", "PurchasePaymentController::create", ["filter" => "isLoggedIn:admin,cashier"]);
});

$routes->group("profile", function ($routes) {
    $routes->get("/", "ProfileController::index", ["filter" => "isLoggedIn:admin,cashier"]);
    $routes->put("(:num)", "ProfileController::update/$1", ["filter" => "isLoggedIn:admin,cashier"]);
});

$routes->group("store", function ($routes) {
    $routes->get("/", "StoreController::index", ["filter" => "isLoggedIn:admin"]);
    $routes->put("(:num)", "StoreController::update/$1", ["filter" => "isLoggedIn:admin"]);
    $routes->put("print", "StoreController::print_customer", ["filter" => "isLoggedIn:admin"]);
    $routes->put("invoice-setting", "StoreController::invoiceSetting", ["filter" => "isLoggedIn:admin"]);
});

$routes->group("reports", function ($routes) {
    $routes->get("omzet", "ReportController::omzet", ["filter" => "isLoggedIn:admin"]);
    $routes->post("export-omzet", "ReportController::attemptExportOmzet", ["filter" => "isLoggedIn:admin"]);
});

$routes->group("customer-card-setting", ["filter" => "isLoggedIn:admin"], function ($routes) {
    $routes->get("/", "CustomerCardSettingController::index");
    $routes->put("(:num)", "CustomerCardSettingController::update/$1");
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
