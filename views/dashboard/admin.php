<h3 class="mb-4">Dashboard Admin</h3>

<?php require_once 'views/layouts/breadcrumb.php'; ?>

<div class="row g-4">

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Wilayah</h6>
                <h2><?= $totalWilayah ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Petugas</h6>
                <h2><?= $totalPetugas ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Layak</h6>
                <h2><?= $totalLayak ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Verifikasi</h6>
                <h2><?= $totalVerifikasi ?></h2>
            </div>
        </div>
    </div>

</div>

<div class="card mt-4">
    <div class="card-body">
        <canvas id="statusChart"></canvas>
    </div>
</div>