<h3 class="mb-4">

    Dashboard Petugas

</h3>

<?php require_once 'views/layouts/breadcrumb.php'; ?>

<div class="row g-4">

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Tugas Saya</h6>
                <h2><?= $totalTugas ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Selesai</h6>
                <h2><?= $totalSelesai ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6>Pending</h6>
                <h2><?= $totalPending ?></h2>
            </div>
        </div>
    </div>

</div>