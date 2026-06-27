<div class="container-fluid py-4 fade-up">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-person-lines-fill text-primary me-2"></i>Modifikasi Data Akun</h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="?page=user-update" method="POST">
                        <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control px-3 py-2" required value="<?= htmlspecialchars($user['nama']) ?>">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Username Login</label>
                                <input type="text" name="username" class="form-control px-3 py-2" required value="<?= htmlspecialchars($user['username']) ?>">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Password Keamanan <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control px-3 py-2" placeholder="Kosongkan jika tidak ingin merubah sandi">
                                <small class="text-muted fst-italic mt-1 d-block">Abaikan isian ini jika password tidak diubah.</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Otoritas (Role)</label>
                                <select name="id_role" class="form-select px-3 py-2" required>
                                    <?php while($r = mysqli_fetch_assoc($roles)): ?>
                                        <option value="<?= $r['id_role'] ?>" <?= ($r['id_role'] == $user['id_role']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($r['nama_role']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Status Akun</label>
                                <select name="status_akun" class="form-select px-3 py-2" required>
                                    <option value="Aktif" <?= ($user['status_akun'] == 'Aktif') ? 'selected' : '' ?>>Aktif Beroperasi</option>
                                    <option value="Nonaktif" <?= ($user['status_akun'] == 'Nonaktif') ? 'selected' : '' ?>>Blokir / Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-top d-flex justify-content-end gap-2">
                            <a href="?page=user" class="btn btn-light rounded-pill px-4 fw-bold text-secondary border">Batalkan</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>