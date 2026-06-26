<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3>Data Kota / Kabupaten</h3>
        <p class="text-muted">Manajemen data kota dan kabupaten.</p>
    </div>

    <a href="?page=kota-create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i>
        Tambah Kota
    </a>

</div>

<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Provinsi</th>
                        <th>Nama Kota</th>
                        <th width="200">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    <?php $no=1; foreach($data as $row): ?>

                    <tr>

                        <td><?= $no++ ?></td>

                        <td><?= $row['nama_provinsi'] ?></td>

                        <td><?= $row['nama_kota'] ?></td>

                        <td>

                            <a href="?page=kota-detail&id=<?= $row['id'] ?>"
                               class="btn btn-sm btn-info">

                                Detail

                            </a>

                            <a href="?page=kota-edit&id=<?= $row['id'] ?>"
                               class="btn btn-sm btn-warning">

                                Edit

                            </a>

                            <a href="?page=kota-delete&id=<?= $row['id'] ?>"
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