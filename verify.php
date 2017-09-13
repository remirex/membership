<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 17.4.2017
 * Time: 18:03
 */
//pokretanje sesije
require_once'function.php';
$db=connect();
if(!$db) echo "Greška";
//else echo "Uspešno";
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify email</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="wrapper">
    <div class="message">
        <h1>Verify email</h1>
        <p id="succes">
            <?php
            if(isset($_GET['email']) and isset($_GET['verify']))
            {

                $email=$_GET['email'];
                $verify=$_GET['verify'];
                $sql="SELECT * FROM users WHERE email='$email' AND verify='$verify'";
                $res=mysqli_query($db,$sql);
                if(mysqli_num_rows($res)==1)
                {
                    $sql="UPDATE users SET verify='1' WHERE email='$email' AND verify='$verify'";
                    mysqli_query($db,$sql);
                    echo  "<font color='green'>Uspešno ste verifikovali email adresu</font>";
                }
                else echo  "<font color='red'>Korisnik se nije registrovao ili je već potvrdio email adresu !!!</font>";
            }
            else
                echo "<font color='red'>Niste uneli neophodne podatke</font>";
            ?>
        </p>
        <a href="index.php"><button>home</button></a>
    </div>
</div>
</body>
</html>

