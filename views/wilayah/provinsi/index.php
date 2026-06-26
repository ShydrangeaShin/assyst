<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white border-0 py-3">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h4 class="fw-bold mb-1">
                    Data Provinsi
                </h4>

                <small class="text-muted">
                    Manajemen data provinsi di dalam sistem.
                </small>

            </div>

            <button
            class="btn btn-primary rounded-pill"
            data-bs-toggle="modal"
            data-bs-target="#modalTambah">

            <i class="bi bi-plus-circle me-1"></i>

            Tambah Provinsi

            </button>

        </div>

    </div>

    <div class="card-body">

        <form method="GET" class="row mb-4">
            <input type="hidden" name="page" value="provinsi">

            <div class="col-md-5">
                <div class="input-group">

                    <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                    </span>

                        <input type="text" name="search" class="form-control" placeholder="Cari nama provinsi..." value="<?= $_GET['search'] ?? '' ?>">

                            <button class="btn btn-primary" type="submit">
                                Cari
                            </button>

                            <?php if(isset($_GET['search'])): ?>
                                <a
                                    href="?page=provinsi"
                                    class="btn btn-outline-secondary">
                                    Reset
                                </a>
                            <?php endif; ?>
                </div>

        </form>
    </div>

        <div class="table-responsive">

            <table class="table align-middle table-hover">

                <thead class="table-light">

                    <tr>

                        <th width="70">No</th>

                        <th>Nama Provinsi</th>

                        <th width="260" class="text-center">

                            Aksi

                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php if(empty($provinsi)): ?>

                    <tr>

                        <td colspan="3"
                            class="text-center text-muted py-4">

                            Belum ada data provinsi.

                        </td>

                    </tr>

                <?php else: ?>

                    <?php $no=1; ?>

                    <?php foreach($provinsi as $row): ?>

                    <tr>

                        <td><?= $no++ ?></td>

                        <td>

                            <span class="fw-semibold">

                                <?= htmlspecialchars($row['nama_provinsi']) ?>

                            </span>

                        </td>

                        <td class="text-center ">

                            <a
                                href="?page=provinsi-detail&id=<?= $row['id_provinsi'] ?>"
                                class="btn btn-sm btn-outline-info rounded-pill me-2">

                                <i class="bi bi-eye"></i>
                            </a>

                            <a
                                href="?page=provinsi-edit&id=<?= $row['id_provinsi'] ?>"
                                class="btn btn-sm btn-outline-warning rounded-pill me-2">

                                <i class="bi bi-pencil"></i>
                            </a>


                            <a
                                href="?page=provinsi-delete&id=<?= $row['id_provinsi'] ?>"
                                class="btn btn-sm btn-outline-danger rounded-pill me-2">

                                <i class="bi bi-trash"></i>
                            </a>


                        </td>

                    </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>


<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4">
            <div class="modal-header">

            <h5 class="modal-title">Tambah Provinsi</h5>

            <button class="btn-close" data-bs-dismiss="modal"> </button>
            </div>

            <form method="POST" action="?page=provinsi-store">
                
            <div class="modal-body">

                <label class="form-label">Nama Provinsi</label>

                <input type="text" name="nama_provinsi" class="form-control" required>

            </div>

            <div class="modal-footer">

            <button type="button" class="btn btn-light" data-bs-dismiss="modal"> Batal </button>

            <button class="btn btn-primary"> Simpan </button>

            </div>

        </form>

        </div>
    </div>
</div>