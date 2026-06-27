<section class="public-dashboard fade-up">

    <div class="container py-4 py-lg-5">

        <div class="public-summary">

            <div class="public-summary-copy">

                <span class="public-kicker">

                    <i class="bi bi-activity"></i>

                    Dashboard Publik

                </span>

                <h1>

                    Statistik Bantuan Sosial AsSyst

                </h1>

                <p>

                    Pantau ringkasan pendataan keluarga dan hasil penalaran
                    kelayakan bantuan sosial berdasarkan wilayah.

                </p>

            </div>

            <div class="public-summary-panel">

                <div>

                    <span>Keputusan Tercatat</span>

                    <strong><?= number_format($totalKeputusan) ?></strong>

                </div>

            </div>

        </div>

        <form
            id="filterWilayahForm"
            method="GET"
            action="index.php"
            class="public-filter">

            <input
                type="hidden"
                name="page"
                value="dashboard-publik">

            <div class="public-filter-head">

                <div>

                    <h2>Filter Wilayah</h2>

                    <p>Filter statistik sampai tingkat desa/kelurahan.</p>

                </div>

                <a
                    href="?page=dashboard-publik"
                    class="btn btn-outline-secondary">

                    <i class="bi bi-arrow-counterclockwise"></i>

                    Reset

                </a>

            </div>

            <div class="row g-3">

                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        Provinsi
                    </label>

                    <select
                        id="provinsi"
                        name="id_provinsi"
                        class="form-select">

                        <option value="">
                            Semua Provinsi
                        </option>

                        <?php foreach($provinsi as $row): ?>

                            <option
                                value="<?= $row['id_provinsi'] ?>"
                                <?= ((string)$id_provinsi === (string)$row['id_provinsi']) ? 'selected' : '' ?>>

                                <?= htmlspecialchars($row['nama_provinsi']) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        Kota / Kabupaten
                    </label>

                    <select
                        id="kota"
                        name="id_kota"
                        class="form-select"
                        data-selected="<?= htmlspecialchars((string)$id_kota) ?>">

                        <option value="">
                            Semua Kota
                        </option>

                    </select>

                </div>

                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        Kecamatan
                    </label>

                    <select
                        id="kecamatan"
                        name="id_kecamatan"
                        class="form-select"
                        data-selected="<?= htmlspecialchars((string)$id_kecamatan) ?>">

                        <option value="">
                            Semua Kecamatan
                        </option>

                    </select>

                </div>

                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        Desa / Kelurahan
                    </label>

                    <select
                        id="desa"
                        name="id_desa"
                        class="form-select"
                        data-selected="<?= htmlspecialchars((string)$id_desa) ?>">

                        <option value="">
                            Semua Desa/Kelurahan
                        </option>

                    </select>

                </div>

            </div>

        </form>

        <div class="row g-3 g-lg-4 mt-1">

            <div class="col-lg-3 col-md-6">

                <div class="public-stat public-stat-primary">

                    <i class="bi bi-people-fill"></i>

                    <span>Keluarga Terdata</span>

                    <strong><?= number_format($totalKeluarga) ?></strong>
                    
                    <br>       

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="public-stat public-stat-success">

                    <i class="bi bi-check-circle-fill"></i>

                    <span>Layak</span>

                    <strong><?= number_format($totalLayak) ?></strong>

                    <small><?= $persenLayak ?>% dari keputusan</small>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="public-stat public-stat-danger">

                    <i class="bi bi-x-circle-fill"></i>

                    <span>Tidak Layak</span>

                    <strong><?= number_format($totalTidakLayak) ?></strong>

                    <small><?= $persenTidakLayak ?>% dari keputusan</small>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="public-stat public-stat-warning">

                    <i class="bi bi-clipboard-pulse"></i>

                    <span>Perlu Verifikasi</span>

                    <strong><?= number_format($totalVerifikasi) ?></strong>

                    <small><?= $persenVerifikasi ?>% dari keputusan</small>

                </div>

            </div>

        </div>

        <div class="row g-4 mt-1">

            <div class="col-lg-8">

                <div class="public-chart-card">

                    <div class="public-card-head">

                        <div>

                            <h2>Distribusi Status</h2>

                            <p>Komposisi hasil penalaran bantuan sosial.</p>

                        </div>

                    </div>

                    <div class="public-chart-wrap">

                        <canvas id="publikChart"></canvas>

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="public-insight-card">

                    <h2>Ringkasan</h2>

                    <div class="public-insight-row">

                        <span>Total keputusan</span>

                        <strong><?= number_format($totalKeputusan) ?></strong>

                    </div>

                    <div class="public-insight-row">

                        <span>Belum ada hasil</span>

                        <strong><?= number_format(max($totalKeluarga - $totalKeputusan, 0)) ?></strong>

                    </div>

                    <div class="public-progress">

                        <div>
                            <span style="width: <?= $persenLayak ?>%"></span>
                        </div>

                        <small>Proporsi layak: <?= $persenLayak ?>%</small>

                    </div>

                </div>

            </div>

        </div>

        <div class="row g-4 mt-3">

            <div class="col-lg-6">
                <div class="card h-100 border-0" style="border-radius: 20px; box-shadow: 0 2px 8px rgba(0,0,0,.05); padding: 10px;">
                    <div class="card-body">
                        <h5 class="fw-bold mb-1" style="color: #212529; font-size: 1.2rem;">Top 5 Kecamatan (Status Layak)</h5>
                        <p class="text-muted small mb-4">Kecamatan dengan jumlah keluarga layak terbanyak.</p>
                        
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover align-middle mb-0">
                                <thead style="background-color: #EAF0FF; color: #1E56CD;">
                                    <tr>
                                        <th width="10%" class="rounded-start py-3 text-center">No</th>
                                        <th class="py-3">Kecamatan</th>
                                        <th width="35%" class="rounded-end py-3 text-center">Total Layak</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    if(isset($ranking) && mysqli_num_rows($ranking) > 0): 
                                        while($row = mysqli_fetch_assoc($ranking)): ?>
                                    <tr>
                                        <td class="py-3 text-center"><?= $no++ ?></td>
                                        <td class="py-3"><?= htmlspecialchars($row['nama_kecamatan']) ?></td>
                                        <td class="py-3 text-center"><strong><?= number_format($row['jumlah']) ?></strong></td>
                                    </tr>
                                    <?php endwhile; else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">Data tidak ditemukan</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card h-100 border-0" style="border-radius: 20px; box-shadow: 0 2px 8px rgba(0,0,0,.05); padding: 10px;">
                    <div class="card-body">
                        <h5 class="fw-bold mb-1" style="color: #212529; font-size: 1.2rem;">Top 10 Desa (Keluarga Terdata)</h5>
                        <p class="text-muted small mb-4">Desa atau kelurahan dengan data pendataan terbanyak.</p>
                        
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover align-middle mb-0">
                                <thead style="background-color: #EAF0FF; color: #1E56CD;">
                                    <tr>
                                        <th width="10%" class="rounded-start py-3 text-center">No</th>
                                        <th class="py-3">Desa / Kelurahan</th>
                                        <th width="35%" class="rounded-end py-3 text-center">Total Terdata</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    if(isset($statistikWilayah) && mysqli_num_rows($statistikWilayah) > 0): 
                                        while($row = mysqli_fetch_assoc($statistikWilayah)): ?>
                                    <tr>
                                        <td class="py-3 text-center"><?= $no++ ?></td>
                                        <td class="py-3"><?= htmlspecialchars($row['nama_desa']) ?></td>
                                        <td class="py-3 text-center"><strong><?= number_format($row['total']) ?></strong></td>
                                    </tr>
                                    <?php endwhile; else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">Data tidak ditemukan</td>
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

