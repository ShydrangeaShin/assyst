<?php

$role = $_SESSION['user']['role'] ?? '';

?>

<div class="sidebar" id="sidebar">

    <div class="sidebar-header">

        <h4>AsSyst</h4>

        <small>Assistance System</small>

    </div>

    <ul class="sidebar-menu">

        <!-- DASHBOARD -->

        <li>

            <a href="?page=dashboard">

                <i class="bi bi-speedometer2"></i>

                Dashboard

            </a>

        </li>

        <?php if ($role == 'Admin') : ?>

            <!-- WILAYAH -->

            <li class="menu-title">
                Master Wilayah
            </li>

            <li>
                <a href="?page=provinsi">
                    <i class="bi bi-map"></i>
                    Provinsi
                </a>
            </li>

            <li>
                <a href="?page=kota">
                    <i class="bi bi-building"></i>
                    Kota/Kabupaten
                </a>
            </li>

            <li>
                <a href="?page=kecamatan">
                    <i class="bi bi-geo"></i>
                    Kecamatan
                </a>
            </li>

            <li>
                <a href="?page=desa">
                    <i class="bi bi-pin-map"></i>
                    Desa/Kelurahan
                </a>
            </li>

            <!-- AKUN -->

            <li class="menu-title">
                Pengguna
            </li>

            <li>
                <a href="?page=akun">
                    <i class="bi bi-people"></i>
                    Manajemen Akun
                </a>
            </li>

            <li>
                <a href="?page=tugas">
                    <i class="bi bi-clipboard-check"></i>
                    Tugas Petugas
                </a>
            </li>

            <li>
                <a href="?page=laporan">
                    <i class="bi bi-file-earmark-text"></i>
                    Laporan
                </a>
            </li>

            <li>
                <a href="?page=log">
                    <i class="bi bi-clock-history"></i>
                    Log Aktivitas
                </a>
            </li>

        <?php endif; ?>

        <?php if ($role == 'Petugas') : ?>

            <li class="menu-title">
                Pendataan
            </li>

            <li>
                <a href="?page=keluarga">
                    <i class="bi bi-house"></i>
                    Data Keluarga
                </a>
            </li>

            <li>
                <a href="?page=kondisi">
                    <i class="bi bi-card-checklist"></i>
                    Kondisi Sosial
                </a>
            </li>

            <li>
                <a href="?page=verifikasi">
                    <i class="bi bi-patch-check"></i>
                    Verifikasi
                </a>
            </li>

            <li>
                <a href="?page=penalaran">
                    <i class="bi bi-diagram-3"></i>
                    Hasil Penalaran
                </a>
            </li>

            <li>
                <a href="?page=tugas">
                    <i class="bi bi-list-task"></i>
                    Tugas Saya
                </a>
            </li>

        <?php endif; ?>

    </ul>

</div>