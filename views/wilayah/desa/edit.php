<?php
$row = $desa ?? $data ?? [];
$selectedProvinsi = $row['id_provinsi'] ?? $row['provinsi_id'] ?? '';
$selectedKota = $row['id_kota'] ?? $row['kota_id'] ?? '';
$selectedKecamatan = $row['id_kecamatan'] ?? $row['kecamatan_id'] ?? '';
$selectedJenis = $row['jenis'] ?? 'Desa';
$idDesa = $row['id_desa'] ?? $row['id'] ?? '';
?>

<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white">

        <h4 class="fw-bold mb-0">

            Edit Desa / Kelurahan

        </h4>

    </div>

    <form
        method="POST"
        action="?page=desa-update">

        <div class="card-body">

            <input
                type="hidden"
                name="id_desa"
                value="<?= htmlspecialchars($idDesa) ?>">

            <div class="mb-3">

                <label class="form-label">

                    Provinsi

                </label>

                <select
                    id="provinsi"
                    class="form-select"
                    required>

                    <?php foreach(($provinsi ?? []) as $item): ?>

                        <?php $idProvinsi = $item['id_provinsi'] ?? $item['id'] ?? ''; ?>

                        <option
                            value="<?= htmlspecialchars($idProvinsi) ?>"
                            <?= ((string)$idProvinsi === (string)$selectedProvinsi) ? 'selected' : '' ?>>

                            <?= htmlspecialchars($item['nama_provinsi'] ?? '') ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Kota / Kabupaten

                </label>

                <select
                    id="kota"
                    class="form-select"
                    required>

                    <?php foreach(($kota ?? []) as $item): ?>

                        <?php $idKota = $item['id_kota'] ?? $item['id'] ?? ''; ?>

                        <option
                            value="<?= htmlspecialchars($idKota) ?>"
                            data-provinsi="<?= htmlspecialchars($item['id_provinsi'] ?? '') ?>"
                            <?= ((string)$idKota === (string)$selectedKota) ? 'selected' : '' ?>>

                            <?= htmlspecialchars($item['nama_kota'] ?? '') ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Kecamatan

                </label>

                <select
                    id="kecamatan"
                    name="id_kecamatan"
                    class="form-select"
                    required>

                    <?php foreach(($kecamatan ?? []) as $item): ?>

                        <?php $idKecamatan = $item['id_kecamatan'] ?? $item['id'] ?? ''; ?>

                        <option
                            value="<?= htmlspecialchars($idKecamatan) ?>"
                            data-kota="<?= htmlspecialchars($item['id_kota'] ?? '') ?>"
                            <?= ((string)$idKecamatan === (string)$selectedKecamatan) ? 'selected' : '' ?>>

                            <?= htmlspecialchars($item['nama_kecamatan'] ?? '') ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Jenis

                </label>

                <select
                    name="jenis"
                    class="form-select"
                    required>

                    <option
                        value="Desa"
                        <?= $selectedJenis === 'Desa' ? 'selected' : '' ?>>

                        Desa

                    </option>

                    <option
                        value="Kelurahan"
                        <?= $selectedJenis === 'Kelurahan' ? 'selected' : '' ?>>

                        Kelurahan

                    </option>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Nama Desa / Kelurahan

                </label>

                <input
                    type="text"
                    name="nama_desa"
                    class="form-control"
                    value="<?= htmlspecialchars($row['nama_desa'] ?? '') ?>"
                    required>

            </div>

        </div>

        <div class="card-footer bg-white">

            <a
                href="?page=desa"
                class="btn btn-secondary">

                Batal

            </a>

            <button class="btn btn-primary">

                Simpan Perubahan

            </button>

        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinsiSelect = document.getElementById('provinsi');
    const kotaSelect = document.getElementById('kota');
    const kecamatanSelect = document.getElementById('kecamatan');
    const selectedKota = '<?= htmlspecialchars((string)$selectedKota, ENT_QUOTES) ?>';
    const selectedKecamatan = '<?= htmlspecialchars((string)$selectedKecamatan, ENT_QUOTES) ?>';

    if (!provinsiSelect || !kotaSelect || !kecamatanSelect) {
        return;
    }

    function filterKota(keepSelected) {
        const provinsiId = provinsiSelect.value;

        Array.from(kotaSelect.options).forEach(function(option) {
            const match = option.dataset.provinsi === provinsiId;

            option.hidden = !match;
            option.disabled = !match;
        });

        kotaSelect.value = keepSelected ? selectedKota : '';
        filterKecamatan(keepSelected);
    }

    function filterKecamatan(keepSelected) {
        const kotaId = kotaSelect.value;

        Array.from(kecamatanSelect.options).forEach(function(option) {
            const match = option.dataset.kota === kotaId;

            option.hidden = !match;
            option.disabled = !match;
        });

        kecamatanSelect.value = keepSelected ? selectedKecamatan : '';
    }

    filterKota(true);
    provinsiSelect.addEventListener('change', function() {
        filterKota(false);
    });
    kotaSelect.addEventListener('change', function() {
        filterKecamatan(false);
    });
});
</script>
