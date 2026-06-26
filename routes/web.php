<?php

$page = $_GET['page'] ?? 'dashboard-publik';

require_once 'config/database.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/DashboardController.php';

$auth = new AuthController($conn);
$dashboard = new DashboardController($conn);


switch ($page) {

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    case 'login':

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $auth->login();
        }

        $page_title = 'Login';
        $content = 'views/auth/login.php';

        include 'views/layouts/guest.php';

    break;

    /*
    |--------------------------------------------------------------------------
    | FORBIDDEN
    |--------------------------------------------------------------------------
    */

    case 'forbidden':

        include 'views/auth/forbidden.php';

        break;

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */

    case 'dashboard-admin':

        onlyAdmin();

        $dashboard->admin();

        break;

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD PETUGAS
    |--------------------------------------------------------------------------
    */

    case 'dashboard-petugas':

        onlyPetugas();

        $dashboard->petugas();

        break;

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD PUBLIK
    |--------------------------------------------------------------------------
    */

    case 'dashboard-publik':

        $dashboard->publik();

        break;

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    case 'logout':

        $auth->logout();

        break;

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES  
|--------------------------------------------------------------------------
*/

    /*
    |--------------------------------------------------------------------------
    | PROVINSI
    |--------------------------------------------------------------------------
    */    
    
    case 'provinsi':
    onlyAdmin();

    require_once 'controllers/ProvinsiController.php';

    $controller = new ProvinsiController($conn);
    $controller->index();
    break;

    case 'provinsi-create':
        onlyAdmin();

        require_once 'controllers/ProvinsiController.php';

        $controller = new ProvinsiController($conn);
        $controller->create();
        break;

    case 'provinsi-store':
        onlyAdmin();

        require_once 'controllers/ProvinsiController.php';

        $controller = new ProvinsiController($conn);
        $controller->store();
        break;

    case 'provinsi-edit':
        onlyAdmin();

        require_once 'controllers/ProvinsiController.php';

        $controller = new ProvinsiController($conn);
        $controller->edit();
        break;

    case 'provinsi-update':
        onlyAdmin();

        require_once 'controllers/ProvinsiController.php';

        $controller = new ProvinsiController($conn);
        $controller->update();
        break;

    case 'provinsi-delete':
        onlyAdmin();

        require_once 'controllers/ProvinsiController.php';

        $controller = new ProvinsiController($conn);
        $controller->delete();
        break;

    /*
    |--------------------------------------------------------------------------
    | DEFAULT
    |--------------------------------------------------------------------------
    */
    default:
        include 'views/auth/forbidden.php';
        break;
}