<div class="container-fluid py-4 fade-up">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Modifikasi Data Kota</h5>
                </div>
                
                <div class="card-body p-4">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="?page=kota-update" method="POST">
                        <input type="hidden" name="id_kota" value="<?= htmlspecialchars($kota['id_kota']) ?>">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Provinsi Induk</label>
                            <select name="id_provinsi" class="form-select px-3 py-2" required>
                                <?php if(isset($provinsi)): ?>
                                    <?php while($p = mysqli_fetch_assoc($provinsi)): ?>
                                        <option value="<?= $p['id_provinsi'] ?>" <?= ($p['id_provinsi'] == $kota['id_provinsi']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($p['nama_provinsi']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Nama Kota / Kabupaten</label>
                            <input type="text" name="nama_kota" class="form-control px-3 py-2" required value="<?= htmlspecialchars($kota['nama_kota']) ?>" placeholder="Ubah nama kota">
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 border-top pt-4 mt-2">
                            <a href="?page=kota" class="btn btn-light rounded-pill px-4 fw-bold text-secondary border">Batalkan</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>