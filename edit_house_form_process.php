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

        $house_id=$_POST['house_id'];
        $q22_1=$_POST['q22_1'];
            // Updating data in "aggriment" table.
$conn->query("UPDATE aggriment 
SET Q1 = '$q1',
    Q1_1 = '$q1_1',
    Q1_2 = '$q1_2',
    Q2 = '$q2' 
WHERE house_id = '$house_id'")
or die($conn->error);

// Updating data in "household_info" table.
$conn->query("UPDATE household_info 
SET Q3 = '$q3', 
    Q4 = '$q4', 
    Q5 = '$q5', 
    Q6 = '$q6', 
    Q7 = '$q7', 
    Q8 = '$q8', 
    Q9 = '$q9', 
    Q10 = '$q10' 
WHERE house_id = '$house_id'")
or die($conn->error);

// Updating data in "vehicle_info" table.
$conn->query("UPDATE vehicle_info 
SET Q11 = '$q11', 
    Q12 = '$q12', 
    Q13 = '$q13', 
    Q14 = '$q14', 
    Q15 = '$q15', 
    Q16 = '$q16', 
    Q17 = '$q17', 
    Q18 = '$q18', 
    Q19 = '$q19', 
    Q20 = '$q20', 
    Q21 = '$q21', 
    Q22 = '$q22',
    Q22_1 = '$q22_1',
    Q23 = '$q23' 
WHERE house_id = '$house_id'")
or die($conn->error);



        if ($_SESSION['user_id']==="00"){
            header("Location: admin_dash.php");
        }
        else{
        header("Location: dashboard.php?type=edit-part1");}
} 
else {
    echo "Invalid request.";
}



?>

