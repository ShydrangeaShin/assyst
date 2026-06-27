<div class="container-fluid py-4 fade-up">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; background-color: #F8F9FA;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="me-3 text-primary"><i class="bi bi-person-vcard fs-1"></i></div>
                    <div>
                        <h5 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($profil['nama_kepala_keluarga']) ?></h5>
                        <p class="mb-0 text-muted font-monospace small">NIK: <?= htmlspecialchars($profil['nik_kk']) ?></p>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-ui-radios text-primary me-2"></i>Form Evaluasi & Bukti Lapangan</h5>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <!-- PERHATIKAN: enctype multipart/form-data WAJIB untuk upload file -->
                    <form action="?page=kondisi-update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_keluarga" value="<?= htmlspecialchars($profil['id_keluarga']) ?>">
                        
                        <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Bagian I: Kondisi Sosial Ekonomi</h6>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold d-block text-dark">1. Apakah keluarga berada dalam kondisi ekonomi rendah / di bawah standar?</label>
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="ekonomi_rendah" id="ekoYa" value="Ya" <?= (isset($kondisi) && $kondisi['ekonomi_rendah'] == 'Ya') ? 'checked' : '' ?> required>
                                <label class="form-check-label" for="ekoYa">Ya, Ekonomi Rendah</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ekonomi_rendah" id="ekoTidak" value="Tidak" <?= (isset($kondisi) && $kondisi['ekonomi_rendah'] == 'Tidak') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="ekoTidak">Tidak</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold d-block text-dark">2. Apakah kepala keluarga memiliki sumber penghasilan tetap setiap bulannya?</label>
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="penghasilan_tetap" id="penghasilanYa" value="Ya" <?= (isset($kondisi) && $kondisi['penghasilan_tetap'] == 'Ya') ? 'checked' : '' ?> required>
                                <label class="form-check-label" for="penghasilanYa">Ya, Memiliki Gaji Tetap</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="penghasilan_tetap" id="penghasilanTidak" value="Tidak" <?= (isset($kondisi) && $kondisi['penghasilan_tetap'] == 'Tidak') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="penghasilanTidak">Tidak (Serabutan/Nganggur)</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold d-block text-dark">3. Apakah keluarga memiliki jumlah tanggungan yang banyak (Lebih dari 3 orang)?</label>
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="banyak_tanggungan" id="tanggunganYa" value="Ya" <?= (isset($kondisi) && $kondisi['banyak_tanggungan'] == 'Ya') ? 'checked' : '' ?> required>
                                <label class="form-check-label" for="tanggunganYa">Ya, Lebih dari 3 Tanggungan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="banyak_tanggungan" id="tanggunganTidak" value="Tidak" <?= (isset($kondisi) && $kondisi['banyak_tanggungan'] == 'Tidak') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="tanggunganTidak">Tidak</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold d-block text-dark">4. Apakah keluarga memiliki aset bernilai tinggi (Misal: Mobil, Tanah Ekstra, Usaha Besar)?</label>
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="aset_bernilai" id="asetYa" value="Ya" <?= (isset($kondisi) && $kondisi['aset_bernilai'] == 'Ya') ? 'checked' : '' ?> required>
                                <label class="form-check-label" for="asetYa">Ya, Punya Aset Besar</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="aset_bernilai" id="asetTidak" value="Tidak" <?= (isset($kondisi) && $kondisi['aset_bernilai'] == 'Tidak') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="asetTidak">Tidak</label>
                            </div>
                        </div>

                        <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2 mt-5">Bagian II: Lampiran Foto Bukti Lapangan</h6>
                        <div class="alert alert-info border-0 bg-info-subtle text-info small mb-4">
                            <i class="bi bi-info-circle-fill me-1"></i> Kosongkan input file jika Anda tidak ingin mengubah/mengganti foto yang sudah diupload sebelumnya. Ekstensi: JPG/PNG, Maksimal: 5MB.
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">1. Foto Tampak Depan Rumah</label>
                                <input type="file" name="foto_rumah" class="form-control px-3" accept="image/png, image/jpeg" <?= empty($foto['foto_rumah']) ? 'required' : '' ?>>
                                <?php if(!empty($foto['foto_rumah'])): ?>
                                    <small class="text-success fw-bold d-block mt-1"><i class="bi bi-check-lg me-1"></i>Tersimpan: <?= htmlspecialchars($foto['foto_rumah']) ?></small>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">2. Foto Kondisi Ekonomi (Dapur/Ruang Tamu)</label>
                                <input type="file" name="foto_ekonomi" class="form-control px-3" accept="image/png, image/jpeg" <?= empty($foto['foto_ekonomi']) ? 'required' : '' ?>>
                                <?php if(!empty($foto['foto_ekonomi'])): ?>
                                    <small class="text-success fw-bold d-block mt-1"><i class="bi bi-check-lg me-1"></i>Tersimpan: <?= htmlspecialchars($foto['foto_ekonomi']) ?></small>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">3. Foto Bersama Kepala Keluarga</label>
                                <input type="file" name="foto_keluarga" class="form-control px-3" accept="image/png, image/jpeg" <?= empty($foto['foto_keluarga']) ? 'required' : '' ?>>
                                <?php if(!empty($foto['foto_keluarga'])): ?>
                                    <small class="text-success fw-bold d-block mt-1"><i class="bi bi-check-lg me-1"></i>Tersimpan: <?= htmlspecialchars($foto['foto_keluarga']) ?></small>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">4. Foto Kartu Keluarga (KK)</label>
                                <input type="file" name="foto_dokumen" class="form-control px-3" accept="image/png, image/jpeg" <?= empty($foto['foto_dokumen']) ? 'required' : '' ?>>
                                <?php if(!empty($foto['foto_dokumen'])): ?>
                                    <small class="text-success fw-bold d-block mt-1"><i class="bi bi-check-lg me-1"></i>Tersimpan: <?= htmlspecialchars($foto['foto_dokumen']) ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 border-top pt-4 mt-5">
                            <a href="?page=kondisi" class="btn btn-light rounded-pill px-4 fw-bold text-secondary border">Batalkan</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm"><i class="bi bi-cloud-arrow-up-fill me-2"></i>Simpan & Upload Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>