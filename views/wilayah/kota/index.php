<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white border-0 py-3">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h4 class="fw-bold mb-1">

                    Data Kota / Kabupaten

                </h4>

                <small class="text-muted">

                    Manajemen data Kota/Kabupaten berdasarkan Provinsi.

                </small>

            </div>

            <button
                class="btn btn-primary rounded-pill"
                data-bs-toggle="modal"
                data-bs-target="#modalTambah">

                <i class="bi bi-plus-circle me-1"></i>

                Tambah Kota

            </button>

        </div>

    </div>

    <div class="card-body">

        <form method="GET" class="mb-4">

            <input
                type="hidden"
                name="page"
                value="kota">

            <div class="row">

                <div class="col-md-5">

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="bi bi-search"></i>

                        </span>

                        <input
                            type="text"
                            class="form-control"
                            name="search"
                            placeholder="Cari kota..."
                            value="<?= $_GET['search'] ?? '' ?>">

                        <button
                            class="btn btn-primary">

                            Cari

                        </button>

                    </div>

                </div>

            </div>

        </form>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="70">No</th>

                        <th>Provinsi</th>

                        <th>Kota / Kabupaten</th>

                        <th width="200" class="text-center">

                            Aksi

                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php if(empty($kota)): ?>

                    <tr>

                        <td colspan="4"
                            class="text-center py-4 text-muted">

                            Belum ada data.

                        </td>

                    </tr>

                <?php else: ?>

                    <?php $no=1; ?>

                    <?php foreach($kota as $row): ?>

                    <tr>

                        <td><?= $no++ ?></td>

                        <td>

                            <?= htmlspecialchars($row['nama_provinsi']) ?>

                        </td>

                        <td>

                            <span class="fw-semibold">

                                <?= htmlspecialchars($row['nama_kota']) ?>

                            </span>

                            <?php if(!$row['can_delete']): ?>

                                <span class="badge bg-warning text-dark ms-2">

                                    Digunakan

                                </span>

                            <?php endif; ?>

                        </td>

                        <td class="text-center">

                            <a
                                href="?page=kota-detail&id=<?= $row['id_kota'] ?>"
                                class="btn btn-sm btn-outline-info rounded-pill">

                                <i class="bi bi-eye"></i>

                            </a>

                            <a
                                href="?page=kota-edit&id=<?= $row['id_kota'] ?>"
                                class="btn btn-sm btn-outline-warning rounded-pill">

                                <i class="bi bi-pencil"></i>

                            </a>

                            <?php if($row['can_delete']): ?>

                                <a
                                    href="?page=kota-delete&id=<?= $row['id_kota'] ?>"
                                    onclick="return confirm('Hapus data kota ini?')"
                                    class="btn btn-sm btn-outline-danger rounded-pill">

                                    <i class="bi bi-trash"></i>

                                </a>

                            <?php else: ?>

                                <button
                                    class="btn btn-sm btn-outline-secondary rounded-pill"
                                    disabled>

                                    <i class="bi bi-lock-fill"></i>

                                </button>

                            <?php endif; ?>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<div class="modal fade" id="modalTambah">

    <div class="modal-dialog">

        <div class="modal-content rounded-4">

            <div class="modal-header">

                <h5 class="modal-title"> Tambah Kota / Kabupaten </h5>
                <button class="btn-close" data-bs-dismiss="modal"> </button>

            </div>

            <form method="POST" action="?page=kota-store">

        <div class="modal-body">
            <div class="mb-3">

                <label class="form-label"> Provinsi </label>
                <select name="id_provinsi" class="form-select" required>

                <option value="">-- Pilih Provinsi --</option>

                <?php foreach($provinsi as $p): ?>

                <option value="<?= $p['id_provinsi'] ?>">

                <?= $p['nama_provinsi'] ?>

                </option>
                <?php endforeach; ?>
                </select>

            </div>

            <div class="mb-3">

                <label class="form-label"> Nama Kota / Kabupaten </label>

                <input type="text" name="nama_kota" class="form-control" required>

            </div>
        </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-light" data-bs-dismiss="modal"> Batal </button>
                <button class="btn btn-primary"> Simpan </button>

            </div>

        </form>

        </div>

    </div>

</div>