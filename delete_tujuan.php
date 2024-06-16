<?php
session_start();
include 'db.php';

// Ambil ID dari URL
$id_tujuan = $_GET['id'];

if ($id_surat) {
    $sql_surat = mysqli_query($conn, "DELETE FROM tujuan WHERE id = '$id_tujuan'");
    if ($sql_surat) {
        $_SESSION['delete_success'] = true;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo mysqli_error($conn);
    }    
} else {
    echo mysqli_error($conn);
}
?>