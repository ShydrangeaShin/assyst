<?php $role = $_SESSION['user']['role']; ?>

<div class="container-fluid py-4 fade-up">
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 12px;">
            <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3 gap-3" style="border-radius: 16px 16px 0 0;">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi <?= $role == 'Admin' ? 'bi-clipboard-check-fill' : 'bi-list-task' ?> text-primary me-2"></i>
                <?= $role == 'Admin' ? 'Manajemen Tugas Petugas' : 'Tugas Lapangan Saya' ?>
            </h5>
            
            <div class="d-flex flex-column flex-md-row gap-2">
                <form action="index.php" method="GET" class="mb-0">
                    <input type="hidden" name="page" value="tugas">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>

                <?php if ($role == 'Admin'): ?>
                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold text-nowrap" data-bs-toggle="modal" data-bs-target="#modalTambahTugas">
                    <i class="bi bi-plus-lg me-1"></i> Buat Tugas
                </button>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #F8F9FA;">
                        <tr>
                            <th width="5%" class="text-center py-3">NO</th>
                            <th width="15%" class="py-3">PETUGAS</th>
                            <th width="20%" class="py-3">LOKASI WILAYAH</th>
                            <th width="20%" class="py-3">NAMA TUGAS</th>
                            <th class="py-3">DESKRIPSI</th>
                            <th width="12%" class="py-3">TANGGAL</th>
                            <th width="12%" class="py-3 text-center">STATUS</th>
                            <th width="10%" class="text-center py-3">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($tugas) > 0): ?>
                            <?php $no = 1; while($row = mysqli_fetch_assoc($tugas)): ?>
                            <tr class="border-bottom">
                                <td class="text-center py-3 text-muted"><?= $no++ ?></td>
                                <td class="py-3 fw-bold text-dark"><?= htmlspecialchars($row['nama_petugas']) ?></td>
                                <td class="py-3">
                                    <span class="d-block fw-bold text-primary small">Desa <?= htmlspecialchars($row['nama_desa']) ?></span>
                                    <span class="text-muted" style="font-size:0.75rem;">Kec. <?= htmlspecialchars($row['nama_kecamatan']) ?>, <?= htmlspecialchars($row['nama_kota']) ?></span>
                                </td>
                                <td class="py-3 fw-bold text-secondary small"><?= htmlspecialchars($row['nama_tugas']) ?></td>
                                <td class="py-3 text-muted small"><?= htmlspecialchars($row['deskripsi']) ?></td>
                                <td class="py-3 small font-monospace"><?= date('d-m-Y', strtotime($row['tanggal_penugasan'])) ?></td>
                                <td class="text-center py-3">
                                    <?php if($row['status_tugas'] == 'Selesai'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Selesai</span>
                                    <?php elseif($row['status_tugas'] == 'Proses'): ?>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3">Proses</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3">Belum Dikerjakan</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center py-3 text-nowrap">
                                    <a href="?page=tugas-edit&id=<?= $row['id_tugas'] ?>" class="btn btn-sm btn-light border shadow-sm rounded-circle text-primary"><i class="bi bi-pencil-square"></i></a>
                                    <?php if ($role == 'Admin'): ?>
                                    <a href="?page=tugas-delete&id=<?= $row['id_tugas'] ?>" class="btn btn-sm btn-light border shadow-sm rounded-circle text-danger ms-1" onclick="return confirm('Hapus tugas?');"><i class="bi bi-trash"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center py-5 text-muted">Belum ada data penugasan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php if ($role == 'Admin'): ?>
<div class="modal fade" id="modalTambahTugas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header pt-4 pb-0 px-4">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-clipboard-plus-fill text-primary me-2"></i>Buat Tugas Lapangan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="?page=tugas-store" method="POST">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Pilih Petugas</label>
                            <select name="id_petugas" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Petugas --</option>
                                <?php while($p = mysqli_fetch_assoc($petugas)): ?>
                                    <option value="<?= $p['id_user'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Tanggal Penugasan</label>
                            <input type="date" name="tanggal_penugasan" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted">Nama Tugas / Judul</label>
                            <input type="text" name="nama_tugas" class="form-control" required placeholder="Contoh: Survei Bansos PKH">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Provinsi</label>
                            <select id="provinsi" class="form-select" required>
                                <option value="">Pilih Provinsi</option>
                                <?php foreach($provinsi as $p): ?>
                                    <option value="<?= $p['id_provinsi'] ?>"><?= htmlspecialchars($p['nama_provinsi']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Kota / Kabupaten</label>
                            <select id="kota" class="form-select" required disabled><option value="">Pilih Kota/Kabupaten</option></select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Kecamatan</label>
                            <select id="kecamatan" class="form-select" required disabled><option value="">Pilih Kecamatan</option></select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Desa / Kelurahan</label>
                            <select id="desa" name="id_desa" class="form-select border-primary" required disabled><option value="">Pilih Desa/Kelurahan</option></select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted">Deskripsi Tugas</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Rincian instruksi kerja lapangan..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pb-4 px-4 pt-0 border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold"><i class="bi bi-send-fill me-2"></i>Kirim Tugas</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dKota = <?= json_encode($kota ?? []); ?>; 
    const dKec = <?= json_encode($kecamatan ?? []); ?>; 
    const dDesa = <?= json_encode($desa ?? []); ?>;
    
    // Panggil fungsi eksternal
    initCascadingWilayah(dKota, dKec, dDesa, {
        provinsi: 'provinsi', // ID elemen HTML
        kota: 'kota',
        kecamatan: 'kecamatan',
        desa: 'desa'
    });
});
</script>
<?php endif; ?>