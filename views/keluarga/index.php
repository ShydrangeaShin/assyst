<?php $role = $_SESSION['user']['role']; ?>

<div class="container-fluid py-4 fade-up">
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 12px;">
            <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 12px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3 gap-3" style="border-radius: 16px 16px 0 0;">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-house-door-fill text-primary me-2"></i>Data Profil Keluarga
            </h5>
            
            <div class="d-flex flex-column flex-md-row gap-2">
                <form action="index.php" method="GET" class="mb-0">
                    <input type="hidden" name="page" value="keluarga">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari NIK atau Nama..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                        <?php if(!empty($_GET['search'])): ?>
                            <a href="?page=keluarga" class="btn btn-outline-danger" title="Reset"><i class="bi bi-x-lg"></i></a>
                        <?php endif; ?>
                    </div>
                </form>

                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold text-nowrap" data-bs-toggle="modal" data-bs-target="#modalTambahKeluarga">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Data
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #F8F9FA;">
                        <tr>
                            <th width="5%" class="text-center py-3">NO</th>
                            <th width="20%" class="py-3">IDENTITAS (NIK / NAMA)</th>
                            <th width="25%" class="py-3">ALAMAT</th>
                            <th width="15%" class="py-3">LOKASI DESA</th>
                            <th width="15%" class="py-3">PETUGAS SURVEYOR</th>
                            <th width="12%" class="text-center py-3">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($keluarga) > 0): ?>
                            <?php $no = 1; while($row = mysqli_fetch_assoc($keluarga)): ?>
                            <tr class="border-bottom">
                                <td class="text-center py-3 text-muted"><?= $no++ ?></td>
                                <td class="py-3">
                                    <strong class="d-block text-dark"><?= htmlspecialchars($row['nama_kepala_keluarga']) ?></strong>
                                    <span class="text-secondary font-monospace small">NIK: <?= htmlspecialchars($row['nik_kk']) ?></span>
                                </td>
                                <td class="py-3 text-muted small"><?= htmlspecialchars($row['alamat']) ?></td>
                                <td class="py-3 fw-bold text-primary small">
                                    Desa <?= htmlspecialchars($row['nama_desa']) ?>
                                    <span class="d-block fw-normal text-muted" style="font-size:0.75rem;">Kec. <?= htmlspecialchars($row['nama_kecamatan']) ?></span>
                                </td>
                                <td class="py-3 small text-secondary"><i class="bi bi-person-badge me-1"></i><?= htmlspecialchars($row['nama_petugas']) ?></td>
                                <td class="text-center py-3 text-nowrap">
                                    <a href="?page=keluarga-detail&id=<?= $row['id_keluarga'] ?>" class="btn btn-sm btn-light border shadow-sm rounded-circle text-info" title="Lihat Detail"><i class="bi bi-info-circle"></i></a>
                                    <a href="?page=keluarga-edit&id=<?= $row['id_keluarga'] ?>" class="btn btn-sm btn-light border shadow-sm rounded-circle text-primary ms-1" title="Ubah Data"><i class="bi bi-pencil-square"></i></a>
                                    <a href="?page=keluarga-delete&id=<?= $row['id_keluarga'] ?>" class="btn btn-sm btn-light border shadow-sm rounded-circle text-danger ms-1" onclick="return confirm('Peringatan: Menghapus keluarga ini juga akan menghapus data kondisi dan hasil verifikasinya. Lanjutkan?');"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center py-5 text-muted">Data keluarga belum tersedia atau tidak ditemukan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahKeluarga" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header pt-4 pb-0 px-4 border-0">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-house-add-fill text-primary me-2"></i>Registrasi Keluarga Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="?page=keluarga-store" method="POST">
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <h6 class="fw-bold border-bottom pb-2 mb-3">Identitas Dasar</h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-muted">Nomor Induk Kependudukan (NIK/KK)</label>
                                    <input type="text" name="nik_kk" class="form-control" required placeholder="Masukkan 16 digit NIK">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-muted">Nama Lengkap Kepala Keluarga</label>
                                    <input type="text" name="nama_kepala_keluarga" class="form-control" required placeholder="Sesuai KTP">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-muted">Nomor Telepon / WhatsApp</label>
                                    <input type="text" name="nomor_telepon" class="form-control" placeholder="Boleh dikosongkan jika tidak ada">
                                </div>
                                <?php if ($role == 'Admin'): ?>
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-muted">Tugaskan Pengawasan (Petugas)</label>
                                    <select name="id_petugas" class="form-select" required>
                                        <option value="" selected disabled>-- Pilih Surveyor --</option>
                                        <?php while($p = mysqli_fetch_assoc($petugas)): ?>
                                            <option value="<?= $p['id_user'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-lg-6 border-start-lg">
                            <h6 class="fw-bold border-bottom pb-2 mb-3">Informasi Lokasi Geografis</h6>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label fw-bold small text-muted">Provinsi</label>
                                    <select id="provinsi" name="id_provinsi" class="form-select" required>
                                        <option value="">Pilih Provinsi</option>
                                        <?php foreach($provinsi as $p): ?>
                                            <option value="<?= $p['id_provinsi'] ?>"><?= htmlspecialchars($p['nama_provinsi']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-bold small text-muted">Kota / Kabupaten</label>
                                    <select id="kota" name="id_kota" class="form-select" required disabled><option value="">Pilih Kota/Kabupaten</option></select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-bold small text-muted">Kecamatan</label>
                                    <select id="kecamatan" name="id_kecamatan" class="form-select" required disabled><option value="">Pilih Kecamatan</option></select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-bold small text-muted">Desa / Kelurahan</label>
                                    <select id="desa" name="id_desa" class="form-select border-primary" required disabled><option value="">Pilih Desa/Kelurahan</option></select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-muted">Alamat Jalan / Detail Rumah</label>
                                    <textarea name="alamat" class="form-control" rows="3" required placeholder="Jalan, RT/RW, Patokan Rumah..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pb-4 px-4 pt-0 border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold"><i class="bi bi-save me-2"></i>Simpan Keluarga</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@media (min-width: 992px) {
    .border-start-lg { border-left: 1px solid #dee2e6; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pSel = document.getElementById('provinsi'); const koSel = document.getElementById('kota');
    const kecSel = document.getElementById('kecamatan'); const dSel = document.getElementById('desa');
    const dKota = <?= json_encode($kota); ?>; const dKec = <?= json_encode($kecamatan); ?>; const dDesa = <?= json_encode($desa); ?>;

    pSel.addEventListener('change', function() {
        koSel.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
        kecSel.innerHTML = '<option value="">Pilih Kecamatan</option>'; dSel.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
        koSel.disabled = kecSel.disabled = dSel.disabled = true;
        if(this.value) {
            koSel.disabled = false;
            dKota.filter(k => k.id_provinsi == this.value).forEach(k => { koSel.innerHTML += `<option value="${k.id_kota}">${k.nama_kota}</option>`; });
        }
    });
    koSel.addEventListener('change', function() {
        kecSel.innerHTML = '<option value="">Pilih Kecamatan</option>'; dSel.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
        kecSel.disabled = dSel.disabled = true;
        if(this.value) {
            kecSel.disabled = false;
            dKec.filter(k => k.id_kota == this.value).forEach(k => { kecSel.innerHTML += `<option value="${k.id_kecamatan}">${k.nama_kecamatan}</option>`; });
        }
    });
    kecSel.addEventListener('change', function() {
        dSel.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>'; dSel.disabled = true;
        if(this.value) {
            dSel.disabled = false;
            dDesa.filter(k => k.id_kecamatan == this.value).forEach(k => { dSel.innerHTML += `<option value="${k.id_desa}">${k.nama_desa}</option>`; });
        }
    });
});
</script>