<?php

// base url web
function base_url($path = '')
{
    // Deteksi protokol (http / https)
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    // Deteksi host (localhost, IP, atau domain)
    $host = $_SERVER['HTTP_HOST'];
    // Folder root project
    $folder = '/assyst/'; 
    
    return $protocol . "://" . $host . $folder . ltrim($path, '/');
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
function uploadFile($file, $folder)
{
    $tmp = $file['tmp_name'];
    $name = $file['name'];
    $ext = pathinfo($name, PATHINFO_EXTENSION);
    $newName = time() . '_' . uniqid() . '.' . $ext;

    // Pastikan path absolut ke folder upload dari root proyek
    $targetDir = __DIR__ . '/../assets/uploads/' . $folder . '/';
    
    // Pastikan folder ada dan memiliki izin tulis
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (move_uploaded_file($tmp, $targetDir . $newName)) {
        return $newName;
    }
    return null;
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

function catatLog($conn, $aktivitas) {
    if(isset($_SESSION['user']['id'])) {
        $id_user = (int)$_SESSION['user']['id'];
        $id_role = (int)$_SESSION['user']['id_role']; // Pastikan id_role disimpan di session saat login
        $ip_address = $_SERVER['REMOTE_ADDR'];
        
        $stmt = $conn->prepare("INSERT INTO log_aktivitas (id_user, id_role, aktivitas, ip_address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $id_user, $id_role, $aktivitas, $ip_address);
        $stmt->execute();
    }
}