<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 17.4.2017
 * Time: 20:01
 */
session_start();
if(!isset($_SESSION['email']))
{
    header("location: index.php");
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profile User</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" type="text/css">
</head>
<body>
        <div id="profile">
            <a href="index.php?logout">Logout</a>
            <h1>Welcome to your profile page</h1>
            <h2>Prijavljeni ste kao: <i style="color: red"><?=$_SESSION['first_name']." ".$_SESSION['last_name']?></i></h2>
            <h3>Preko email adrese: <b style="color: blue"><?=$_SESSION['email']?></b></h3>
        </div>
</body>
</html>
