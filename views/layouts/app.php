<?php require_once 'views/layouts/header.php'; ?>
<?php require_once 'views/layouts/navbar.php'; ?>

<div class="main-layout">

    <?php require_once 'views/layouts/sidebar.php'; ?>

    <main class="content">

        <?php
        if (isset($breadcrumbs)) {
            require_once 'views/layouts/breadcrumb.php';
        }
        ?>

        <?php include $content; ?>

    </main>

</div>

<?php require_once 'views/layouts/footer.php'; ?>