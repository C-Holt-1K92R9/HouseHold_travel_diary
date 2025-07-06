<?php
require "0_config.php";

// Set the path to the XML file
session_start();

$number_of_questions=23;
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data

   for ($i = 1; $i <= $number_of_questions; $i++) {
        if ($i==4){
            ${"q" . $i."a"}=$_POST["q".$i."_a"];
            ${"q" . $i."b"}=$_POST["q".$i."_b"];
            if (empty(${"q" . $i."a"}) && empty(${"q" . $i."b"})){
                ${"q" . $i}="";
            }
            else{
            ${"q" . $i}=${"q" . $i."a"}.", ".${"q" . $i."b"};}
        }       
        else{
            ${"q" . $i} = $_POST["q" . $i];}
        }
        $q1_1 = $_POST["q1_1"];
        $q1_2 = $_POST["q1_2"];
        // creating house_id
        date_default_timezone_set('Asia/Dhaka');

        $current_date=strval(date('d.m.y'));
        $serial_date=strval(date('y.m.d'));
        $surveyer_id=$_SESSION['user_id'];
        $svid=$surveyer_id."-".$current_date;
        $check_t = $conn->query("SELECT house_id FROM aggriment WHERE house_id LIKE '$svid%' ORDER BY house_id DESC LIMIT 1");
        $check = $check_t->fetch_assoc();
        
        if (empty($check)) {
            // No existing house_id found, start with "01"
            $serial = "01";
        } else {
            // Split the last house_id into its components
            $house_parts = explode("-", $check["house_id"]); // Example: "01-20241226-01"
            $last_date = $house_parts[1]; // Extract the date part (e.g., "20241226")
        
            if ($current_date == $last_date) {
                // If the current date matches the last date, increment the serial
                $serial = intval($house_parts[2]) + 1;
                // Pad the serial to 2 digits if necessary
                $serial = str_pad(strval($serial), 2, "0", STR_PAD_LEFT);
            } else {
                // If the current date is different, reset the serial to "01"
                $serial = "01";
            }
        }
        $q22_1=$_POST['q22_1'];
        // Construct the new house_id
        $house_id = $surveyer_id . "-" . $current_date . "-" . $serial;
        $serial_id=$surveyer_id . "-" . $serial_date . "-" . $serial;
        //Inserting data into "aggriment" table
        $conn->query( "INSERT INTO aggriment (house_id, Q1, Q1_1, Q1_2, Q2) 
                           VALUES ('$house_id', '$q1','$q1_1','$q1_2' '$q2')");

        //Inserting  data into "household_info" table.
        $conn->query( "INSERT INTO household_info (house_id, serial_id, Q3, Q4, Q5, Q6, Q7, Q8, Q9, Q10) 
                           VALUES ('$house_id','$serial_id', '$q3', '$q4', '$q5', '$q6', '$q7', '$q8', '$q9', '$q10')");
        //Inserting data into "vehicle_info" table.
        $conn->query( "INSERT INTO vehicle_info (house_id, Q11, Q12, Q13, Q14, Q15, Q16, Q17, Q18, Q19, Q20, Q21, Q22, Q22_1, Q23) 
                           VALUES ('$house_id', '$q11', '$q12', '$q13', '$q14', '$q15', '$q16', '$q17', '$q18', '$q19', '$q20', '$q21', '$q22','$q22_1', '$q23')");


    // Provide a success message or redirect back to the form
    header("Location: trip_form.php?type={$house_id}");
} else {
    echo "Invalid request.";
}


?>

