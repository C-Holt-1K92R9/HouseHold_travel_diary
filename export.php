<?php
require "0_config.php";
session_start();
date_default_timezone_set('Asia/Dhaka');

$current_date = date('d-m');
$table_name = $_POST['table_name'] ?? '';
$tname=$table_name;
if ($table_name=='aggriment'){
    $tname='aggrement';
}

$sid=$_POST['sid'] ?? '';
$file_name =$sid.'-'. preg_replace('/[^A-Za-z0-9_\-]/', '-', $tname).'-' . $current_date . ".csv"; // Sanitize filename

// Define column names and limits based on the table
switch ($table_name) {
    case "user":
        $columns = ['user_id', 'name', 'phone_number' ,'email', 'status','is_verified','created_at'];
        break;
    case "aggriment":
        $columns = ['house_id', 'Q1', 'Q2'];
        break;
    case "household_info":
        $columns = ['house_id', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q8', 'Q9', 'Q10'];
        break;
    case "vehicle_info":
        $columns = ['house_id', 'Q11', 'Q12', 'Q13', 'Q14', 'Q15', 'Q16', 'Q17', 'Q18', 'Q19', 'Q20', 'Q21', 'Q22', 'Q22_1', 'Q23'];
        break;
    case "house_member_travel_info":
    default:
        $columns = ['member_id','Q24', 'Q25', 'Q26', 'Q27', 'Q28', 'Q29', 'Q30', 'Q31', 'Q32', 'Q33', 'Q34', 'Q34_1', 'Q35',
        'Q36', 'Q36_1', 'Q37', 'Q38', 'Q39', 'Q40', 'Q41', 'Q41_1', 'Q42', 'Q43', 'Q43_1', 'Q44', 'Q45', 'Q46', 'Q47', 'Q48', 'Q48_1', 'Q49', 'Q50', 'Q50_1', 'Q51',
        'Q52', 'Q53', 'Q54', 'Q55', 'Q55_1', 'Q56', 'Q57', 'Q57_1', 'Q58', 'Q59', 'Q60', 'Q61', 'Q62', 'Q62_1', 'Q63', 'Q64', 'Q64_1', 'Q65', 'Q66', 'Q67',
        'Q68', 'Q69', 'Q69_1', 'Q70', 'Q71', 'Q71_1', 'Q72', 'Q73', 'Q74', 'Q75', 'Q76', 'Q76_1', 'Q77', 'Q78', 'Q78_1', 'Q79', 'Q80', 'Q81', 'Q82', 'Q83', 'Q83_1',
        'Q84', 'Q85', 'Q85_1', 'Q86', 'Q87', 'Q88', 'Q89', 'Q90', 'Q90_1', 'Q91', 'Q92', 'Q92_1', 'Q93', 'Q94', 'Q95', 'Q96', 'Q97', 'Q97_1', 'Q98', 'Q99','Q99_1', 
        'Q100','Q101'];
        break;
}

// Prepare CSV header
$csv_data = implode(",", $columns) . "\n";

if ($table_name==='aggriment'|| $table_name==='household_info' || $table_name==='vehicle_info'){
    $id='house_id';
}
elseif($table_name==='house_member_travle_info'){
    $id='member_id';
}
else{
    $id="user_id";
}
// Fetch data from the database
if ($sid==="all"){
    $query = "SELECT * FROM `$table_name`";}
else{
    $query = "SELECT * FROM `$table_name` where $id like '$sid-%' ";
}

$result = $conn->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $row_data = [];
        // Add question data to row
        foreach ($columns as $column) {
            if (isset($row[$column])) {
                // Escape double quotes by doubling them and wrap in quotes
                $row_data[] = '"' . str_replace('"', '""', $row[$column]) . '"';
            } else {
                $row_data[] = '""'; // Add empty field if column doesn't exist
            }
        }

        // Append row data to CSV string
        $csv_data .= implode(",", $row_data) . "\n";
    }
} else {
    die("Error retrieving data: " . $conn->error);
}
if ($table_name==='aggriment'){
    $table_name='';
}
// Set headers for CSV download
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=\"$file_name\"");
header("Pragma: no-cache");
header("Expires: 0");

// Output CSV data
echo $csv_data;

// Close database connection
$conn->close();
?>
