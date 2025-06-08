<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require "0_config.php";

$note = $_GET['note'] ?? "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $check = $conn->query("SELECT * FROM user WHERE email='$email'");

    if ($check->num_rows > 0) {
        $verification_token = bin2hex(random_bytes(32));

        $insrt = "UPDATE user SET verification_token = '$verification_token' WHERE email = '$email'";
        if ($conn->query($insrt) === TRUE) {
            $verification_link = "https://hisctg.com/reset_pass_via_mail.php?token=$verification_token";
            $subject = "Request to Reset Password";

            // HTML message
            $message = "
            <html>
            <head>
                <title>Password Reset</title>
            </head>
            <body style='font-family: Arial, sans-serif; color: #333;'>
                <table width='100%' cellpadding='0' cellspacing='0'>
                    <tr>
                        <td style='padding: 20px; background-color: #f7f7f7; text-align: center;'>
                            <h2 style='color: #4CAF50;'>Password Reset</h2>
                            <p style='font-size: 16px;'>Hello,</p>
                            <p style='font-size: 16px;'>A password reset request has been made for the account associated with $email. You can reset your password by clicking the button below:</p>
                            <a href='$verification_link' style='display: inline-block; padding: 12px 20px; background-color: #4CAF50; color: #fff; text-decoration: none; border-radius: 5px;'>Reset Password</a>
                            <p style='font-size: 14px; color: #777;'>If you did not request a password change, please ignore this email.</p>
                        </td>
                    </tr>
                </table>
                <footer style='text-align: center; padding: 20px; background-color: #f7f7f7;'>
                    <p style='font-size: 12px;'>Best regards,</p>
                    <p style='font-size: 12px;'>The HIS-CTG Team</p>
                    <p style='font-size: 12px;'>For support, contact <a href='mailto:hisctgs@gmail.com' style='color: #4CAF50;'>hisctgs@gmail.com</a></p>
                </footer>
            </body>
            </html>
            ";

            // Send email using PHPMailer
            $mail = new PHPMailer(true);

            try {
                // SMTP configuration
                $mail->isSMTP();
                $mail->Host       = 'your smtp host';
                $mail->SMTPAuth   = //true or false;
                $mail->Username   = 'your mail here'; // Your SMTP username
                $mail->Password   = 'password here'; // Your SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = port; // TCP port

                // Recipients
                $mail->setFrom('hisctgs@gmail.com', 'HIS-CTG Support');
                $mail->addAddress($email); // Add recipient's email

                // Email content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $message;
                $mail->AltBody = 'To reset your password, please visit: ' . $verification_link;

               ;

                // Redirect to a success page
                if( $mail->send()){
                header("Location: success.php?head=Reset Password&msg=A password reset link has been sent to your email.<br><span style='color:red;'>Note: Check your spam folder in case it's filtered as spam.<span> &btn=Back to Login");
                exit();}
            } catch (Exception $e) {
                echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else {
        header("Location: forgot_pass.php?note=No user found by that email.");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>

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
        <h2>Enter your email</h2>
        <p style="color:red;">
            <?= $note ?>
        </p>
    </div>
    <form id="loginForm" class="login-form" action="reset_password.php" method="POST">
      <div class="input-field">
        <input id="email" type="email" name="email" placeholder="email" class="input" required>
      </div>
      <p id="prompt" style="color: green; display:none;">It might take a while to send the mail, please be patient.<br><b>If it is taking too long, please refresh the page and try again.</b></p>
      <button type="submit" class="login" onclick="showPrompt()">Submit</button>
    </form>
  </div>
  <script>
    function showPrompt() {
        if(document.getElementById('email').value!=""){
            document.getElementById('prompt').style.display="block";
        }}
  </script>
</body>
</html>
