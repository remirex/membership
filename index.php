<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 17.4.2017
 * Time: 17:47
 */
// priključivanje funkcija
require_once('function.php');
// konekcija na bazu !!!
$db = connect();
if(!$db) echo 'Greška prilikom konekcije na bazu !!';
    //else echo 'Uspešna konekcija na bazu !!';
//startovanje sesije !!!
// logout
if(isset($_GET['logout']))
{
    session_start();
    unset($_SESSION['email']);
    unset($_SESSION['first_name']);
    unset($_SESSION['last_name']);
    session_destroy();
}
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
<div id="header">
    <h1>Membership System</h1>
</div>
<div class="wrapper">
    <?php
    {
		
        // da li je setovan  $_POST['regist'] !!!
        if(isset($_POST['regist']))
        {
            require_once'register.php';
        }
        // da li je setovan  $_POST['login'] !!!
        elseif(isset($_POST['login']))
        {
            require_once'login.php';
        }
    }
    ?>
    <div id="reg_form">
        <h1>Regist</h1>
        <form action="#" method="post">
            <label for="fname">First Name:</label><br>
            <input type="text" id="fname" name="first_name" placeholder="First Name"><br>
            <span><?php if(isset($fnameErr)) echo $fnameErr; ?></span><br>
            <label for="lname">Last Name:</label><br>
            <input type="text" id="lname" name="last_name" placeholder="Last Name"><br>
            <span><?php if(isset($lnameErr)) echo $lnameErr; ?></span><br>
            <label for="mail">Email:</label><br>
            <input type="email" id="mail" name="email" placeholder="Email"><br>
            <span><?php if(isset($emailErr)) echo $emailErr; ?></span><br>
            <label for="pass">Password:</label><br>
            <input type="password" id="pass" name="password" placeholder="Password"><br>
            <span><?php if(isset($passErr)) echo $passErr; ?></span><br>
            <label for="pass2">Confirm-Password:</label><br>
            <input type="password" id="pass2" name="password2" placeholder="Confirm Password"><br>
            <span><?php if(isset($confpassErr)) echo $confpassErr; ?></span><br><br>
            <input type="submit" value="Register" name="regist">
        </form>
    </div>

    <div id="log_form">
        <h1>Log In</h1>
        <form action="#" method="post">
            <label for="mail">Email:</label><br>
            <input type="email" id="mail" name="email" placeholder="Email"><br>
            <span><?php if(isset($emailErr2)) echo $emailErr2; ?></span><br>
            <label for="pass">Password:</label><br>
            <input type="password" id="pass" name="password" placeholder="Password"><br>
            <span><?php if(isset($passErr2)) echo $passErr2; ?></span><br><br>
            <input type="submit" value="Log In" name="login">
        </form>
        <a href="forgot.php">Forgot your password ?</a>
    </div>
</div>
</body>
</html>
