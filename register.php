<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 17.4.2017
 * Time: 18:01
 */
 
// čitanje promenljivih !!!
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
//provera !!!
if(empty($first_name))
{
    $fnameErr = 'Obavezno polje !!';
}else{
    $first_name = test_input($first_name);
    if(!preg_match("/^[a-zA-Z]*$/",$first_name))
    {
        $fnameErr = 'Nedozvoljeni karakteri !!';
    }
}
if(empty($last_name))
{
    $lnameErr = 'Obavezno polje !!';
}else{
    $last_name = test_input($last_name);
    if(!preg_match("/^[a-zA-Z]*$/",$last_name))
    {
        $lnameErr = 'Nedozvoljeni karakteri !!';
    }
}
if(empty($email))
{
    $emailErr = 'Obavezno polje !!';
}else{
    $email = test_input($email);
    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        $emailErr = 'Pogrešan format mail adrese !!';
    }
}
if(empty($password))
{
    $passErr = 'Obavezno polje !!';
}elseif(strlen($password)<7){
    $passErr = 'Password mora sadržati više od 7 karaktera !!';
}else{
    $password = test_input($password);
    if(!preg_match("/^[a-zA-Z0-9]*$/",$password))
        $passErr = 'Nedozvoljeni karakteri !!';
}
if(empty($password2))
{
    $confpassErr = 'Molimo vas potvrdite password';
}else{
    $password2 = test_input($password2);
    if(!preg_match("/^[a-zA-Z0-9]*$/",$password2)) {
        $confpassErr = 'Nedozvoljeni karakteri !!';
    }
		/**
 * provera postojanja korisnika u bazi sa zadatom email adresom
 */
$sql = "SELECT * FROM users WHERE email='$email'";
$res = mysqli_query($db,$sql);
if(mysqli_num_rows($res)>0)
{
    $_SESSION['message'] = 'Korisnik sa ovom email adresom već postoji u bazi !!';
    header("location: error.php");
}
elseif($password==$password2)
{
    //unos podataka u bazu ako je prošla filtracija !!!!
    $verify=time();
    $hash = password_hash($password,PASSWORD_BCRYPT,array('cost'=>10));//kriptovanje password-a !!!!
    $sql = "INSERT INTO users (first_name,last_name,email,password,token,verify) VALUES ('$first_name','$last_name','$email','$hash','','$verify')";
    if(mysqli_query($db,$sql) or die(mysqli_error($db)))
    {
        //slanje verifikacionog mail-a
        $to=$email;
        $subject="NEWS PORTAL - Validacija email adrese";
        $message="http://localhost/php_validation/verify.php?email=$email&verify=$verify";
        mail($to,$subject,$message);
        $_SESSION['message'] = "Molimo vas verifikujte vašu email adresu,verifikacion link se nalazi na vašoj email adresi !!!";
        header("location: succes.php");
    }else{
        $_SESSION['message'] = 'Greška prilikom registracije !!';
        header("location: error.php");
    }
}	
else{
    $_SESSION['message'] = 'Lozinke se ne poklapaju !!';
    header("location: error.php");
    }
}
?>