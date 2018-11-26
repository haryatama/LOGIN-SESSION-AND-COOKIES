<?php
    session_start();
    if(!isset($_SESSION["login"]))
    {
        echo $_SESSION["login"];
        header("Location:login.php");
        exit;
    }
    
    require 'function.php';
    $mahasiswa = query("SELECT * FROM phpdatabase");

    if(isset($_POST["cari"]))
    {
        $mahasiswa = cari($_POST["keyword"]);
    }

    
?>

<!DOCTYPE html>
<html leng = "en">
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <title> Document </title>
</head>
<body>
    <h1> Daftar Mahasiswa </h1>

    <li>
    <a href= "logout.php"> Logout</a>
    
    <li>
    <a href = "tambah_data.php">  Tambah Data Mahasiswa </a>
    
    <table border = "1" cellpadding = "10" cellspacing = "0">

    <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Nim</th>
        <th>Email</th>
        <th>Jurusan</th>
        <th>Gambar</th>
        <th>Aksi</th>
    </tr>
    
    <br>
    <br>

    <form action="" method="POST">
        
        <input type="text" name="keyword" size="40" autofocus placeholder="Masukkan Keyword Pencarian" autocomplete="off">
        <button type="submit" name=cari>cari</button>
    </form>
    
    <br>
    <br>
    

    <!-- //kita biat contoh data static -->

    <?php $i=1 ?>
    
    <?php foreach ($mahasiswa as $row): ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= $row["Nama"];?></td>
        <td><?= $row["Nim"];?></td>
        <td><?= $row["Email"];?></td>
        <td><?= $row["Jurusan"];?></td>
        <td> <img src="img/<?php echo $row["Gambar"]; ?>" alt="" srcset="" width="100" height="100"></td>
        <td>

            <a href="edit.php?id=<?php echo $row["ID"];?>">Edit</a>
            <a href="hapus.php?id=<?php echo $row["ID"];?>"onclick="return confirm('apakah data ini akan dihapus')">Hapus</a>
        </td>
    </tr>
    <?php $i++ ?>
    <?php endforeach;?>
    
</body>
</html>