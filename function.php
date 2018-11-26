<?php

    //membuat koneksi
    $conn=mysqli_connect("localhost", "root", "", "percobaan1");

    //ambil data dari tabel mahasiswa/query data mahasiswa
    $result=mysqli_query($conn,"SELECT * FROM phpdatabase");

    //function query akan menerima isi parameter dari string query yang ada pada index2.php (line 3)
    function query($query_kedua){
        //dikarena $conn diluar function query maka dibutuhkan scope global $$conn

        global $conn;
        $result = mysqli_query($conn, $query_kedua);

        //wadah kosong untuk menampung isi array pada saat looping line 16

        $rows = [];
        while ($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function tambah ($data)
    {
        global $conn;

        $nama =htmlspecialchars($data["Nama"]);
        $nim =htmlspecialchars($data["Nim"]);
        $email =htmlspecialchars($data["Email"]);
        $jurusan =htmlspecialchars($data["Jurusan"]);
        //$gambar =htmlspecialchars($data["Gambar"];

        $gambar=upload();
        if(!$gambar)
        {
            return false;
        }

        $query = " INSERT INTO phpdatabase  
                    VALUES 
                    ('','$nama','$nim','$email','$jurusan','$gambar')";
        mysqli_query($conn,$query);

        return mysqli_affected_rows($conn);
    }

    function hapus ($id)
    {
        global $conn;
        mysqli_query($conn," DELETE FROM phpdatabase WHERE id = $id ");
        return mysqli_affected_rows($conn); 
    }

    function edit ($data)
    {
        global $conn;
        
        $id=$data["id"];
        $nama=htmlspecialchars($data["Nama"]);
        $nim=htmlspecialchars($data["Nim"]);
        $email=htmlspecialchars($data["Email"]);
        $jurusan=htmlspecialchars($data["Jurusan"]);
        $gambar=htmlspecialchars($data["Gambar"]);

        if($_FILES['Gambar'][error]===4)
        {
            $gambar=$GambarLama;
        }else
        {
            $gambar=upload();
        }
        
        
        $query = " UPDATE phpdatabase SET 
                    Nama = '$nama' ,
                    Nim = '$nim' ,
                    Email = '$email' ,
                    Jurusan = '$jurusan' ,
                    Gambar = '$gambar' 
                    WHERE id = $id ";
        mysqli_query($conn,$query);

        return mysqli_affected_rows($conn);

        $namafilebaru=uniquid();
        $namafilebaru .= '.';
        $namafilebaru .= $pecah_gambar;

        move_uploaded_file($tmpfile,'image/' .$namafilebaru);

        return $namafilebaru;
    }

    function cari ($keyword)
    {
        $sql = "SELECT * FROM phpdatabase
                WHERE 
                Nama LIKE '%$keyword%' OR
                Nim LIKE '%$keyword%' OR
                Email LIKE '%$keyword%' OR
                Jurusan LIKE '%$keyword%' ";

        return query($sql);
    }

    function upload()
    {
        $nama_file = $_FILES["Gambar"]["name"];
        $ukuran_file = $_FILES["Gambar"]["size"];
        $error = $_FILES["Gambar"]["error"];
        $tmpfile = $_FILES["Gambar"]["tmp_name"];

        if($error===4)
        {
            echo "
                <script>
                    alert('tidak ada gambar yang diupload');
                </script>
                ";
                return false;
        }

    $jenis_gambar =["jpg" , "jpeg" , "gif"];
    $pecah_gambar=explode('.' , $nama_file);
    $pecah_gambar=strtolower(end($pecah_gambar));
    if(!in_array($pecah_gambar,$jenis_gambar))
    {
        echo "
            <script>
                alert('yang anda upload bukan file gambar');
            </script>
            ";
            return false;
    }

    if($ukuran_file > 10000000)
    {
        echo "
            <script>
                alert('ukuran gambar terlalu besar');
            </script>
            ";
            return false;
    }

    move_uploaded_file($tmpfile,'image/'. $nama_file);

    return $nama_file;
    }

    function registrasi ($data)
    {
        global $conn;

        $username = strtOlower(stripcslashes($data['username']));

        $password = mysqli_real_escape_string($conn,$data['password']);
        $password2 = mysqli_real_escape_string($conn,$data['password2']);

        $result = mysqli_query($conn,"SELECT username FROM user WHERE username='$username'");

        if(mysqli_fetch_assoc($result))
        {
            echo "
                <script>
                    alert('username sudah ada');
                </script>
                ";
                return false;
        }
        if($password!=$password2)
        {
            echo "
            <script>
                alert('password anda tidak sama');
            </script>
            ";
            return false;
        }
        
        //$password=md5($password);

        $password=password_hash($password,PASSWORD_DEFAULT);

        //var_dump($password);

        mysqli_query ($conn,"INSERT INTO user VALUES ('','$username','$password')");

        return mysqli_affected_rows($conn);
    }
?>
