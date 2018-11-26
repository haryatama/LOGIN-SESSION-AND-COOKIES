<?php
    session_start();
    

    if(isset($_COOKIE['ID']) && isset($_COOKIE['Username']))
    {
        $id = $_COOKIE['ID'];
        $key = $_COOKIE['key'];

        $result=mysqli_query($conn,"SELECT Username FROM user WHERE ID=$id");
        $row=mysqli_fetch_assoc($result);

        if($key === hash('sha256',$row['Username']))
        {
            $_SESSION['login']=true;
        }
    }

    if(isset($_SESSION["login"]))
    {
        header("Location:index.php");
        exit;
    }
    require 'function.php';

    if(isset($_POST["login"]))
    {
        $username=$_POST["Username"];
        $password=$_POST["Password"];

        $result=mysqli_query($conn,"SELECT * FROM user WHERE Username='$username'");

        if(mysqli_num_rows($result)===1)
        {
            $row=mysqli_fetch_assoc($result);

            if(password_verify($password,$row["Password"]))
            {
                $_SESSION["login"]=true;

                if(isset($_POST['remember']))
                {
                    setcookie('ID',$row['ID'],time()+60);
                    setcookie('key',hash(sha256,$row['Username']),time()+60);
                }
                
                header("Location:index.php");
                exit;
            }
        }
        $error=true;
    }
?>

<!DOCTYPE html>
<html>
<head>  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Halaman Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <h1>Halaman Login</h1>
    <?php if(isset($error)):?>
        <p style="color:red;font-style=bold">
        username dan password salah</p>

        <?php endif ?>

        <form action="" method="POST" >
        <ul>
            <li>
                <label for="Username">username</label>
                <input type="text"  id="Username" name="Username">
                </li>
                <li>
                <label for="Password">password</label>
                <input type="Password"  id="Password" name="Password">
                </li>
                <li>
                <label for="remember">Remember me</label>
                <input type="checkbox"  id="remember" name="remember">
                </li>
            
            <button type="submit" name="login">Login</button>
            </li>
            </ul>
        </form>
</body>
</html>