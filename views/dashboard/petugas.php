<div class="container-fluid py-4 fade-up">

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; background: linear-gradient(135deg, #1E56CD 0%, #153D93 100%); color: white;">
                <div class="card-body p-4 p-md-5 d-flex align-items-center justify-content-between position-relative overflow-hidden">
                    <div style="z-index: 2;">
                        <h3 class="fw-bold mb-2">Selamat Datang, <?= htmlspecialchars($_SESSION['user']['nama']) ?>! 👋</h3>
                        <p class="mb-0 opacity-75">Pantau terus tugas survei lapangan Anda. Pastikan data keluarga terinput dengan akurat.</p>
                    </div>
                    <i class="bi bi-clipboard-data position-absolute opacity-25" style="right: 30px; top: -10px; font-size: 8rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <h2 class="fw-bold mb-1"><?= number_format($totalKeluarga) ?></h2>
                    <p class="text-muted small fw-bold mb-0">TOTAL KELUARGA DISURVEI</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger-subtle text-danger mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-calendar-x fs-3"></i>
                    </div>
                    <h2 class="fw-bold mb-1 text-danger"><?= number_format($tugasBelum) ?></h2>
                    <p class="text-muted small fw-bold mb-0">TUGAS BELUM DIKERJAKAN</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-info-subtle text-info mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-arrow-repeat fs-3"></i>
                    </div>
                    <h2 class="fw-bold mb-1 text-info"><?= number_format($tugasProses) ?></h2>
                    <p class="text-muted small fw-bold mb-0">TUGAS DALAM PROSES</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success-subtle text-success mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-check-circle fs-3"></i>
                    </div>
                    <h2 class="fw-bold mb-1 text-success"><?= number_format($tugasSelesai) ?></h2>
                    <p class="text-muted small fw-bold mb-0">TUGAS SELESAI</p>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 border-bottom pb-2"><i class="bi bi-bar-chart-fill text-primary me-2"></i>Kinerja Survei</h6>
                    <p class="text-muted small mb-4">Persentase penyelesaian tugas lapangan yang diberikan oleh Administrator kepada Anda.</p>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold small text-secondary">Progres Penyelesaian</span>
                        <span class="fw-bold text-success fs-5"><?= $persenSelesai ?>%</span>
                    </div>
                    <div class="progress" style="height: 14px; border-radius: 30px; background-color: #E9ECEF;">
                        <div class="progress-bar bg-success rounded-pill progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?= $persenSelesai ?>%"></div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex justify-content-between small mb-2">
                            <span class="text-muted">Total Tugas Diterima:</span>
                            <strong class="text-dark"><?= number_format($totalTugas) ?> Tugas</strong>
                        </div>
                        <a href="?page=tugas" class="btn btn-outline-primary w-100 rounded-pill mt-2 fw-bold">Lihat Semua Tugas</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom-0" style="border-radius: 16px 16px 0 0;">
                    <h6 class="fw-bold mb-0"><i class="bi bi-list-check text-primary me-2"></i>Tugas Terbaru Anda</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background-color: #F8F9FA;">
                                <tr>
                                    <th width="30%" class="py-3 px-4">TANGGAL & NAMA TUGAS</th>
                                    <th width="30%" class="py-3">LOKASI SURVEI</th>
                                    <th width="20%" class="py-3 text-center">STATUS</th>
                                    <th width="10%" class="py-3 text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($tugasTerbaru) > 0): ?>
                                    <?php while($row = mysqli_fetch_assoc($tugasTerbaru)): ?>
                                    <tr class="border-bottom">
                                        <td class="py-3 px-4">
                                            <strong class="d-block text-dark small"><?= htmlspecialchars($row['nama_tugas']) ?></strong>
                                            <span class="text-muted font-monospace" style="font-size: 0.75rem;"><i class="bi bi-calendar-event me-1"></i><?= date('d-m-Y', strtotime($row['tanggal_penugasan'])) ?></span>
                                        </td>
                                        <td class="py-3">
                                            <?php if(!empty($row['id_desa'])): ?>
                                                <span class="d-block fw-bold text-primary small">Desa <?= htmlspecialchars($row['nama_desa']) ?></span>
                                                <span class="text-muted" style="font-size:0.75rem;">Kec. <?= htmlspecialchars($row['nama_kecamatan']) ?>, <?= htmlspecialchars($row['nama_kota']) ?></span>
                                            <?php else: ?>
                                                <span class="text-danger small fst-italic">Lokasi belum diatur</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-3 text-center">
                                            <?php if($row['status_tugas'] == 'Selesai'): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Selesai</span>
                                            <?php elseif($row['status_tugas'] == 'Proses'): ?>
                                                <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3">Proses</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3">Belum Dikerjakan</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-3 text-center">
                                            <a href="?page=tugas-edit&id=<?= $row['id_tugas'] ?>" class="btn btn-sm btn-light border shadow-sm rounded-circle text-primary" title="Update Progres">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-check2-circle fs-2 d-block mb-2 opacity-50"></i>
                                            Belum ada tugas lapangan yang diberikan kepada Anda.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>