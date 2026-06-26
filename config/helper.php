<?php

// base url web
function base_url($path = '')
{
    return 'http://localhost:8080/assyst/' . $path;
}


// fungsi biar no injection
function clean($data)
{
    return htmlspecialchars(
        trim($data),
        ENT_QUOTES,
        'UTF-8'
    );
}

// set tanggal web ke indo
function tanggalIndonesia($tanggal)
{
    return date(
        'd-m-Y',
        strtotime($tanggal)
    );
}

// fungsi upload file
function uploadFile(
    $file,
    $folder
)
{
    $allowed = ['jpg', 'jpeg', 'png'];

    $filename = $file['name'];

    $tmp = $file['tmp_name'];

    $size = $file['size'];

    $ext = strtolower(
        pathinfo(
            $filename,
            PATHINFO_EXTENSION
        )
    );

    if (!in_array($ext, $allowed)) {
        return false;
    }

    if ($size > 5242880) {
        return false;
    }

    $newName =
        uniqid() .
        '.' .
        $ext;

    move_uploaded_file(
        $tmp,
        "../assets/uploads/" .
        $folder .
        "/" .
        $newName
    );

    return $newName;
}

// redirect

function redirect($url)
{
    header(
        "Location: " .
        base_url($url)
    );

    exit;
}

// alert bootstrap
function setFlash(
    $type,
    $message
)
{
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function getFlash()
{
    if (
        isset($_SESSION['flash'])
    ) {

        $flash =
            $_SESSION['flash'];

        unset(
            $_SESSION['flash']
        );

        return
            "<div class='alert alert-{$flash['type']}'>
                {$flash['message']}
            </div>";
    }
}

function view($file)
{
    include $file;
}

function asset($path)
{
    return base_url('assets/' . $path);
}