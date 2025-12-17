<?php
include '../classes/connect.php';
$DB = new Database();
if (isset($_POST['signUp'])) {
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password); // ← missing semicolon fixed

    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $DB->read($checkEmail);
    if (is_array($result)) {
        echo "Email exists!";
    } else {
        $insertQuery = "INSERT INTO users(FirstName,LastName,email,password)
         VALUES ('$firstName','$lastName','$email','$password')"; // ← missing semicolon fixed

        if ($DB->save($insertQuery)) {
            header("location: login.php");
            die;
        } else {
            echo "Error";
        }
    }
}

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $sql = "SELECT * FROM users WHERE email='$email' and password='$password' limit 1"; // ← missing semicolon fixed
    $result = $DB->read($sql); // ← missing semicolon fixed

    if (is_array($result)) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['email'] = $result[0]['email'];
        header("Location: ../index.php");
        exit();
    } else {
        echo "Not Found, Incorrect Email or Password";
    }
}
?>