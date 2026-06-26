<div class="card">

    <div class="card-header">

        Edit Kecamatan

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

                    <?php foreach($provinsi as $row): ?>

                        <option
                            value="<?= $row['id'] ?>"
                            <?= $row['id']==$data['provinsi_id']
                            ? 'selected' : '' ?>>

                            <?= $row['nama_provinsi'] ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <!-- KOTA -->

            <div class="mb-3">

                <label class="form-label">

                    Kota

                </label>

                <select
                    id="kota"
                    name="kota_id"
                    class="form-select">

                    <?php foreach($kota as $row): ?>

                        <option
                            value="<?= $row['id'] ?>"
                            <?= $row['id']==$data['kota_id']
                            ? 'selected':''
                            ?>>

                            <?= $row['nama_kota'] ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <!-- KECAMATAN -->

            <div class="mb-3">

                <label class="form-label">

                    Nama Kecamatan

                </label>

                <input
                    type="text"
                    name="nama_kecamatan"
                    class="form-control"
                    value="<?= $data['nama_kecamatan'] ?>">

            </div>

            <button
                class="btn btn-warning">

                Update

            </button>

        </form>

    </div>

</div>