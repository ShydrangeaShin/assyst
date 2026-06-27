<?php

$page = $_GET['page'] ?? 'dashboard-publik';

require_once 'config/database.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/ProvinsiController.php';
require_once 'controllers/KotaController.php';
require_once 'controllers/KecamatanController.php';
require_once 'controllers/DesaController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/TugasController.php';
require_once 'controllers/LaporanController.php';
require_once 'controllers/LogController.php';
require_once 'controllers/KeluargaController.php';
require_once 'controllers/KondisiController.php';
require_once 'controllers/VerifikasiController.php';

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
        
        include 'views/auth/login.php';


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

    case 'dashboard':

        if (!isset($_SESSION['user'])) {

            header("Location:?page=login");

            exit;
        }

        if ($_SESSION['user']['role'] == 'Admin') {

            $dashboard->admin();

        } elseif ($_SESSION['user']['role'] == 'Petugas') {

            $dashboard->petugas();

        }

    break;

    /*
    |--------------------------------------------------------------------------
    | PROVINSI
    |--------------------------------------------------------------------------
    */    
    
    case 'provinsi':
    onlyAdmin();

    $controller = new ProvinsiController($conn);
    $controller->index();
    break;

    // case 'provinsi-create':
    //     onlyAdmin();

    //     require_once 'controllers/ProvinsiController.php';

    //     $controller = new ProvinsiController($conn);
    //     $controller->create();
    //     break;

    case 'provinsi-store':
        onlyAdmin();

        require_once 'controllers/ProvinsiController.php';

        $controller = new ProvinsiController($conn);
        $controller->store();
        break;

    case 'provinsi-detail':
        onlyAdmin();

        require_once 'controllers/ProvinsiController.php';

        $controller = new ProvinsiController($conn);
        $controller->detail();
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
    | KOTA
    |--------------------------------------------------------------------------
    */           

    case 'kota':   

    onlyAdmin();

        $controller = new KotaController($conn);
        $controller->index();
        break;   

    case 'kota-store':

        onlyAdmin();

        $controller = new KotaController($conn);

        $controller->store();

    break;

    case 'kota-detail':

        onlyAdmin();

        $controller = new KotaController($conn);

        $controller->detail($_GET['id']);

    break;

    case 'kota-edit':

        onlyAdmin();

        $controller = new KotaController($conn);

        $controller->edit($_GET['id']);

    break;

    case 'kota-update':

        onlyAdmin();

        $controller = new KotaController($conn);

        $controller->update();

    break;

    case 'kota-delete':

        onlyAdmin();

        $controller = new KotaController($conn);

        $controller->delete($_GET['id']);

    break;

    /*
    |--------------------------------------------------------------------------
    | KECAMATAN
    |--------------------------------------------------------------------------
    */

    case 'kecamatan':

        onlyAdmin();

        $controller = new KecamatanController($conn);

        $controller->index();

    break;

    case 'kecamatan-create':

        onlyAdmin();

        $controller = new KecamatanController($conn);

        $controller->create();

    break;

    case 'kecamatan-store':

        onlyAdmin();

        $controller = new KecamatanController($conn);

        $controller->store();

    break;

    case 'kecamatan-detail':

        onlyAdmin();

        $controller = new KecamatanController($conn);

        $controller->detail($_GET['id']);

    break;

    case 'kecamatan-edit':

        onlyAdmin();

        $controller = new KecamatanController($conn);

        $controller->edit($_GET['id']);

    break;

    case 'kecamatan-update':

        onlyAdmin();

        $controller = new KecamatanController($conn);

        $controller->update();

    break;

    case 'kecamatan-delete':

        onlyAdmin();

        $controller = new KecamatanController($conn);

        $controller->delete($_GET['id']);

    break;

    /*
    |--------------------------------------------------------------------------
    | DESA / KELURAHAN
    |--------------------------------------------------------------------------
    */

    case 'desa':

        onlyAdmin();

        $controller = new DesaController($conn);

        $controller->index();

    break;

    case 'desa-create':

        onlyAdmin();

        $controller = new DesaController($conn);

        $controller->create();

    break;

    case 'desa-store':

        onlyAdmin();

        $controller = new DesaController($conn);

        $controller->store();

    break;

    case 'desa-detail':

        onlyAdmin();

        $controller = new DesaController($conn);

        $controller->detail($_GET['id']);

    break;

    case 'desa-edit':

        onlyAdmin();

        $controller = new DesaController($conn);

        $controller->edit($_GET['id']);

    break;

    case 'desa-update':

        onlyAdmin();

        $controller = new DesaController($conn);

        $controller->update();

    break;

    case 'desa-delete':

        onlyAdmin();

        $controller = new DesaController($conn);

        $controller->delete($_GET['id']);

    break;
    
    /*
    |--------------------------------------------------------------------------
    | USER / MANAJEMEN AKUN
    |--------------------------------------------------------------------------
    */

    case 'user':
        onlyAdmin();
        $controller = new UserController($conn);
        $controller->index();
        break;

    case 'user-store':
        onlyAdmin();
        $controller = new UserController($conn);
        $controller->store();
        break;

    case 'user-edit':
        onlyAdmin();
        $controller = new UserController($conn);
        $controller->edit($_GET['id']);
        break;

    case 'user-update':
        onlyAdmin();
        $controller = new UserController($conn);
        $controller->update();
        break;

    case 'user-delete':
        onlyAdmin();
        $controller = new UserController($conn);
        $controller->delete($_GET['id']);
        break;

    /*
    |--------------------------------------------------------------------------
    | TUGAS / MANAJEMEN PEKERJAAN
    |--------------------------------------------------------------------------
    */
    case 'tugas':
        if (!isset($_SESSION['user'])) { header("Location:?page=login"); exit; }
        $controller = new TugasController($conn);
        $controller->index();
        break;

    case 'tugas-store':
        onlyAdmin(); // Hanya admin yang boleh menambah tugas
        $controller = new TugasController($conn);
        $controller->store();
        break;

    case 'tugas-edit':
        if (!isset($_SESSION['user'])) { header("Location:?page=login"); exit; }
        $controller = new TugasController($conn);
        $controller->edit($_GET['id']);
        break;

    case 'tugas-update':
        if (!isset($_SESSION['user'])) { header("Location:?page=login"); exit; }
        $controller = new TugasController($conn);
        $controller->update();
        break;

    case 'tugas-delete':
        onlyAdmin(); // Hanya admin yang boleh menghapus
        $controller = new TugasController($conn);
        $controller->delete($_GET['id']);
        break;

    /*
    |--------------------------------------------------------------------------
    | LAPORAN / REPORTING
    |--------------------------------------------------------------------------
    */
    case 'laporan':
        if (!isset($_SESSION['user'])) { header("Location:?page=login"); exit; }
        $controller = new LaporanController($conn);
        $controller->index();
        break;


    /*
    |--------------------------------------------------------------------------
    | LOG AKTIVITAS / SYSTEM AUDIT
    |--------------------------------------------------------------------------
    */
    case 'log':
        onlyAdmin(); // Pastikan fungsi helper ini sudah ada, atau ganti dengan validasi session admin
        $controller = new LogController($conn);
        $controller->index();
        break;

