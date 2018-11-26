<?php

require 'function.php';

$id=$_GET["ID"];
//var_dump($id);

$mhs=query("SELECT * FROM phpdatabase WHERE ID=$id")[0];
//var_dump($mhs[0]["Nama"]);

if(isset($_POST['submit']))
{
    if(edit($_POST)>0){
        echo "
        <script>
            alert('data berhasil diperbarui');
            document.location.href='index.php';
            </script>
            ";
    }else{
        echo "
        <script>
            alert('data gagal diperbarui');
            document.location.href='edit.php';
            </script>";
            echo "<br>";
            echo mysqli_error($conn);
            
        }
    }

   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Update data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    
</head>
<body>
    <h1> update data mahasiswa </h1>
    
    <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="GambarLama" value="<?= $mhs["Gambar"] ?>">
            </li>

            <ul>
            <li>    
            <label for="Nama">Nama</label>
            <input type="text" name="Nama" id="Nama" value="<?= $mhs["Nama"];?>" >
            </li>
            <li>
            <label for="Nim">Nim</label>
            <input type="text" name="Nim" id="Nim" required value="<?= $mhs["Nim"];?>" >
            </li>
            <li>
            <label for="Email">Email</label>
            <input type="text" name="Email" id="Email" required value="<?= $mhs["Email"];?>" >
            </li>
            <li>
            <label for="Jurusan">Jurusan</label>
            <input type="text" name="Jurusan" id="Jurusan" required value="<?= $mhs["Jurusan"];?>" >
            </li>
            <li>
            <label for="Gambar">Gambar</label>
            <img src="image/<?= $mhs["Gambar"]; ?>" alt="" height="100" width="100"><br>
            <input type="file" name="Gambar" id="Gambar" >
            </li>
        <li>
        <button type="submit" name="submit">Update</button>
        </li>
        </ul>
    </form>
    
</body>
</html>

