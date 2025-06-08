<?php
// Include the existing database connection
require "0_config.php"; // Adjust path if necessary

// Handle close report request
$message = '';
if (isset($_POST['close_report_id'])) {
    $report_id = $_POST['close_report_id'];
    $sql = "UPDATE user_issues SET status = 'closed' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $report_id);

    if ($stmt->execute()) {
        $message = "Report ID $report_id has been closed successfully.";
    } else {
        $message = "Error closing the report. Please try again.";
    }
    $stmt->close();
}

// Fetch all reports
$sql = "SELECT * FROM user_issues ORDER BY submitted_at DESC";
$result = $conn->query($sql);
$reports = $result->fetch_all(MYSQLI_ASSOC);
$result->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin - View Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 10px;
            margin: 0;
        }
        .container {
            width: 100%;
            max-width: 95%;
            background-color: #1e1e1e;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
            overflow-x: auto;
        }
        h1 {
            color: #00c853;
            text-align: center;
            margin-bottom: 15px;
            font-size: 1.5em;
        }
        .message {
            background-color: #003300;
            color: #00c853;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 0.9em;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #333;
            word-wrap: break-word;
        }
        th {
            background-color: #2c2c2c;
            color: #b0b0b0;
            font-size: 0.8em;
        }
        .status {
            padding: 5px 10px;
            border-radius: 5px;
            color: #fff;
            display: inline-block;
            font-size: 0.8em;
        }
        .open-status {
            background-color: #d32f2f;
        }
        .closed-status {
            background-color: #388e3c;
        }
        form {
            display: inline;
        }
        button {
            background-color: #00c853;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 0.9em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 5px;
            width: 100%;
        }
        button:hover {
            background-color: #00a344;
        }
    </style>
</head>
<body>
    <button onclick="window.location.href='admin_dash.php?type=home'">Go back to Admin Dashboard</button>
    <div class="container">
        <h1>Admin - Issue Reports</h1>
        <?php if (!empty($message)) echo "<div class='message'>$message</div>"; ?>

        <table>
            <thead>
                <tr>
                    <th>ID / Email</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date Submitted</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($report['id']); ?></td>
                        <td><?php echo htmlspecialchars($report['issue_title']); ?></td>
                        <td><?php echo htmlspecialchars($report['issue_description']); ?></td>
                        <td><?php echo htmlspecialchars($report['submitted_at']); ?></td>
                        <td>
                            <span class="status <?php echo $report['status'] == 'open' ? 'open-status' : 'closed-status'; ?>">
                                <?php echo ucfirst($report['status']); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($report['status'] == 'open'): ?>
                                <form method="POST" action="report_admin.php">
                                    <input type="hidden" name="close_report_id" value="<?php echo $report['id']; ?>">
                                    <button type="submit">Close Report</button>
                                </form>
                            <?php else: ?>
                                <span>Closed</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
