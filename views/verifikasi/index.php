<div class="container-fluid py-4 fade-up">
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 12px;">
            <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 12px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3 gap-3" style="border-radius: 16px 16px 0 0;">
            <div>
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-patch-check-fill text-primary me-2"></i>Validasi Data Survei</h5>
                <small class="text-muted">Menunggu persetujuan Admin sebelum sistem melakukan penalaran.</small>
            </div>
            
            <form action="index.php" method="GET" class="mb-0">
                <input type="hidden" name="page" value="verifikasi">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari NIK / Nama..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                    <?php if(!empty($_GET['search'])): ?>
                        <a href="?page=verifikasi" class="btn btn-outline-danger" title="Reset"><i class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #F8F9FA;">
                        <tr>
                            <th width="5%" class="text-center py-3">NO</th>
                            <th width="25%" class="py-3">IDENTITAS KELUARGA</th>
                            <th width="20%" class="py-3">LOKASI DESA</th>
                            <th width="20%" class="py-3">PETUGAS SURVEYOR</th>
                            <th width="15%" class="text-center py-3">STATUS VERIFIKASI</th>
                            <th width="15%" class="text-center py-3">TINJAU & VALIDASI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($data) > 0): ?>
                            <?php $no = 1; while($row = mysqli_fetch_assoc($data)): ?>
                            <tr class="border-bottom">
                                <td class="text-center py-3 text-muted"><?= $no++ ?></td>
                                <td class="py-3">
                                    <strong class="d-block text-dark"><?= htmlspecialchars($row['nama_kepala_keluarga']) ?></strong>
                                    <span class="text-secondary font-monospace small">NIK: <?= htmlspecialchars($row['nik_kk']) ?></span>
                                </td>
                                <td class="py-3 text-secondary small">Desa <?= htmlspecialchars($row['nama_desa']) ?></td>
                                <td class="py-3 small text-secondary"><i class="bi bi-person-badge me-1"></i><?= htmlspecialchars($row['nama_petugas']) ?></td>
                                <td class="text-center py-3">
                                    <?php 
                                        $status = $row['status_verifikasi'] ?? 'Pending';
                                        if ($status == 'Valid') {
                                            echo '<span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2"><i class="bi bi-check2-all me-1"></i>Tervalidasi</span>';
                                        } else if ($status == 'Ditolak') {
                                            echo '<span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-2"><i class="bi bi-x-circle me-1"></i>Ditolak</span>';
                                        } else {
                                            echo '<span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-2"><i class="bi bi-hourglass-split me-1"></i>Menunggu</span>';
                                        }
                                    ?>
                                </td>
                                <td class="text-center py-3">
                                    <a href="?page=verifikasi-detail&id=<?= $row['id_keluarga'] ?>" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm fw-bold">
                                        <i class="bi bi-search me-1"></i>Tinjau Data
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center py-5 text-muted"><i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>Belum ada data survei yang siap diverifikasi.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>