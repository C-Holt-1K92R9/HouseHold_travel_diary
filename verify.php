<?php
include '0_config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the database
    $stmt = $conn->prepare("SELECT user_id FROM user WHERE verification_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update user's verification status
        $stmt->close();
        $update_stmt = $conn->prepare("UPDATE user SET is_verified = 1, verification_token = NULL WHERE verification_token = ?");
        $update_stmt->bind_param("s", $token);

        if ($update_stmt->execute()) {
            header("Location: success.php?head=Verification Successfull! & msg=Your email has been verified successfully! You can now log in to your account.");
        } else {
            echo "Error verifying email.";
        }
        $update_stmt->close();
    } else {
        echo "Invalid verification link or account already verified. ";
    }
} else {
    echo "No verification token provided.";
}
?>
