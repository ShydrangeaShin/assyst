<?php
// Perhitungan proporsi penyelesaian dan komposisi penalaran
$totalKeputusan = $totalLayak + $totalTidakLayak + $totalVerifikasi;
$persenLayak = $totalKeputusan > 0 ? round(($totalLayak / $totalKeputusan) * 100, 1) : 0;
$persenTidakLayak = $totalKeputusan > 0 ? round(($totalTidakLayak / $totalKeputusan) * 100, 1) : 0;
$persenVerifikasi = $totalKeputusan > 0 ? round(($totalVerifikasi / $totalKeputusan) * 100, 1) : 0;

$belumDiproses = max($totalKeluarga - $totalKeputusan, 0);
$persenSelesai = $totalKeluarga > 0 ? round(($totalKeputusan / $totalKeluarga) * 100, 1) : 0;
?>

<div class="container-fluid py-4 fade-up">
    <div class="row g-3 mb-4">
        <div class="col-lg-6 col-md-6">
            <div class="card border-0 shadow-sm position-relative overflow-hidden" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="text-muted fw-bold mb-0" style="font-size: 0.85rem; letter-spacing: 0.5px;">PETUGAS LAPANGAN AKTIF</h6>
                        <span class="badge bg-info-light text-info rounded-pill px-2 py-1 small" style="background-color: #E0F7FA; color: #006064;">Petugas</span>
                    </div>
                    <h2 class="fw-bold mb-1" style="color: var(--text);"><?= number_format($totalPetugas) ?></h2>
                    <p class="text-muted small mb-0"><i class="bi bi-person-badge text-info me-1"></i> Personel terdaftar sistem</p>
                    <i class="bi bi-person-bounding-box position-absolute text-info opacity-25" style="right: 20px; bottom: 10px; font-size: 3.5rem;"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="card border-0 shadow-sm position-relative overflow-hidden" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="text-muted fw-bold mb-0" style="font-size: 0.85rem; letter-spacing: 0.5px;">CAKUPAN WILAYAH NASIONAL</h6>
                        <span class="badge rounded-pill px-2 py-1 small" style="background-color: #F3E5F5; color: #4A148C;">Hierarki</span>
                    </div>
                    <h2 class="fw-bold mb-1" style="color: var(--text);"><?= number_format($totalWilayah) ?></h2>
                    <p class="text-muted small mb-0"><i class="bi bi-geo-alt text-purple me-1"></i> Agregat wilayah operasional</p>
                    <i class="bi bi-globe position-absolute opacity-25" style="right: 20px; bottom: 10px; font-size: 3.5rem; color: #4A148C;"></i>
                </div>
            </div>
        </div>
    </div>

    <form id="filterWilayahForm" method="GET" action="index.php" class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
        <input type="hidden" name="page" value="dashboard-admin">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h5 class="fw-bold mb-1"><i class="bi bi-funnel text-primary me-2"></i>Filter Penampang Data</h5>
                    <p class="text-muted small mb-0">Terapkan filter lokasi untuk meninjau status laporan dan riwayat log spesifik per wilayah.</p>
                </div>
                <a href="?page=dashboard-admin" class="btn btn-light border-0 shadow-sm text-primary rounded-pill px-3 fw-bold">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
            
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-bold">Provinsi</label>
                    <select id="provinsi" name="id_provinsi" class="form-select">
                        <option value="">Semua Provinsi</option>
                        <?php foreach($provinsi as $row): ?>
                            <option value="<?= $row['id_provinsi'] ?>" <?= ((string)$id_provinsi === (string)$row['id_provinsi']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['nama_provinsi']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-bold">Kota / Kabupaten</label>
                    <select id="kota" name="id_kota" class="form-select" data-selected="<?= htmlspecialchars((string)$id_kota) ?>">
                        <option value="">Semua Kota</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-bold">Kecamatan</label>
                    <select id="kecamatan" name="id_kecamatan" class="form-select" data-selected="<?= htmlspecialchars((string)$id_kecamatan) ?>">
                        <option value="">Semua Kecamatan</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-bold">Desa / Kelurahan</label>
                    <select id="desa" name="id_desa" class="form-select" data-selected="<?= htmlspecialchars((string)$id_desa) ?>">
                        <option value="">Semua Desa/Kelurahan</option>
                    </select>
                </div>
            </div>
        </div>
    </form>

    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; padding: 15px;">
                <div class="card-body">
                    <h5 class="fw-bold text-dark mb-1"><i class="bi bi-clipboard-data-fill text-primary me-2"></i>Ringkasan Laporan Penalaran</h5>
                    <p class="text-muted small mb-4">Pantauan kinerja pemrosesan data keluarga sesuai filter wilayah aktif.</p>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background-color: #F8F9FA; border-left: 4px solid var(--text-muted);">
                                <small class="text-muted d-block fw-bold mb-1">TOTAL KELUARGA TERDATA</small>
                                <strong class="fs-3"><?= number_format($totalKeluarga) ?></strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background-color: #EAF0FF; border-left: 4px solid var(--primary);">
                                <small class="text-primary d-block fw-bold mb-1">SELESAI DIPROSES</small>
                                <strong class="fs-3 text-primary"><?= number_format($totalKeputusan) ?></strong>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label d-flex justify-content-between small fw-bold text-secondary mb-1">
                            <span>Saturasi Pemrosesan (Beban Kerja Terselesaikan)</span>
                            <span><?= $persenSelesai ?>%</span>
                        </label>
                        <div class="progress" style="height: 12px; border-radius: 30px; background-color: #E9ECEF;">
                            <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: <?= $persenSelesai ?>%"></div>
                        </div>
                        <small class="text-muted d-block mt-2"><i class="bi bi-info-circle me-1"></i>Terdapat <strong><?= number_format($belumDiproses) ?></strong> keluarga yang masih belum memiliki keputusan status bansos.</small>
                    </div>

                    <div class="row g-2 text-center mt-3 border-top pt-3">
                        <div class="col-4">
                            <span class="d-block text-success fw-bold fs-5"><?= number_format($totalLayak) ?></span>
                            <small class="text-muted">Layak</small>
                        </div>
                        <div class="col-4">
                            <span class="d-block text-danger fw-bold fs-5"><?= number_format($totalTidakLayak) ?></span>
                            <small class="text-muted">Tidak Layak</small>
                        </div>
                        <div class="col-4">
                            <span class="d-block text-warning fw-bold fs-5"><?= number_format($totalVerifikasi) ?></span>
                            <small class="text-muted">Verifikasi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; padding: 15px;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-1"><i class="bi bi-pie-chart-fill text-primary me-2"></i>Distribusi Keputusan</h5>
                        <p class="text-muted small mb-3">Proporsi kelayakan yang disimpulkan oleh sistem.</p>
                    </div>
                    <div class="position-relative my-auto flex-grow-1 d-flex align-items-center justify-content-center" style="min-height: 220px;">
                        <canvas id="adminDashboardChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-2" style="border-radius: 20px;">
        <div class="card-body p-0">
            <div class="p-4 border-bottom">
                <h5 class="fw-bold mb-1"><i class="bi bi-clock-history text-primary me-2"></i>Riwayat Sistem Terkini</h5>
                <p class="text-muted small mb-0">Lima (5) jejak entri pendataan atau modifikasi hasil terakhir pada area ini.</p>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle mb-0">
                    <thead style="background-color: #F8F9FA;">
                        <tr>
                            <th width="15%" class="py-3 px-4 text-muted small">KODE REF</th>
                            <th width="45%" class="py-3 text-muted small">LOKASI DESA</th>
                            <th width="40%" class="py-3 px-4 text-muted small">STATUS AKHIR PENALARAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(isset($logTerbaru) && mysqli_num_rows($logTerbaru) > 0): 
                            while($row = mysqli_fetch_assoc($logTerbaru)): ?>
                        <tr style="border-bottom: 1px solid #F1F3F5;">
                            <td class="py-3 px-4"><span class="badge bg-light text-dark border font-monospace">#<?= str_pad($row['id_keluarga'], 5, '0', STR_PAD_LEFT) ?></span></td>
                            <td class="py-3 fw-bold text-secondary"><?= htmlspecialchars($row['nama_desa']) ?></td>
                            <td class="py-3 px-4">
                                <?php if ($row['status_hasil'] == 'LAYAK'): ?>
                                    <span class="badge bg-success-subtle text-success px-3 py-2 border border-success-subtle rounded-pill">Layak Menerima</span>
                                <?php elseif ($row['status_hasil'] == 'TIDAK LAYAK'): ?>
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 border border-danger-subtle rounded-pill">Ditolak / Tidak Layak</span>
                                <?php elseif ($row['status_hasil'] == 'PERLU VERIFIKASI'): ?>
                                    <span class="badge bg-warning-subtle text-warning px-3 py-2 border border-warning-subtle rounded-pill">Manual Verifikasi</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2 border border-secondary-subtle rounded-pill">Pending / Draft</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                Belum ada riwayat aktivitas pada sektor wilayah ini.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Script Engine untuk Dropdown Interaktif
    const form = document.getElementById('filterWilayahForm');
    const provinsiSelect = document.getElementById('provinsi');
    const kotaSelect = document.getElementById('kota');
    const kecamatanSelect = document.getElementById('kecamatan');
    const desaSelect = document.getElementById('desa');
    const kotaData = <?= json_encode($kota ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
    const kecamatanData = <?= json_encode($kecamatan ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
    const desaData = <?= json_encode($desa ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;

    function addOption(select, value, text, selected) {
        const option = document.createElement('option');
        option.value = value;
        option.textContent = text;
        option.selected = selected;
        select.appendChild(option);
    }

    function renderKotaOptions() {
        const provinsiId = provinsiSelect.value;
        const selectedKota = kotaSelect.dataset.selected || '';
        kotaSelect.innerHTML = '';
        addOption(kotaSelect, '', 'Semua Kota', selectedKota === '');
        kotaSelect.disabled = provinsiId === '';

        if (provinsiId === '') {
            kotaSelect.dataset.selected = '';
            renderKecamatanOptions();
            return;
        }

        kotaData.forEach(function(row) {
            if (String(row.id_provinsi) !== String(provinsiId)) return;
            addOption(kotaSelect, String(row.id_kota), row.nama_kota, String(row.id_kota) === String(selectedKota));
        });
        renderKecamatanOptions();
    }

    function renderKecamatanOptions() {
        const kotaId = kotaSelect.value;
        const selectedKecamatan = kecamatanSelect.dataset.selected || '';
        kecamatanSelect.innerHTML = '';
        addOption(kecamatanSelect, '', 'Semua Kecamatan', selectedKecamatan === '');
        kecamatanSelect.disabled = kotaId === '';

        if (kotaId === '') {
            kecamatanSelect.dataset.selected = '';
            renderDesaOptions();
            return;
        }

        kecamatanData.forEach(function(row) {
            if (String(row.id_kota) !== String(kotaId)) return;
            addOption(kecamatanSelect, String(row.id_kecamatan), row.nama_kecamatan, String(row.id_kecamatan) === String(selectedKecamatan));
        });
        renderDesaOptions();
    }

    function renderDesaOptions() {
        const kecamatanId = kecamatanSelect.value;
        const selectedDesa = desaSelect.dataset.selected || '';
        desaSelect.innerHTML = '';
        addOption(desaSelect, '', 'Semua Desa/Kelurahan', selectedDesa === '');
        desaSelect.disabled = kecamatanId === '';

        if (kecamatanId === '') {
            desaSelect.dataset.selected = '';
            return;
        }

        desaData.forEach(function(row) {
            if (String(row.id_kecamatan) !== String(kecamatanId)) return;
            addOption(desaSelect, String(row.id_desa), row.nama_desa, String(row.id_desa) === String(selectedDesa));
        });
    }

    renderKotaOptions();

    provinsiSelect.addEventListener('change', function() {
        kotaSelect.dataset.selected = ''; kecamatanSelect.dataset.selected = ''; desaSelect.dataset.selected = '';
        renderKotaOptions(); form.submit();
    });
    kotaSelect.addEventListener('change', function() {
        kotaSelect.dataset.selected = kotaSelect.value; kecamatanSelect.dataset.selected = ''; desaSelect.dataset.selected = '';
        renderKecamatanOptions(); form.submit();
    });
    kecamatanSelect.addEventListener('change', function() {
        kecamatanSelect.dataset.selected = kecamatanSelect.value; desaSelect.dataset.selected = '';
        renderDesaOptions(); form.submit();
    });
    desaSelect.addEventListener('change', function() {
        desaSelect.dataset.selected = desaSelect.value;
        form.submit();
    });

    // 2. Chart.js Render Engine
    const adminCanvas = document.getElementById('adminDashboardChart');
    if (adminCanvas && window.Chart) {
        new Chart(adminCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Layak', 'Tidak Layak', 'Perlu Verifikasi'],
                datasets: [{
                    data: [<?= (int)$totalLayak ?>, <?= (int)$totalTidakLayak ?>, <?= (int)$totalVerifikasi ?>],
                    backgroundColor: ['#28A745', '#DC3545', '#FFC107'],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, boxWidth: 10, padding: 20, font: { size: 12 } }
                    }
                }
            }
        });
    }
});
</script>