<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3>Data Desa / Kelurahan</h3>
        <p class="text-muted">
            Manajemen data desa dan kelurahan.
        </p>
    </div>

    <a href="?page=desa-create" class="btn btn-primary">

        <i class="bi bi-plus-circle"></i>

        Tambah Desa

    </a>

</div>

<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Provinsi</th>
                        <th>Kota</th>
                        <th>Kecamatan</th>
                        <th>Desa</th>
                        <th width="220">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    <?php $no=1; ?>

                    <?php foreach($data as $row): ?>

                    <tr>

                        <td><?= $no++ ?></td>

                        <td><?= $row['nama_provinsi'] ?></td>

                        <td><?= $row['nama_kota'] ?></td>

                        <td><?= $row['nama_kecamatan'] ?></td>

                        <td><?= $row['nama_desa'] ?></td>

                        <td>

                            <a
                            href="?page=desa-detail&id=<?= $row['id'] ?>"
                            class="btn btn-sm btn-info">

                                Detail

                            </a>

                            <a
                            href="?page=desa-edit&id=<?= $row['id'] ?>"
                            class="btn btn-sm btn-warning">

                                Edit

                            </a>

                            <a
                            href="?page=desa-delete&id=<?= $row['id'] ?>"
                            class="btn btn-sm btn-danger">

                                Hapus

                            </a>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>