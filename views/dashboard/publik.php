<!-- Hero Section -->
<section class="public-hero">

    <div class="container">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div class="hero-text">

                <h1 class="fw-bold mb-3 mt-3">
                    AsSyst
                </h1>

                <p class="lead text-muted mb-4">
                    Sistem Pendukung Keputusan untuk membantu pemerintah
                    menentukan kelayakan penerima bantuan sosial secara
                    objektif, transparan, dan sistematis menggunakan
                    pendekatan Logika Penalaran.
                </p>

            </div>

            <div class="hero-image">

    

            </div>

        </div>

    </div>

</section>


<div class="container py-5">

    <div class="text-center mb-5">

        <h2 class="fw-bold">
            Statistik Bantuan Sosial
        </h2>

        <p class="text-muted">
            Ringkasan data penerima bantuan sosial berdasarkan
            hasil pendataan terbaru.
        </p>

    </div>

    <div class="card shadow-sm mb-4">

    <div class="card-header">

        <strong>Filter Wilayah</strong>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3">

                <label class="form-label">
                    Provinsi
                </label>

                <select
                    id="provinsi"
                    class="form-select">

                    <option value="">
                        Semua Provinsi
                    </option>

                    <?php while($row=mysqli_fetch_assoc($provinsi)){ ?>

                        <option value="<?= $row['id_provinsi'] ?>">

                            <?= $row['nama_provinsi'] ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="col-md-3">

                <label class="form-label">
                    Kota/Kabupaten
                </label>

                <select
                    id="kota"
                    class="form-select">

                    <option>

                        Semua Kota

                    </option>

                </select>

            </div>

            <div class="col-md-3">

                <label class="form-label">
                    Kecamatan
                </label>

                <select
                    id="kecamatan"
                    class="form-select">

                    <option>

                        Semua Kecamatan

                    </option>

                </select>

            </div>

            <div class="col-md-3">

                <label class="form-label">
                    Desa
                </label>

                <select
                    id="desa"
                    class="form-select">

                    <option>

                        Semua Desa

                    </option>

                </select>

            </div>

        </div>

    </div>

</div>

    <div class="row g-4">

        <div class="col-lg-3 col-md-6">

            <div class="stat-card">

                <div class="icon text-primary">
                    <i class="bi bi-people-fill"></i>
                </div>

                <h6>Keluarga Terdata</h6>

                <h2><?= $totalKeluarga ?></h2>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="stat-card">

                <div class="icon text-success">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                <h6>Layak</h6>

                <h2><?= $totalLayak ?></h2>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="stat-card">

                <div class="icon text-danger">
                    <i class="bi bi-x-circle-fill"></i>
                </div>

                <h6>Tidak Layak</h6>

                <h2><?= $totalTidakLayak ?></h2>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="stat-card">

                <div class="icon text-warning">
                    <i class="bi bi-search"></i>
                </div>

                <h6>Perlu Verifikasi</h6>

                <h2><?= $totalVerifikasi ?></h2>

            </div>

        </div>

    </div>


    <div class="card mt-5">

        <div class="card-header">

            Distribusi Status Bantuan Sosial

        </div>

        <div class="card-body">

            <canvas id="publikChart" height="110"></canvas>

        </div>

    </div>

</div>

