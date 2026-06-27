<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white">

        <h4 class="fw-bold mb-0">

            Tambah Kecamatan

        </h4>

    </div>

    <form
        method="POST"
        action="?page=kecamatan-store">

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
                    name="id_kota"
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

                    Nama Kecamatan

                </label>

                <input
                    type="text"
                    name="nama_kecamatan"
                    class="form-control"
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

                Simpan

            </button>

        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinsiSelect = document.getElementById('provinsi');
    const kotaSelect = document.getElementById('kota');

    if (!provinsiSelect || !kotaSelect) {
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
    }

    filterKota();
    provinsiSelect.addEventListener('change', filterKota);
});
</script>
