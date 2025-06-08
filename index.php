<?php
require "0_config.php";

if (isset($_COOKIE['logincookie'])){
    $cid=$_COOKIE['logincookie'];
    $checkc=$conn->query("SELECT login_token from user where login_token = '$cid'");
    if ($checkc->num_rows >0){
    $checkc->fetch_assoc();
    session_start();
        $sql = "SELECT * FROM user WHERE login_token='$cid'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['phone_number'] = $row['phone_number'];
        $_SESSION['email'] = $row['email'];
        // Redirect based on user role
        if ($_SESSION['user_id'] === '00') {
            header("Location: admin_dash.php");
            exit();
        } else {
            header("Location: dashboard.php");
            exit();
        }

    }
    else{
        setcookie('logincookie', '', time() - (3600*24*2), '/'); // set expiration date to 1 day ago
        unset($_COOKIE['logincookie']);
        unset($_SESSION['user_id']);
        session_destroy();
        header("Location: index.php?result=Session expired. Please log in again.");
    }

}

$result= $_GET['result']??"";

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Survey Log In</title>

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
        overflow: auto;
        scrollbar-width: 0px; /* For Firefox */

    }
    .label input[type="checkbox"] {
                width: 17px;
                height: 17px;
                display: grid;
            }

    .logo-container {
        width: 80px; /* Responsive size */
        height: 80px; /* Responsive size */
        margin-bottom: 1.5rem; /* Responsive spacing */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .logo {
        max-width: 100%; /* Prevents overflow */
        max-height: 100%; /* Prevents overflow */
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

    .label {
        display: flex;
        align-items: center;
        left: -15px;
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
    .banner {
            background-color: green;
            color: white;
            width:100%;
            padding: 15px;
            border-radius:10px;
            text-align: center;
            font-size: 1.3em;
            font-weight: bold;
            font-style:italic;
            animation: fadeInOut 3s infinite;
        }

        @keyframes fadeInOut {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .details {
            padding: 20px;
            margin-top: 50px;
            background-color:rgba(249, 249, 249, 0.13);
            border: 1px solid #ccc;
            border-radius:10px;
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .details h2 {
            color: rgb(201, 201, 201);
        }

        .details a {
            color:rgb(55, 255, 0);
            text-decoration: none;
        }

        .details ul {
            list-style-type: none;
            padding: 0;
        }

        .details ul li {
            margin: 5px 0;
        }
  </style>
</head>
<body>
<div class="banner">
    Household Travel Survey has officially commenced from 1st January 2025. It will continue till 31st January.
</div><br>
  <div class="login-container">
    <div class="login-header">
        <h2>Welcome Back</h2>
        <p style="color:red;"><?= $result ?></p>
    </div>
    <form id="loginForm" class="login-form" action="login_process.php" method="POST">
      <div class="input-field">
        <input type="email" class="input" name="email_or_id" placeholder="Email address" required>
      </div>
      <div class="input-field">
        <input type="password" name="password" placeholder="Password" class="input" required>
      </div>
     <a class="fgr" href="reset_password.php">Forgot Password?</a>
      <!-- <a class="fgr" href="resend_mail.php">Resend verification mail</a>-->
      <label class="label">
                    <input type="checkbox"  name="remember" value="1" checked>
                        <p class="text">Remember me</p>
                    </label>
      <button type="submit" class="login">Log In</button>
      <div class="register">
        <!--<p>Don't have an account? <a class="fgr" href="signup.html">Register</a></p>-->

        <p style="color:skyblue;">Found an issue with the website? <a href="report.php" style="color:red;">Report</a></p>
      </div>
    </form>
  </div>

  <div class="details">
    <h2>About the Survey:</h2>
    <p>The survey is conducted for the M.Sc Thesis titled <strong><em>“Modeling Urban Mobility in Chattogram: A Comparative Analysis of Traditional and Machine Learning Approaches.”</em></strong> by Kamol Debnath Dip, Lecturer, CE, CUET. The research aims to understand how people in Chattogram travel within the city.</p>

    <p>We are collecting data on travel patterns and household demographics through brief interviews with residents. This information will be used to develop and compare different models for predicting travel behavior in Chattogram, which can help city planners improve transportation systems.</p>

    <p><strong>Your participation is voluntary and confidential.</strong> The survey will take approximately 40-50 minutes per household. If you have any questions, please do not hesitate to contact Kamol Debnath Dip:</p>
    <ul>
        <li><strong>Mobile:</strong> 01521301787</li>
        <li><strong>Email:</strong> <a href="mailto:kamoldip@cuet.ac.bd">kamoldip@cuet.ac.bd</a></li>
    </ul>

    <p><a href="https://www.cuet.ac.bd/members/673">Link to My Affiliation (For Authenticity)</a></p>
    <p><a href="https://drive.google.com/drive/folders/18pS4kl0aq6Ox0Qb-max2oe4z1yg3A2nM?usp=sharing">Surveyor list</a></p>
</div>
</body>
</html>
