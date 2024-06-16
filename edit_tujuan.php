<?php
session_start();
include 'db.php';

// Ambil ID dari URL
$id_tujuan = isset($_GET['id']) ? $_GET['id'] : "";
$sql_tampil = mysqli_query($conn, "SELECT * FROM tujuan WHERE id = '$id_tujuan'");
$row_tujuan = mysqli_fetch_assoc($sql_tampil);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $orang = mysqli_real_escape_string($conn, $_POST['orang']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $institusi = mysqli_real_escape_string($conn, $_POST['institusi']);

    $update_tujuan = "UPDATE tujuan SET alamat = '$alamat', orang = '$orang', jabatan = '$jabatan', institusi = '$institusi' WHERE id = '$id_tujuan'";
    $insert = mysqli_query($conn, $update_tujuan);
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="themes/midnight-green.css">
    <title>Edit Tujuan</title>
    <style>
        col.max-width {
            max-width: 150px; /* Set the maximum width */
        }
        td {
            word-wrap: break-word; /* Ensure content wraps within the cell */
        }
    </style>
</head>
<body>
    <h4>Edit Tujuan:</h4>
    <form method="POST">                
        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" value="<?php echo $row_tujuan['alamat']; ?>" required><br><br>

        <label for="orang">Penerima:</label>
        <input type="text" id="orang" name="orang" value="<?php echo $row_tujuan['orang']; ?>" required><br><br>

        <label for="jabatan">Jabatan:</label>
        <input type="text" id="jabatan" name="jabatan" value="<?php echo $row_tujuan['jabatan']; ?>" required><br><br>

        <label for="institusi">Institusi:</label>
        <input type="text" id="institusi" name="institusi" value="<?php echo $row_tujuan['institusi']; ?>" required><br><br>

        <input type="submit" value="Update Data"><br>
    </form>
</body>
</html>

<?php
$conn->close();
?>
