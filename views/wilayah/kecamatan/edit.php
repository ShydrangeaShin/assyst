<?php
$row = $kecamatan ?? $data ?? [];
$selectedKota = $row['id_kota'] ?? $row['kota_id'] ?? '';
$selectedProvinsi = $row['id_provinsi'] ?? $row['provinsi_id'] ?? '';
$idKecamatan = $row['id_kecamatan'] ?? $row['id'] ?? '';
?>

<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white">

        <h4 class="fw-bold mb-0">

            Edit Kecamatan

        </h4>

    </div>

    <form
        method="POST"
        action="?page=kecamatan-update">

        <div class="card-body">

            <input
                type="hidden"
                name="id_kecamatan"
                value="<?= htmlspecialchars($idKecamatan) ?>">

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
                    name="id_kota"
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

                    Nama Kecamatan

                </label>

                <input
                    type="text"
                    name="nama_kecamatan"
                    class="form-control"
                    value="<?= htmlspecialchars($row['nama_kecamatan'] ?? '') ?>"
                    required>

            </div>

        </div>

        <div class="card-footer bg-white">

            <a
                href="?page=kecamatan"
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
    const selectedKota = '<?= htmlspecialchars((string)$selectedKota, ENT_QUOTES) ?>';

    if (!provinsiSelect || !kotaSelect) {
        return;
    }

    function filterKota(keepSelected) {
        const provinsiId = provinsiSelect.value;

        kotaSelect.disabled = provinsiId === '';

        Array.from(kotaSelect.options).forEach(function(option) {
            const match = option.dataset.provinsi === provinsiId;

            option.hidden = !match;
            option.disabled = !match;
        });

        if (keepSelected) {
            kotaSelect.value = selectedKota;
            return;
        }

        kotaSelect.value = '';
    }

    filterKota(true);
    provinsiSelect.addEventListener('change', function() {
        filterKota(false);
    });
});
</script>
