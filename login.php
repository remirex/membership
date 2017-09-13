<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 17.4.2017
 * Time: 18:01
 */
//čitanje promenljivih
$email = $_POST['email'];
$password = $_POST['password'];
//provera
if(empty($email))
{
    $emailErr2 = 'Obavezno polje !!';
}else{
    $email = test_input($email);
    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        $emailErr2 = 'Pogrešan format mail adrese !!';
    }
}
if(empty($password))
{
    $passErr2 = 'Obavezno polje !!';
}elseif(strlen($password)<7){
    $passErr2 = 'Password mora sadržati više od 7 karaktera !!';
}else {
    $password = test_input($password);
    if (!preg_match("/^[a-zA-Z0-9]*$/", $password))
        $passErr2 = 'Nedozvoljeni karakteri !!';
    else {
        //provera postojanja podataka u bazi !!!
        $sql = "SELECT * FROM users WHERE email='$email'";
        $res = mysqli_query($db, $sql);
        if (mysqli_num_rows($res) == 1) {
            $row = mysqli_fetch_object($res);
            if (password_verify($password, $row->password)) {
				session_start();
                $_SESSION['first_name'] = $row->first_name;
                $_SESSION['last_name'] = $row->last_name;
                $_SESSION['email'] = $row->email;
                header("location: profile.php");
            } else {
                $_SESSION['message'] = "Pogrešan password !!!";
                header('location:error.php');
            }
        } else {
            $_SESSION['message'] = "Nema korisnika u bazi sa ovim email-om i password-om !!!";
            header('location:error.php');
        }
    }
}
?>