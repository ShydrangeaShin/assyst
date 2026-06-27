<div class="container-fluid py-4 fade-up">
    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3 gap-3" style="border-radius: 16px 16px 0 0;">
            <div>
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-shield-check text-primary me-2"></i>Audit Jejak Sistem</h5>
                <small class="text-muted">Merekam seluruh riwayat modifikasi dan aktivitas yang terjadi di dalam AsSyst.</small>
            </div>
            
            <div class="d-flex flex-column flex-md-row gap-2">
                <form action="index.php" method="GET" class="mb-0">
                    <input type="hidden" name="page" value="log">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari user atau aktivitas..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                        <?php if(!empty($_GET['search'])): ?>
                            <a href="?page=log" class="btn btn-outline-danger" title="Reset Pencarian"><i class="bi bi-x-lg"></i></a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #F8F9FA;">
                        <tr>
                            <th width="5%" class="text-center py-3">NO</th>
                            <th width="20%" class="py-3">WAKTU (TIMESTAMP)</th>
                            <th width="25%" class="py-3">AKTOR / PENGGUNA</th>
                            <th width="35%" class="py-3">DESKRIPSI AKTIVITAS</th>
                            <th width="15%" class="py-3">IP ADDRESS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($logs) > 0): ?>
                            <?php $no = 1; while($row = mysqli_fetch_assoc($logs)): ?>
                            <tr class="border-bottom">
                                <td class="text-center py-3 text-muted"><?= $no++ ?></td>
                                <td class="py-3 font-monospace small">
                                    <i class="bi bi-clock me-1 text-secondary"></i>
                                    <?= date('d-m-Y H:i:s', strtotime($row['created_at'])) ?>
                                </td>
                                <td class="py-3">
                                    <strong class="text-dark d-block"><?= htmlspecialchars($row['nama']) ?></strong>
                                    <span class="text-muted small font-monospace">@<?= htmlspecialchars($row['username']) ?></span>
                                    <?php if ($row['nama_role'] == 'Admin'): ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2 ms-1" style="font-size: 0.7rem;">Admin</span>
                                    <?php else: ?>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-2 ms-1" style="font-size: 0.7rem;">Petugas</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 text-secondary small">
                                    <?= htmlspecialchars($row['aktivitas']) ?>
                                </td>
                                <td class="py-3 font-monospace text-muted small">
                                    <?= htmlspecialchars($row['ip_address'] ?? 'Tidak Terdeteksi') ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-clipboard-x fs-1 d-block mb-2 opacity-50"></i>
                                    Tidak ada catatan log aktivitas yang ditemukan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>