<?php
if(!isset($_SESSION))
    session_start();
include_once "../../helper/validator.php";
require "../../database/db_connection.php";
require "../../database/user.php";
global $conn;

if(isset($_POST["regform"])) {
    $data_is_valid = checkForm($_POST, ["username", "email", "password", "password_confirm"]);

    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $password_conf = $_POST["password_confirm"];

    $user_exists = getUserByEmail($email);
    if($user_exists)
    {
        $error = "Email you entered already exists!";
        array_push($_SESSION["messages"], $error);
        header("location: /blog/pages/auth/signup.php");
    }

    if(
        $data_is_valid &&
        checkLength($username, 20) &&
        checkLength($password, 50, 8) &&
        checkPass($password) &&
        checkEmail($email) &&
        $password === $password_conf
    ){
        $user_id = createUser($username, $email, $password);
        if($user_id)
        {
            array_push($_SESSION["messages"], "Account Created successfully, please login");
            header("location: /blog/pages/auth/login.php");
        }
        else
            echo "Error creating user!";
    }
    else 
    {
        if(!$data_is_valid)
            $error = "Registration data is invalid!";
        else if(!checkLength($username, 20))
            $error = "Username must be of length 3 as minimum and 20 as maximum!";
        else if(!checkEmail($email))
            $error = "Invalid email!";
        else if(!checkLength($password, 50, 8) || !checkPass($password))
        {
            $error = "Password must be atleast of length 8 ";
            $error.= "and contains atleast one letter, digit and special character!";
        }
        else if($password !== $password_conf)
            $error = "Passwords do not match!";
        array_push($_SESSION["messages"], $error);
        header("location: /blog/pages/auth/signup.php");
    }

}


if(isset($_POST["loginform"])) {
    $data_is_valid = checkForm($_POST, ["email", "password"]);

    $email = $_POST["email"];
    $password = $_POST["password"];
    
    $user = getUserByEmail($email);

    if($user) {
        if(password_verify($password, $user['password'])) {
            $_SESSION["user"] = $user;
            header("location: /blog/");
        }
        else {
            $error = "Incorrect password";
            array_push($_SESSION["messages"], $error);
            header("location: /blog/pages/auth/login.php");
        }
    }
    else {
        $error = "Create an account first.";
        array_push($_SESSION["messages"], $error);
        header("location: /blog/pages/auth/signup.php");
    }   
}
?>