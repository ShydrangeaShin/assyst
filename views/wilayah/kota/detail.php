<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white">

        <h4 class="fw-bold mb-0">

            Detail Provinsi

        </h4>

    </div>

    <div class="card-body">

        <table class="table table-borderless">

            <tr>

                <th width="220">

                    ID Kota/Kabupaten

                </th>

                <td>

                    <?= $kota['id_kota']; ?>

                </td>

            </tr>

            <tr>

                <th>

                    Nama Kota/Kabupaten

                </th>

                <td>

                    <?= htmlspecialchars($kota['nama_kota']); ?>

                </td>

            </tr>

            <tr>

                <th>

                    Jumlah Kecamatan

                </th>

                <td>

                    <span class="badge bg-primary">

                        <?= $kota['total_kecamatan']; ?>

                    </span>

                </td>

            </tr>

        </table>

    </div>

    <div class="card-footer bg-white text-end">

        <a
            href="?page=kota"
            class="btn btn-secondary rounded-pill">

            <i class="bi bi-arrow-left"></i>

            Kembali

        </a>

    </div>

</div>