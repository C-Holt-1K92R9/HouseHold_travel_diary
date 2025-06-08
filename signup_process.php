<?php
// Database connection
require "0_config.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);

    //$user_id = $conn->real_escape_string($_POST['user_id']);
    $user_id="";
    $check_t = $conn->query("SELECT user_id FROM user ORDER BY user_id DESC LIMIT 1");
$check = $check_t->fetch_assoc();

// Check if a result was returned
if ($check) {
    // Extract user_id, convert to integer, increment, and pad with leading zeroes if needed
    $last_id = intval($check["user_id"]); // Convert VARCHAR to integer
    $new_id = $last_id + 1; // Increment
    $user_id = str_pad(strval($new_id), 2, "0", STR_PAD_LEFT); // Pad with leading zeroes if necessary
} else {
    // If no records exist, start with "01"
    $user_id = "01";
}

    

    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $password = $conn->real_escape_string($_POST['password']);

    //$verification_token = bin2hex(random_bytes(32));
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Check if email or user_id already exists
    $check_sql = "SELECT * FROM user WHERE email = '$email' OR user_id = '$user_id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "User ID or email already exists.";
    } else {
        // Insert new user into database
        $insert_sql = "INSERT INTO user (user_id, password, email, phone_number, name) 
                       VALUES ('$user_id', '$hashed_password', '$email', '$phone_number', '$name')";

        if ($conn->query($insert_sql) === TRUE) 
        {
            header("Location: success.php?head=Success. & msg=Your registration has been successfully completed! You can now Log into your account. & btn= Go to login");
            exit();
        }
        else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    }
}
// Close connection
$conn->close();
?>