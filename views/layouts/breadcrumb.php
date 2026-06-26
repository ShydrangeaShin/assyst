<?php

if (!isset($breadcrumbs)) {
    $breadcrumbs = [
        'Dashboard'
    ];
}

?>

<nav aria-label="breadcrumb">

    <ol class="breadcrumb custom-breadcrumb">

        <?php foreach ($breadcrumbs as $key => $item) : ?>

            <?php if ($key == array_key_last($breadcrumbs)) : ?>

                <li
                    class="breadcrumb-item active"
                    aria-current="page">

                    <?= $item ?>

                </li>

            <?php else : ?>

                <li class="breadcrumb-item">

                    <?= $item ?>

                </li>

            <?php endif; ?>

        <?php endforeach; ?>

    </ol>

</nav>