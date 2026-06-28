<div class="container-fluid py-4 fade-up">
    
    <div class="card border-0 shadow-sm mb-4 d-print-none" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 border-bottom-0" style="border-radius: 16px 16px 0 0;">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-funnel text-primary me-2"></i>Filter Laporan</h5>
        </div>
        <div class="card-body p-4 pt-0">
            <form id="filterLaporanForm" method="GET" action="index.php">
                <input type="hidden" name="page" value="laporan">
                <div class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-muted">Provinsi</label>
                        <select id="provinsi" name="id_provinsi" class="form-select">
                            <option value="">Semua Provinsi</option>
                            <?php foreach($provinsi as $row): ?>
                                <option value="<?= $row['id_provinsi'] ?>" <?= ((string)($_GET['id_provinsi']??'') === (string)$row['id_provinsi']) ? 'selected' : '' ?>><?= htmlspecialchars($row['nama_provinsi']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-muted">Kota/Kabupaten</label>
                        <select id="kota" name="id_kota" class="form-select" data-selected="<?= htmlspecialchars($_GET['id_kota']??'') ?>"><option value="">Semua Kota</option></select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-muted">Kecamatan</label>
                        <select id="kecamatan" name="id_kecamatan" class="form-select" data-selected="<?= htmlspecialchars($_GET['id_kecamatan']??'') ?>"><option value="">Semua Kecamatan</option></select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-muted">Desa/Kelurahan</label>
                        <select id="desa" name="id_desa" class="form-select" data-selected="<?= htmlspecialchars($_GET['id_desa']??'') ?>"><option value="">Semua Desa</option></select>
                    </div>
                    
                    <div class="col-lg-4 col-md-6 mt-3">
                        <label class="form-label small fw-bold text-muted">Status Keputusan</label>
                        <select name="status_hasil" class="form-select fw-bold">
                            <option value="">Semua Status</option>
                            <option value="LAYAK" <?= (($_GET['status_hasil']??'') == 'LAYAK') ? 'selected' : '' ?>>🟢 LAYAK</option>
                            <option value="TIDAK LAYAK" <?= (($_GET['status_hasil']??'') == 'TIDAK LAYAK') ? 'selected' : '' ?>>🔴 TIDAK LAYAK</option>
                            <option value="PERLU VERIFIKASI" <?= (($_GET['status_hasil']??'') == 'PERLU VERIFIKASI') ? 'selected' : '' ?>>🟠 PERLU VERIFIKASI</option>
                            <option value="BELUM" <?= (($_GET['status_hasil']??'') == 'BELUM') ? 'selected' : '' ?>>⚪ BELUM DIPROSES</option>
                        </select>
                    </div>
                    <div class="col-lg-5 col-md-6 mt-3">
                        <label class="form-label small fw-bold text-muted">Pencarian Spesifik</label>
                        <input type="text" name="search" class="form-control" placeholder="Cari NIK atau Nama KK..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    </div>
                    <div class="col-lg-3 col-md-12 mt-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill fw-bold"><i class="bi bi-search me-1"></i> Terapkan</button>
                        <a href="?page=laporan" class="btn btn-light border fw-bold" title="Reset Filter"><i class="bi bi-arrow-counterclockwise"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3" style="border-radius: 16px 16px 0 0;">
            <div>
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-table text-primary me-2"></i>Rekapitulasi Data Bansos</h5>
                <small class="text-muted d-print-none">Total: <?= number_format(mysqli_num_rows($laporan)) ?> keluarga ditemukan.</small>
            </div>
            <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm fw-bold d-print-none text-nowrap">
                <i class="bi bi-printer me-2"></i>Cetak PDF
            </button>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="laporanTable">
                    <thead style="background-color: #F8F9FA;">
                        <tr>
                            <th width="3%" class="text-center py-3">NO</th>
                            <th width="22%" class="py-3">IDENTITAS KELUARGA</th>
                            <th width="20%" class="py-3">ALAMAT & WILAYAH</th>
                            <th width="25%" class="py-3">KONDISI SOSIAL EKONOMI</th>
                            <th width="15%" class="py-3 text-center">STATUS KELAYAKAN</th>
                            <th width="15%" class="py-3">PETUGAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($laporan) > 0): ?>
                            <?php $no = 1; while($row = mysqli_fetch_assoc($laporan)): ?>
                            <tr class="border-bottom">
                                <td class="text-center py-3 text-muted"><?= $no++ ?></td>
                                <td class="py-3">
                                    <strong class="text-dark d-block"><?= htmlspecialchars($row['nama_kepala_keluarga']) ?></strong>
                                    <span class="font-monospace text-secondary small">NIK: <?= htmlspecialchars($row['nik_kk']) ?></span>
                                </td>
                                <td class="py-3 small">
                                    <span class="d-block text-dark"><?= htmlspecialchars($row['alamat']) ?></span>
                                    <span class="text-muted">Ds. <?= htmlspecialchars($row['nama_desa']) ?>, Kec. <?= htmlspecialchars($row['nama_kecamatan']) ?>, <?= htmlspecialchars($row['nama_kota']) ?></span>
                                </td>
                                <td class="py-3">
                                    <?php if(isset($row['ekonomi_rendah'])): ?>
                                        <div class="d-flex flex-wrap gap-1">
                                            <span class="badge <?= $row['ekonomi_rendah'] == 'Ya' ? 'bg-danger' : 'bg-success' ?> bg-opacity-10 <?= $row['ekonomi_rendah'] == 'Ya' ? 'text-danger' : 'text-success' ?> border">Eko. Rendah: <?= $row['ekonomi_rendah'] ?></span>
                                            <span class="badge <?= $row['penghasilan_tetap'] == 'Tidak' ? 'bg-danger' : 'bg-success' ?> bg-opacity-10 <?= $row['penghasilan_tetap'] == 'Tidak' ? 'text-danger' : 'text-success' ?> border">Gaji Tetap: <?= $row['penghasilan_tetap'] ?></span>
                                            <span class="badge <?= $row['banyak_tanggungan'] == 'Ya' ? 'bg-warning' : 'bg-secondary' ?> bg-opacity-10 <?= $row['banyak_tanggungan'] == 'Ya' ? 'text-warning' : 'text-secondary' ?> border">Tanggungan >3: <?= $row['banyak_tanggungan'] ?></span>
                                            <span class="badge <?= $row['aset_bernilai'] == 'Tidak' ? 'bg-danger' : 'bg-success' ?> bg-opacity-10 <?= $row['aset_bernilai'] == 'Tidak' ? 'text-danger' : 'text-success' ?> border">Aset Berharga: <?= $row['aset_bernilai'] ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic small">Survei kondisi belum diinput</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center py-3">
                                    <?php if($row['status_hasil'] == 'LAYAK'): ?>
                                        <span class="badge bg-success w-100 py-2">LAYAK</span>
                                    <?php elseif($row['status_hasil'] == 'TIDAK LAYAK'): ?>
                                        <span class="badge bg-danger w-100 py-2">TIDAK LAYAK</span>
                                    <?php elseif($row['status_hasil'] == 'PERLU VERIFIKASI'): ?>
                                        <span class="badge bg-warning text-dark w-100 py-2">VERIFIKASI MANUAL</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary bg-opacity-25 text-secondary border w-100 py-2">BELUM ADA HASIL</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 text-secondary small">
                                    <i class="bi bi-person-badge me-1"></i> <?= htmlspecialchars($row['nama_petugas']) ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center py-5 text-muted"><i class="bi bi-folder-x fs-1 d-block mb-2 opacity-50"></i>Tidak ada data yang sesuai dengan filter.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
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