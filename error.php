<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 17.4.2017
 * Time: 18:02
 */
//pokretanje sesije
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Error</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="wrapper">
    <div class="message">
        <h1>Error</h1>
        <p id="error">
            <?php
            if(isset($_SESSION['message']) and !empty($_SESSION['message']))
            {
                echo $_SESSION['message'];
            }
            else{
                header("location: index.php");
            }
            ?>
        </p>
        <a href="http://localhost/php_validation/index.php"><button>home</button></a>
    </div>
</div>
</body>
</html>
