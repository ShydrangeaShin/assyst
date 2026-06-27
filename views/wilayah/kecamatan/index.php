<?php
$rows = $kecamatan ?? $data ?? [];
?>

<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white border-0 py-3">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h4 class="fw-bold mb-1">

                    Data Kecamatan

                </h4>

                <small class="text-muted">

                    Manajemen data kecamatan berdasarkan Kota/Kabupaten.

                </small>

            </div>

            <button
                class="btn btn-primary rounded-pill"
                data-bs-toggle="modal"
                data-bs-target="#modalTambah">

                <i class="bi bi-plus-circle me-1"></i>

                Tambah Kecamatan

            </button>

        </div>

    </div>

    <div class="card-body">

        <form method="GET" class="mb-4">

            <input
                type="hidden"
                name="page"
                value="kecamatan">

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
                            placeholder="Cari kecamatan..."
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

                        <button
                            class="btn btn-primary"
                            type="submit">

                            Cari

                        </button>

                        <?php if(isset($_GET['search'])): ?>

                            <a
                                href="?page=kecamatan"
                                class="btn btn-outline-secondary">

                                Reset

                            </a>

                        <?php endif; ?>

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

                        <th>Kecamatan</th>

                        <th width="200" class="text-center">

                            Aksi

                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php if(empty($rows)): ?>

                    <tr>

                        <td
                            colspan="5"
                            class="text-center py-4 text-muted">

                            Belum ada data kecamatan.

                        </td>

                    </tr>

                <?php else: ?>

                    <?php $no = 1; ?>

                    <?php foreach($rows as $row): ?>

                    <?php
                    $id = $row['id_kecamatan'] ?? $row['id'] ?? '';
                    $canDelete = $row['can_delete'] ?? true;
                    ?>

                    <tr>

                        <td><?= $no++ ?></td>

                        <td>

                            <?= htmlspecialchars($row['nama_provinsi'] ?? '-') ?>

                        </td>

                        <td>

                            <?= htmlspecialchars($row['nama_kota'] ?? '-') ?>

                        </td>

                        <td>

                            <span class="fw-semibold">

                                <?= htmlspecialchars($row['nama_kecamatan'] ?? '-') ?>

                            </span>

                            <?php if(!$canDelete): ?>

                                <span class="badge bg-warning text-dark ms-2">

                                    Digunakan

                                </span>

                            <?php endif; ?>

                        </td>

                        <td class="text-center">

                            <a
                                href="?page=kecamatan-detail&id=<?= $id ?>"
                                class="btn btn-sm btn-outline-info rounded-pill">

                                <i class="bi bi-eye"></i>

                            </a>

                            <a
                                href="?page=kecamatan-edit&id=<?= $id ?>"
                                class="btn btn-sm btn-outline-warning rounded-pill">

                                <i class="bi bi-pencil"></i>

                            </a>

                            <?php if($canDelete): ?>

                                <a
                                    href="?page=kecamatan-delete&id=<?= $id ?>"
                                    onclick="return confirm('Hapus data kecamatan ini?')"
                                    class="btn btn-sm btn-outline-danger rounded-pill">

                                    <i class="bi bi-trash"></i>

                                </a>

                            <?php else: ?>

                                <button
                                    class="btn btn-sm btn-outline-secondary rounded-pill"
                                    disabled
                                    title="Masih digunakan oleh data Desa/Kelurahan">

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

<div class="modal fade" id="modalTambah" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content rounded-4">

            <div class="modal-header">

                <h5 class="modal-title">

                    Tambah Kecamatan

                </h5>

                <button
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form method="POST" action="?page=kecamatan-store">

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">

                            Provinsi

                        </label>

                        <select
                            id="modal_provinsi"
                            class="form-select"
                            required>

                            <option value="">

                                -- Pilih Provinsi --

                            </option>

                            <?php foreach(($provinsi ?? []) as $item): ?>

                                <option value="<?= $item['id_provinsi'] ?? $item['id'] ?>">

                                    <?= htmlspecialchars($item['nama_provinsi'] ?? '') ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Kota / Kabupaten

                        </label>

                        <select
                            id="modal_kota"
                            name="id_kota"
                            class="form-select"
                            disabled
                            required>

                            <option value="">

                                -- Pilih Kota / Kabupaten --

                            </option>

                            <?php foreach(($kota ?? []) as $item): ?>

                                <option
                                    value="<?= $item['id_kota'] ?? $item['id'] ?>"
                                    data-provinsi="<?= $item['id_provinsi'] ?? '' ?>">

                                    <?= htmlspecialchars($item['nama_kota'] ?? '') ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Nama Kecamatan

                        </label>

                        <input
                            type="text"
                            name="nama_kecamatan"
                            class="form-control"
                            required>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button class="btn btn-primary">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinsiSelect = document.getElementById('modal_provinsi');
    const kotaSelect = document.getElementById('modal_kota');

    if (!provinsiSelect || !kotaSelect) {
        return;
    }

    function filterKota() {
        const provinsiId = provinsiSelect.value;

        kotaSelect.value = '';
        kotaSelect.disabled = provinsiId === '';

        Array.from(kotaSelect.options).forEach(function(option) {
            if (option.value === '') {
                option.hidden = false;
                option.disabled = false;
                return;
            }

            const match = option.dataset.provinsi === provinsiId;

            option.hidden = !match;
            option.disabled = !match;
        });
    }

    filterKota();
    provinsiSelect.addEventListener('change', filterKota);
});
</script>
