<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 17.4.2017
 * Time: 18:02
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
    <title>Forgot Password</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="wrapper">
    <div id="forgot">
        <?php
        if(isset($_POST['email']))
        {
            // čitanje promenljive email !!!
            $email = $_POST['email'];
            // provera prom email
            if(empty($email))
            {
                $emailErr = 'Obavezno polje !!';
            }else{
                $email = test_input($email);
                if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                    $emailErr = 'Pogrešan format email adrese !!';
                }else{
                    // provera postojanja email-a u bazi !!!
                    $sql = "SELECT * FROM users WHERE email='$email'";
                    $res = mysqli_query($db,$sql);
                    if(mysqli_num_rows($res)==1)
                    {
                        // definisanje tokena za promenu password-a !!!
                        $str = 'qwertzuioplkjhgfdsayxcvbnm1234567890';
                        $str = str_shuffle($str);//izmešana kombinacija slova i brojeva koje smo definisali u $str !!!!
                        $str = substr($str,0,10);
                        /*
                        //definisanje url-a za reset passworda,ručno ga podešavamo pošto radimo iz localhosta !!!
                        $url = "http://localhost/membership/php_validation/reset.php?token=$str&email=$email";
                        */
                        // update tokena !!!,setujemo interval trajanja tokena pošto se može desiti zloupotreba od strane hacker-a
                        $sql = "UPDATE users SET token='$str',expire = DATE_ADD(NOW(),INTERVAL 5 MINUTE ) WHERE email='$email'";
                        mysqli_query($db,$sql);
                        // slanje linka sa podacima za resetovanje !!!
                        $to=$email;
                        $subject="NEWS PORTAL - Resetovanje password-a";
                        $message="Poštovani, \n\r Kako bih ste nastavili sa registracijom, kliknite na link koji se nalazi ispod \n\r http://localhost/php_validation/reset.php?email=$email&token=$str";
                        mail($to,$subject,$message);
                        $_SESSION['message'] = "Proverite svoj email <b>$email</b>, kako bi mogli da nastavite sa resetovanjem password-a !!";
                        header("location: succes.php");
                    }else{
                        $_SESSION['message'] = 'Izvinite,email ne postoji u bazi,proverite input polje !!';
                        header("location: error.php");
                    }
                }
            }
        }
        ?>
        <h1>Forgot - Password ?</h1>
        <form action="#" method="post">
            <label for="mail">Email:</label><br>
            <input type="email" id="mail" name="email" placeholder="Email"><br>
            <span><?php if(isset($emailErr)) echo $emailErr; ?></span><br><br>
            <input type="submit" value="Request Password" name="forgot">
        </form>
    </div>
</div>
</body>
</html>

