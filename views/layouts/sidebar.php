<?php

$role = $_SESSION['user']['role'] ?? '';

$currentPage = $_GET['page'] ?? '';

?>

<aside class="sidebar p-2 sticky-top bg-primary">

    <div class="sidebar-brand text-center mb-2">

        <h4 class="fw-bold text-white mb-1">
            AsSyst
        </h4>

        <small class="text-white-50">
            Assistance System
        </small>

    </div>

    <ul class="nav flex-column sidebar-menu">

        <li class="nav-item mb-1">

            <a class="nav-link <?= str_contains($currentPage,'dashboard') ? 'active' : '' ?>"
               href="?page=dashboard">

                <i class="bi bi-speedometer2"></i>

                Dashboard

            </a>

        </li>

        <?php if ($role == 'Admin') : ?>

            <!-- WILAYAH -->

            <li class="menu-title">
                Master Wilayah
            </li>

            <li class="nav-item mb-1">
                <a class="nav-link <?= ($currentPage=='provinsi' || $currentPage=='provinsi-create' || $currentPage=='provinsi-edit') ? 'active' : '' ?>"href="?page=provinsi">
                    <i class="bi bi-map"></i>
                    Provinsi
                </a>
            </li>

            <li class="nav-item mb-1"> 
                <a class="nav-link <?= ($currentPage=='kota' || $currentPage=='kota-create' || $currentPage=='kota-edit') ? 'active' : '' ?>" href="?page=kota">
                    <i class="bi bi-building"></i>
                    Kota/Kabupaten
                </a>
            </li>

            <li class="nav-item mb-1">
                <a class="nav-link <?= $currentPage=='kecamatan' ? 'active' : '' ?>" href="?page=kecamatan">
                    <i class="bi bi-geo"></i>
                    Kecamatan
                </a>
            </li>

            <li class="nav-item mb-1">
                <a class="nav-link <?= $currentPage=='desa' ? 'active' : '' ?>" href="?page=desa">
                    <i class="bi bi-pin-map"></i>
                    Desa/Kelurahan
                </a>
            </li>

            <!-- AKUN -->

            <li class="menu-title">
                Pengguna
            </li>

            <li class="nav-item mb-1">
                <a class="nav-link <?= $currentPage=='akun' ? 'active' : '' ?>" href="?page=akun">
                    <i class="bi bi-people"></i>
                    Manajemen Akun
                </a>
            </li>

            <li class="nav-item mb-1">
                <a class="nav-link <?= $currentPage=='tugas' ? 'active' : '' ?>" href="?page=tugas">
                    <i class="bi bi-clipboard-check"></i>
                    Tugas Petugas
                </a>
            </li>

            <li class="nav-item mb-1">
                <a class="nav-link <?= $currentPage=='laporan' ? 'active' : '' ?>" href="?page=laporan">
                    <i class="bi bi-file-earmark-text"></i>
                    Laporan
                </a>
            </li>

            <li class="nav-item mb-1">
                <a class="nav-link <?= $currentPage=='log' ? 'active' : '' ?>" href="?page=log">
                    <i class="bi bi-clock-history"></i>
                    Log Aktivitas
                </a>
            </li>

        <?php endif; ?>

        <?php if ($role == 'Petugas') : ?>

            <li class="menu-title">
                Pendataan
            </li>

            <li class="nav-item mb-1">
                <a class="nav-link <?= $currentPage=='keluarga' ? 'active' : '' ?>" href="?page=keluarga">
                    <i class="bi bi-house"></i>
                    Data Keluarga
                </a>
            </li>

            <li class="nav-item mb-1">
                <a class="nav-link <?= $currentPage=='kondisi' ? 'active' : '' ?>" href="?page=kondisi">
                    <i class="bi bi-card-checklist"></i>
                    Kondisi Sosial
                </a>
            </li>

            <li class="nav-item mb-1">
                <a class="nav-link <?= $currentPage=='verifikasi' ? 'active' : '' ?>" href="?page=verifikasi">
                    <i class="bi bi-patch-check"></i>
                    Verifikasi
                </a>
            </li>

            <li class="nav-item mb-1">
                <a class="nav-link <?= $currentPage=='penalaran' ? 'active' : '' ?>" href="?page=penalaran">
                    <i class="bi bi-diagram-3"></i>
                    Hasil Penalaran
                </a>
            </li>

            <li class="nav-item mb-1">
                <a class="nav-link <?= $currentPage=='tugas' ? 'active' : '' ?>" href="?page=tugas">
                    <i class="bi bi-list-task"></i>
                    Tugas Saya
                </a>
            </li>

        <?php endif; ?>

        <li class="menu-title">
            Logout
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?page=logout">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
        </li>

        <li class="menu-title">
            <div>© <?= date('Y') ?>AsSyst</div>
        </li>


    </ul>
</aside>
