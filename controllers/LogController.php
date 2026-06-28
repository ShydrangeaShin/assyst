<?php
require_once 'models/LogAktivitas.php';

class LogController
{
    private $logModel;

    public function __construct($db)
    {
        $this->logModel = new LogAktivitas($db);
    }

    public function index()
    {
        $page_title = "Log Aktivitas Sistem";
        $breadcrumbs = ["Sistem", "Log Aktivitas"];
        
        $search = $_GET['search'] ?? '';
        
        $logs = $this->logModel->getAllWithRelations($search);

        $content = "views/log/index.php";
        include "views/layouts/app.php";
    }
}