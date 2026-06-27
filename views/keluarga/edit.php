<?php $role = $_SESSION['user']['role']; ?>

<div class="container-fluid py-4 fade-up">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Pembaruan Data Keluarga</h5>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="?page=keluarga-update" method="POST">
                        <input type="hidden" name="id_keluarga" value="<?= htmlspecialchars($data['id_keluarga']) ?>">
                        
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Informasi Identitas</h6>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted">Nomor Induk Kependudukan (NIK/KK)</label>
                                    <input type="text" name="nik_kk" class="form-control px-3 py-2" required value="<?= htmlspecialchars($data['nik_kk']) ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted">Nama Kepala Keluarga</label>
                                    <input type="text" name="nama_kepala_keluarga" class="form-control px-3 py-2" required value="<?= htmlspecialchars($data['nama_kepala_keluarga']) ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted">Nomor Telepon / WhatsApp</label>
                                    <input type="text" name="nomor_telepon" class="form-control px-3 py-2" value="<?= htmlspecialchars($data['nomor_telepon'] ?? '') ?>">
                                </div>
                                <?php if ($role == 'Admin'): ?>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted">Petugas Lapangan (Surveyor)</label>
                                    <select name="id_petugas" class="form-select px-3 py-2" required>
                                        <?php while($p = mysqli_fetch_assoc($petugas)): ?>
                                            <option value="<?= $p['id_user'] ?>" <?= ($p['id_user'] == $data['id_petugas']) ? 'selected' : '' ?>><?= htmlspecialchars($p['nama']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-lg-6">
                                <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Administrasi Wilayah</h6>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted">Provinsi</label>
                                    <select id="provinsiEdit" name="id_provinsi" class="form-select px-3 py-2" required>
                                        <option value="">Pilih Provinsi</option>
                                        <?php foreach($provinsi as $p): ?>
                                            <option value="<?= $p['id_provinsi'] ?>" <?= ($p['id_provinsi'] == $data['id_provinsi']) ? 'selected' : '' ?>><?= htmlspecialchars($p['nama_provinsi']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted">Kota / Kabupaten</label>
                                    <select id="kotaEdit" name="id_kota" class="form-select px-3 py-2" data-selected="<?= $data['id_kota'] ?>" required></select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted">Kecamatan</label>
                                    <select id="kecamatanEdit" name="id_kecamatan" class="form-select px-3 py-2" data-selected="<?= $data['id_kecamatan'] ?>" required></select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted">Desa / Kelurahan</label>
                                    <select id="desaEdit" name="id_desa" class="form-select px-3 py-2 border-primary" data-selected="<?= $data['id_desa'] ?>" required></select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted">Alamat Jalan</label>
                                    <textarea name="alamat" class="form-control px-3 py-2" rows="2" required><?= htmlspecialchars($data['alamat']) ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 border-top pt-4 mt-3">
                            <a href="?page=keluarga" class="btn btn-light rounded-pill px-4 fw-bold text-secondary border">Batalkan</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pSel = document.getElementById('provinsiEdit'); const koSel = document.getElementById('kotaEdit');
    const kecSel = document.getElementById('kecamatanEdit'); const dSel = document.getElementById('desaEdit');
    const dKota = <?= json_encode($kota); ?>; const dKec = <?= json_encode($kecamatan); ?>; const dDesa = <?= json_encode($desa); ?>;

    function renderOptions(dataArr, filterKey, filterVal, targetSelect, valueKey, textKey, selectedVal) {
        targetSelect.innerHTML = '<option value="">-- Pilih --</option>';
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
        renderOptions(dKec, 'id_kota', selKota, kecSel, 'id_kecamatan', 'nama_kecamatan', selKec);
        renderOptions(dDesa, 'id_kecamatan', selKec, dSel, 'id_desa', 'nama_desa', selDesa);
    }

    pSel.addEventListener('change', () => { koSel.setAttribute('data-selected',''); kecSel.setAttribute('data-selected',''); dSel.setAttribute('data-selected',''); initCascading(); });
    koSel.addEventListener('change', function() { koSel.setAttribute('data-selected', this.value); kecSel.setAttribute('data-selected',''); dSel.setAttribute('data-selected',''); initCascading(); });
    kecSel.addEventListener('change', function() { kecSel.setAttribute('data-selected', this.value); dSel.setAttribute('data-selected',''); initCascading(); });
    
    initCascading();
});
</script>