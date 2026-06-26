<form method="POST">

    <div class="card">

        <div class="card-header">

            Edit Kota

        </div>

        <div class="card-body">

            <div class="mb-3">

                <label class="form-label">

                    Provinsi

                </label>

                <select
                    name="provinsi_id"
                    class="form-select">

                    <?php foreach($provinsi as $p): ?>

                    <option
                        value="<?= $p['id'] ?>"
                        <?= $p['id']==$data['provinsi_id'] ? 'selected':'' ?>>

                        <?= $p['nama_provinsi'] ?>

                    </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Nama Kota

                </label>

                <input
                    type="text"
                    name="nama_kota"
                    value="<?= $data['nama_kota'] ?>"
                    class="form-control">

            </div>

        </div>

        <div class="card-footer">

            <button class="btn btn-warning">

                Update

            </button>

        </div>

    </div>

</form>