<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 17.4.2017
 * Time: 18:13
 */
// priključivanje funkcija
require_once('function.php');
// konekcija na bazu !!!
$db = connect();
if(!$db) echo 'Greška prilikom konekcije na bazu !!';
    //else echo 'Uspešna konekcija na bazu !!';
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="wrapper">
    <div id="reset">
        <h1>Reset Password</h1>
        <?php
        if(isset($_GET['email']) and !empty($_GET['email']) and isset($_GET['token']) and !empty($_GET['token']))
        {
            //čitanje get globalnih varijabli !!!
            $email = test_input($_GET['email']);
            $token = test_input($_GET['token']);
            //definisanje upita !!!bitno je da name je token različit od empty i da je expire veći od trnutnog vremena !!!
            $sql = "SELECT * FROM users WHERE email='$email' and token='$token' and token <> '' and expire > NOW()";
            $res = mysqli_query($db,$sql);
            if(mysqli_num_rows($res)==0)
            {
                $_SESSION['message'] = 'Uneli ste pogrešan URL za resetovanje password-a !!';
                header("location: error.php");
            }
        }else
        {
            $_SESSION['message'] = 'Izvinite,validacija je prekinuta,pokušajte ponovo';
            header("location: error.php");
        }
        ?>
        <form action="#" method="post">
            <?php
            if(isset($_POST['regist'])) {
                // čitenje prom !!!
                $new_password = $_POST['new_password'];
                $conf_new_password = $_POST['conf_new_password'];
                //provera !!!
                $new_password = $_POST['new_password'];
                $conf_new_password = $_POST['conf_new_password'];
                if (empty($new_password)) {
                    $newpassErr = 'Unesite novi password';
                } elseif (strlen($new_password) < 7) {
                    $newpassErr = 'Password mora imati više od 7 karaktera!!';
                } else {
                    $new_password = test_input($new_password);
                    if (!preg_match("/^[a-zA-Z0-9]*$/", $new_password)) {
                        $newpassErr = 'Nedozvoljeni karakteri';
                    }
                }
                if (empty($conf_new_password)) {
                    $confpassErr = 'Potvrdite password';
                }
                elseif($new_password == $conf_new_password)
                {
                    // kriptovanje novog passworda !!!
                    $new_password = password_hash($new_password,PASSWORD_BCRYPT);
                    $sql = "UPDATE users SET password='$new_password',token='' WHERE email='$email'";
                    if(mysqli_query($db,$sql) or die(mysqli_error($db)))
                    {
                        $_SESSION['message'] = 'Uspešno ste resetovali password !!';
                        header("location: succes.php");
                    }
                }else{
                    $_SESSION['message'] = 'Password-i se ne poklapaju,pokušajte ponovo !!';
                    header("location: error.php");
                }
            }
            ?>
            <label for="pass">New Password:</label><br>
            <input type="password" id="pass" name="new_password" placeholder="New Password"><br>
            <span><?php if(isset($newpassErr)) echo $newpassErr; ?></span><br>
            <label for="pass">Confirm New Password:</label><br>
            <input type="password" id="pass" name="conf_new_password" placeholder="Confirm New Password"><br>
            <span><?php if(isset($confpassErr)) echo $confpassErr; ?></span><br><br>
            <input type="submit" value="Apply" name="regist">
        </form>
    </div>
</div>
</body>
</html>
