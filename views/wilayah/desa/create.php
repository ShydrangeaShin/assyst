<div class="card">

    <div class="card-header">

        Tambah Desa / Kelurahan

    </div>

    <div class="card-body">

        <form method="POST">

            <!-- PROVINSI -->

            <div class="mb-3">

                <label class="form-label">

                    Provinsi

                </label>

                <select
                    id="provinsi"
                    class="form-select">

                    <option value="">
                        Pilih Provinsi
                    </option>

                    <?php foreach($provinsi as $row): ?>

                    <option value="<?= $row['id'] ?>">

                        <?= $row['nama_provinsi'] ?>

                    </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <!-- KOTA -->

            <div class="mb-3">

                <label class="form-label">

                    Kota / Kabupaten

                </label>

                <select
                    id="kota"
                    class="form-select">

                    <option value="">
                        Pilih Kota
                    </option>

                </select>

            </div>

            <!-- KECAMATAN -->

            <div class="mb-3">

                <label class="form-label">

                    Kecamatan

                </label>

                <select
                    id="kecamatan"
                    name="kecamatan_id"
                    class="form-select"
                    required>

                    <option value="">
                        Pilih Kecamatan
                    </option>

                </select>

            </div>

            <!-- DESA -->

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

            <button
                type="submit"
                class="btn btn-primary">

                Simpan

            </button>

        </form>

    </div>

</div>