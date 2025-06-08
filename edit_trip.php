<?php
require "0_config.php";

//============================================================
session_start();

$member_id = $_GET['type'] ?? null;
if (isset($member_id)) {
    // Prepare the statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM house_member_travle_info WHERE member_id = ?");
    $stmt->bind_param("s", $member_id); // 'i' for integer parameter type
    $stmt->execute();
    $member = $stmt->get_result()->fetch_assoc();
}
for ($i = 30; $i <= 100; $i++){

        if ($i==30 ||$i==32 ||$i==39 ||$i==46 ||$i==53 ||$i==60 ||$i==67 ||$i==74 ||$i==81 ||$i==88 ||$i==95)
            { // for locations
                if (!empty($member['Q'.$i])){
                list(${"q".$i."_a"}, ${"q".$i."_b"}) = array_map('trim', explode(',', $member['Q'.$i]));}
                else{
                    ${"q".$i."_a"}="";
                    ${"q".$i."_b"}="";
                }
                
                
            }
        
    }

    $questions = [97, 90, 83, 76, 69, 62, 55, 48, 41, 34]; // List of question numbers
    foreach ($questions as $i) {
        $array = explode(",", $member['Q' . $i]); // Split the response by commas
        $array2 = explode(",", $member['Q' . $i."_1"]);
        // Initialize all possible mode variables to empty by default
        for ($k = 1; $k <= 14; $k++) {
            ${"q" . $i . "_" . $k} = 0;
            ${"q" . $i ."_1". "_" . $k} = 0;
        }
    
        // Set variable to specific mode based on response
        foreach ($array as $option) {
            switch (trim($option)) {
                case 'Bus':
                    ${"q" . $i . "_1"} = 1;
                    break;
                case 'Private Bus (Office bus/ school bus etc)':
                    ${"q" . $i . "_2"} = 1;
                    break;
                case 'Human Hauler ( 9 or 14 seater tempu etc)':
                    ${"q" . $i . "_3"} = 1;
                    break;
                case 'Paddle Rickshaw':
                    ${"q" . $i . "_4"} = 1;
                    break;
                case 'Auto Rickshaw':
                    ${"q" . $i . "_5"} = 1;
                    break;   
                case 'CNG/taxi':
                    ${"q" . $i . "_6"} = 1;
                    break;
                case 'Personal Car':
                    ${"q" . $i . "_7"} = 1;
                    break;
                case 'Rented or ride sharing Car':
                    ${"q" . $i . "_8"} = 1;
                    break;
                case 'Personal 2 wheeler':
                    ${"q" . $i . "_9"} = 1;
                    break;
                case 'Ride sharing 2 wheeler':
                    ${"q" . $i . "_10"} = 1;
                    break;
                case 'Bicycle':
                    ${"q" . $i . "_11"} = 1;
                    break;
                case 'Walk':
                    ${"q" . $i . "_12"} = 1;
                    break;
                case 'Train':
                    ${"q" . $i . "_13"} = 1;
                    break;
                case 'Other':
                    ${"q" . $i . "_14"} = 1;
                    break;
            }
        }
        foreach ($array2 as $option2) {
            switch (trim($option2)) {
                case 'Bus':
                    ${"q" . $i ."_1". "_1"} = 1;
                    break;
                case 'Private Bus (Office bus/ school bus etc)':
                    ${"q" . $i ."_1". "_2"} = 1;
                    break;
                case 'Human Hauler ( 9 or 14 seater tempu etc)':
                    ${"q" . $i ."_1". "_3"} = 1;
                    break;
                case 'Paddle Rickshaw':
                    ${"q" . $i ."_1". "_4"} = 1;
                    break;
                case 'Auto Rickshaw':
                    ${"q" . $i ."_1". "_5"} = 1;
                    break;   
                case 'CNG/taxi':
                    ${"q" . $i."_1" . "_6"} = 1;
                    break;
                case 'Personal Car':
                    ${"q" . $i."_1" . "_7"} = 1;
                    break;
                case 'Rented or ride sharing Car':
                    ${"q" . $i ."_1". "_8"} = 1;
                    break;
                case 'Personal 2 wheeler':
                    ${"q" . $i ."_1". "_9"} = 1;
                    break;
                case 'Ride sharing 2 wheeler':
                    ${"q" . $i ."_1". "_10"} = 1;
                    break;
                case 'Bicycle':
                    ${"q" . $i ."_1". "_11"} = 1;
                    break;
                case 'Walk':
                    ${"q" . $i ."_1". "_12"} = 1;
                    break;
                case 'Train':
                    ${"q" . $i ."_1". "_13"} = 1;
                    break;
                case 'Other':
                    ${"q" . $i ."_1". "_14"} = 1;
                    break;
            }
        }
    }
    ?>
    


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Form</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>  
    <style>
                    body {
                font-family: Arial, sans-serif;
                background-color: #292929;
                color: #fff;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                zoom:0%;
            }
            .locator{
                padding: 10px 15px;
                background-color: #3cb371;
                border: none;
                color: #fff;
                border-radius: 5px;
                cursor: pointer;
            }
            .other {
                opacity: 0.5;
                pointer-events: none;
            }
            
            .otherRad:checked ~ .other {
                content: "*";
                opacity: 1;
                pointer-events: auto;
                background-color: #2e8b57;
            }

            .Q{
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0 0 10px #000;
                margin-bottom:25px;
                
            }
            .must {
                color: red;
            }

            .container {
                width: 100%;
                margin: auto;
                padding: 20px;
                background-color: #2e2e2e;
                border-radius: 10px;
                box-shadow: 0 0 10px #000;
            }

            .form-group {
                margin-bottom: 15px;
                top: 10px;
            }
            .next_btn{
                padding: 10px 15px;
                background-color: #0ca3a5;
                border: none;
                color: #fff;
                border-radius: 5px;
                cursor: pointer;
            }

            .bottom_btn{
                display: flex;
                justify-content: space-between;}
            .final{
                width: 100%;

            }
            .submit_next{
                width: 35%;
                padding: 10px 15px;
                background-color: #3cb371;
                border: none;
                color: #fff;
                border-radius: 5px;
                cursor: pointer;
            }
            .submit {

                padding: 10px 15px;
                background-color: #3cb371;
                border: none;
                color: #fff;
                border-radius: 5px;
                cursor: pointer;
            }

            .submit:hover {
                background-color: #2e8b57;
            }
            .section{
                display: none;
            }
            .active{
                display: block;
            }
            /* for radio type */
            .radio-input label {
                display: flex;
                align-items: center;
                gap: 15px;
                padding: 0px 10px;
                width: 220px;
                cursor: pointer;
                height: 50px;
                position: relative;
            }

            .radio-input .label input[type="radio"],input[type="checkbox"] {
                width: 17px;
                height: 17px;
            }
            /* From Uiverse.io by adamgiebl */ 
            .cyberpunk-checkbox {
                appearance: none;
                width: 20px;
                height: 20px;
                border: 2px solid #30cfd0;
                border-radius: 5px;
                background-color: transparent;
                display: inline-block;
                position: relative;
                margin-right: 10px;
                cursor: pointer;
            }
            
            .cyberpunk-checkbox:before {
                content: "";
                background-color: #30cfd0;
                display: block;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) scale(0);
                width: 10px;
                height: 10px;
                border-radius: 3px;
                transition: all 0.3s ease-in-out;
            }
            
            .cyberpunk-checkbox:checked:before {
                transform: translate(-50%, -50%) scale(1);
            }
            
            .cyberpunk-checkbox-label {
                font-size: 18px;
                color: #fff;
                cursor: pointer;
                user-select: none;
                display: flex;
                align-items: center;
            }
            /* for text type */
            input[type="text"],
            input[type="number"],
            input[type="date"],
            input[type="time"],
            select,
            textarea {
                width: 90%;
                padding: 8px;
                margin-top: 5px;
                border-radius: 5px;
                border: 1px solid #555;
                background-color: #3e3e3e;
                color: #fff;
            }

            /* Media query for mobile devices */
            @media (max-width: 2000px) {
                .right{
                    position: relative;
                    right:-90%;
                }
                .container {
                    width: 90%; /* Make container take more space on mobile */
                    padding: 20px;
                }

                .radio-input label {
                    width: 100%; /* Adjust radio label width for mobile */
                    justify-content: left;
                }

                .submit {
                    width: 100%; /* Full width button on mobile */
                    padding: 12px 0;
                    position: relative;
                }
                
                input[type="text"],
                input[type="number"],
                input[type="date"],
                input[type="time"],
                select,
                textarea {
                    width:90%;
                    padding: 10px; /* Increase padding for better touch interaction */
                }
            }


    </style>
