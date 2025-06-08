<?php
$head=$_GET['head']??'';
$msg=$_GET['msg']??'';
$btn=$_GET['btn']??'';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ensures proper scaling on mobile -->
    <title><?= $head ?></title>
    <style>
        /* Basic styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color: #1c1c1c; /* Dark grey background */
        margin: 0;
        }
            /* Responsive card styling */
            /* Responsive card styling */
        .success-card {
            width: 90%;
            max-width: 400px;
            text-align: center;
            padding: 20px;
            background-color: #2d2d2d; /* Dark grey container */
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            margin: 10px;
        }
        .success-card h1 {
            color: #28a745;
            font-size: 22px;
            margin-bottom: 10px;
        }
        .success-icon {
            font-size: 50px;
            color: #28a745;
            margin-bottom: 20px;
        }
        .success-card p {
            color: white;
            font-size: 16px;
            margin-bottom: 20px;
            line-height: 1.4;
        }
        .login-button {
            display: inline-block;
            padding: 12px 25px;
            font-size: 16px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .login-button:hover {
            background-color: #218838;
        }

        /* Adjustments for very small screens */
        @media (max-width: 480px) {
            .success-card {
                padding: 15px;
            }
            .success-icon {
                font-size: 40px;
            }
            .success-card h1 {
                font-size: 20px;
            }
            .success-card p {
                font-size: 15px;
            }
            .login-button {
                padding: 10px 20px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>

<div class="success-card">
    <div class="success-icon">✓</div>
    <h1><?= $head ?></h1>
    <p><?= $msg ?></p>
    <a href="index.php" class="login-button"><?= $btn ?></a>
</div>

</body>
</html>
