<div class="card">

    <div class="card-header">

        Edit Desa

    </div>

    <div class="card-body">

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">

                    Provinsi

                </label>

                <select
                    id="provinsi"
                    class="form-select">

                    <?php foreach($provinsi as $row): ?>

                    <option
                        value="<?= $row['id'] ?>"
                        <?= ($row['id'] == $data['provinsi_id']) ? 'selected' : '' ?>>

                        <?= $row['nama_provinsi'] ?>

                    </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Kota

                </label>

                <select
                    id="kota"
                    class="form-select">

                    <?php foreach($kota as $row): ?>

                    <option
                        value="<?= $row['id'] ?>"
                        <?= ($row['id'] == $data['kota_id']) ? 'selected' : '' ?>>

                        <?= $row['nama_kota'] ?>

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
                    name="kecamatan_id"
                    class="form-select">

                    <?php foreach($kecamatan as $row): ?>

                    <option
                        value="<?= $row['id'] ?>"
                        <?= ($row['id'] == $data['kecamatan_id']) ? 'selected' : '' ?>>

                        <?= $row['nama_kecamatan'] ?>

                    </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Nama Desa

                </label>

                <input
                    type="text"
                    name="nama_desa"
                    value="<?= $data['nama_desa'] ?>"
                    class="form-control">

            </div>

            <button class="btn btn-warning">

                Update

            </button>

        </form>

    </div>

</div>