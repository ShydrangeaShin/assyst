<div class="container-fluid py-4 fade-up">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-info-circle-fill text-info me-2"></i>Detail Informasi Kecamatan</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <tr>
                                <td width="40%" class="text-muted fw-bold small py-2">KODE REFERENSI (ID)</td>
                                <td width="5%" class="py-2">:</td>
                                <td class="fw-bold text-dark py-2 font-monospace">#<?= htmlspecialchars($kecamatan['id_kecamatan']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-bold small py-2">NAMA KECAMATAN</td>
                                <td class="py-2">:</td>
                                <td class="fw-bold text-dark py-2"><?= htmlspecialchars($kecamatan['nama_kecamatan']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-bold small py-2">KOTA/KABUPATEN INDUK</td>
                                <td class="py-2">:</td>
                                <td class="fw-bold text-dark py-2"><?= htmlspecialchars($kecamatan['nama_kota'] ?? 'Tidak Diketahui') ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="mt-4 pt-4 border-top d-flex justify-content-end">
                        <a href="?page=kecamatan" class="btn btn-light rounded-pill px-4 fw-bold text-secondary border shadow-sm">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>