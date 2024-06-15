<?php
session_start();
include 'db.php';

// Ambil ID dari URL
$user_id = isset($_GET['id']) ? $_GET['id'] : "";

// Sanitasi user ID
$user_id = mysqli_real_escape_string($conn, $user_id);

// Ambil data penerbit berdasarkan user_id, untuk menampilkan data user
$sql_penerbitdata = mysqli_query($conn, "SELECT * FROM penerbit WHERE id_user='$user_id'");
$row_penerbit = mysqli_fetch_array($sql_penerbitdata);
$id_penerbit = $row_penerbit['id']; //ekstrak id sebagai id_penerbit

//ambil data surat berdasarkan id_penerbit, untuk menampilkan surat dari penerbit yang login
$sql_suratuser = mysqli_query($conn, "SELECT surat.berlaku_dari, surat.berlaku_sampai, surat.detail, surat.status, klasifikasi.nama AS jenis, klasifikasi.nomor FROM surat INNER JOIN  klasifikasi ON surat.id_jenis = klasifikasi.id WHERE surat.id_penerbit = $id_penerbit");
//$row_suratuser = mysqli_fetch_array($sql_suratuser);

//ambil data divisi untuk dropdown
$sql_divisi = mysqli_query($conn, "SELECT * FROM divisi");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $nip = mysqli_real_escape_string($conn, $_POST['NIP']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $id_divisi = mysqli_real_escape_string($conn, $_POST['divisi']);

    if ($row_penerbit) {
        // If entry exists, update it
        $update_sql = "UPDATE penerbit SET id_divisi='$id_divisi', nama='$nama', NIP='$nip', jabatan='$jabatan', status='$status' WHERE id_user='$user_id'";
        if (mysqli_query($conn, $update_sql)) {
            echo "Data updated successfully.";
            header("Location: " . $_SERVER['REQUEST_URI']);
        		exit;
        } else {
            echo "Error updating data: " . mysqli_error($conn);
            header("Location: " . $_SERVER['REQUEST_URI']);
        		exit;
        }
    } else {
        // If entry does not exist, insert a new one
        $insert_sql = "INSERT INTO penerbit (id_user, id_divisi, nama, NIP, jabatan, status) VALUES ('$user_id', '$id_divisi', '$nama', '$nip', '$jabatan', '$status')";
        if (mysqli_query($conn, $insert_sql)) {
            echo "Data inserted successfully.";
            header("Location: " . $_SERVER['REQUEST_URI']);
        		exit;
        } else {
            echo "Error inserting data: " . mysqli_error($conn);
            header("Location: " . $_SERVER['REQUEST_URI']);
        		exit;
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="themes/midnight-green.css">
    <title>Edit Page</title>
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
	 <?php if ($row_penerbit): ?> <!--Jika user sudah terdaftar sebagai penerbit-->
    <h2>Halo, <u><?= $row_penerbit['nama']; ?></u>. Anda login sebagai User.</h2>
	 <?php else: ?> <!--Jika user belum terdaftar sebagai penerbit-->
	 <h3>Data tidak ditemukan, silahkan isi data Anda sebagai penerbit menggunakan form di bawah.<h3>    
    <h3>Tambah Data Anda Sebagai Admin</h3>
	 <?php endif; ?>
    </div>
    <h4>Edit data Pribadi:</h4>
    <form method="POST">
        <label for="nama">Nama: </label>
        <input type="text" id="nama" name="nama" value="<?php echo isset($row_penerbit['nama']) ? $row_penerbit['nama'] : ''; ?>" required><br><br>
        <label for="NIP">NIP: </label>
        <input type="text" id="NIP" name="NIP" value="<?php echo isset($row_penerbit['NIP']) ? $row_penerbit['NIP'] : ''; ?>" required><br><br>
        <label for="jabatan">Jabatan: </label>
        <input type="text" id="jabatan" name="jabatan" value="<?php echo isset($row_penerbit['jabatan']) ? $row_penerbit['jabatan'] : ''; ?>" required><br><br>
        <label for="options">Divisi:</label>
    	  <select id="options" name="divisi">
    		<?php
   	   $no_div = 1;
    		while ($row_divisi = mysqli_fetch_array($sql_divisi)) {
        		$selected = '';
        		if (isset($row_penerbit['id_divisi']) && $row_penerbit['id_divisi'] == $row_divisi['id']) {
            $selected = 'selected';
	        	}
    		?>        		
    		<option value="<?php echo $row_divisi['id']; ?>" <?php echo $selected; ?>>
         <?php echo $row_divisi['nama_divisi'] . "/" . $row_divisi['kode_divisi']; ?>
    	   </option>
    		<?php
    		$no_div++;
    		}
    		?>
		  </select>
		  <br><br>
    	  <label for="status">Status: </label>
		  <select id="status" name="status">
    			<option value="1" <?php echo (isset($row_penerbit['status']) && $row_penerbit['status'] == 1) ? 'selected' : ''; ?>>Aktif</option>
    		 	<option value="0" <?php echo (isset($row_penerbit['status']) && $row_penerbit['status'] == 0) ? 'selected' : ''; ?>>Non-Aktif</option>
		  </select><br><br>
    	  <input type="submit" value="Update Data"><br>
    </form>
    </div>
    <div>
    	  <h4>Surat yang anda terbitkan:</h4>
    	  <a href="input_letter.php?id=<?php echo $id_penerbit;?>">Tambahkan Surat</a><br>    	  
    	  <table>		  		
		  		<tr>
					<th>Berlaku Dari</th>
					<th>Berlaku Sampai</th>
					<th>Detail</th>
					<th>Status</th>
					<th>Jenis</th>
					<th>Nomor</th>
					<th>Opsi</th>    	  		
    	  		</tr>
    	  <?php if (mysqli_num_rows($sql_suratuser) > 0): ?> <!--Jika ada surat yang dimiliki oleh seorang user sebagai seorang penerbit-->		  		
				<?php
				$no_sur=1;
				while ($row_suratuser = mysqli_fetch_array($sql_suratuser)) {
				?>
    	  		<tr>
					<td><?php echo $row_suratuser['berlaku_dari']?></td>
					<td><?php echo $row_suratuser['berlaku_sampai']?></td>
					<td><?php echo $row_suratuser['detail']?></td>
					<td><?php echo $row_suratuser['status'] == 1 ? 'Disetujui' : 'Belum Disetujui' ?></td>
					<td><?php echo $row_suratuser['jenis']?></td>
					<td><?php echo $row_suratuser['nomor']?></td>
					<td><?php echo $row_suratuser['status'] == 0 ? '---' : '<a href="edit_surat.php">Edit</a> <br>' ?></td>    	  		
    	  		</tr>
    	  		<?php } else: ?> <!--Jika tidak ada surat-->
    	  	</table>
				<h4>Anda Masih Belum Menerbitkan Surat.</h4>    	  		
		  <?php endif; ?>    	  	    
    </div>
</body>
</html>

<?php
$conn->close();
?>
