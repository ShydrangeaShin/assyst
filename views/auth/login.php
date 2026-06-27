<?php require_once 'views/layouts/header.php'; ?>

<main>
<div class="login-page">
    <div class="login-card fade-up">
        
        <div class="login-logo text-center mb-4">
            <!-- <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-3" style="width: 72px; height: 72px; box-shadow: 0 10px 20px rgba(30,86,205,0.25);">
                <i class="bi bi-shield-lock-fill fs-1"></i>
            </div> -->
            <h1 class="fw-bold mb-0" style="color: var(--primary);">AsSyst</h1>
            <p class="text-muted small mt-1">Sistem Penalaran Kelayakan Bansos</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center px-3 py-2" role="alert" style="border-radius: 12px;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div class="small">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close" style="padding: 0.8rem;"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center px-3 py-2" role="alert" style="border-radius: 12px;">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div class="small">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close" style="padding: 0.8rem;"></button>
            </div>
        <?php endif; ?>

        <form action="index.php?page=login" method="POST">
            
            <div class="mb-3">
                <label for="username" class="form-label text-muted small fw-bold mb-1">USERNAME</label>
                <div class="position-relative">
                    <i class="bi bi-person position-absolute text-muted" style="top: 50%; left: 16px; transform: translateY(-50%); font-size: 1.1rem;"></i>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required autofocus style="padding-left: 45px; height: 48px;">
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label text-muted small fw-bold mb-1">PASSWORD</label>
                <div class="position-relative">
                    <i class="bi bi-lock position-absolute text-muted" style="top: 50%; left: 16px; transform: translateY(-50%); font-size: 1.1rem;"></i>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required style="padding-left: 45px; height: 48px;">
                </div>
            </div>

            <button type="submit" name="login" class="btn btn-primary w-100 mb-3 shadow-sm d-flex justify-content-center align-items-center gap-2" style="height: 48px; border-radius: 12px; font-weight: 600;">
                Masuk <i class="bi bi-arrow-right"></i>
            </button>

            <div class="text-center mt-3">
                <a href="?page=dashboard-publik" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1" style="transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='#6c757d'">
                    <i class="bi bi-house"></i> Kembali ke Dashboard Publik
                </a>
            </div>
            
        </form>
    </div>
</div>

</main>

<?php require_once 'views/layouts/footer.php'; ?>