<?php
session_start();
include 'db.php';

// Ambil ID dari URL
$id_penerbit = isset($_GET['id']) ? $_GET['id'] : "";
$check_level = mysqli_query($conn, "SELECT penerbit.nama, user.username, user.level FROM  penerbit JOIN user ON penerbit.id_user = user.id WHERE penerbit.id = '$id_penerbit';");
$row_level = mysqli_fetch_array($check_level);

$check_level2 = mysqli_query($conn, "SELECT penerbit.nama, user.username, user.level FROM  penerbit JOIN user ON penerbit.id_user = user.id WHERE penerbit.id = '$id_penerbit';");
$row_level2 = mysqli_fetch_array($check_level2);
//echo "<h1>". $user_id . "</h1>";

// Sanitasi user ID
$id_penerbit = mysqli_real_escape_string($conn, $id_penerbit);

//ambil data surat berdasarkan id_penerbit, untuk menampilkan surat dari penerbit yang login
if ($row_level['level'] != 2){
	$sql_suratuser = mysqli_query($conn, "SELECT `tujuan`.`alamat`, `tujuan`.`orang`, `tujuan`.`jabatan`, `tujuan`.`institusi`, `surat`.*, `klasifikasi`.`nama`, `klasifikasi`.`nomor` FROM `tujuan`  LEFT JOIN `surat` ON `surat`.`id_tujuan` = `tujuan`.`id` LEFT JOIN `klasifikasi` ON `surat`.`id_jenis` = `klasifikasi`.`id` WHERE `surat`.`status` IS NOT NULL AND `surat`.`id_penerbit` = '$id_penerbit';");	
} else {
	$sql_suratuser = mysqli_query($conn, "SELECT `tujuan`.`alamat`, `tujuan`.`orang`, `tujuan`.`jabatan`, `tujuan`.`institusi`, `surat`.*, `klasifikasi`.`nama`, `klasifikasi`.`nomor` FROM `tujuan`  LEFT JOIN `surat` ON `surat`.`id_tujuan` = `tujuan`.`id` LEFT JOIN `klasifikasi` ON `surat`.`id_jenis` = `klasifikasi`.`id` WHERE `surat`.`status` IS NOT NULL;");	
}

