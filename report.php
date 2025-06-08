<?php

require "0_config.php";
// Handle form submission
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $issue_title = $_POST['issue_title'];
    $issue_description = $_POST['issue_description'];

    $sql = "INSERT INTO user_issues (user_id, issue_title, issue_description) VALUES ('$user_id', '$issue_title', '$issue_description')";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute()) {
        $message = "<p class='success-message'>Issue submitted successfully. Thank you!</p>";
    } else {
        $message = "<p class='error-message'>Error submitting the issue. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report an Issue</title>
    <style>
        html {
            scrollbar-width: none;
                }

        body {
            -ms-overflow-style: none; /* IE and Edge */
            ::-webkit-scrollbar, ::-webkit-scrollbar-button { display: none; } /* Chrome */
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            schrol
        }
        .bbtn{
            max-width:30%; 
            background-color:transparent;
            border: solid white;
        }
        .bbtn:hover{
            background-color: white;
            color:black;
        }
        
        .container {
            max-width: 400px;
            width: 100%;
            background: #1e1e1e;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        h1 {
            font-size: 1.6em;
            color: #00c853;
        }
        .form-group {
            margin: 15px 0;
            text-align: left;
        }
        label {
            display: block;
            font-weight: bold;
            color: #b0b0b0;
            margin-bottom: 5px;
        }
        input[type="text"], textarea {
            width: 95%;
            padding: 10px;
            border: 1px solid #333;
            background-color: #2c2c2c;
            color: #e0e0e0;
            border-radius: 5px;
            font-size: 1em;
        }
        input[type="text"]::placeholder,
        textarea::placeholder {
            color: #888;
        }
        button {
            background-color: #00c853;
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #00a344;
        }
        .success-message, .error-message {
            font-size: 1em;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }
        .success-message {
            color: #2e7d32;
            background-color: #003300;
        }
        .error-message {
            color: #f44336;
            background-color: #3c2c2c;
        }
        @media (max-width: 480px) {
            .container {
                padding: 15px;
                width: 90%;
            }
            h1 {
                font-size: 1.4em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Report an Issue</h1>
        <?php echo $message; ?>
        <form method="POST" action="report.php">
            
            <div class="form-group">
                <label for="issue_title">Issue Title:</label>
                <input type="text" id="issue_title" name="issue_title" placeholder="Enter a title for your issue" required>
            </div>

            <div class="form-group">
                <label for="issue_title">User ID or Email:</label>
                <input type="text" id="issue_title" name="user_id" placeholder="User ID or Email" required>
            </div>

            <div class="form-group">
                <label for="issue_description">Issue Description:</label>
                <textarea id="issue_description" name="issue_description" rows="5" placeholder="Describe your issue" required></textarea>
            </div>

            <button type="submit">Submit</button><br><br>

        </form>
        <button class="bbtn" onclick="window.location.href='index.php'">Back to login</button>
    </div>
</body>
</html>
