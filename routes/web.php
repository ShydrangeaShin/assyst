<?php

$page = $_GET['page'] ?? 'dashboard-publik';

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

    if($_SERVER['REQUEST_METHOD']
       == 'POST')
    {
        $auth->login();
    }

    $page_title = 'Login';

    $content =
    'views/auth/login.php';

    include
    'views/layouts/guest.php';

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
    | DEFAULT
    |--------------------------------------------------------------------------
    */

    default:

        include
        'views/auth/forbidden.php';

        break;
}