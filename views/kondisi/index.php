<div class="container-fluid py-4 fade-up">

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 12px;">
            <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-funnel text-primary me-2"></i>Saring Pemilihan Keluarga</h6>
                <a href="?page=kondisi" class="btn btn-sm btn-light border text-danger" title="Reset Filter"><i class="bi bi-x-circle me-1"></i>Reset</a>
            </div>
            
            <form id="filterKondisiForm" method="GET" action="index.php">
                <input type="hidden" name="page" value="kondisi">
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
                    
                    <div class="col-lg-9 col-md-8 mt-3">
                        <input type="text" name="search" class="form-control" placeholder="Cari NIK atau Nama KK spesifik..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    </div>
                    <div class="col-lg-3 col-md-4 mt-3">
                        <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="bi bi-search me-2"></i>Cari Keluarga</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 border-bottom" style="border-radius: 16px 16px 0 0;">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-clipboard-heart text-primary me-2"></i>Daftar Pembaruan Kondisi Sosial</h5>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #F8F9FA;">
                        <tr>
                            <th width="5%" class="text-center py-3">NO</th>
                            <th width="30%" class="py-3">IDENTITAS (NIK / NAMA)</th>
                            <th width="25%" class="py-3">LOKASI DESA</th>
                            <th width="20%" class="py-3 text-center">STATUS PENGISIAN</th>
                            <th width="20%" class="text-center py-3">AKSI KONDISI</th>
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
                                <td class="py-3 fw-bold text-primary small">
                                    Desa <?= htmlspecialchars($row['nama_desa']) ?>
                                    <span class="d-block fw-normal text-muted" style="font-size:0.75rem;">Kec. <?= htmlspecialchars($row['nama_kecamatan']) ?></span>
                                </td>
                                <td class="text-center py-3">
                                    <?php if(!empty($row['id_kondisi'])): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2"><i class="bi bi-check-circle me-1"></i>Sudah Diinput</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-2"><i class="bi bi-exclamation-circle me-1"></i>Belum Diinput</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center py-3">
                                    <a href="?page=kondisi-edit&id=<?= $row['id_keluarga'] ?>" class="btn btn-sm <?= !empty($row['id_kondisi']) ? 'btn-light border text-primary' : 'btn-primary' ?> rounded-pill px-3 shadow-sm fw-bold">
                                        <?= !empty($row['id_kondisi']) ? '<i class="bi bi-pencil-square me-1"></i>Ubah Data' : '<i class="bi bi-plus-circle me-1"></i>Input Kondisi' ?>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-5 text-muted"><i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>Data keluarga tidak ditemukan dalam filter ini.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pSel = document.getElementById('provinsi'); const koSel = document.getElementById('kota');
    const kecSel = document.getElementById('kecamatan'); const dSel = document.getElementById('desa');
    const dKota = <?= json_encode($kota ?? []); ?>; const dKec = <?= json_encode($kecamatan ?? []); ?>; const dDesa = <?= json_encode($desa ?? []); ?>;

    function renderOptions(dataArr, filterKey, filterVal, targetSelect, valueKey, textKey, selectedVal) {
        targetSelect.innerHTML = '<option value="">Semua ' + (targetSelect.id.charAt(0).toUpperCase() + targetSelect.id.slice(1)) + '</option>';
        if(!filterVal) { targetSelect.disabled = true; return; }
        targetSelect.disabled = false;
        dataArr.filter(item => String(item[filterKey]) === String(filterVal)).forEach(item => {
            const isSelected = String(item[valueKey]) === String(selectedVal) ? 'selected' : '';
            targetSelect.innerHTML += `<option value="${item[valueKey]}" ${isSelected}>${item[textKey]}</option>`;
        });
    }

    function initCascading() {
        const selKota = koSel.getAttribute('data-selected'); const selKec = kecSel.getAttribute('data-selected'); const selDesa = dSel.getAttribute('data-selected');
        renderOptions(dKota, 'id_provinsi', pSel.value, koSel, 'id_kota', 'nama_kota', selKota);
        renderOptions(dKec, 'id_kota', selKota || koSel.value, kecSel, 'id_kecamatan', 'nama_kecamatan', selKec);
        renderOptions(dDesa, 'id_kecamatan', selKec || kecSel.value, dSel, 'id_desa', 'nama_desa', selDesa);
    }

    pSel.addEventListener('change', () => { koSel.setAttribute('data-selected',''); kecSel.setAttribute('data-selected',''); dSel.setAttribute('data-selected',''); initCascading(); });
    koSel.addEventListener('change', function() { koSel.setAttribute('data-selected', this.value); kecSel.setAttribute('data-selected',''); dSel.setAttribute('data-selected',''); initCascading(); });
    kecSel.addEventListener('change', function() { kecSel.setAttribute('data-selected', this.value); dSel.setAttribute('data-selected',''); initCascading(); });
    
    initCascading();
});
</script>