<div class="card shadow-sm rounded-4">

    <div class="card-header">

        Edit Provinsi

    </div>

    <div class="card-body">

        <form
            method="POST"
            action="?page=provinsi-update">

            <input
                type="hidden"
                name="id_provinsi"
                value="<?= $data['id_provinsi'] ?>">

            <div class="mb-3">

                <label class="form-label">

                    Nama Provinsi

                </label>

                <input
                    type="text"
                    name="nama_provinsi"
                    class="form-control"
                    value="<?= htmlspecialchars($data['nama_provinsi']) ?>"
                    required>

            </div>

            <button
                class="btn btn-warning">

                Update

            </button>

            <a
                href="?page=provinsi"
                class="btn btn-secondary">

                Kembali

            </a>

        </form>

    </div>

</div>