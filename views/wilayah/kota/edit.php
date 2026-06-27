<div class="card shadow-sm border-0 rounded-4">

    <div class="card-header bg-white">

        <h4 class="fw-bold mb-0">

            Edit Kota / Kabupaten

        </h4>

    </div>

    <form
        method="POST"
        action="?page=kota-update">

        <div class="card-body">

            <input
                type="hidden"
                name="id_kota"
                value="<?= $kota['id_kota']; ?>">

            <div class="mb-3">

                <label class="form-label">

                    Provinsi

                </label>

                <select
                    name="id_provinsi"
                    class="form-select"
                    required>

                    <?php foreach($provinsi as $p): ?>

                        <option
                            value="<?= $p['id_provinsi']; ?>"

                            <?= ($p['id_provinsi']==$kota['id_provinsi'])
                                ? 'selected'
                                : ''; ?>>

                            <?= $p['nama_provinsi']; ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Nama Kota / Kabupaten

                </label>

                <input
                    type="text"
                    name="nama_kota"
                    class="form-control"
                    value="<?= htmlspecialchars($kota['nama_kota']); ?>"
                    required>

            </div>

        </div>

        <div class="card-footer bg-white">

            <a
                href="?page=kota"
                class="btn btn-secondary">

                Batal

            </a>

            <button
                class="btn btn-primary">

                Simpan Perubahan

            </button>

        </div>

    </form>

</div>