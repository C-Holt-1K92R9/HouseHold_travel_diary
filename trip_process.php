<?php
require "0_config.php";

session_start();
$number_of_questions=102;
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data
    for ($i = 24; $i <= $number_of_questions; $i++) {
        if($i==97|| $i==90 ||$i==83 ||$i==76||$i==69||$i==62||$i==55||$i==48||$i==41||$i==34 )
        { // for multiple option
            $v=$_POST['limit'.$i]; 
            ${"q" . $i}="";
            ${"q" . $i."_1"}="";
            $has=false;
            $has1=false;
            for ($j = 1; $j <=$v ; $j++){
                if($_POST["q" . $i ."-".$j]!=""){
                    if($has){
                        ${"q" . $i}=${"q" . $i}.", ";
                    }
                    ${"q" . $i}=${"q" . $i}.$_POST["q" . $i ."-".$j];
                    $has=true;
                }
                if($_POST["q" . $i."-1" ."-".$j]!=""){
                    if($has1){
                        ${"q" . $i."_1"}=${"q" . $i."_1"}.", ";
                    }
                    ${"q" . $i."_1"}=${"q" . $i."_1"}.$_POST["q" . $i."-1" ."-".$j];
                    $has1=true;
                }
            }
        }
        else if ($i==30 ||$i==32 ||$i==39 ||$i==46 ||$i==53 ||$i==60 ||$i==67 ||$i==74 ||$i==81 ||$i==88 ||$i==95)
        { // for locations
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
        $house_id=$_POST['house_id'];
        $check_mem = $conn->query("SELECT member_id FROM house_member_travle_info WHERE member_id LIKE '$house_id%' ORDER BY member_id DESC LIMIT 1");
        $check_m = $check_mem->fetch_assoc();

        if (empty($check_m)) {
            // No matching member_id found, start with "01"
            $m_serial = "01";
        } else {
            // Extract the last part of member_id (after splitting by '-')
            $member_parts = explode("-", $check_m["member_id"]); // Example: "01-0209-01-01"
            $m_serial = intval($member_parts[3]) + 1; // Increment the serial part
            
            // Pad the new serial to 2 digits if necessary
            $m_serial = str_pad(strval($m_serial), 2, "0", STR_PAD_LEFT);
        }

        // Construct the new member_id
        $member_id = $house_id . "-" . $m_serial;

        //[36,43,50,57,64,71,78,85,92,99]
        $q36_1=$_POST['q36_1'];
        $q43_1=$_POST['q43_1'];
        $q50_1=$_POST['q50_1'];
        $q57_1=$_POST['q57_1'];
        $q64_1=$_POST['q64_1'];
        $q71_1=$_POST['q71_1'];
        $q78_1=$_POST['q78_1'];
        $q85_1=$_POST['q85_1'];
        $q92_1=$_POST['q92_1'];
        $q99_1=$_POST['q99_1'];
        $conn->query( "INSERT INTO house_member_travle_info (member_id, Q24, Q25, Q26, Q27, Q28, Q29, Q30, Q31, Q32, Q33, Q34, Q35, Q36, Q37, Q38, Q39, Q40, Q41, Q42, Q43, Q44, Q45, Q46, Q47, Q48, Q49, Q50, Q51, Q52, Q53, Q54, Q55, Q56, Q57, Q58, Q59, Q60, Q61, Q62, Q63, Q64, Q65, Q66, Q67, Q68, Q69, Q70, Q71, Q72, Q73, Q74, Q75, Q76, Q77, Q78, Q79, Q80, Q81, Q82, Q83, Q84, Q85, Q86, Q87, Q88, Q89, Q90, Q91, Q92, Q93, Q94, Q95, Q96, Q97, Q98, Q99, Q100, Q101, Q34_1, Q41_1, Q48_1, Q55_1, Q62_1, Q69_1, Q76_1, Q83_1, Q90_1, Q97_1, Q36_1, Q43_1, Q50_1, Q57_1, Q64_1, Q71_1, Q78_1, Q85_1, Q92_1, Q99_1) 
                           VALUES ('$member_id', '$q24', '$q25', '$q26', '$q27', '$q28', '$q29', '$q30', '$q31', '$q32', '$q33', '$q34', '$q35', '$q36', '$q37', '$q38', '$q39', '$q40', '$q41', '$q42', '$q43', '$q44', '$q45', '$q46', '$q47', '$q48', '$q49', '$q50', '$q51', '$q52', '$q53', '$q54', '$q55', '$q56', '$q57', '$q58', '$q59', '$q60', '$q61', '$q62', '$q63', '$q64', '$q65', '$q66', '$q67', '$q68', '$q69', '$q70', '$q71', '$q72', '$q73', '$q74', '$q75', '$q76', '$q77', '$q78', '$q79', '$q80', '$q81', '$q82', '$q83', '$q84', '$q85', '$q86', '$q87', '$q88', '$q89', '$q90', '$q91', '$q92', '$q93', '$q94', '$q95', '$q96', '$q97', '$q98', '$q99', '$q100', '$q102', '$q34_1', '$q41_1', '$q48_1', '$q55_1', '$q62_1', '$q69_1', '$q76_1', '$q83_1', '$q90_1', '$q97_1', '$q36_1', '$q43_1', '$q50_1', '$q57_1', '$q64_1', '$q71_1', '$q78_1', '$q85_1', '$q92_1', '$q99_1')");




} else {
    echo "Invalid request.";
}
if ($q101=="Yes"){
    header("Location: trip_form.php?type={$house_id}");
}
else{

    if ($_SESSION['user_id']==="00"){
            header("Location: admin_dash.php");
        }
        else{
        header("Location: dashboard.php");}
    exit();
}
?>
