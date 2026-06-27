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

                    ID Provinsi

                </th>

                <td>

                    <?= $provinsi['id_provinsi']; ?>

                </td>

            </tr>

            <tr>

                <th>

                    Nama Provinsi

                </th>

                <td>

                    <?= htmlspecialchars($provinsi['nama_provinsi']); ?>

                </td>

            </tr>

            <tr>

                <th>

                    Jumlah Kota/Kabupaten

                </th>

                <td>

                    <span class="badge bg-primary">

                        <?= $provinsi['total_kota']; ?>

                    </span>

                </td>

            </tr>

        </table>

    </div>

    <div class="card-footer bg-white text-end">

        <a
            href="?page=provinsi"
            class="btn btn-secondary rounded-pill">

            <i class="bi bi-arrow-left"></i>

            Kembali

        </a>

    </div>

</div>