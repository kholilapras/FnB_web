<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama_lengkap = mysqli_real_escape_string($koneksi, $_REQUEST['nama_lengkap']);
    $no_telp = mysqli_real_escape_string($koneksi, $_REQUEST['no_telp']);
    $email = mysqli_real_escape_string($koneksi, $_REQUEST['email']);
    $password = mysqli_real_escape_string($koneksi, $_REQUEST['password']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO akun (nama_lengkap, no_telp, email, password, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = mysqli_stmt_init($koneksi);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ssss", $nama_lengkap, $no_telp, $email, $hashed_password);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // If registration successful
            header("Location: page.php?page=login");
            exit();
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($koneksi);
}
