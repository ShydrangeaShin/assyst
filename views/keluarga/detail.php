<div class="container-fluid py-4 fade-up">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom" style="border-radius: 16px 16px 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-person-vcard-fill text-primary me-2"></i>Informasi Lengkap Keluarga</h5>
                        <span class="badge bg-light text-dark border font-monospace">REF: #<?= str_pad($keluarga['id_keluarga'], 5, '0', STR_PAD_LEFT) ?></span>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5">
                    
                    <div class="row mb-4 pb-4 border-bottom">
                        <div class="col-sm-4 text-muted small fw-bold mb-2 mb-sm-0">NAMA KEPALA KELUARGA</div>
                        <div class="col-sm-8 fw-bold fs-5 text-dark"><?= htmlspecialchars($keluarga['nama_kepala_keluarga']) ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted small fw-bold">NOMOR NIK / KK</div>
                        <div class="col-sm-8 font-monospace"><?= htmlspecialchars($keluarga['nik_kk']) ?></div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted small fw-bold">NOMOR TELEPON</div>
                        <div class="col-sm-8"><?= !empty($keluarga['nomor_telepon']) ? htmlspecialchars($keluarga['nomor_telepon']) : '<span class="text-secondary fst-italic">Tidak ada catatan nomor</span>' ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted small fw-bold">TANGGAL REGISTRASI</div>
                        <div class="col-sm-8 font-monospace text-secondary"><?= date('d F Y, H:i', strtotime($keluarga['tanggal_input'])) ?> WIB</div>
                    </div>

                    <div class="row mb-4 pb-4 border-bottom">
                        <div class="col-sm-4 text-muted small fw-bold">PETUGAS SURVEYOR</div>
                        <div class="col-sm-8 fw-bold text-primary"><i class="bi bi-person-badge me-1"></i><?= htmlspecialchars($keluarga['nama_petugas']) ?></div>
                    </div>

                    <div class="bg-light p-4 rounded-3">
                        <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Informasi Administratif Tempat Tinggal</h6>
                        <div class="row g-3 text-sm">
                            <div class="col-6 col-md-3">
                                <small class="text-muted d-block fw-bold mb-1">Provinsi</small>
                                <strong><?= htmlspecialchars($keluarga['nama_provinsi']) ?></strong>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-muted d-block fw-bold mb-1">Kota/Kab.</small>
                                <strong><?= htmlspecialchars($keluarga['nama_kota']) ?></strong>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-muted d-block fw-bold mb-1">Kecamatan</small>
                                <strong><?= htmlspecialchars($keluarga['nama_kecamatan']) ?></strong>
                            </div>
                            <div class="col-6 col-md-3">
                                <small class="text-muted d-block fw-bold mb-1">Desa/Kelurahan</small>
                                <strong><?= htmlspecialchars($keluarga['nama_desa']) ?></strong>
                            </div>
                            <div class="col-12 mt-3 pt-3 border-top border-white">
                                <small class="text-muted d-block fw-bold mb-1">Alamat Jalan Lengkap</small>
                                <span class="text-dark"><?= htmlspecialchars($keluarga['alamat']) ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 d-flex justify-content-end">
                        <a href="?page=keluarga" class="btn btn-light rounded-pill px-4 fw-bold text-secondary border shadow-sm">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>