//ambil data tujuan untuk dropdown
$sql_tujuan = mysqli_query($conn, "SELECT * FROM tujuan WHERE status = '1'");
$sql_tujuandaftar = mysqli_query($conn, "SELECT * FROM tujuan WHERE status = '1'");
$sql_klasifikasi = mysqli_query($conn, "SELECT * FROM klasifikasi WHERE status = '1'");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['surat'])) {
    	  $id_tujuan = mysqli_real_escape_string($conn, $_POST['tujuan']);
    	  $klasifikasi = mysqli_real_escape_string($conn, $_POST['klasifikasi']);
    	  $tgl_berlaku = mysqli_real_escape_string($conn, $_POST['tgl_berlaku']);
    	  $tgl_sampai = mysqli_real_escape_string($conn, $_POST['tgl_sampai']);
    	  $detail = mysqli_real_escape_string($conn, $_POST['detail']);
    	  $status = mysqli_real_escape_string($conn, $_POST['status']);
        if ($row_level['level'] != 2) {
				$insert_surat = "INSERT INTO surat (id_penerbit, id_tujuan, id_jenis, berlaku_dari, berlaku_sampai, detail, status) VALUES ('$id_penerbit', '$id_tujuan', '$klasifikasi', '$tgl_berlaku', '$tgl_sampai', '$detail', '0')";
	 	  } else {
    			$insert_surat = "INSERT INTO surat (id_penerbit, id_tujuan, id_jenis, berlaku_dari, berlaku_sampai, detail, status) VALUES ('$id_penerbit', '$id_tujuan', '$klasifikasi', '$tgl_berlaku', '$tgl_sampai', '$detail', '$status')";
	 	  }
	 	  $add_surat = mysqli_query($conn, $insert_surat);
    			} elseif (isset($_POST['tujuan'])) {
    			$alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    			$orang = mysqli_real_escape_string($conn, $_POST['orang']);
    			$jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    			$institusi = mysqli_real_escape_string($conn, $_POST['institusi']);
    			$insert_tujuan = "INSERT INTO tujuan (alamat, orang, jabatan, institusi) VALUES ('$alamat','$orang','$jabatan','$institusi')";
    			$add_tujuan = mysqli_query($conn, $insert_tujuan);
    	  }
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
    <title>Input Letter</title>
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

    <div>
        <h4>Buat Surat:</h4>
        <form method="POST">                
            <label for="options">Tujuan:</label>
            <select id="options" name="tujuan">
                <?php
                $no_tujuan = 1;
                while ($row_tujuan = mysqli_fetch_array($sql_tujuan)) {
                    $selected = '';
                    if (isset($row_penerbit['id_tujuan']) && $row_penerbit['id_tujuan'] == $row_tujuan['id']) {
                        $selected = 'selected';
                    }
                ?>                
                <option value="<?php echo $row_tujuan['id']; ?>" <?php echo $selected; ?>>
                    <?php echo $row_tujuan['institusi'] . " / " . $row_tujuan['orang'] . " / " . $row_tujuan['jabatan'] . " / " . $row_tujuan['alamat']; ?>
                </option>
                <?php
                $no_tujuan++;
                }
                ?>
            </select><br><br>

            <label for="options">Klasifikasi:</label>
            <select id="options" name="klasifikasi">
                <?php while ($row_klasifikasi = mysqli_fetch_array($sql_klasifikasi)){ ?> 
                    <option value="<?php echo $row_klasifikasi['id'] ?>"><?php echo $row_klasifikasi['nama'] . "/" . $row_klasifikasi['nomor'] ?></option>
                <?php } ?>          
            </select><br><br>

            <label for="tgl_berlaku">Tanggal Berlaku: </label>
            <input type="date" id="tgl_berlaku" name="tgl_berlaku" required><br><br>

            <label for="tgl_sampai">Berlaku Sampai: </label>
            <input type="date" id="tgl_sampai" name="tgl_sampai" required><br><br>

            <label for="detail">Detail: </label>
            <textarea id="detail" name="detail" rows="8" cols="20"></textarea>
            <br><br>

            <label for="status">Status: </label>
            <?php if ($row_level['level'] == 2):  ?>         
            <select id="status" name="status">
                <option value="1" <?php echo (isset($row_penerbit['status']) && $row_penerbit['status'] == 1) ? 'selected' : ''; ?>>Aktif</option>
                <option value="0" <?php echo (isset($row_penerbit['status']) && $row_penerbit['status'] == 0) ? 'selected' : ''; ?>>Non-Aktif</option>
            </select><br><br>
            <?php endif; ?>
            <input type="submit" name="surat" value="Buat Surat"><br>
        </form>
    </div>
    
    <div>
    <h4>Surat yang anda terbitkan:</h4>
    <p><a href="input_letter.php?id=<?php echo $id_penerbit;?>">Tambahkan Surat</a></p>     
    <table>                 
        <tr>
            <th>Institusi</th>
            <th>Penerima</th>
            <th>Jabatan</th>
            <th>Alamat</th>
            <th>Berlaku Dari</th>
            <th>Berlaku Sampai</th>
            <th>Detail</th>
            <th>Status</th>
            <th>Jenis</th>
            <th>Nomor Jenis</th>
            <th>ID</th>
            <th>Opsi</th> 
        </tr>
        <?php if (mysqli_num_rows($sql_suratuser) > 0): ?> <!--Jika ada surat yang dimiliki oleh seorang user sebagai seorang penerbit-->                
            <?php
            $no_sur=1;
            while ($row_suratuser = mysqli_fetch_array($sql_suratuser)) {
            ?>
            <tr>
                <td><?php echo $row_suratuser['institusi']?></td>
                <td><?php echo $row_suratuser['orang']?></td>
                <td><?php echo $row_suratuser['jabatan']?></td>
                <td><?php echo $row_suratuser['alamat']?></td>
                <td><?php echo $row_suratuser['berlaku_dari']?></td>
                <td><?php echo $row_suratuser['berlaku_sampai']?></td>
                <td><?php echo $row_suratuser['detail']?></td>
                <td><?php echo $row_suratuser['status'] == 1 ? 'Disetujui' : 'Belum Disetujui' ?></td>
                <td><?php echo $row_suratuser['nama']?></td> <!--nama klasifikasi-->
                <td><?php echo $row_suratuser['nomor']?></td>
                <td><?php echo $row_suratuser['id']?></td>
                <td>
                    <?php if ($row_level['level'] == 2){ ?>
                        <?php if ($row_suratuser['status'] == 0) { ?>
                            <p><a href="edit_letter.php?id=<?php echo $row_suratuser['id']?>">Edit</a></p>
                            <p><a href="delete_letter.php?id=<?php echo $row_suratuser['id']?>">Hapus</a> </p>
                            <p><a href="approve_letter.php?id=<?php echo $row_suratuser['id']?>">Setujui</a></p>
                        <?php } else { ?>
                            <p>---</p>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if ($row_suratuser['status'] == 0) { ?>
                            <p><a href="edit_letter.php?id=<?php echo $row_suratuser['id']?>">Edit</a></p>
                            <p><a href="delete_letter.php?id=<?php echo $row_suratuser['id']?>">Hapus</a></p>
                        <?php } else { ?>
                            <p>---</p>
                        <?php } ?>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        <?php else: ?> <!--Jika tidak ada surat-->    
    <h4>Anda Masih Belum Menerbitkan Surat.</h4>
    <?php endif; ?>
    </table>              
</div> 
<br><br>

<div>
	 	<h4>Buat Tujuan:</h4>
        <form method="POST">
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" required><br><br>
            <label for="orang">Penerima</label>
            <input type="text" id="orang" name="orang" required><br><br>
            <label for="jabatan">Jabatan</label>
            <input type="text" id="jabatan" name="jabatan" required><br><br>    
            <label for="institusi">Institusi</label>
            <input type="text" id="institusi" name="institusi" required><br><br>
            <input type="submit" name="tujuan" value="Tambahkan Penerima"><br>
        </form>
    </div>

<div>
	<h4>Daftar tujuan yang tersedia:</h4>
    <table>
        <tr>
            <th>Alamat</th>
            <th>Penerima</th>
            <th>Jabatan</th>
            <th>Institusi</th>
            <th>Opsi</th>
        </tr>
        <?php if (mysqli_num_rows($sql_tujuan) > -1): ?>
            <?php while ($row_tujuandaftar = mysqli_fetch_array($sql_tujuandaftar)) { ?>
                <tr>
                    <td><?php echo $row_tujuandaftar['alamat'] ?></td>
                    <td><?php echo $row_tujuandaftar['orang'] ?></td>
                    <td><?php echo $row_tujuandaftar['jabatan'] ?></td>
                    <td><?php echo $row_tujuandaftar['institusi'] ?></td>
                    <td>
                        <?php if ($row_level2['level'] == 2){ ?>
                            <p><a href="edit_tujuan.php?id=<?php echo $row_tujuandaftar['id']?>">Edit</a> </p>
                            <p><a href="delete_tujuan.php?id=<?php echo $row_tujuandaftar['id']?>">Hapus</a> </p>
                        <?php } else { ?>
                            <p><a href="edit_tujuan.php?id=<?php echo $row_tujuandaftar['id']?>">Edit</a> </p>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        <?php else: ?>
    </table>         
    <h4>Silahkan Buat Tujuan Surat.</h4>              
    <?php endif; ?>
</div>

</body>

</html>

<?php
$conn->close();
?>