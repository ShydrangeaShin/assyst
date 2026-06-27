<?php $role = $_SESSION['user']['role']; ?>

<div class="container-fluid py-4 fade-up">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-ui-checks text-primary me-2"></i>Pembaruan Progres Tugas Lapangan</h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="?page=tugas-update" method="POST">
                        <input type="hidden" name="id_tugas" value="<?= htmlspecialchars($data['id_tugas']) ?>">
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Petugas Eksekutor</label>
                                <?php if ($role == 'Admin'): ?>
                                    <select name="id_petugas" class="form-select" required>
                                        <?php while($p = mysqli_fetch_assoc($petugas)): ?>
                                            <option value="<?= $p['id_user'] ?>" <?= ($p['id_user'] == $data['id_petugas']) ? 'selected' : '' ?>><?= htmlspecialchars($p['nama']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                <?php else: ?>
                                    <input type="text" class="form-control bg-light text-muted" value="<?= htmlspecialchars($data['nama_petugas']) ?>" readonly>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Tanggal Penugasan</label>
                                <?php if ($role == 'Admin'): ?>
                                    <input type="date" name="tanggal_penugasan" class="form-control" required value="<?= htmlspecialchars($data['tanggal_penugasan']) ?>">
                                <?php else: ?>
                                    <input type="date" class="form-control bg-light text-muted" value="<?= htmlspecialchars($data['tanggal_penugasan']) ?>" readonly>
                                <?php endif; ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Nama Tugas</label>
                                <?php if ($role == 'Admin'): ?>
                                    <input type="text" name="nama_tugas" class="form-control" required value="<?= htmlspecialchars($data['nama_tugas']) ?>">
                                <?php else: ?>
                                    <input type="text" class="form-control bg-light text-muted" value="<?= htmlspecialchars($data['nama_tugas']) ?>" readonly>
                                <?php endif; ?>
                            </div>

                            <?php if ($role == 'Admin'): ?>
                            <div class="col-12"><h6 class="fw-bold mb-0 border-bottom pb-2 mt-2">Target Lokasi Kerja</h6></div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Provinsi</label>
                                <select id="provinsiEdit" class="form-select">
                                    <option value="">Pilih Provinsi</option>
                                    <?php foreach($provinsi as $p): ?>
                                        <option value="<?= $p['id_provinsi'] ?>" <?= ($p['id_provinsi'] == $data['id_provinsi']) ? 'selected' : '' ?>><?= htmlspecialchars($p['nama_provinsi']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Kota / Kabupaten</label>
                                <select id="kotaEdit" class="form-select" data-selected="<?= $data['id_kota'] ?>"></select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Kecamatan</label>
                                <select id="kecamatanEdit" class="form-select" data-selected="<?= $data['id_kecamatan'] ?>"></select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Desa / Kelurahan</label>
                                <select id="desaEdit" name="id_desa" class="form-select border-primary" data-selected="<?= $data['id_desa'] ?>"></select>
                            </div>
                            <?php else: ?>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Target Wilayah Kerja</label>
                                <input type="text" class="form-control bg-light text-muted" value="Desa/Kel. <?= htmlspecialchars($data['nama_desa']) ?>, Kec. <?= htmlspecialchars($data['nama_kecamatan']) ?>" readonly>
                            </div>
                            <?php endif; ?>

                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Deskripsi Tugas</label>
                                <?php if ($role == 'Admin'): ?>
                                    <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                                <?php else: ?>
                                    <textarea class="form-control bg-light text-muted" rows="3" readonly><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                                <?php endif; ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Status Kerja Lapangan</label>
                                <select name="status_tugas" class="form-select fw-bold" required>
                                    <option value="Belum Dikerjakan" <?= ($data['status_tugas'] == 'Belum Dikerjakan') ? 'selected' : '' ?>>🔴 Belum Dikerjakan</option>
                                    <option value="Proses" <?= ($data['status_tugas'] == 'Proses') ? 'selected' : '' ?>>🔵 Proses (Sedang Berjalan)</option>
                                    <option value="Selesai" <?= ($data['status_tugas'] == 'Selesai') ? 'selected' : '' ?>>🟢 Selesai</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 border-top pt-4 mt-4">
                            <a href="?page=tugas" class="btn btn-light rounded-pill px-4 fw-bold text-secondary border">Batalkan</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($role == 'Admin'): ?>
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
        const selKota = koSel.getAttribute('data-selected');
        const selKec = kecSel.getAttribute('data-selected');
        const selDesa = dSel.getAttribute('data-selected');
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
<?php endif; ?>