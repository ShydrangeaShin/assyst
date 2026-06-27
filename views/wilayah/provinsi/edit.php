<div class="container-fluid py-4 fade-up">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Modifikasi Data Provinsi</h5>
                </div>
                
                <div class="card-body p-4">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="?page=provinsi-update" method="POST">
                        <input type="hidden" name="id_provinsi" value="<?= htmlspecialchars($data['id_provinsi']) ?>">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Nama Provinsi</label>
                            <input type="text" name="nama_provinsi" class="form-control px-3 py-2" required value="<?= htmlspecialchars($data['nama_provinsi']) ?>" placeholder="Ubah nama provinsi">
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 border-top pt-4 mt-2">
                            <a href="?page=provinsi" class="btn btn-light rounded-pill px-4 fw-bold text-secondary border">Batalkan</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>