/*
    |--------------------------------------------------------------------------
    | VERIFIKASI & PENALARAN (KHUSUS ADMIN)
    |--------------------------------------------------------------------------
    */
    case 'verifikasi':
        onlyAdmin();
        $controller = new VerifikasiController($conn);
        $controller->index();
        break;

    case 'verifikasi-detail':
        onlyAdmin();
        $controller = new VerifikasiController($conn);
        $controller->detail($_GET['id']);
        break;

    case 'verifikasi-update':
        onlyAdmin();
        $controller = new VerifikasiController($conn);
        $controller->update();
        break;
        
    // PETUGAS ROUTES

    /*
    |--------------------------------------------------------------------------
    | MANAJEMEN DATA KELUARGA
    |--------------------------------------------------------------------------
    */
    case 'keluarga':
        if (!isset($_SESSION['user'])) { header("Location:?page=login"); exit; }
        $controller = new KeluargaController($conn);
        $controller->index();
        break;

    case 'keluarga-store':
        if (!isset($_SESSION['user'])) { header("Location:?page=login"); exit; }
        $controller = new KeluargaController($conn);
        $controller->store();
        break;

    case 'keluarga-detail':
        if (!isset($_SESSION['user'])) { header("Location:?page=login"); exit; }
        $controller = new KeluargaController($conn);
        $controller->detail($_GET['id']);
        break;

    case 'keluarga-edit':
        if (!isset($_SESSION['user'])) { header("Location:?page=login"); exit; }
        $controller = new KeluargaController($conn);
        $controller->edit($_GET['id']);
        break;

    case 'keluarga-update':
        if (!isset($_SESSION['user'])) { header("Location:?page=login"); exit; }
        $controller = new KeluargaController($conn);
        $controller->update();
        break;

    case 'keluarga-delete':
        if (!isset($_SESSION['user'])) { header("Location:?page=login"); exit; }
        $controller = new KeluargaController($conn);
        $controller->delete($_GET['id']);
        break;
    
    /*
    |--------------------------------------------------------------------------
    | MANAJEMEN KONDISI SOSIAL KELUARGA
    |--------------------------------------------------------------------------
    */
    case 'kondisi':
        if (!isset($_SESSION['user'])) { header("Location:?page=login"); exit; }
        $controller = new KondisiController($conn);
        $controller->index();
        break;

    case 'kondisi-edit':
        if (!isset($_SESSION['user'])) { header("Location:?page=login"); exit; }
        $controller = new KondisiController($conn);
        $controller->edit($_GET['id']);
        break;

    case 'kondisi-update':
        if (!isset($_SESSION['user'])) { header("Location:?page=login"); exit; }
        $controller = new KondisiController($conn);
        $controller->update();
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
