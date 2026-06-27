<div class="container-fluid py-4 fade-up">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Modifikasi Data Desa/Kelurahan</h5>
                </div>
                
                <div class="card-body p-4">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="?page=desa-update" method="POST">
                        <input type="hidden" name="id_desa" value="<?= htmlspecialchars($desa['id_desa']) ?>">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Kecamatan Induk</label>
                            <select name="id_kecamatan" class="form-select px-3 py-2" required>
                                <?php if(isset($kecamatan)): ?>
                                    <?php while($k = mysqli_fetch_assoc($kecamatan)): ?>
                                        <option value="<?= $k['id_kecamatan'] ?>" <?= ($k['id_kecamatan'] == $desa['id_kecamatan']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($k['nama_kecamatan']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Nama Desa / Kelurahan</label>
                            <input type="text" name="nama_desa" class="form-control px-3 py-2" required value="<?= htmlspecialchars($desa['nama_desa']) ?>" placeholder="Ubah nama desa/kelurahan">
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 border-top pt-4 mt-2">
                            <a href="?page=desa" class="btn btn-light rounded-pill px-4 fw-bold text-secondary border">Batalkan</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>