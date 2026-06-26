<div class="card">

    <div class="card-header">

        Tambah Kota / Kabupaten

    </div>

    <div class="card-body">

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">

                    Provinsi

                </label>

                <select
                    name="provinsi_id"
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

            <div class="mb-3">

                <label class="form-label">

                    Nama Kota/Kabupaten

                </label>

                <input
                    type="text"
                    name="nama_kota"
                    class="form-control"
                    required>

            </div>

            <button class="btn btn-primary">

                Simpan

            </button>

        </form>

    </div>

</div>