</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filterWilayahForm');
    const provinsiSelect = document.getElementById('provinsi');
    const kotaSelect = document.getElementById('kota');
    const kecamatanSelect = document.getElementById('kecamatan');
    const desaSelect = document.getElementById('desa');
    const kotaData = <?= json_encode($kota, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
    const kecamatanData = <?= json_encode($kecamatan, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
    const desaData = <?= json_encode($desa, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;

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
            if (String(row.id_provinsi) !== String(provinsiId)) {
                return;
            }

            addOption(
                kotaSelect,
                String(row.id_kota),
                row.nama_kota,
                String(row.id_kota) === String(selectedKota)
            );
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
            if (String(row.id_kota) !== String(kotaId)) {
                return;
            }

            addOption(
                kecamatanSelect,
                String(row.id_kecamatan),
                row.nama_kecamatan,
                String(row.id_kecamatan) === String(selectedKecamatan)
            );
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
            if (String(row.id_kecamatan) !== String(kecamatanId)) {
                return;
            }

            addOption(
                desaSelect,
                String(row.id_desa),
                row.nama_desa,
                String(row.id_desa) === String(selectedDesa)
            );
        });
    }

    renderKotaOptions();

    provinsiSelect.addEventListener('change', function() {
        kotaSelect.dataset.selected = '';
        kecamatanSelect.dataset.selected = '';
        desaSelect.dataset.selected = '';
        renderKotaOptions();
        form.submit();
    });

    kotaSelect.addEventListener('change', function() {
        kotaSelect.dataset.selected = kotaSelect.value;
        kecamatanSelect.dataset.selected = '';
        desaSelect.dataset.selected = '';
        renderKecamatanOptions();
        form.submit();
    });

    kecamatanSelect.addEventListener('change', function() {
        kecamatanSelect.dataset.selected = kecamatanSelect.value;
        desaSelect.dataset.selected = '';
        renderDesaOptions();
        form.submit();
    });

    desaSelect.addEventListener('change', function() {
        desaSelect.dataset.selected = desaSelect.value;
        form.submit();
    });

    const chartCanvas = document.getElementById('publikChart');

    if (chartCanvas && window.Chart) {
        new Chart(chartCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Layak', 'Tidak Layak', 'Perlu Verifikasi'],
                datasets: [{
                    data: [
                        <?= (int)$totalLayak ?>,
                        <?= (int)$totalTidakLayak ?>,
                        <?= (int)$totalVerifikasi ?>
                    ],
                    backgroundColor: ['#2F9E44', '#E03131', '#F59F00'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            padding: 18
                        }
                    }
                }
            }
        });
    }
});
</script>