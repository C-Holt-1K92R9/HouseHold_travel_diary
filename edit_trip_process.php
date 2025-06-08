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


        // getting the house id
        //$house_t=$conn->query("SELECT house_id from aggriment where house_id like '$surveyer_id%' order by house_id DESC limit 1");
        //$house= $house_t->fetch_assoc();
        $member_id=$_POST['member_id'];
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
        $conn->query("UPDATE house_member_travle_info 
              SET Q24='$q24', Q25='$q25', Q26='$q26', Q27='$q27', Q28='$q28', Q29='$q29', 
                  Q30='$q30', Q31='$q31', Q32='$q32', Q33='$q33', Q34='$q34', Q35='$q35', 
                  Q36='$q36', Q37='$q37', Q38='$q38', Q39='$q39', Q40='$q40', Q41='$q41', 
                  Q42='$q42', Q43='$q43', Q44='$q44', Q45='$q45', Q46='$q46', Q47='$q47', 
                  Q48='$q48', Q49='$q49', Q50='$q50', Q51='$q51', Q52='$q52', Q53='$q53', 
                  Q54='$q54', Q55='$q55', Q56='$q56', Q57='$q57', Q58='$q58', Q59='$q59', 
                  Q60='$q60', Q61='$q61', Q62='$q62', Q63='$q63', Q64='$q64', Q65='$q65', 
                  Q66='$q66', Q67='$q67', Q68='$q68', Q69='$q69', Q70='$q70', Q71='$q71', 
                  Q72='$q72', Q73='$q73', Q74='$q74', Q75='$q75', Q76='$q76', Q77='$q77', 
                  Q78='$q78', Q79='$q79', Q80='$q80', Q81='$q81', Q82='$q82', Q83='$q83', 
                  Q84='$q84', Q85='$q85', Q86='$q86', Q87='$q87', Q88='$q88', Q89='$q89', 
                  Q90='$q90', Q91='$q91', Q92='$q92', Q93='$q93', Q94='$q94', Q95='$q95', 
                  Q96='$q96', Q97='$q97', Q98='$q98', Q99='$q99', Q100='$q100', Q101='$q102', Q34_1='$q34_1',
                  Q41_1='$q41_1', Q48_1='$q48_1', Q55_1='$q55_1', Q62_1='$q62_1', Q69_1='$q69_1', Q76_1='$q76_1',
                  Q83_1='$q83_1', Q90_1='$q90_1', Q97_1='$q97_1', Q36_1='$q36_1', Q43_1='$q43_1', Q50_1='$q50_1', 
                  Q57_1='$q57_1', Q64_1='$q64_1', Q71_1='$q71_1', Q78_1='$q78_1', Q85_1='$q85_1', Q92_1='$q92_1', Q99_1='$q99_1'
              WHERE member_id='$member_id'");

if ($_SESSION['user_id']==="00"){
    header("Location: admin_dash.php");
}
else{
header("Location: dashboard.php?type=edit-part1");}
    exit();


} else {
    echo "Invalid request.";
}

?>
