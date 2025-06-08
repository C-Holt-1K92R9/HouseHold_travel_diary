<?php
require "0_config.php";

// Start session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $email_or_id = $conn->real_escape_string($_POST['email_or_id']);
    $password = $conn->real_escape_string($_POST['password']);
    if (isset($_POST['remember'])){
        $rem=true;
    }
    else{
        $rem=false;
    }
    // SQL query to check if the user exists
    $sql = "SELECT * FROM user WHERE (email = '$email_or_id' OR user_id = '$email_or_id')";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();

        // Check if user is verified
        if ($row['is_verified'] == 1) {
            if ($row['status']==1){
            // Verify password
            if (password_verify($password, $row['password'])) {
                    if ($rem){
                    $login_token=bin2hex(random_bytes(32));
                    $id=$row['user_id'];
                    $conn->query("UPDATE user 
                        SET login_token = '$login_token'
                        WHERE user_id = '$id'");
                    setcookie("logincookie", "$login_token", time() + (3600*24*2), "/");
                    }
                // Set session variables  
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
            } else {
                header("Location: index.php?result=Incorrect password.");
                exit();
            }
        }else{header("Location: index.php?result=User has been Deactivated. Contact 'Admin' for more information.");}  }
        else {
            header("Location: index.php?result=User is not verified. Check your email to find the verification link.");
            exit();
        }
    } else {
        header("Location: index.php?result=User not found.");
        exit();
    }
}

// Close connection
$conn->close();
?>
