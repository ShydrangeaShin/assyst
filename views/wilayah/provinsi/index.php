<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3>Data Provinsi</h3>
        <p class="text-muted mb-0">
            Manajemen data provinsi.
        </p>
    </div>

    <a href="?page=provinsi-create"
       class="btn btn-primary">

        <i class="bi bi-plus-circle"></i>
        Tambah Provinsi

    </a>

</div>

<div class="card">

    <div class="card-body">

        <div class="row mb-3">

            <div class="col-md-4">

                <input
                    type="text"
                    class="form-control"
                    placeholder="Cari provinsi...">

            </div>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th width="80">No</th>
                        <th>Nama Provinsi</th>
                        <th width="200">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>

                        <td>Jawa Barat</td>

                        <td>

                            <a
                                href="?page=provinsi-detail&id=1"
                                class="btn btn-sm btn-info">

                                Detail

                            </a>

                            <a
                                href="?page=provinsi-edit&id=1"
                                class="btn btn-sm btn-warning">

                                Edit

                            </a>

                            <button
                                class="btn btn-sm btn-danger">

                                Hapus

                            </button>

                        </td>

                    </tr>   

                </tbody>

            </table>

        </div>

    </div>

</div>