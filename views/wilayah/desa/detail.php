<?php
$row = $desa ?? $data ?? [];
?>

<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white">

        <h4 class="fw-bold mb-0">

            Detail Desa / Kelurahan

        </h4>

    </div>

    <div class="card-body">

        <table class="table table-borderless">

            <tr>

                <th width="220">

                    ID Desa/Kelurahan

                </th>

                <td>

                    <?= htmlspecialchars($row['id_desa'] ?? $row['id'] ?? '-') ?>

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

                    Kecamatan

                </th>

                <td>

                    <?= htmlspecialchars($row['nama_kecamatan'] ?? '-') ?>

                </td>

            </tr>

            <tr>

                <th>

                    Jenis

                </th>

                <td>

                    <?= htmlspecialchars($row['jenis'] ?? '-') ?>

                </td>

            </tr>

            <tr>

                <th>

                    Nama Desa/Kelurahan

                </th>

                <td>

                    <?= htmlspecialchars($row['nama_desa'] ?? '-') ?>

                </td>

            </tr>

            <?php if(isset($row['total_keluarga'])): ?>

            <tr>

                <th>

                    Jumlah Keluarga

                </th>

                <td>

                    <span class="badge bg-primary">

                        <?= htmlspecialchars($row['total_keluarga']) ?>

                    </span>

                </td>

            </tr>

            <?php endif; ?>

        </table>

    </div>

    <div class="card-footer bg-white text-end">

        <a
            href="?page=desa"
            class="btn btn-secondary rounded-pill">

            <i class="bi bi-arrow-left"></i>

            Kembali

        </a>

    </div>

</div>