</head>
<body>
    <div id="head_start" class="container">
        <h2>Survey Form</h2>
        <p><span class="must">* Indicated required questions.</span></p>
        <p>Note: Select <span class="must">"null"</span> if not answered. [For the questions that are not mandatory]</p>
    <form action="edit_trip_process.php" method="POST">
        <input type="hidden" value="<?= $member_id?>" name="member_id">
        <div class="section active" id="section1">
            <!-- Q24 -->
             <h1>Personal Information</h1>
            <div class="Q">
                <p><span class="q_no">Q24: </span> Gender <span class="must">*</span> </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q24" value="Male" <?= $member['Q24'] === 'Male' ? 'checked' : '' ?> required>
                             <p class="text">Male</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q24" value="Female" <?= $member['Q24'] === 'Female' ? 'checked' : '' ?> required>
                            <p class="text">Female</p>
                   </label>
                    </div> 
            </div>

            <!-- Q25 -->
            <div class="Q">
                <p><span class="q_no">Q25: </span> Age<span class="must">*</span>  </p>
                <div class="radio-input">
                <input type="number" name="q25" placeholder="Age" required value="<?=htmlspecialchars($member['Q25'])?>">
                    
                    </div> 
            </div>

            <!-- Q26 -->
            <div class="Q">
                <p><span class="q_no">Q26: </span> Has Driving license.<span class="must">*</span> </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q26" value="Only car- Non professional" required <?= $member['Q26'] === 'Only car- Non professional' ? 'checked' : '' ?>>
                             <p class="text">Only car- Non professional</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q26" value="Only 2 wheeler- non professional" required <?= $member['Q26'] === 'Only 2 wheeler- non professional' ? 'checked' : '' ?>>
                            <p class="text">Only 2 wheeler- non professional</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q26" value="Both Non professional" required <?= $member['Q26'] === 'Both Non professional' ? 'checked' : '' ?>>
                            <p class="text">Both Non professional</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q26" value="Professional" required <?= $member['Q26'] === 'Professional' ? 'checked' : '' ?>>
                            <p class="text">Professional</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q26" value="None" required <?= $member['Q26'] === 'None' ? 'checked' : '' ?>>
                        <p class="text">None</p>
                    </label>
                    </div>
            </div>

            <!-- Q27 -->
            <div class="Q">
                <p><span class="q_no">Q27: </span> Highest Level of Education<span class="must">*</span> 
                </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q27" value="Phd or equivalent" required <?= $member['Q27'] === 'Phd or equivalent' ? 'checked' : '' ?>>
                             <p class="text">Phd or equivalent</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q27" value="Masters or equivalent" required <?= $member['Q27'] === 'Masters or equivalent' ? 'checked' : '' ?>>
                            <p class="text">Masters or equivalent</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q27" value="Bachelor or equivalent" required <?= $member['Q27'] === 'Bachelor or equivalent' ? 'checked' : '' ?>>
                        <p class="text">Bachelor or equivalent</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q27" value="Technical or equivalent" required <?= $member['Q27'] === 'Technical or equivalent' ? 'checked' : '' ?>>
                            <p class="text">Technical or equivalent</p>
                   </label>
                   <label class="label">
                       <input type="radio"  name="q27" value="Higher Secondary" required <?= $member['Q27'] === 'Higher Secondary' ? 'checked' : '' ?>>
                           <p class="text">Higher Secondary</p>
                  </label>
                  <label class="label">
                   <input type="radio"  name="q27" value="Secondary" required <?= $member['Q27'] === 'Secondary' ? 'checked' : '' ?>>
                       <p class="text">Secondary</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q27" value="Primary" required <?= $member['Q27'] === 'Primary' ? 'checked' : '' ?>>
                        <p class="text">Primary</p>
               </label>
               <label class="label">
                   <input type="radio"  name="q27" value="Illeterate" required <?= $member['Q27'] === 'Illeterate' ? 'checked' : '' ?>>
                       <p class="text">Illeterate</p>
              </label>
              <label class="label">
                <input type="radio"  name="q27" value="Other" required <?= $member['Q27'] === 'Other' ? 'checked' : '' ?>>
                    <p class="text">Other</p>
           </label>
                </div> 
            </div>

            <!-- Q28 -->
            <div class="Q">
                <p><span class="q_no">Q28: </span> Occupation <span class="must">*</span> 
                </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q28" value="Govt. Employee" required <?= $member['Q28'] === 'Govt. Employee' ? 'checked' : '' ?>>
                             <p class="text">Govt. Employee</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q28" value="Private Employee" required <?= $member['Q28'] === 'Private Employee' ? 'checked' : '' ?>>
                            <p class="text">Private Employee</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q28" value="Businessman" required <?= $member['Q28'] === 'Businessman' ? 'checked' : '' ?>>
                        <p class="text">Businessman</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q28" value="Student" required <?= $member['Q28'] === 'Student' ? 'checked' : '' ?>>
                            <p class="text">Student</p>
                   </label>
                   <label class="label">
                       <input type="radio"  name="q28" value="Housewife" required <?= $member['Q28'] === 'Housewife' ? 'checked' : '' ?>>
                           <p class="text">Housewife</p>
                  </label>
                  <label class="label">
                   <input type="radio"  name="q28" value="Tuition" required <?= $member['Q28'] === 'Tuition' ? 'checked' : '' ?>>
                       <p class="text">Tuition</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q28" value="Freelancer" required <?= $member['Q28'] === 'Freelancer' ? 'checked' : '' ?>>
                        <p class="text">Freelancer </p>
                        
               </label>
               <label class="label">
                   <input type="radio"  name="q28" value="Staff" required <?= $member['Q28'] === 'Staff' ? 'checked' : '' ?>>
                       <p class="text">Staff </p>
              </label>
              <label class="label">
                <input type="radio"  name="q28" value="Unemployed" required <?= $member['Q28'] === 'Unemployed' ? 'checked' : '' ?>>
                    <p class="text">Unemployed</p>
                </label>
                <label class="label">
                    <input type="radio"  name="q28" value="Other" required <?= $member['Q28'] === 'Other' ? 'checked' : '' ?>>
                        <p class="text">Other</p>
                    </label>
                </div>
                </div>
                <div class="bottom_btn">
                    <p></p>
                    <a class="next_btn" onclick="opentab('section1','part2')" href="#head_start">Next</a>
                
                </div>
        
            </div>

            <div class="section" id="part2">
                <h1>Trip related information</h1>
               <h3> Below questionnaire are used to collect individual trip related information.</h3>
            

            <div class="section active" id="section2">
            
            <h1>Trip 1</h1>
            
            <!-- Q29 -->
            <div class="Q">
                <p><span class="q_no">Q29: </span> <h3>Start Time</h3>
                    Trip start time </p>
                    <input type="time" name="q29" value="<?= htmlspecialchars($member['Q29'] ?? '') ?>">
            </div>

            <!-- Q30 -->
            <div class="Q">
                <p><span class="q_no">Q30: Origin address (please write specifically so that we can pinpoint roughly on map)</span></p>
                <div>
                    <label for="q30_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q30_lat" name="q30_a" value="<?= htmlspecialchars($q30_a ?? '') ?>">
                    <label for="q30_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q30_lng" name="q30_b" value="<?= htmlspecialchars($q30_b ?? '') ?>">
                    <button type="button" onclick="openMap('q30')" class="locator">Open Map</button>
                </div>
        
            </div>

            <!-- Q31 -->
            <div class="Q">
                <p><span class="q_no">Q31: </span> Origin Type </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q31" value="Home" <?= $member['Q31'] === 'Home' ? 'checked' : '' ?>>
                             <p class="text">Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q31" value="Work" <?= $member['Q31'] === 'Work' ? 'checked' : '' ?>>
                            <p class="text">Work</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q31" value="Education" <?= $member['Q31'] === 'Education' ? 'checked' : '' ?>>
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q31" value="Shopping" <?= $member['Q31'] === 'Shopping' ? 'checked' : '' ?>>
                            <p class="text">Shopping</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q31" value="Social/Recreational/Personal" <?= $member['Q31'] === 'Social/Recreational/Personal' ? 'checked' : '' ?>>
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q31" value="Pickup or Drop off" <?= $member['Q31'] === 'Pickup or Drop off' ? 'checked' : '' ?>>
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q31" value="Medical" <?= $member['Q31'] === 'Medical' ? 'checked' : '' ?>>
                            <p class="text">Medical</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q31" value="Others" <?= $member['Q31'] === 'Others' ? 'checked' : '' ?>>
                            <p class="text">Others</p>
                   </label>
                   <label class="label">
                    <input type="radio" id="value-1" name="q31" value="" <?= empty($member['Q31']) ? 'checked' : '' ?>>
                    <p class="text">null</p>
              </label>  
                    </div> 
            </div>

            <!-- Q32 -->
            <div class="Q">
                <p><span class="q_no">Q32: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="start_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q32_lat" name="q32_a" value="<?= htmlspecialchars($q32_a ?? '') ?>">
                    <label for="start_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q32_lng" name="q32_b" value="<?= htmlspecialchars($q32_b ?? '') ?>">
                    <button type="button" onclick="openMap('q32')" class="locator">Open Map</button>
                </div>
        
            </div>

            <!-- Q33 -->
            <div class="Q">
                <p><span class="q_no">Q33: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q33" value="Work" <?= $member['Q33'] === 'Work' ? 'checked' : '' ?>>
                             <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q33" value="Education" <?= $member['Q33'] === 'Education' ? 'checked' : '' ?>>
                            <p class="text">Education</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q33" value="Shopping" <?= $member['Q33'] === 'Shopping' ? 'checked' : '' ?>>
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                    <input type="radio"  name="q33" value="Social/Recreational/Personal" <?= $member['Q33'] === 'Social/Recreational/Personal' ? 'checked' : '' ?>>
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                    <input type="radio"  name="q33" value="Return to Home" <?= $member['Q33'] === 'Return to Home' ? 'checked' : '' ?>>
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q33" value="Pickup or Drop off" <?= $member['Q33'] === 'Pickup or Drop off' ? 'checked' : '' ?>>
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q33" value="Medical" <?= $member['Q33'] === 'Medical' ? 'checked' : '' ?>>
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio"  name="q33" value="Others" <?= $member['Q33'] === 'Others' ? 'checked' : '' ?>>
                    <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" id="value-1" name="q33" value="" <?= empty($member['Q33']) ? 'checked' : '' ?>>
                        <p class="text">null</p>
                  </label> 
                  </null->
                    </div> 
            </div>

            <!-- Q34 -->
            <div class="Q">
            <p><span class="q_no">Q34: </span> Modes used for stages</p>
            <div class="radio-input">
                <input type="hidden" name="limit34" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q34-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q34-1" value="Bus" <?= $q34_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-2" value="Private Bus (Office bus/ school bus etc)" <?= $q34_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q34_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-4" value="Paddle Rickshaw" <?= $q34_4 === 1 ? 'checked' : '' ?>>
                    <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-5" value="Auto Rickshaw" <?= $q34_5 === 1 ? 'checked' : '' ?>>
                    <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-6" value="CNG/taxi" <?= $q34_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-7" value="Personal Car" <?= $q34_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-8" value="Rented or ride sharing Car" <?= $q34_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-9" value="Personal 2 wheeler" <?= $q34_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-10" value="Ride sharing 2 wheeler" <?= $q34_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-11" value="Bicycle" <?= $q34_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-12" value="Walk" <?= $q34_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-13" value="Train" <?= $q34_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-14" value="Other" <?= $q34_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    <!-- Q34-1 -->
        <div class="Q">
            <p><span class="q_no">Q34.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason?</p>
            <div class="radio-input">
                <input type="hidden" name="limit34-1" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q34-1-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q34-1-1" value="Bus" <?= $q34_1_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-1-2" value="Private Bus (Office bus/ school bus etc)" <?= $q34_1_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q34_1_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q34-1-4" value="Paddle Rickshaw" <?= $q34_1_4 === 1 ? 'checked' : '' ?>>
                            <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q34-1-5" value="Auto Rickshaw"<?= $q34_1_5 === 1 ? 'checked' : '' ?> >
                            <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-1-6" value="CNG/taxi" <?= $q34_1_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-1-7" value="Personal Car" <?= $q34_1_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-1-8" value="Rented or ride sharing Car" <?= $q34_1_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-1-9" value="Personal 2 wheeler" <?= $q34_1_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-1-10" value="Ride sharing 2 wheeler" <?= $q34_1_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-1-11" value="Bicycle" <?= $q34_1_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-1-12" value="Walk" <?= $q34_1_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-1-13" value="Train" <?= $q34_1_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q34-1-14" value="Other" <?= $q34_1_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    



            <!-- Q35 -->
            <div class="Q">
                <p><span class="q_no">Q35: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                    <input type="time" name="q35" value="<?= htmlspecialchars($member['Q35'] ?? '') ?>">
            </div>

            <!-- Q36 -->
            <div class="Q">
                <p><span class="q_no">Q36: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q36" value="Alone" <?= $member['Q36'] === 'Alone' ? 'checked' : '' ?>>
                             <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36" value="1 person" <?= $member['Q36'] === '1 person' ? 'checked' : '' ?>>
                            <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36" value="2 persons" <?= $member['Q36'] === '2 persons' ? 'checked' : '' ?>>
                            <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q36" value="3 persons" <?= $member['Q36'] === '3 persons' ? 'checked' : '' ?>>
                           <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36" value="3+ persons" <?= $member['Q36'] === '3+ persons' ? 'checked' : '' ?>>
                            <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q36" value="" <?= empty($member['Q36']) ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q36_1 -->
            <div class="Q">
                <p><span class="q_no">Q36_1: </span> <h2>Approximate out-of-vehicle waiting time</h2> <Br>(Waiting means the approximate amount of time the trip maker had to wait to get on a certain vehicle. For example, if you are traveling to work bus, and before getting on the bus you have to wait 5 mins for the bus to arrive at the station. Then the waiting time is 5 min. )
                </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q36_1" value="0-5 mins" <?= $member['Q36_1'] === '0-5 mins' ? 'checked' : '' ?>>
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36_1" value="5-10 mins" <?= $member['Q36_1'] === '5-10 mins' ? 'checked' : '' ?>>
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36_1" value="10-15 mins" <?= $member['Q36_1'] === '10-15 mins' ? 'checked' : '' ?>>
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q36_1" value="15-20 mins" <?= $member['Q36_1'] === '15-20 mins' ? 'checked' : '' ?>>
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36_1" value="20-30 mins" <?= $member['Q36_1'] === '20-30 mins' ? 'checked' : '' ?>>
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36_1" value="30-45 mins" <?= $member['Q36_1'] === '30-45 mins' ? 'checked' : '' ?>>
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36_1" value="45+ mins" <?= $member['Q36_1'] === '45+ mins' ? 'checked' : '' ?>>
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q36_1" value="" <?= $member['Q36_1'] === '' ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q37 -->
            <div class="Q">
                <p><span class="q_no">Q37: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home  that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                    <input type="text" name="q37" value="<?= htmlspecialchars($member['Q37'] ?? '') ?>">
                </div>
                <div class="bottom_btn">
                    <a class="next_btn" onclick="opentab('part2','section1')" href="#head_start">Previous</a>
                    <a class="next_btn" onclick="opentab('section2','section3')" href="#head_start">Next</a>
                </div>
            </div>
            
            <div class="section" id="section3">
            <h1>Trip 2</h1>
            <!-- Q38 -->
            <div class="Q">
                <p><span class="q_no">Q38: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q38" value="<?= htmlspecialchars($member['Q38'] ?? '') ?>">
            </div>

            <!-- Q39 -->
            <div class="Q">
                <p><span class="q_no">Q39: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q39_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q39_lat" name="q39_a" value="<?= htmlspecialchars($q39_a ?? '') ?>">
                    <label for="q39_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q39_lng" name="q39_b" value="<?= htmlspecialchars($q39_b ?? '') ?>">
                    <button type="button" onclick="openMap('q39')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q40 -->
            <div class="Q">
                <p><span class="q_no">Q40: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q40" value="Work" <?= $member['Q40'] === 'Work' ? 'checked' : '' ?>>
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q40" value="Education" <?= $member['Q40'] === 'Education' ? 'checked' : '' ?>>
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q40" value="Shopping" <?= $member['Q40'] === 'Shopping' ? 'checked' : '' ?>>
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q40" value="Social/Recreational/Personal" <?= $member['Q40'] === 'Social/Recreational/Personal' ? 'checked' : '' ?>>
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q40" value="Return to Home" <?= $member['Q40'] === 'Return to Home' ? 'checked' : '' ?>>
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q40" value="Pickup or Drop off" <?= $member['Q40'] === 'Pickup or Drop off' ? 'checked' : '' ?>>
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q40" value="Medical" <?= $member['Q40'] === 'Medical' ? 'checked' : '' ?>>
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q40" value="Others" <?= $member['Q40'] === 'Others' ? 'checked' : '' ?>>
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" id="value-1" name="q40" value="" <?= empty($member['Q40']) ? 'checked' : '' ?>>
                        <p class="text">null</p>
                    </label>
                </div>
            </div>

            <!-- Q41 -->
            <div class="Q">
            <p><span class="q_no">Q41: </span> Modes used for stages</p>
            <div class="radio-input">
                <input type="hidden" name="limit41" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q41-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q41-1" value="Bus" <?= $q41_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-2" value="Private Bus (Office bus/ school bus etc)" <?= $q41_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q41_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-4" value="Paddle Rickshaw" <?= $q41_4 === 1 ? 'checked' : '' ?>>
                    <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-5" value="Auto Rickshaw" <?= $q41_5 === 1 ? 'checked' : '' ?>>
                    <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-6" value="CNG/taxi" <?= $q41_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-7" value="Personal Car" <?= $q41_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-8" value="Rented or ride sharing Car" <?= $q41_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-9" value="Personal 2 wheeler" <?= $q41_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-10" value="Ride sharing 2 wheeler" <?= $q41_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-11" value="Bicycle" <?= $q41_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-12" value="Walk" <?= $q41_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-13" value="Train" <?= $q41_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-14" value="Other" <?= $q41_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    <!-- Q41-1 -->
        <div class="Q">
            <p><span class="q_no">Q41.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason?</p>
            <div class="radio-input">
                <input type="hidden" name="limit41-1" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q41-1-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q41-1-1" value="Bus" <?= $q41_1_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-1-2" value="Private Bus (Office bus/ school bus etc)" <?= $q41_1_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q41_1_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q41-1-4" value="Paddle Rickshaw" <?= $q41_1_4 === 1 ? 'checked' : '' ?>>
                            <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q41-1-5" value="Auto Rickshaw"<?= $q41_1_5 === 1 ? 'checked' : '' ?> >
                            <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-1-6" value="CNG/taxi" <?= $q41_1_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-1-7" value="Personal Car" <?= $q41_1_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-1-8" value="Rented or ride sharing Car" <?= $q41_1_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-1-9" value="Personal 2 wheeler" <?= $q41_1_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-1-10" value="Ride sharing 2 wheeler" <?= $q41_1_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-1-11" value="Bicycle" <?= $q41_1_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-1-12" value="Walk" <?= $q41_1_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-1-13" value="Train" <?= $q41_1_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q41-1-14" value="Other" <?= $q41_1_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    


            <!-- Q42 -->
            <div class="Q">
                <p><span class="q_no">Q42: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q42" value="<?= htmlspecialchars($member['Q42'] ?? '') ?>">
            </div>

            <!-- Q43 -->
            <div class="Q">
                <p><span class="q_no">Q43: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q43" value="Alone" <?= $member['Q43'] === 'Alone' ? 'checked' : '' ?>>
                             <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q43" value="1 person" <?= $member['Q43'] === '1 person' ? 'checked' : '' ?>>
                            <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q43" value="2 persons" <?= $member['Q43'] === '2 persons' ? 'checked' : '' ?>>
                            <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q43" value="3 persons" <?= $member['Q43'] === '3 persons' ? 'checked' : '' ?>>
                           <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q43" value="3+ persons" <?= $member['Q43'] === '3+ persons' ? 'checked' : '' ?>>
                            <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q43" value="" <?= empty($member['Q43']) ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 

            </div>
            <!-- Q43_1 -->
            <div class="Q">
                <p><span class="q_no">Q43_1: </span> <h2>Approximate out-of-vehicle waiting time</h2> <Br>(Waiting means the approximate amount of time the trip maker had to wait to get on a certain vehicle. For example, if you are traveling to work bus, and before getting on the bus you have to wait 5 mins for the bus to arrive at the station. Then the waiting time is 5 min. )
                </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q43_1" value="0-5 mins" <?= $member['Q43_1'] === '0-5 mins' ? 'checked' : '' ?>>
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q43_1" value="5-10 mins" <?= $member['Q43_1'] === '5-10 mins' ? 'checked' : '' ?>>
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q43_1" value="10-15 mins" <?= $member['Q43_1'] === '10-15 mins' ? 'checked' : '' ?>>
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q43_1" value="15-20 mins" <?= $member['Q43_1'] === '15-20 mins' ? 'checked' : '' ?>>
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q43_1" value="20-30 mins" <?= $member['Q43_1'] === '20-30 mins' ? 'checked' : '' ?>>
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q43_1" value="30-45 mins" <?= $member['Q43_1'] === '30-45 mins' ? 'checked' : '' ?>>
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q43_1" value="45+ mins" <?= $member['Q43_1'] === '45+ mins' ? 'checked' : '' ?>>
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q43_1" value="" <?= $member['Q43_1'] === '' ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>        
            <!-- Q44 -->
            <div class="Q">
                <p><span class="q_no">Q44: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q44" value="<?= htmlspecialchars($member['Q44'] ?? '') ?>">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentab('section3','section2')" href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentab('section3','section4')" href="#head_start">Next</a>
            </div>
            </div>
            <div class="section" id="section4">
            <h1>Trip 3</h1>
            <!-- Q45 -->
            <div class="Q">
                <p><span class="q_no">Q45: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q45" value="<?= htmlspecialchars($member['Q45'] ?? '') ?>"> 
            </div>

            <!-- Q46 -->
            <div class="Q">
                <p><span class="q_no">Q46: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q46_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q46_lat" name="q46_a" value="<?= htmlspecialchars($q46_a ?? '') ?>">
                    <label for="q46_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q46_lng" name="q46_b" value="<?= htmlspecialchars($q46_b ?? '') ?>">
                    <button type="button" onclick="openMap('q46')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q47 -->
            <div class="Q">
                <p><span class="q_no">Q47: </span> Trip Purpose </p>
                < <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q47" value="Work" <?= $member['Q47'] === 'Work' ? 'checked' : '' ?>>
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q47" value="Education" <?= $member['Q47'] === 'Education' ? 'checked' : '' ?>>
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q47" value="Shopping" <?= $member['Q47'] === 'Shopping' ? 'checked' : '' ?>>
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q47" value="Social/Recreational/Personal" <?= $member['Q47'] === 'Social/Recreational/Personal' ? 'checked' : '' ?>>
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q47" value="Return to Home" <?= $member['Q47'] === 'Return to Home' ? 'checked' : '' ?>>
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q47" value="Pickup or Drop off" <?= $member['Q47'] === 'Pickup or Drop off' ? 'checked' : '' ?>>
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q47" value="Medical" <?= $member['Q47'] === 'Medical' ? 'checked' : '' ?>>
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q47" value="Others" <?= $member['Q47'] === 'Others' ? 'checked' : '' ?>>
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q47" value="" <?= empty($member['Q47']) ? 'checked' : '' ?>>
                        <p class="text">null</p>
                    </label>
                </div>
            </div>

            <!-- Q48 -->
            <div class="Q">
            <p><span class="q_no">Q48: </span> Modes used for stages</p>
            <div class="radio-input">
                <input type="hidden" name="limit48" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q48-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q48-1" value="Bus" <?= $q48_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-2" value="Private Bus (Office bus/ school bus etc)" <?= $q48_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q48_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-4" value="Paddle Rickshaw" <?= $q48_4 === 1 ? 'checked' : '' ?>>
                    <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-5" value="Auto Rickshaw" <?= $q48_5 === 1 ? 'checked' : '' ?>>
                    <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-6" value="CNG/taxi" <?= $q48_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-7" value="Personal Car" <?= $q48_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-8" value="Rented or ride sharing Car" <?= $q48_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-9" value="Personal 2 wheeler" <?= $q48_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-10" value="Ride sharing 2 wheeler" <?= $q48_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-11" value="Bicycle" <?= $q48_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-12" value="Walk" <?= $q48_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-13" value="Train" <?= $q48_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-14" value="Other" <?= $q48_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    <!-- Q48-1 -->
        <div class="Q">
            <p><span class="q_no">Q48.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason?</p>
            <div class="radio-input">
                <input type="hidden" name="limit48-1" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q48-1-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q48-1-1" value="Bus" <?= $q48_1_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-1-2" value="Private Bus (Office bus/ school bus etc)" <?= $q48_1_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q48_1_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q48-1-4" value="Paddle Rickshaw" <?= $q48_1_4 === 1 ? 'checked' : '' ?>>
                            <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q48-1-5" value="Auto Rickshaw"<?= $q48_1_5 === 1 ? 'checked' : '' ?> >
                            <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-1-6" value="CNG/taxi" <?= $q48_1_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-1-7" value="Personal Car" <?= $q48_1_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-1-8" value="Rented or ride sharing Car" <?= $q48_1_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-1-9" value="Personal 2 wheeler" <?= $q48_1_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-1-10" value="Ride sharing 2 wheeler" <?= $q48_1_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-1-11" value="Bicycle" <?= $q48_1_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-1-12" value="Walk" <?= $q48_1_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-1-13" value="Train" <?= $q48_1_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q48-1-14" value="Other" <?= $q48_1_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    

            <!-- Q49 -->
            <div class="Q">
                <p><span class="q_no">Q49: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q49" value="<?= htmlspecialchars($member['Q49'] ?? '') ?>">
            </div>

            <!-- Q50 -->
            <div class="Q">
                <p><span class="q_no">Q50: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q50" value="Alone" <?= $member['Q50'] === 'Alone' ? 'checked' : '' ?>>
                             <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q50" value="1 person" <?= $member['Q50'] === '1 person' ? 'checked' : '' ?>>
                            <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q50" value="2 persons" <?= $member['Q50'] === '2 persons' ? 'checked' : '' ?>>
                            <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q50" value="3 persons" <?= $member['Q50'] === '3 persons' ? 'checked' : '' ?>>
                           <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q50" value="3+ persons" <?= $member['Q50'] === '3+ persons' ? 'checked' : '' ?>>
                            <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q50" value="" <?= empty($member['Q50']) ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 

            </div>
            <!-- Q50_1 -->
            <div class="Q">
                <p><span class="q_no">Q50_1: </span> <h2>Approximate out-of-vehicle waiting time</h2> <Br>(Waiting means the approximate amount of time the trip maker had to wait to get on a certain vehicle. For example, if you are traveling to work bus, and before getting on the bus you have to wait 5 mins for the bus to arrive at the station. Then the waiting time is 5 min. )
                </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q50_1" value="0-5 mins" <?= $member['Q50_1'] === '0-5 mins' ? 'checked' : '' ?>>
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q50_1" value="5-10 mins" <?= $member['Q50_1'] === '5-10 mins' ? 'checked' : '' ?>>
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q50_1" value="10-15 mins" <?= $member['Q50_1'] === '10-15 mins' ? 'checked' : '' ?>>
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q50_1" value="15-20 mins" <?= $member['Q50_1'] === '15-20 mins' ? 'checked' : '' ?>>
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q50_1" value="20-30 mins" <?= $member['Q50_1'] === '20-30 mins' ? 'checked' : '' ?>>
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q50_1" value="30-45 mins" <?= $member['Q50_1'] === '30-45 mins' ? 'checked' : '' ?>>
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q50_1" value="45+ mins" <?= $member['Q50_1'] === '45+ mins' ? 'checked' : '' ?>>
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q50_1" value="" <?= $member['Q50_1'] === '' ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q51 -->
            <div class="Q">
                <p><span class="q_no">Q51: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q51" value="<?= htmlspecialchars($member['Q51'] ?? '') ?>">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentab('section4','section3')" href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentab('section4','section5')" href="#head_start">Next</a>
            </div>
            </div>
            <div class="section" id="section5">
            <h1>Trip 4</h1>
            <!-- Q52 -->
            <div class="Q">
                <p><span class="q_no">Q52: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q52" value="<?= htmlspecialchars($member['Q52'] ?? '') ?>">
            </div>

            <!-- Q53 -->
            <div class="Q">
                <p><span class="q_no">Q53: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q53_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q53_lat" name="q53_a" value="<?= htmlspecialchars($q53_a ?? '') ?>">
                    <label for="q53_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q53_lng" name="q53_b" value="<?= htmlspecialchars($q53_b ?? '') ?>">
                    <button type="button" onclick="openMap('q53')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q54 -->
            <div class="Q">
                <p><span class="q_no">Q54: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q54" value="Work" <?= $member['Q54'] === 'Work' ? 'checked' : '' ?>>
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q54" value="Education" <?= $member['Q54'] === 'Education' ? 'checked' : '' ?>>
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q54" value="Shopping" <?= $member['Q54'] === 'Shopping' ? 'checked' : '' ?>>
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q54" value="Social/Recreational/Personal" <?= $member['Q54'] === 'Social/Recreational/Personal' ? 'checked' : '' ?>>
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q54" value="Return to Home" <?= $member['Q54'] === 'Return to Home' ? 'checked' : '' ?>>
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q54" value="Pickup or Drop off" <?= $member['Q54'] === 'Pickup or Drop off' ? 'checked' : '' ?>>
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q54" value="Medical" <?= $member['Q54'] === 'Medical' ? 'checked' : '' ?>>
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q54" value="Others" <?= $member['Q54'] === 'Others' ? 'checked' : '' ?>>
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q54" value="" <?= empty($member['Q54']) ? 'checked' : '' ?>>
                        <p class="text">null</p>
                    </label>
                </div>
            </div>

            <!-- Q55 -->
            <div class="Q">
            <p><span class="q_no">Q55: </span> Modes used for stages</p>
            <div class="radio-input">
                <input type="hidden" name="limit55" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q55-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q55-1" value="Bus" <?= $q55_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-2" value="Private Bus (Office bus/ school bus etc)" <?= $q55_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q55_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-4" value="Paddle Rickshaw" <?= $q55_4 === 1 ? 'checked' : '' ?>>
                    <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-5" value="Auto Rickshaw" <?= $q55_5 === 1 ? 'checked' : '' ?>>
                    <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-6" value="CNG/taxi" <?= $q55_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-7" value="Personal Car" <?= $q55_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-8" value="Rented or ride sharing Car" <?= $q55_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-9" value="Personal 2 wheeler" <?= $q55_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-10" value="Ride sharing 2 wheeler" <?= $q55_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-11" value="Bicycle" <?= $q55_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-12" value="Walk" <?= $q55_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-13" value="Train" <?= $q55_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-14" value="Other" <?= $q55_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    <!-- Q55-1 -->
        <div class="Q">
            <p><span class="q_no">Q55.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason?</p>
            <div class="radio-input">
                <input type="hidden" name="limit55-1" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q55-1-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q55-1-1" value="Bus" <?= $q55_1_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-1-2" value="Private Bus (Office bus/ school bus etc)" <?= $q55_1_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q55_1_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q55-1-4" value="Paddle Rickshaw" <?= $q55_1_4 === 1 ? 'checked' : '' ?>>
                            <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q55-1-5" value="Auto Rickshaw"<?= $q55_1_5 === 1 ? 'checked' : '' ?> >
                            <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-1-6" value="CNG/taxi" <?= $q55_1_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-1-7" value="Personal Car" <?= $q55_1_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-1-8" value="Rented or ride sharing Car" <?= $q55_1_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-1-9" value="Personal 2 wheeler" <?= $q55_1_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-1-10" value="Ride sharing 2 wheeler" <?= $q55_1_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-1-11" value="Bicycle" <?= $q55_1_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-1-12" value="Walk" <?= $q55_1_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-1-13" value="Train" <?= $q55_1_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q55-1-14" value="Other" <?= $q55_1_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    


            <!-- Q56 -->
            <div class="Q">
                <p><span class="q_no">Q56: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q56" value="<?= htmlspecialchars($member['Q56'] ?? '') ?>">
            </div>
            
          
            
            <!-- Q57 -->
            <div class="Q">
                <p><span class="q_no">Q57: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q57" value="Alone" <?= $member['Q57'] === 'Alone' ? 'checked' : '' ?>>
                             <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q57" value="1 person" <?= $member['Q57'] === '1 person' ? 'checked' : '' ?>>
                            <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q57" value="2 persons" <?= $member['Q57'] === '2 persons' ? 'checked' : '' ?>>
                            <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q57" value="3 persons" <?= $member['Q57'] === '3 persons' ? 'checked' : '' ?>>
                           <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q57" value="3+ persons" <?= $member['Q57'] === '3+ persons' ? 'checked' : '' ?>>
                            <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q57" value="" <?= empty($member['Q57']) ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 

            </div>
            <!-- Q57_1 -->
            <div class="Q">
                <p><span class="q_no">Q57_1: </span> <h2>Approximate out-of-vehicle waiting time</h2> <Br>(Waiting means the approximate amount of time the trip maker had to wait to get on a certain vehicle. For example, if you are traveling to work bus, and before getting on the bus you have to wait 5 mins for the bus to arrive at the station. Then the waiting time is 5 min. )
                </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q57_1" value="0-5 mins" <?= $member['Q57_1'] === '0-5 mins' ? 'checked' : '' ?>>
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q57_1" value="5-10 mins" <?= $member['Q57_1'] === '5-10 mins' ? 'checked' : '' ?>>
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q57_1" value="10-15 mins" <?= $member['Q57_1'] === '10-15 mins' ? 'checked' : '' ?>>
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q57_1" value="15-20 mins" <?= $member['Q57_1'] === '15-20 mins' ? 'checked' : '' ?>>
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q57_1" value="20-30 mins" <?= $member['Q57_1'] === '20-30 mins' ? 'checked' : '' ?>>
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q57_1" value="30-45 mins" <?= $member['Q57_1'] === '30-45 mins' ? 'checked' : '' ?>>
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q57_1" value="45+ mins" <?= $member['Q57_1'] === '45+ mins' ? 'checked' : '' ?>>
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q57_1" value="" <?= $member['Q57_1'] === '' ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q58 -->
            <div class="Q">
                <p><span class="q_no">Q58: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q58" value="<?= htmlspecialchars($member['Q58'] ?? '') ?>">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentab('section5','section4')" href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentab('section5','section6')" href="#head_start">Next</a>
            </div>
        </div>
        
        <div class="section" id="section6">
            <h1>Trip 5</h1>
            <!-- Q59 -->
            <div class="Q">
                <p><span class="q_no">Q59: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q59" value="<?= htmlspecialchars($member['Q59'] ?? '') ?>">
            </div>

            <!-- Q60 -->
            <div class="Q">
                <p><span class="q_no">Q60: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q60_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q60_lat" name="q60_a" value="<?= htmlspecialchars($q60_a ?? '') ?>">
                    <label for="q60_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q60_lng" name="q60_b" value="<?= htmlspecialchars($q60_b ?? '') ?>">
                    <button type="button" onclick="openMap('q60')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q61 -->
            <div class="Q">
                <p><span class="q_no">Q61: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q61" value="Work" <?= $member['Q61'] === 'Work' ? 'checked' : '' ?>>
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q61" value="Education" <?= $member['Q61'] === 'Education' ? 'checked' : '' ?>>
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q61" value="Shopping" <?= $member['Q61'] === 'Shopping' ? 'checked' : '' ?>>
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q61" value="Social/Recreational/Personal" <?= $member['Q61'] === 'Social/Recreational/Personal' ? 'checked' : '' ?>>
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q61" value="Return to Home" <?= $member['Q61'] === 'Return to Home' ? 'checked' : '' ?>>
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q61" value="Pickup or Drop off" <?= $member['Q61'] === 'Pickup or Drop off' ? 'checked' : '' ?>>
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q61" value="Medical" <?= $member['Q61'] === 'Medical' ? 'checked' : '' ?>>
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q61" value="Others" <?= $member['Q61'] === 'Others' ? 'checked' : '' ?>>
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q61" value="" <?= empty($member['Q61']) ? 'checked' : '' ?>>
                        <p class="text">null</p>
                    </label>
                </div>

                
            </div>

            <!-- Q62 -->
            <div class="Q">
            <p><span class="q_no">Q62: </span> Modes used for stages</p>
            <div class="radio-input">
                <input type="hidden" name="limit62" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q62-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q62-1" value="Bus" <?= $q62_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-2" value="Private Bus (Office bus/ school bus etc)" <?= $q62_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q62_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-4" value="Paddle Rickshaw" <?= $q62_4 === 1 ? 'checked' : '' ?>>
                    <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-5" value="Auto Rickshaw" <?= $q62_5 === 1 ? 'checked' : '' ?>>
                    <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-6" value="CNG/taxi" <?= $q62_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-7" value="Personal Car" <?= $q62_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-8" value="Rented or ride sharing Car" <?= $q62_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-9" value="Personal 2 wheeler" <?= $q62_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-10" value="Ride sharing 2 wheeler" <?= $q62_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-11" value="Bicycle" <?= $q62_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-12" value="Walk" <?= $q62_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-13" value="Train" <?= $q62_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-14" value="Other" <?= $q62_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    <!-- Q62-1 -->
        <div class="Q">
            <p><span class="q_no">Q62.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason?</p>
            <div class="radio-input">
                <input type="hidden" name="limit62-1" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q62-1-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q62-1-1" value="Bus" <?= $q62_1_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-1-2" value="Private Bus (Office bus/ school bus etc)" <?= $q62_1_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q62_1_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q62-1-4" value="Paddle Rickshaw" <?= $q62_1_4 === 1 ? 'checked' : '' ?>>
                            <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q62-1-5" value="Auto Rickshaw"<?= $q62_1_5 === 1 ? 'checked' : '' ?> >
                            <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-1-6" value="CNG/taxi" <?= $q62_1_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-1-7" value="Personal Car" <?= $q62_1_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-1-8" value="Rented or ride sharing Car" <?= $q62_1_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-1-9" value="Personal 2 wheeler" <?= $q62_1_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-1-10" value="Ride sharing 2 wheeler" <?= $q62_1_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-1-11" value="Bicycle" <?= $q62_1_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-1-12" value="Walk" <?= $q62_1_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-1-13" value="Train" <?= $q62_1_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q62-1-14" value="Other" <?= $q62_1_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    


            <!-- Q63 -->
            <div class="Q">
                <p><span class="q_no">Q63: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q63" value="<?= htmlspecialchars($member['Q63'] ?? '') ?>">
            </div>

            <!-- Q64 -->
            <div class="Q">
                <p><span class="q_no">Q64: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q64" value="Alone" <?= $member['Q64'] === 'Alone' ? 'checked' : '' ?>>
                             <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q64" value="1 person" <?= $member['Q64'] === '1 person' ? 'checked' : '' ?>>
                            <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q64" value="2 persons" <?= $member['Q64'] === '2 persons' ? 'checked' : '' ?>>
                            <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q64" value="3 persons" <?= $member['Q64'] === '3 persons' ? 'checked' : '' ?>>
                           <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q64" value="3+ persons" <?= $member['Q64'] === '3+ persons' ? 'checked' : '' ?>>
                            <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q64" value="" <?= empty($member['Q64']) ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 

            </div>
            <!-- Q64_1 -->
            <div class="Q">
                <p><span class="q_no">Q64_1: </span> <h2>Approximate out-of-vehicle waiting time</h2> <Br>(Waiting means the approximate amount of time the trip maker had to wait to get on a certain vehicle. For example, if you are traveling to work bus, and before getting on the bus you have to wait 5 mins for the bus to arrive at the station. Then the waiting time is 5 min. )
                </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q64_1" value="0-5 mins" <?= $member['Q64_1'] === '0-5 mins' ? 'checked' : '' ?>>
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q64_1" value="5-10 mins" <?= $member['Q64_1'] === '5-10 mins' ? 'checked' : '' ?>>
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q64_1" value="10-15 mins" <?= $member['Q64_1'] === '10-15 mins' ? 'checked' : '' ?>>
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q64_1" value="15-20 mins" <?= $member['Q64_1'] === '15-20 mins' ? 'checked' : '' ?>>
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q64_1" value="20-30 mins" <?= $member['Q64_1'] === '20-30 mins' ? 'checked' : '' ?>>
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q64_1" value="30-45 mins" <?= $member['Q64_1'] === '30-45 mins' ? 'checked' : '' ?>>
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q64_1" value="45+ mins" <?= $member['Q64_1'] === '45+ mins' ? 'checked' : '' ?>>
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q64_1" value="" <?= $member['Q64_1'] === '' ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q65 -->
            <div class="Q">
                <p><span class="q_no">Q65: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q65" value="<?= htmlspecialchars($member['Q65'] ?? '') ?>">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentab('section6','section5')" href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentab('section6','section7')" href="#head_start">Next</a>
            </div>
        </div>
            <div class="section" id="section7">
            <h1>Trip 6</h1>
            <!-- Q66 -->
            <div class="Q">
                <p><span class="q_no">Q66: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q66" value="<?= htmlspecialchars($member['Q66'] ?? '') ?>">
            </div>

            <!-- Q67 -->
            <div class="Q">
                <p><span class="q_no">Q67: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q67_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q67_lat" name="q67_a" value="<?= htmlspecialchars($q67_a ?? '') ?>">
                    <label for="q67_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q67_lng" name="q67_b" value="<?= htmlspecialchars($q67_b ?? '') ?>">
                    <button type="button" onclick="openMap('q67')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q68 -->
            <div class="Q">
                <p><span class="q_no">Q68: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q68" value="Work" <?= $member['Q68'] === 'Work' ? 'checked' : '' ?>>
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q68" value="Education" <?= $member['Q68'] === 'Education' ? 'checked' : '' ?>>
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q68" value="Shopping" <?= $member['Q68'] === 'Shopping' ? 'checked' : '' ?>>
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q68" value="Social/Recreational/Personal" <?= $member['Q68'] === 'Social/Recreational/Personal' ? 'checked' : '' ?>>
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q68" value="Return to Home" <?= $member['Q68'] === 'Return to Home' ? 'checked' : '' ?>>
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q68" value="Pickup or Drop off" <?= $member['Q68'] === 'Pickup or Drop off' ? 'checked' : '' ?>>
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q68" value="Medical" <?= $member['Q68'] === 'Medical' ? 'checked' : '' ?>>
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q68" value="Others" <?= $member['Q68'] === 'Others' ? 'checked' : '' ?>>
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q68" value="" <?= empty($member['Q68']) ? 'checked' : '' ?>>
                        <p class="text">null</p>
                    </label>
                </div>

            </div>

            <!-- Q69 -->
            <div class="Q">
            <p><span class="q_no">Q69: </span> Modes used for stages</p>
            <div class="radio-input">
                <input type="hidden" name="limit69" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q69-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q69-1" value="Bus" <?= $q69_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-2" value="Private Bus (Office bus/ school bus etc)" <?= $q69_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q69_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-4" value="Paddle Rickshaw" <?= $q69_4 === 1 ? 'checked' : '' ?>>
                    <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-5" value="Auto Rickshaw" <?= $q69_5 === 1 ? 'checked' : '' ?>>
                    <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-6" value="CNG/taxi" <?= $q69_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-7" value="Personal Car" <?= $q69_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-8" value="Rented or ride sharing Car" <?= $q69_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-9" value="Personal 2 wheeler" <?= $q69_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-10" value="Ride sharing 2 wheeler" <?= $q69_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-11" value="Bicycle" <?= $q69_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-12" value="Walk" <?= $q69_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-13" value="Train" <?= $q69_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-14" value="Other" <?= $q69_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    <!-- Q69-1 -->
        <div class="Q">
            <p><span class="q_no">Q69.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason?</p>
            <div class="radio-input">
                <input type="hidden" name="limit69-1" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q69-1-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q69-1-1" value="Bus" <?= $q69_1_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-1-2" value="Private Bus (Office bus/ school bus etc)" <?= $q69_1_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q69_1_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q69-1-4" value="Paddle Rickshaw" <?= $q69_1_4 === 1 ? 'checked' : '' ?>>
                            <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q69-1-5" value="Auto Rickshaw"<?= $q69_1_5 === 1 ? 'checked' : '' ?> >
                            <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-1-6" value="CNG/taxi" <?= $q69_1_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-1-7" value="Personal Car" <?= $q69_1_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-1-8" value="Rented or ride sharing Car" <?= $q69_1_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-1-9" value="Personal 2 wheeler" <?= $q69_1_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-1-10" value="Ride sharing 2 wheeler" <?= $q69_1_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-1-11" value="Bicycle" <?= $q69_1_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-1-12" value="Walk" <?= $q69_1_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-1-13" value="Train" <?= $q69_1_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q69-1-14" value="Other" <?= $q69_1_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    


            <!-- Q70 -->
            <div class="Q">
                <p><span class="q_no">Q70: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q70" value="<?= htmlspecialchars($member['Q70'] ?? '') ?>">
            </div>

            <!-- Q71 -->
            <div class="Q">
                <p><span class="q_no">Q71: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q71" value="Alone" <?= $member['Q71'] === 'Alone' ? 'checked' : '' ?>>
                             <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q71" value="1 person" <?= $member['Q71'] === '1 person' ? 'checked' : '' ?>>
                            <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q71" value="2 persons" <?= $member['Q71'] === '2 persons' ? 'checked' : '' ?>>
                            <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q71" value="3 persons" <?= $member['Q71'] === '3 persons' ? 'checked' : '' ?>>
                           <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q71" value="3+ persons" <?= $member['Q71'] === '3+ persons' ? 'checked' : '' ?>>
                            <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q71" value="" <?= empty($member['Q71']) ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 

            </div>
            <!-- Q71_1 -->
            <div class="Q">
                <p><span class="q_no">Q71_1: </span> <h2>Approximate out-of-vehicle waiting time</h2> <Br>(Waiting means the approximate amount of time the trip maker had to wait to get on a certain vehicle. For example, if you are traveling to work bus, and before getting on the bus you have to wait 5 mins for the bus to arrive at the station. Then the waiting time is 5 min. )
                </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q71_1" value="0-5 mins" <?= $member['Q71_1'] === '0-5 mins' ? 'checked' : '' ?>>
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q71_1" value="5-10 mins" <?= $member['Q71_1'] === '5-10 mins' ? 'checked' : '' ?>>
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q71_1" value="10-15 mins" <?= $member['Q71_1'] === '10-15 mins' ? 'checked' : '' ?>>
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q71_1" value="15-20 mins" <?= $member['Q71_1'] === '15-20 mins' ? 'checked' : '' ?>>
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q71_1" value="20-30 mins" <?= $member['Q71_1'] === '20-30 mins' ? 'checked' : '' ?>>
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q71_1" value="30-45 mins" <?= $member['Q71_1'] === '30-45 mins' ? 'checked' : '' ?>>
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q71_1" value="45+ mins" <?= $member['Q71_1'] === '45+ mins' ? 'checked' : '' ?>>
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q71_1" value="" <?= $member['Q71_1'] === '' ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q72 -->
            <div class="Q">
                <p><span class="q_no">Q72: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q72" value="<?= htmlspecialchars($member['Q72'] ?? '') ?>">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentab('section7','section6')" href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentab('section7','section8')" href="#head_start">Next</a>
            </div>
            </div>
            <div class="section" id="section8">
            <h1>Trip 7</h1>
            <!-- Q73 -->
            <div class="Q">
                <p><span class="q_no">Q73: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q73" value="<?= htmlspecialchars($member['Q73'] ?? '') ?>">
            </div>

            <!-- Q74 -->
            <div class="Q">
                <p><span class="q_no">Q74: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q74_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q74_lat" name="q74_a" value="<?= htmlspecialchars($q74_a ?? '') ?>">
                    <label for="q74_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q74_lng" name="q74_b" value="<?= htmlspecialchars($q74_b ?? '') ?>">
                    <button type="button" onclick="openMap('q74')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q75 -->
            <div class="Q">
                <p><span class="q_no">Q75: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q75" value="Work" <?= $member['Q75'] === 'Work' ? 'checked' : '' ?>>
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q75" value="Education" <?= $member['Q75'] === 'Education' ? 'checked' : '' ?>>
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q75" value="Shopping" <?= $member['Q75'] === 'Shopping' ? 'checked' : '' ?>>
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q75" value="Social/Recreational/Personal" <?= $member['Q75'] === 'Social/Recreational/Personal' ? 'checked' : '' ?>>
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q75" value="Return to Home" <?= $member['Q75'] === 'Return to Home' ? 'checked' : '' ?>>
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q75" value="Pickup or Drop off" <?= $member['Q75'] === 'Pickup or Drop off' ? 'checked' : '' ?>>
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q75" value="Medical" <?= $member['Q75'] === 'Medical' ? 'checked' : '' ?>>
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q75" value="Others" <?= $member['Q75'] === 'Others' ? 'checked' : '' ?>>
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q75" value="" <?= empty($member['Q75']) ? 'checked' : '' ?>>
                        <p class="text">null</p>
                    </label>
                </div>

            </div>

            <!-- Q76 -->
            <div class="Q">
            <p><span class="q_no">Q76: </span> Modes used for stages</p>
            <div class="radio-input">
                <input type="hidden" name="limit76" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q76-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q76-1" value="Bus" <?= $q76_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-2" value="Private Bus (Office bus/ school bus etc)" <?= $q76_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q76_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-4" value="Paddle Rickshaw" <?= $q76_4 === 1 ? 'checked' : '' ?>>
                    <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-5" value="Auto Rickshaw" <?= $q76_5 === 1 ? 'checked' : '' ?>>
                    <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-6" value="CNG/taxi" <?= $q76_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-7" value="Personal Car" <?= $q76_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-8" value="Rented or ride sharing Car" <?= $q76_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-9" value="Personal 2 wheeler" <?= $q76_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-10" value="Ride sharing 2 wheeler" <?= $q76_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-11" value="Bicycle" <?= $q76_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-12" value="Walk" <?= $q76_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-13" value="Train" <?= $q76_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-14" value="Other" <?= $q76_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    <!-- Q76-1 -->
        <div class="Q">
            <p><span class="q_no">Q76.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason?</p>
            <div class="radio-input">
                <input type="hidden" name="limit76-1" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q76-1-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q76-1-1" value="Bus" <?= $q76_1_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-1-2" value="Private Bus (Office bus/ school bus etc)" <?= $q76_1_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q76_1_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q76-1-4" value="Paddle Rickshaw" <?= $q76_1_4 === 1 ? 'checked' : '' ?>>
                            <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q76-1-5" value="Auto Rickshaw"<?= $q76_1_5 === 1 ? 'checked' : '' ?> >
                            <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-1-6" value="CNG/taxi" <?= $q76_1_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-1-7" value="Personal Car" <?= $q76_1_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-1-8" value="Rented or ride sharing Car" <?= $q76_1_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-1-9" value="Personal 2 wheeler" <?= $q76_1_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-1-10" value="Ride sharing 2 wheeler" <?= $q76_1_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-1-11" value="Bicycle" <?= $q76_1_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-1-12" value="Walk" <?= $q76_1_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-1-13" value="Train" <?= $q76_1_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q76-1-14" value="Other" <?= $q76_1_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    


            <!-- Q77 -->
            <div class="Q">
                <p><span class="q_no">Q77: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q77" value="<?= htmlspecialchars($member['Q77'] ?? '') ?>">
            </div>

            <!-- Q78 -->
            <div class="Q">
                <p><span class="q_no">Q78: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q78" value="Alone" <?= $member['Q78'] === 'Alone' ? 'checked' : '' ?>>
                             <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q78" value="1 person" <?= $member['Q78'] === '1 person' ? 'checked' : '' ?>>
                            <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q78" value="2 persons" <?= $member['Q78'] === '2 persons' ? 'checked' : '' ?>>
                            <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q78" value="3 persons" <?= $member['Q78'] === '3 persons' ? 'checked' : '' ?>>
                           <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q78" value="3+ persons" <?= $member['Q78'] === '3+ persons' ? 'checked' : '' ?>>
                            <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q78" value="" <?= empty($member['Q78']) ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 

            </div>
            <!-- Q78_1 -->
            <div class="Q">
                <p><span class="q_no">Q78_1: </span> <h2>Approximate out-of-vehicle waiting time</h2> <Br>(Waiting means the approximate amount of time the trip maker had to wait to get on a certain vehicle. For example, if you are traveling to work bus, and before getting on the bus you have to wait 5 mins for the bus to arrive at the station. Then the waiting time is 5 min. )
                </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q78_1" value="0-5 mins" <?= $member['Q78_1'] === '0-5 mins' ? 'checked' : '' ?>>
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q78_1" value="5-10 mins" <?= $member['Q78_1'] === '5-10 mins' ? 'checked' : '' ?>>
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q78_1" value="10-15 mins" <?= $member['Q78_1'] === '10-15 mins' ? 'checked' : '' ?>>
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q78_1" value="15-20 mins" <?= $member['Q78_1'] === '15-20 mins' ? 'checked' : '' ?>>
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q78_1" value="20-30 mins" <?= $member['Q78_1'] === '20-30 mins' ? 'checked' : '' ?>>
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q78_1" value="30-45 mins" <?= $member['Q78_1'] === '30-45 mins' ? 'checked' : '' ?>>
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q78_1" value="45+ mins" <?= $member['Q78_1'] === '45+ mins' ? 'checked' : '' ?>>
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q78_1" value="" <?= $member['Q78_1'] === '' ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q79 -->
            <div class="Q">
                <p><span class="q_no">Q79: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q79" value="<?= htmlspecialchars($member['Q79'] ?? '') ?>">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentab('section8','section7')" href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentab('section8','section9')" href="#head_start">Next</a>
            </div>
            </div>
            <div class="section" id="section9">
            <h1>Trip 8</h1>
            <!-- Q80 -->
            <div class="Q">
                <p><span class="q_no">Q80: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q80" value="<?= htmlspecialchars($member['Q80'] ?? '') ?>">
            </div>

            <!-- Q81 -->
            <div class="Q">
                <p><span class="q_no">Q81: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q81_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q81_lat" name="q81_a" value="<?= htmlspecialchars($q81_a ?? '') ?>">
                    <label for="q81_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q81_lng" name="q81_b" value="<?= htmlspecialchars($q81_b ?? '') ?>">
                    <button type="button" onclick="openMap('q81')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q82 -->
            <div class="Q">
                <p><span class="q_no">Q82: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q82" value="Work" <?= $member['Q82'] === 'Work' ? 'checked' : '' ?>>
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q82" value="Education" <?= $member['Q82'] === 'Education' ? 'checked' : '' ?>>
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q82" value="Shopping" <?= $member['Q82'] === 'Shopping' ? 'checked' : '' ?>>
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q82" value="Social/Recreational/Personal" <?= $member['Q82'] === 'Social/Recreational/Personal' ? 'checked' : '' ?>>
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q82" value="Return to Home" <?= $member['Q82'] === 'Return to Home' ? 'checked' : '' ?>>
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q82" value="Pickup or Drop off" <?= $member['Q82'] === 'Pickup or Drop off' ? 'checked' : '' ?>>
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q82" value="Medical" <?= $member['Q82'] === 'Medical' ? 'checked' : '' ?>>
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q82" value="Others" <?= $member['Q82'] === 'Others' ? 'checked' : '' ?>>
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q82" value="" <?= empty($member['Q82']) ? 'checked' : '' ?>>
                        <p class="text">null</p>
                    </label>
                </div>

            </div>

            <!-- Q83 -->
            <div class="Q">
            <p><span class="q_no">Q83: </span> Modes used for stages</p>
            <div class="radio-input">
                <input type="hidden" name="limit83" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q83-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q83-1" value="Bus" <?= $q83_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-2" value="Private Bus (Office bus/ school bus etc)" <?= $q83_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q83_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-4" value="Paddle Rickshaw" <?= $q83_4 === 1 ? 'checked' : '' ?>>
                    <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-5" value="Auto Rickshaw" <?= $q83_5 === 1 ? 'checked' : '' ?>>
                    <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-6" value="CNG/taxi" <?= $q83_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-7" value="Personal Car" <?= $q83_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-8" value="Rented or ride sharing Car" <?= $q83_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-9" value="Personal 2 wheeler" <?= $q83_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-10" value="Ride sharing 2 wheeler" <?= $q83_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-11" value="Bicycle" <?= $q83_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-12" value="Walk" <?= $q83_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-13" value="Train" <?= $q83_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-14" value="Other" <?= $q83_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    <!-- Q83-1 -->
        <div class="Q">
            <p><span class="q_no">Q83.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason?</p>
            <div class="radio-input">
                <input type="hidden" name="limit83-1" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q83-1-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q83-1-1" value="Bus" <?= $q83_1_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-1-2" value="Private Bus (Office bus/ school bus etc)" <?= $q83_1_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q83_1_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q83-1-4" value="Paddle Rickshaw" <?= $q83_1_4 === 1 ? 'checked' : '' ?>>
                            <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q83-1-5" value="Auto Rickshaw"<?= $q83_1_5 === 1 ? 'checked' : '' ?> >
                            <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-1-6" value="CNG/taxi" <?= $q83_1_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-1-7" value="Personal Car" <?= $q83_1_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-1-8" value="Rented or ride sharing Car" <?= $q83_1_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-1-9" value="Personal 2 wheeler" <?= $q83_1_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-1-10" value="Ride sharing 2 wheeler" <?= $q83_1_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-1-11" value="Bicycle" <?= $q83_1_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-1-12" value="Walk" <?= $q83_1_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-1-13" value="Train" <?= $q83_1_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q83-1-14" value="Other" <?= $q83_1_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    


            <!-- Q84 -->
            <div class="Q">
                <p><span class="q_no">Q84: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q84" value="<?= htmlspecialchars($member['Q84'] ?? '') ?>">
            </div>

            <!-- Q85 -->
            <div class="Q">
                <p><span class="q_no">Q85: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q85" value="Alone" <?= $member['Q85'] === 'Alone' ? 'checked' : '' ?>>
                             <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q85" value="1 person" <?= $member['Q85'] === '1 person' ? 'checked' : '' ?>>
                            <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q85" value="2 persons" <?= $member['Q85'] === '2 persons' ? 'checked' : '' ?>>
                            <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q85" value="3 persons" <?= $member['Q85'] === '3 persons' ? 'checked' : '' ?>>
                           <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q85" value="3+ persons" <?= $member['Q85'] === '3+ persons' ? 'checked' : '' ?>>
                            <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q85" value="" <?= empty($member['Q85']) ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 

            </div>
            <!-- Q85_1 -->
            <div class="Q">
                <p><span class="q_no">Q85_1: </span> <h2>Approximate out-of-vehicle waiting time</h2> <Br>(Waiting means the approximate amount of time the trip maker had to wait to get on a certain vehicle. For example, if you are traveling to work bus, and before getting on the bus you have to wait 5 mins for the bus to arrive at the station. Then the waiting time is 5 min. )
                </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q85_1" value="0-5 mins" <?= $member['Q85_1'] === '0-5 mins' ? 'checked' : '' ?>>
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q85_1" value="5-10 mins" <?= $member['Q85_1'] === '5-10 mins' ? 'checked' : '' ?>>
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q85_1" value="10-15 mins" <?= $member['Q85_1'] === '10-15 mins' ? 'checked' : '' ?>>
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q85_1" value="15-20 mins" <?= $member['Q85_1'] === '15-20 mins' ? 'checked' : '' ?>>
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q85_1" value="20-30 mins" <?= $member['Q85_1'] === '20-30 mins' ? 'checked' : '' ?>>
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q85_1" value="30-45 mins" <?= $member['Q85_1'] === '30-45 mins' ? 'checked' : '' ?>>
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q85_1" value="45+ mins" <?= $member['Q85_1'] === '45+ mins' ? 'checked' : '' ?>>
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q85_1" value=""  <?= $member['Q85_1'] === '' ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q86 -->
            <div class="Q">
                <p><span class="q_no">Q86: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q86" value="<?= htmlspecialchars($member['Q86'] ?? '') ?>">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentab('section9','section8')" href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentab('section9','section10')" href="#head_start">Next</a>
            </div>
            </div>
            <div class="section" id="section10">
            <h1>Trip 9</h1>
            <!-- Q87 -->
            <div class="Q">
                <p><span class="q_no">Q87: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q87" value="<?= htmlspecialchars($member['Q87'] ?? '') ?>">
            </div>

            <!-- Q88 -->
            <div class="Q">
                <p><span class="q_no">Q88: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q88_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q88_lat" name="q88_a" value="<?= htmlspecialchars($q88_a ?? '') ?>">
                    <label for="q88_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q88_lng" name="q88_b" value="<?= htmlspecialchars($q88_b ?? '') ?>">
                    <button type="button" onclick="openMap('q88')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q89 -->
            <div class="Q">
                <p><span class="q_no">Q89: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q89" value="Work" <?= $member['Q89'] === 'Work' ? 'checked' : '' ?>>
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q89" value="Education" <?= $member['Q89'] === 'Education' ? 'checked' : '' ?>>
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q89" value="Shopping" <?= $member['Q89'] === 'Shopping' ? 'checked' : '' ?>>
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q89" value="Social/Recreational/Personal" <?= $member['Q89'] === 'Social/Recreational/Personal' ? 'checked' : '' ?>>
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q89" value="Return to Home" <?= $member['Q89'] === 'Return to Home' ? 'checked' : '' ?>>
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q89" value="Pickup or Drop off" <?= $member['Q89'] === 'Pickup or Drop off' ? 'checked' : '' ?>>
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q89" value="Medical" <?= $member['Q89'] === 'Medical' ? 'checked' : '' ?>>
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q89" value="Others" <?= $member['Q89'] === 'Others' ? 'checked' : '' ?>>
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q89" value="" <?= empty($member['Q89']) ? 'checked' : '' ?>>
                        <p class="text">null</p>
                    </label>
                </div>

            </div>

            <!-- Q90 -->
            <div class="Q">
            <p><span class="q_no">Q90: </span> Modes used for stages</p>
            <div class="radio-input">
                <input type="hidden" name="limit90" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q90-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q90-1" value="Bus" <?= $q90_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-2" value="Private Bus (Office bus/ school bus etc)" <?= $q90_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q90_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-4" value="Paddle Rickshaw" <?= $q90_4 === 1 ? 'checked' : '' ?>>
                    <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-5" value="Auto Rickshaw" <?= $q90_5 === 1 ? 'checked' : '' ?>>
                    <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-6" value="CNG/taxi" <?= $q90_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-7" value="Personal Car" <?= $q90_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-8" value="Rented or ride sharing Car" <?= $q90_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-9" value="Personal 2 wheeler" <?= $q90_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-10" value="Ride sharing 2 wheeler" <?= $q90_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-11" value="Bicycle" <?= $q90_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-12" value="Walk" <?= $q90_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-13" value="Train" <?= $q90_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-14" value="Other" <?= $q90_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    <!-- Q90-1 -->
        <div class="Q">
            <p><span class="q_no">Q90.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason?</p>
            <div class="radio-input">
                <input type="hidden" name="limit90-1" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q90-1-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q90-1-1" value="Bus" <?= $q90_1_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-1-2" value="Private Bus (Office bus/ school bus etc)" <?= $q90_1_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q90_1_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q90-1-4" value="Paddle Rickshaw" <?= $q90_1_4 === 1 ? 'checked' : '' ?>>
                            <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q90-1-5" value="Auto Rickshaw"<?= $q90_1_5 === 1 ? 'checked' : '' ?> >
                            <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-1-6" value="CNG/taxi" <?= $q90_1_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-1-7" value="Personal Car" <?= $q90_1_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-1-8" value="Rented or ride sharing Car" <?= $q90_1_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-1-9" value="Personal 2 wheeler" <?= $q90_1_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-1-10" value="Ride sharing 2 wheeler" <?= $q90_1_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-1-11" value="Bicycle" <?= $q90_1_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-1-12" value="Walk" <?= $q90_1_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-1-13" value="Train" <?= $q90_1_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q90-1-14" value="Other" <?= $q90_1_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    


            <!-- Q91 -->
            <div class="Q">
                <p><span class="q_no">Q91: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q91" value="<?= htmlspecialchars($member['Q91'] ?? '') ?>">
            </div>

            <!-- Q92 -->
            <div class="Q">
                <p><span class="q_no">Q92: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q92" value="Alone" <?= $member['Q92'] === 'Alone' ? 'checked' : '' ?>>
                             <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q92" value="1 person" <?= $member['Q92'] === '1 person' ? 'checked' : '' ?>>
                            <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q92" value="2 persons" <?= $member['Q92'] === '2 persons' ? 'checked' : '' ?>>
                            <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q92" value="3 persons" <?= $member['Q92'] === '3 persons' ? 'checked' : '' ?>>
                           <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q92" value="3+ persons" <?= $member['Q92'] === '3+ persons' ? 'checked' : '' ?>>
                            <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q92" value="" <?= empty($member['Q92']) ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 

            </div>
            <!-- Q92_1 -->
            <div class="Q">
                <p><span class="q_no">Q92_1: </span> <h2>Approximate out-of-vehicle waiting time</h2> <Br>(Waiting means the approximate amount of time the trip maker had to wait to get on a certain vehicle. For example, if you are traveling to work bus, and before getting on the bus you have to wait 5 mins for the bus to arrive at the station. Then the waiting time is 5 min. )
                </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q92_1" value="0-5 mins" <?= $member['Q92_1'] === '0-5 mins' ? 'checked' : '' ?>>
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q92_1" value="5-10 mins" <?= $member['Q92_1'] === '5-10 mins' ? 'checked' : '' ?>>
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q92_1" value="10-15 mins" <?= $member['Q92_1'] === '10-15 mins' ? 'checked' : '' ?>>
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q92_1" value="15-20 mins" <?= $member['Q92_1'] === '15-20 mins' ? 'checked' : '' ?>>
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q92_1" value="20-30 mins" <?= $member['Q92_1'] === '20-30 mins' ? 'checked' : '' ?>>
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q92_1" value="30-45 mins" <?= $member['Q92_1'] === '30-45 mins' ? 'checked' : '' ?>>
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q92_1" value="45+ mins" <?= $member['Q92_1'] === '45+ mins' ? 'checked' : '' ?>>
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q92_1" value="" <?= $member['Q92_1'] === '' ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q93 -->
            <div class="Q">
                <p><span class="q_no">Q93: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q93" value="<?= htmlspecialchars($member['Q93'] ?? '') ?>">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentab('section10','section9')" href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentab('section10','section11')" href="#head_start">Next</a>
            </div>
        </div>
        <div class="section" id="section11">
            <h1>Trip 10</h1>
            <!-- Q94 -->
            <div class="Q">
                <p><span class="q_no">Q94: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q94" value="<?= htmlspecialchars($member['Q94'] ?? '') ?>">
            </div>

            <!-- Q95 -->
            <div class="Q">
                <p><span class="q_no">Q95: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q95_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q95_lat" name="q95_a" value="<?= htmlspecialchars($q95_a ?? '') ?>">
                    <label for="q95_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q95_lng" name="q95_b" value="<?= htmlspecialchars($q95_b ?? '') ?>">
                    <button type="button" onclick="openMap('q95')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q96 -->
            <div class="Q">
                <p><span class="q_no">Q96: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q96" value="Work" <?= $member['Q96'] === 'Work' ? 'checked' : '' ?>>
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q96" value="Education" <?= $member['Q96'] === 'Education' ? 'checked' : '' ?>>
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q96" value="Shopping" <?= $member['Q96'] === 'Shopping' ? 'checked' : '' ?>>
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q96" value="Social/Recreational/Personal" <?= $member['Q96'] === 'Social/Recreational/Personal' ? 'checked' : '' ?>>
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q96" value="Return to Home" <?= $member['Q96'] === 'Return to Home' ? 'checked' : '' ?>>
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q96" value="Pickup or Drop off" <?= $member['Q96'] === 'Pickup or Drop off' ? 'checked' : '' ?>>
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q96" value="Medical" <?= $member['Q96'] === 'Medical' ? 'checked' : '' ?>>
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q96" value="Others" <?= $member['Q96'] === 'Others' ? 'checked' : '' ?>>
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q96" value="" <?= empty($member['Q96']) ? 'checked' : '' ?>>
                        <p class="text">null</p>
                    </label>
                </div>

            </div>

            <!-- Q97 -->
            <div class="Q">
            <p><span class="q_no">Q97: </span> Modes used for stages</p>
            <div class="radio-input">
                <input type="hidden" name="limit97" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q97-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q97-1" value="Bus" <?= $q97_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-2" value="Private Bus (Office bus/ school bus etc)" <?= $q97_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q97_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-4" value="Paddle Rickshaw" <?= $q97_4 === 1 ? 'checked' : '' ?>>
                    <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-5" value="Auto Rickshaw" <?= $q97_5 === 1 ? 'checked' : '' ?>>
                    <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-6" value="CNG/taxi" <?= $q97_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-7" value="Personal Car" <?= $q97_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-8" value="Rented or ride sharing Car" <?= $q97_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-9" value="Personal 2 wheeler" <?= $q97_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-10" value="Ride sharing 2 wheeler" <?= $q97_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-11" value="Bicycle" <?= $q97_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-12" value="Walk" <?= $q97_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-13" value="Train" <?= $q97_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-14" value="Other" <?= $q97_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    <!-- Q97-1 -->
        <div class="Q">
            <p><span class="q_no">Q97.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason?</p>
            <div class="radio-input">
                <input type="hidden" name="limit97-1" value="14">
                <!-- Hidden fields to ensure all are set -->
                <?php for ($k = 1; $k <= 14; $k++): ?>
                    <input type="hidden" name="q97-1-<?= $k ?>" value="">
                <?php endfor; ?>

                <label class="label">
                    <input type="checkbox" name="q97-1-1" value="Bus" <?= $q97_1_1 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bus</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-1-2" value="Private Bus (Office bus/ school bus etc)" <?= $q97_1_2 === 1 ? 'checked' : '' ?>>
                    <p class="text">Private Bus (Office bus/ school bus etc)</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" <?= $q97_1_3 === 1 ? 'checked' : '' ?>>
                    <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q97-1-4" value="Paddle Rickshaw" <?= $q97_1_4 === 1 ? 'checked' : '' ?>>
                            <p class="text">Paddle Rickshaw</p>
                </label>
                <label class="label">
                <input type="checkbox"  name="q97-1-5" value="Auto Rickshaw"<?= $q97_1_5 === 1 ? 'checked' : '' ?> >
                            <p class="text">Auto Rickshaw</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-1-6" value="CNG/taxi" <?= $q97_1_6 === 1 ? 'checked' : '' ?>>
                    <p class="text">CNG/taxi</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-1-7" value="Personal Car" <?= $q97_1_7 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-1-8" value="Rented or ride sharing Car" <?= $q97_1_8 === 1 ? 'checked' : '' ?>>
                    <p class="text">Rented or ride sharing Car</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-1-9" value="Personal 2 wheeler" <?= $q97_1_9 === 1 ? 'checked' : '' ?>>
                    <p class="text">Personal 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-1-10" value="Ride sharing 2 wheeler" <?= $q97_1_10 === 1 ? 'checked' : '' ?>>
                    <p class="text">Ride sharing 2 wheeler</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-1-11" value="Bicycle" <?= $q97_1_11 === 1 ? 'checked' : '' ?>>
                    <p class="text">Bicycle</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-1-12" value="Walk" <?= $q97_1_12 === 1 ? 'checked' : '' ?>>
                    <p class="text">Walk</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-1-13" value="Train" <?= $q97_1_13 === 1 ? 'checked' : '' ?>>
                    <p class="text">Train</p>
                </label>
                <label class="label">
                    <input type="checkbox" name="q97-1-14" value="Other" <?= $q97_1_14 === 1 ? 'checked' : '' ?>>
                    <p class="text">Other</p>
                </label>
            </div>
        </div>
    


            <!-- Q98 -->
            <div class="Q">
                <p><span class="q_no">Q98: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q98" value="<?= htmlspecialchars($member['Q98'] ?? '') ?>">
            </div>

            <!-- Q99 -->
            <div class="Q">
                <p><span class="q_no">Q99: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q99" value="Alone" <?= $member['Q99'] === 'Alone' ? 'checked' : '' ?>>
                             <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q99" value="1 person" <?= $member['Q99'] === '1 person' ? 'checked' : '' ?>>
                            <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q99" value="2 persons" <?= $member['Q99'] === '2 persons' ? 'checked' : '' ?>>
                            <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q99" value="3 persons" <?= $member['Q99'] === '3 persons' ? 'checked' : '' ?>>
                           <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q99" value="3+ persons" <?= $member['Q99'] === '3+ persons' ? 'checked' : '' ?>>
                            <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q99" value="" <?= empty($member['Q99']) ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 

            </div>
            <!-- Q99_1 -->
            <div class="Q">
                <p><span class="q_no">Q99_1: </span> <h2>Approximate out-of-vehicle waiting time</h2> <Br>(Waiting means the approximate amount of time the trip maker had to wait to get on a certain vehicle. For example, if you are traveling to work bus, and before getting on the bus you have to wait 5 mins for the bus to arrive at the station. Then the waiting time is 5 min. )
                </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q99_1" value="0-5 mins" <?= $member['Q99_1'] === '0-5 mins' ? 'checked' : '' ?>>
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q99_1" value="5-10 mins" <?= $member['Q99_1'] === '5-10 mins' ? 'checked' : '' ?>>
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q99_1" value="10-15 mins" <?= $member['Q99_1'] === '10-15 mins' ? 'checked' : '' ?>>
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q99_1" value="15-20 mins" <?= $member['Q99_1'] === '15-20 mins' ? 'checked' : '' ?>>
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q99_1" value="20-30 mins" <?= $member['Q99_1'] === '20-30 mins' ? 'checked' : '' ?>>
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q99_1" value="30-45 mins" <?= $member['Q99_1'] === '30-45 mins' ? 'checked' : '' ?>>
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q99_1" value="45+ mins" <?= $member['Q99_1'] === '45+ mins' ? 'checked' : '' ?>>
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q99_1" value="" <?= $member['Q99_1'] === '' ? 'checked' : '' ?>>
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q100 -->
            <div class="Q">
                <p><span class="q_no">Q100: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q100" value="<?= htmlspecialchars($member['Q100'] ?? '') ?>">
            </div>
            <div class="Q">
                <p><span class="q_no">(Optional): </span>Additional Information</p>
                <input type="text" name="q102" value="<?= htmlspecialchars($member['Q101'] ?? '') ?>">
            </div>

        
            
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentab('section11','section10')" href="#head_start">Previous</a>
                
            </div>
            
        </div>
        <br><br>
        <p><span class="must">Note:</span><em>  If no other trip is made by the person, you can submit or else press next.</p></em>    
        <button type="submit" class="submit final">Submit</button>
    </div>
    </form>
    <script>
        function opentab(current,toop) {
            document.getElementById(current).classList.remove("active");
            document.getElementById(toop).classList.add("active");
        }
        
        function opentab(current,toop) {
                document.getElementById(current).classList.remove("active");
                document.getElementById(toop).classList.add("active");
                const targetElement = document.getElementById("toop");
                window.scrollTo({
                    top: targetElement.offsetTop,
                    behavior: "smooth"
      });
            }
        // Open a new window with the map for selecting the location
        function openMap(type) {
            window.open(`map.php?type=${type}`, "Select Location", "width=800,height=600");
        }
    
        // Function to receive data from the map and populate the form
        function receiveLocationData(lat, lng, type) {
            document.getElementById(String(type+'_lat')).value = lat;
            document.getElementById(String(type+'_lng')).value = lng; 
        }
    
    var checker=document.getElementsByClassName("otherRad");
    var checkother=document.getElementsByClassName("other");
    if (checker.checked=true){
        checkother.required=true;
        checkother.style="background-color: #3cb371;";
    }
    
            
            
    </script>

</body>
</html>