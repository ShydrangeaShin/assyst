<div class="container-fluid py-4 fade-up">
    <div class="row g-4">
        
        <!-- Panel Kiri: Data Survei Keluarga -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-card-checklist text-primary me-2"></i>Rincian Hasil Survei Lapangan</h5>
                    <span class="badge bg-light text-dark border font-monospace">REF: #<?= str_pad($keluarga['id_keluarga'], 5, '0', STR_PAD_LEFT) ?></span>
                </div>
                
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold mb-1">NAMA KEPALA KELUARGA</h6>
                            <p class="fw-bold text-dark fs-5"><?= htmlspecialchars($keluarga['nama_kepala_keluarga']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold mb-1">NOMOR NIK / KK</h6>
                            <p class="font-monospace text-dark"><?= htmlspecialchars($keluarga['nik_kk']) ?></p>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded-3 mb-4">
                        <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Evaluasi Kondisi Sosial Ekonomi</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <span class="d-block small text-muted mb-1">Kondisi Ekonomi Rendah?</span>
                                <span class="badge <?= $keluarga['ekonomi_rendah'] == 'Ya' ? 'bg-danger' : 'bg-success' ?> bg-opacity-10 <?= $keluarga['ekonomi_rendah'] == 'Ya' ? 'text-danger' : 'text-success' ?> border px-3 py-2 fw-bold w-100 text-start"><?= $keluarga['ekonomi_rendah'] ?></span>
                            </div>
                            <div class="col-md-6">
                                <span class="d-block small text-muted mb-1">Ada Penghasilan Tetap?</span>
                                <span class="badge <?= $keluarga['penghasilan_tetap'] == 'Tidak' ? 'bg-danger' : 'bg-success' ?> bg-opacity-10 <?= $keluarga['penghasilan_tetap'] == 'Tidak' ? 'text-danger' : 'text-success' ?> border px-3 py-2 fw-bold w-100 text-start"><?= $keluarga['penghasilan_tetap'] ?></span>
                            </div>
                            <div class="col-md-6">
                                <span class="d-block small text-muted mb-1">Banyak Tanggungan (>3)?</span>
                                <span class="badge <?= $keluarga['banyak_tanggungan'] == 'Ya' ? 'bg-warning' : 'bg-secondary' ?> bg-opacity-10 <?= $keluarga['banyak_tanggungan'] == 'Ya' ? 'text-warning' : 'text-secondary' ?> border px-3 py-2 fw-bold w-100 text-start"><?= $keluarga['banyak_tanggungan'] ?></span>
                            </div>
                            <div class="col-md-6">
                                <span class="d-block small text-muted mb-1">Punya Aset Bernilai?</span>
                                <span class="badge <?= $keluarga['aset_bernilai'] == 'Ya' ? 'bg-danger' : 'bg-success' ?> bg-opacity-10 <?= $keluarga['aset_bernilai'] == 'Ya' ? 'text-danger' : 'text-success' ?> border px-3 py-2 fw-bold w-100 text-start"><?= $keluarga['aset_bernilai'] ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Placeholder Modul Foto -->
                    <!-- Grid Modul Foto Bukti Lapangan -->
                    <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2 mt-5">Bukti Lampiran Foto Lapangan</h6>
                    <div class="row g-3">
                        <?php 
                        // Map folder sesuai dengan parameter fungsi uploadFile di Helper
                        $jenis_foto = [
                            'rumah' => ['label' => 'Tampak Depan Rumah', 'file' => $foto['foto_rumah'] ?? ''],
                            'ekonomi' => ['label' => 'Kondisi Ruangan / Dapur', 'file' => $foto['foto_ekonomi'] ?? ''],
                            'keluarga' => ['label' => 'Foto Bersama Keluarga', 'file' => $foto['foto_keluarga'] ?? ''],
                            'dokumen' => ['label' => 'Dokumen KK / KTP', 'file' => $foto['foto_dokumen'] ?? '']
                        ];
                        
                        foreach($jenis_foto as $folder => $data_foto): ?>
                        <div class="col-md-6">
                            <div class="card border border-light shadow-sm overflow-hidden h-100" style="border-radius: 12px;">
                                <div class="card-header bg-white py-2 px-3 small fw-bold text-muted border-bottom"><?= $data_foto['label'] ?></div>
                                <div class="card-body p-0 text-center bg-light" style="height: 220px;">
                                    <?php if($data_foto['file']): ?>
                                        <a href="<?= base_url('assets/uploads/'.$folder.'/'.$data_foto['file']) ?>" target="_blank" title="Klik untuk memperbesar">
                                            <img src="<?= base_url('assets/uploads/'.$folder.'/'.$data_foto['file']) ?>" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="<?= $data_foto['label'] ?>">
                                        </a>
                                    <?php else: ?>
                                        <div class="d-flex flex-column align-items-center justify-content-center h-100 text-secondary">
                                            <i class="bi bi-image-fill fs-1 opacity-25 mb-2"></i>
                                            <span class="small opacity-50">Belum Ada Foto</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Kanan: Form Keputusan Admin -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-shield-lock-fill text-primary me-2"></i>Otoritas Validasi</h5>
                </div>
                
                <div class="card-body p-4">
                    <div class="alert alert-info border-0 bg-info-subtle text-info mb-4 rounded-3 small">
                        <i class="bi bi-info-circle-fill me-1"></i> Jika Anda mengubah status menjadi <strong>Valid</strong>, mesin penalaran akan otomatis mengkalkulasi kelayakan bansos keluarga ini.
                    </div>

                    <form action="?page=verifikasi-update" method="POST">
                        <input type="hidden" name="id_keluarga" value="<?= $keluarga['id_keluarga'] ?>">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Keputusan Validasi</label>
                            <select name="status_verifikasi" class="form-select px-3 py-3 fw-bold" required>
                                <option value="Pending" <?= (isset($verifikasi) && $verifikasi['status_verifikasi'] == 'Pending') ? 'selected' : '' ?>>🟠 Tetapkan Pending</option>
                                <option value="Ditolak" <?= (isset($verifikasi) && $verifikasi['status_verifikasi'] == 'Ditolak') ? 'selected' : '' ?>>🔴 Tolak Data (Data Tidak Valid)</option>
                                <option value="Valid" <?= (isset($verifikasi) && $verifikasi['status_verifikasi'] == 'Valid') ? 'selected' : '' ?>>🟢 Setujui (Data Valid & Akurat)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Catatan Admin (Opsional)</label>
                            <textarea name="catatan" class="form-control px-3 py-2" rows="4" placeholder="Ketik alasan penolakan atau catatan tambahan..."><?= htmlspecialchars($verifikasi['catatan'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 fw-bold shadow-sm"><i class="bi bi-save me-2"></i>Simpan & Proses</button>
                            <a href="?page=verifikasi" class="btn btn-light rounded-pill py-2 fw-bold text-secondary border">Batalkan</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>