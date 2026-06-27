<?php require_once 'views/layouts/header.php'; ?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-2 rounded sticky-top" style="z-index: 1020;">

    <div class="container">

        <a class="navbar-brand fw-bold text-primary" href="index.php?page=dashboard-publik">
            AsSyst
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarGuest">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse"
             id="navbarGuest">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=dashboard-publik">Beranda</a>
                </li>

                <li class="nav-item ms-lg-2">
                    <a class="btn btn-primary" href="index.php?page=login"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<main>
    <?php include $content; ?>
</main>

<?php require_once 'views/layouts/footer.php'; ?>