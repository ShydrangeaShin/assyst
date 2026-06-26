<div class="card">

    <div class="card-header">

        Tambah Kecamatan

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
                    class="form-select"
                    required>

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
                    name="kota_id"
                    class="form-select"
                    required>

                    <option value="">
                        Pilih Kota
                    </option>

                </select>

            </div>

            <!-- NAMA KECAMATAN -->

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

            <button
                type="submit"
                class="btn btn-primary">

                Simpan

            </button>

        </form>

    </div>

</div>