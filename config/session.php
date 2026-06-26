<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// verif login
function checkLogin()
{
    if (!isset($_SESSION['user'])) {

        header("Location: index.php?page=login");
        exit;
    }
}

// Cek if role = Admin

function onlyAdmin()
{
    checkLogin();

    if ($_SESSION['user']['role'] != 'Admin') {

        header("Location: index.php?page=forbidden");
        exit;
    }
}

// cek if role = Petugas
function onlyPetugas()
{
    checkLogin();

    if ($_SESSION['user']['role'] != 'Petugas') {

        header("Location: index.php?page=forbidden");
        exit;
    }
}

// Logout
function logout()
{
    session_destroy();

    header("Location: index.php?page=login");
    exit;
}