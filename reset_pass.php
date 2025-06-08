<?php
require "0_config.php";

$id=$_GET['id']??'';
$msg=$_GET['msg']??'';
$check=$conn->query("SELECT * from user where user_id = '$id' ");
if ($check->num_rows >0){
if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (isset($_POST['password']) && isset($_POST['oldpassword'])){
    
    $new_pass=password_hash($_POST['password'], PASSWORD_DEFAULT);
    $old_pass=$_POST['oldpassword'];

    $check=$conn->query("SELECT * from user where user_id = '$id' ");


    if ($check->num_rows >0){
        $checkt=$check->fetch_assoc();
        if (password_verify($old_pass, $checkt['password'])){
        $check->close();
        $conn->query("UPDATE user SET password= '$new_pass' where user_id = '$id'");
        header("Location: success.php?head=Success! & msg=Your password has been successfully changed! & btn=Go back");
        exit();
    }
        else{
             header("Location: reset_pass.php? id=$id & msg=Your old password does not match. Please Try again.");
        }
    }


}
}}
else{
    header("Location: expired.php");
}



?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password</title>

  <style>
        body {
        font-family: Arial, sans-serif;
        background-color: black;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        padding: 2rem; /* Adjusted for mobile padding */
        box-sizing: border-box;
        overflow: hidden;
    }

    .login-container {
        background-color: #18181b;
        padding: 3rem; /* Reduced padding for mobile */
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 90%; /* Make it responsive */
        max-width: 320px; /* Maximum width for larger screens */
    }

    .login-header {
        text-align: center;
        margin-bottom: 1.5rem; /* Responsive margin */
    }

    .login-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .login-button {
        padding: 1rem; /* Increased padding for touch */
        border-radius: 0.25rem;
        border: none;
        background-color: #28a745;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .login-button:hover {
        background-color:#17802f;
    }

    /* Styles for input */
    .input {
        line-height: 1.75; /* Improved line height for readability */
        border: 2px solid transparent;
        border-bottom-color: #777;
        padding: 0.5rem; /* Increased padding for better touch */
        outline: none;
        background-color: transparent;
        color: #fff;
        transition: .3s cubic-bezier(0.645, 0.045, 0.355, 1);
        width: 100%;
        box-sizing: border-box;
    }

    .input:focus, .input:hover {
        outline: none;
        padding: 0.5rem 1rem; /* Added padding */
        border-radius: 1rem;
        border-color: #7a9cc6;
    }

    .input:focus::placeholder {
        opacity: 0;
        transition: opacity .3s;
    }

    .error {
        color: red;
        text-align: center;
        margin-bottom: 1rem;
    }

    .checkbox-input label {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 0px 10px;
        width: 220px;
        cursor: pointer;
        height: 50px;
        position: relative;
    }

    .login {
        padding: 1rem; /* Increased padding for touch */
        border-radius: 0.25rem;
        border: none;
        background-color: #28a745;
        color: rgb(255, 255, 255);
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .login:hover:after {
        background-color:   #1e7632;
    }

    .fgr {
        border-bottom-color: #777;
        padding: .2rem 0;
        outline: none;
        background-color: transparent;
        color: #fff;
        transition: .3s cubic-bezier(0.645, 0.045, 0.355, 1);
        width: 100%;
        box-sizing: border-box;
        border: 2px solid transparent;
    }

    .fgr:focus, .fgr:hover {
        outline: none;
        padding: .2rem 1rem;
        border-radius: 1rem;
    }


    /* Media Queries for Responsive Design */
    @media (max-width: 20px) {
        .login-container {
            padding: 2rem; /* Adjust padding for smaller screens */
        }
        .login-button, .input, .fgr {
            padding: 0.8rem; /* Slightly smaller for smaller screens */
        }
        .checkbox-input label {
            width: auto; /* Adjust width to fit smaller screens */
        }
    }

  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-header">
        <h2>Enter New Password</h2>
        <p style="color:red;"><?= $msg?></p>
    </div>
    <form id="loginForm" class="login-form" action="reset_pass.php?id=<?=$id?>" method="POST">
      <div class="input-field">
        <input type="password" name="oldpassword" placeholder="Old Password" class="input" required>
        <input type="password" name="password" placeholder="New Password" class="input" required>
      </div>
      <button type="submit" class="login">Reset</button>
      
    </form>
  </div>
</body>
</html>