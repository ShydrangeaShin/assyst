<?php
$row = $kecamatan ?? $data ?? [];
?>

<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white">

        <h4 class="fw-bold mb-0">

            Detail Kecamatan

        </h4>

    </div>

    <div class="card-body">

        <table class="table table-borderless">

            <tr>

                <th width="220">

                    ID Kecamatan

                </th>

                <td>

                    <?= htmlspecialchars($row['id_kecamatan'] ?? $row['id'] ?? '-') ?>

                </td>

            </tr>

            <tr>

                <th>

                    Provinsi

                </th>

                <td>

                    <?= htmlspecialchars($row['nama_provinsi'] ?? '-') ?>

                </td>

            </tr>

            <tr>

                <th>

                    Kota / Kabupaten

                </th>

                <td>

                    <?= htmlspecialchars($row['nama_kota'] ?? '-') ?>

                </td>

            </tr>

            <tr>

                <th>

                    Nama Kecamatan

                </th>

                <td>

                    <?= htmlspecialchars($row['nama_kecamatan'] ?? '-') ?>

                </td>

            </tr>

            <?php if(isset($row['total_desa'])): ?>

            <tr>

                <th>

                    Jumlah Desa/Kelurahan

                </th>

                <td>

                    <span class="badge bg-primary">

                        <?= htmlspecialchars($row['total_desa']) ?>

                    </span>

                </td>

            </tr>

            <?php endif; ?>

        </table>

    </div>

    <div class="card-footer bg-white text-end">

        <a
            href="?page=kecamatan"
            class="btn btn-secondary rounded-pill">

            <i class="bi bi-arrow-left"></i>

            Kembali

        </a>

    </div>

</div>
