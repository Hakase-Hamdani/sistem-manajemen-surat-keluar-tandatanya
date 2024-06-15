<?php
session_start();
include 'db.php';

// Ambil ID dari URL
$id_surat = $_GET['id'];

if ($id_surat) {
    $sql_surat = mysqli_query($conn, "UPDATE surat SET status = 1 WHERE id = '$id_surat'");
    if ($sql_surat) {
        $_SESSION['approve_success'] = true;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo mysqli_error($conn);
    }    
} else {
    echo mysqli_error($conn);
}
?>