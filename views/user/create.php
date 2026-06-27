<div class="container-fluid py-4 fade-up">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-person-plus-fill text-primary me-2"></i>Registrasi Akun Baru</h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="?page=user-store" method="POST">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control px-3 py-2" required placeholder="Masukkan nama lengkap user">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Username Login</label>
                                <input type="text" name="username" class="form-control px-3 py-2" required placeholder="Gunakan identifier unik (tanpa spasi)">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Password Keamanan</label>
                                <input type="password" name="password" class="form-control px-3 py-2" required placeholder="Ketik kata sandi minimal 8 karakter">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Otoritas (Role)</label>
                                <select name="id_role" class="form-select px-3 py-2" required>
                                    <option value="" selected disabled>-- Pilih Hak Akses Sistem --</option>
                                    <?php while($r = mysqli_fetch_assoc($roles)): ?>
                                        <option value="<?= $r['id_role'] ?>"><?= htmlspecialchars($r['nama_role']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Status Akun</label>
                                <select name="status_akun" class="form-select px-3 py-2" required>
                                    <option value="Aktif">Aktif Beroperasi</option>
                                    <option value="Nonaktif">Blokir / Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-top d-flex justify-content-end gap-2">
                            <a href="?page=user" class="btn btn-light rounded-pill px-4 fw-bold text-secondary border">Batalkan</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm"><i class="bi bi-save me-2"></i>Simpan Akun</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>