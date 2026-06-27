<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white">

        <h4 class="fw-bold mb-0">

            Tambah Desa / Kelurahan

        </h4>

    </div>

    <form
        method="POST"
        action="?page=desa-store">

        <div class="card-body">

            <div class="mb-3">

                <label class="form-label">

                    Provinsi

                </label>

                <select
                    id="provinsi"
                    class="form-select"
                    required>

                    <option value="">

                        -- Pilih Provinsi --

                    </option>

                    <?php foreach(($provinsi ?? []) as $row): ?>

                        <option value="<?= $row['id_provinsi'] ?? $row['id'] ?>">

                            <?= htmlspecialchars($row['nama_provinsi'] ?? '') ?>

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
                    disabled
                    required>

                    <option value="">

                        -- Pilih Kota / Kabupaten --

                    </option>

                    <?php foreach(($kota ?? []) as $row): ?>

                        <option
                            value="<?= $row['id_kota'] ?? $row['id'] ?>"
                            data-provinsi="<?= $row['id_provinsi'] ?? '' ?>">

                            <?= htmlspecialchars($row['nama_kota'] ?? '') ?>

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
                    disabled
                    required>

                    <option value="">

                        -- Pilih Kecamatan --

                    </option>

                    <?php foreach(($kecamatan ?? []) as $row): ?>

                        <option
                            value="<?= $row['id_kecamatan'] ?? $row['id'] ?>"
                            data-kota="<?= $row['id_kota'] ?? '' ?>">

                            <?= htmlspecialchars($row['nama_kecamatan'] ?? '') ?>

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

                    <option value="Desa">Desa</option>
                    <option value="Kelurahan">Kelurahan</option>

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

                Simpan

            </button>

        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinsiSelect = document.getElementById('provinsi');
    const kotaSelect = document.getElementById('kota');
    const kecamatanSelect = document.getElementById('kecamatan');

    if (!provinsiSelect || !kotaSelect || !kecamatanSelect) {
        return;
    }

    function filterKota() {
        const provinsiId = provinsiSelect.value;

        kotaSelect.value = '';
        kotaSelect.disabled = provinsiId === '';

        Array.from(kotaSelect.options).forEach(function(option) {
            if (option.value === '') {
                option.hidden = false;
                option.disabled = false;
                return;
            }

            const match = option.dataset.provinsi === provinsiId;

            option.hidden = !match;
            option.disabled = !match;
        });

        filterKecamatan();
    }

    function filterKecamatan() {
        const kotaId = kotaSelect.value;

        kecamatanSelect.value = '';
        kecamatanSelect.disabled = kotaId === '';

        Array.from(kecamatanSelect.options).forEach(function(option) {
            if (option.value === '') {
                option.hidden = false;
                option.disabled = false;
                return;
            }

            const match = option.dataset.kota === kotaId;

            option.hidden = !match;
            option.disabled = !match;
        });
    }

    filterKota();
    provinsiSelect.addEventListener('change', filterKota);
    kotaSelect.addEventListener('change', filterKecamatan);
});
</script>
