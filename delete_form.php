<?php
require "0_config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required POST data is set
    if (isset($_POST['hid'])) {
        $hid = $_POST['hid'];

        // Use prepared statements to prevent SQL injection
        $stmt1 = $conn->prepare("DELETE FROM aggriment WHERE house_id = ?");
        $stmt2 = $conn->prepare("DELETE FROM household_info WHERE house_id = ?");
        $stmt3 = $conn->prepare("DELETE FROM vehicle_info WHERE house_id = ?");
        $stmt4 = $conn->prepare("DELETE FROM house_member_travle_info WHERE member_id LIKE ?");

        $stmt1->bind_param("s", $hid);
        $stmt2->bind_param("s", $hid);
        $stmt3->bind_param("s", $hid);
        $likeHid = "$hid%"; // Prepare for LIKE query
        $stmt4->bind_param("s", $likeHid);

        // Execute each query and check for errors
        $stmt1->execute();
        $stmt2->execute();
        $stmt3->execute();
        $stmt4->execute();

        $stmt1->close();
        $stmt2->close();
        $stmt3->close();
        $stmt4->close();

    } elseif (isset($_POST['mid'])) {
        $mid = $_POST['mid'];

        // Use prepared statements for mid as well
        $stmt = $conn->prepare("DELETE FROM house_member_travle_info WHERE member_id = ?");
        $stmt->bind_param("s", $mid);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect back to the dashboard
    header("Location: dashboard.php?type=edit-part1");
    exit();
} else {
    // Invalid request method
    http_response_code(405);
    echo "Method Not Allowed";
    exit();
}
?>
