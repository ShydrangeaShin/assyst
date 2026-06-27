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
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pin-map-fill text-primary me-2"></i>Data Master Desa / Kelurahan</h5>
            
            <div class="d-flex flex-column flex-md-row gap-2">
                <form action="index.php" method="GET" class="mb-0">
                    <input type="hidden" name="page" value="desa">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari desa..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                        <?php if(!empty($_GET['search'])): ?>
                            <a href="?page=desa" class="btn btn-outline-danger" title="Reset Pencarian"><i class="bi bi-x-lg"></i></a>
                        <?php endif; ?>
                    </div>
                </form>

                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold text-nowrap" data-bs-toggle="modal" data-bs-target="#modalTambahDesa">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Data
                </button>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #F8F9FA;">
                        <tr>
                            <th width="5%" class="text-center py-3">NO</th>
                            <th class="py-3">NAMA DESA / KELURAHAN</th>
                            <th class="py-3">KECAMATAN INDUK</th>
                            <th width="15%" class="text-center py-3">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($desa) > 0): ?>
                            <?php $no = 1; foreach($desa as $row): ?>
                            <tr class="border-bottom">
                                <td class="text-center py-3 text-muted"><?= $no++ ?></td>
                                <td class="py-3 fw-bold text-dark"><?= htmlspecialchars($row['nama_desa']) ?></td>
                                <td class="py-3 text-secondary"><?= htmlspecialchars($row['nama_kecamatan'] ?? 'Tidak Diketahui') ?></td>
                                <td class="text-center py-3 text-nowrap">
                                    <a href="?page=desa-detail&id=<?= $row['id_desa'] ?>" class="btn btn-sm btn-light border shadow-sm rounded-circle text-info" title="Detail">
                                        <i class="bi bi-info-circle"></i>
                                    </a>
                                    <a href="?page=desa-edit&id=<?= $row['id_desa'] ?>" class="btn btn-sm btn-light border shadow-sm rounded-circle text-primary ms-1" title="Ubah Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    
                                    <?php if ($row['can_delete']): ?>
                                        <a href="?page=desa-delete&id=<?= $row['id_desa'] ?>" class="btn btn-sm btn-light border shadow-sm rounded-circle text-danger ms-1" onclick="return confirm('Hapus desa/kelurahan ini secara permanen?');" title="Hapus Data">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-light border shadow-sm rounded-circle text-muted ms-1" title="Data sedang terhubung dengan data keluarga" disabled>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                    Data desa atau kelurahan belum tersedia.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahDesa" tabindex="-1" aria-labelledby="modalTambahDesaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="modal-title fw-bold text-dark" id="modalTambahDesaLabel"><i class="bi bi-plus-circle-fill text-primary me-2"></i>Registrasi Desa Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="?page=desa-store" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Kecamatan Induk</label>
                        <select name="id_kecamatan" class="form-select px-3 py-2" required>
                            <option value="" selected disabled>-- Pilih Kecamatan --</option>
                            <?php if(isset($kecamatan) && mysqli_num_rows($kecamatan) > 0): ?>
                                <?php while($k = mysqli_fetch_assoc($kecamatan)): ?>
                                    <option value="<?= $k['id_kecamatan'] ?>"><?= htmlspecialchars($k['nama_kecamatan']) ?></option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold small text-muted">Nama Desa / Kelurahan</label>
                        <input type="text" name="nama_desa" class="form-control px-3 py-2" required placeholder="Contoh: Purus">
                    </div>
                </div>
                <div class="modal-footer border-top-0 pb-4 px-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold"><i class="bi bi-save me-2"></i>Simpan Desa</button>
                </div>
            </form>
        </div>
    </div>
</div>