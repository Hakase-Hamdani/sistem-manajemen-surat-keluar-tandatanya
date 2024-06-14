<?php
session_start();
include 'db.php';

//ambil data surat berdasarkan id_penerbit, untuk menampilkan surat dari penerbit yang login
$sql_usershow = mysqli_query($conn, "SELECT * FROM user");

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch user data based on ID
    $sql_user = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'");
    $row_user = mysqli_fetch_array($sql_user);
} else {
    // Redirect or handle the case where ID is not provided
    header("Location: user_list.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $level = mysqli_real_escape_string($conn, $_POST['level']);

    $update_sql = "UPDATE user SET username = '$username', status = '$status', level = '$level' WHERE id = '$id'";
    mysqli_query($conn, $update_sql);
    header("Location: admin_edit-user.php?id=$id");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="themes/midnight-green.css">
    <title>Edit Data User</title>
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
	 <h3>Anda Sedang Menambah Data User</h3>
    <form method="POST">
        <label for="username">Username: </label>
        <input type="text" id="username" name="username" value="<?php echo $row_user['username']?>" required><br><br>
        <label for="status">Status: </label>
        <select id="status" name="status">
				<option value="1" <?php echo $row_user['status'] == 1 ? 'selected' : ''; ?>>Aktif</option>
				<option value="0" <?php echo $row_user['status'] == 0 ? 'selected' : ''; ?>>Non-Aktif</option>        
        </select>
        <label for="level">Level: </label>
        <select id="level" name="level">
				<option value="0" <?php echo $row_user['level'] == 0 ? 'selected' : ''; ?>>User</option>
				<option value="1" <?php echo $row_user['level'] == 1 ? 'selected' : ''; ?>>Admin</option>
				<option value="2" <?php echo $row_user['level'] == 2 ? 'selected' : ''; ?>>Pimpinan</option>
        </select>
    	  <input type="submit" value="Update Data"><br>
    </form>
    </div>
    <div>
    	  <h3>Surat yang anda terbitkan:</h3>    	  
    	  <table>		  		
		  		<tr>
					<th>Useraname</th>
					<th>Status</th>
					<th>Level</th>
					<th>Opsi</th>    	  		
    	  		</tr>		  		
				<?php
				$no_user=1;
				while ($tampil_user = mysqli_fetch_array($sql_usershow)) {
				?>
    	  		<tr>
					<td><?php echo $tampil_user['username']?></td>
					<td><?php echo ($tampil_user['status'] == 1) ? 'Aktif' : 'Non-Aktif' ?></td>
					<td><?php echo ($tampil_user['level'] == 0) ? 'User' : (($tampil_user['level'] == 1) ? 'Admin' : 'Pimpinan'); ?></td>
					<td><a href="admin_edit-user.php?id=<?php echo $tampil_user['id'] ?>" >Edit<br></td> 	  		
    	  		</tr>    	  		
		  <?php $no_user++; } ?>
		  </table>    	  	    
    </div>
</body>
</html>

<?php
$conn->close();
?>
