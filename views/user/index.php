<div class="container-fluid py-4 fade-up">
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
            <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3" style="border-radius: 16px 16px 0 0;">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-people-fill text-primary me-2"></i>Daftar Pengguna</h5>
            <a href="?page=user-create" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                <i class="bi bi-plus-lg me-1"></i> Tambah Akun
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #F8F9FA;">
                        <tr>
                            <th width="5%" class="text-center py-3">NO</th>
                            <th class="py-3">NAMA LENGKAP</th>
                            <th class="py-3">USERNAME</th>
                            <th class="py-3">OTORITAS ROLE</th>
                            <th class="py-3 text-center">STATUS</th>
                            <th width="12%" class="text-center py-3">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while($row = mysqli_fetch_assoc($users)): ?>
                        <tr class="border-bottom">
                            <td class="text-center py-3 text-muted"><?= $no++ ?></td>
                            <td class="py-3 fw-bold text-dark"><?= htmlspecialchars($row['nama']) ?></td>
                            <td class="py-3 text-secondary font-monospace">@<?= htmlspecialchars($row['username']) ?></td>
                            <td class="py-3">
                                <?php if ($row['id_role'] == 1): ?>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3">Administrator</span>
                                <?php else: ?>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3">Petugas (Surveyor)</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center py-3">
                                <?php if($row['status_akun'] == 'Aktif'): ?>
                                    <i class="bi bi-circle-fill text-success small me-1"></i> <span class="fw-bold text-success small">Aktif</span>
                                <?php else: ?>
                                    <i class="bi bi-circle-fill text-danger small me-1"></i> <span class="fw-bold text-danger small">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center py-3">
                                <a href="?page=user-edit&id=<?= $row['id_user'] ?>" class="btn btn-sm btn-light border shadow-sm rounded-circle text-primary" title="Ubah Data">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="?page=user-delete&id=<?= $row['id_user'] ?>" class="btn btn-sm btn-light border shadow-sm rounded-circle text-danger ms-1" onclick="return confirm('Apakah Anda yakin ingin menghapus akun permanen?');" title="Hapus Data">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>