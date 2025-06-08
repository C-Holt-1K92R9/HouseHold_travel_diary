<?php
require "0_config.php";
//================================================================
session_start();


$house_id = $_GET['type'] ?? null;

if (isset($house_id)) {
    // Prepare the statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM household_info WHERE house_id = ?");
    $stmt->bind_param("s", $house_id); // 'i' for integer parameter type
    $stmt->execute();
    $house = $stmt->get_result()->fetch_assoc();

    $stmt2 = $conn->prepare("SELECT * FROM aggriment WHERE house_id = ?");
    $stmt2->bind_param("s", $house_id); // 'i' for integer parameter type
    $stmt2->execute();
    $aggr = $stmt2->get_result()->fetch_assoc();

    $stmt3 = $conn->prepare("SELECT * FROM vehicle_info WHERE house_id = ?");
    $stmt3->bind_param("s", $house_id); // 'i' for integer parameter type
    $stmt3->execute();
    $vhcl = $stmt3->get_result()->fetch_assoc();

}


list($latitude, $longitude) = array_map('trim', explode(',', $house['Q4']));


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Form</title>
    <!--<link rel="stylesheet" href="styles.css">-->
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
<div class="container">
    <h2>Survey Form</h2>
    <p><span class="must">* Indicated required questions.</span></p>
    <p>Note: Select <span class="must">"null"</span> if not answered. [For the questions that are not mandatory]</p>
    
    <form action="edit_house_form_process.php" method="POST">
        <div class="section active" id="section1">
        <h1>Agreement</h1>
        <input type="hidden" name="house_id" value="<?= $house_id ?>">
        <!-- Q1 -->
        <div class="Q">
        <div class="radio-input">
            <p><span class="q_no">Q1: </span>Do you agree to help us in research by providing some information about your household travel diaries? 
                [ আপনি কি আপনার গৃহস্থালিসংক্রান্ত যাত্রাবিবরনির কিছু তথ্য দিয়ে গবেষনায় সাহায্য করতে রাজি আছেন? ] <span class="must">*</span> <br> </p>
            
            
                <label class="label">
                  <input type="radio" name="q1" value="Yes" <?= $aggr['Q1'] === 'Yes' ? 'checked' : '' ?> required>
                  <p class="text">Yes</p>
                </label>
                <label class="label">
                  <input type="radio" name="q1" value="No" <?= $aggr['Q1'] === 'No' ? 'checked' : '' ?> required>
                  <p class="text">No</p>
                </label>

              </div>
              
            </div>    
        <!-- Q2 -->
        <div class="Q">
        <p><span class="q_no">Q2: </span>Your Mobile Number if you want to attend lucky draw. </p>
        
        <input type="text" id="p_num" name="q2" placeholder="Phone" value="<?= htmlspecialchars($aggr['Q2'] ?? '') ?>">
        </div> 
        <div class="bottom_btn">
            <p></p>
            <a class="next_btn" onclick="opentab('section1','section2')">Next</a>
        </div>
                
        </div>

        <div class="section" id="section2">
        <h1>Household Information</h1>
        <!-- Q3 -->
        <div class="Q">
        <p><span class="q_no">Q3: </span>Ward NO.<span class="must">*</span> </p>
        
        <input type="number" id="ward" name="q3" placeholder="Ward no." value="<?= htmlspecialchars($house['Q3'] ?? '') ?>" required>
        
        </div>
        <!-- Q4-->
        <div class="Q">
            <p><span class="q_no">Q4: Home Address</span></p>
            <div>
                <label for="q4_lat">Latitude:</label>
                <input type="number" step="0.000000000000001"  id="q4_lat" name="q4_a" value="<?= htmlspecialchars($latitude) ?>">
                <label for="q4_lng">Longitude:</label>
                <input type="number" step="0.000000000000001" id="q4_lng" name="q4_b" value="<?= htmlspecialchars($longitude) ?>">
                <br><br><a  onclick="openMap('q4')" class="locator">Open Map</a>
            </div>
    
        </div>
        <!-- Q5 -->
        <div class="Q">
        <p><span class="q_no">Q5: </span>Household Type <span class="must">*</span><br>
            <br><span style="color:rgb(0, 136, 255)">Enter 1:</span> for bungalows/ luxury apartments, typically households with cars<br>
            <br><span style="color:rgb(0, 136, 255)">Enter 2:</span> for one or two or three Bedroom hall Kitchen apartments, typically households
            that don't own a car (may or may not own two-wheelers)<br>
            <br><span style="color:rgb(0, 136, 255)">Enter 3:</span> for Iow income households/ tin shed / brick wall building that are not categorized
            as slum / basti / hutment<br>
            <br><span style="color:rgb(0, 136, 255)">Enter 4:</span> for slum / basti / hutment<br>
            <br><span style="color:rgb(0, 136, 255)">Enter 5:</span> for bachelor household or mess.
            Mark only one oval. </p>
        
            <div class="radio-input">
                <label class="label">
                  <input type="radio" name="q5" value="Entered: 1" <?= $house['Q5'] === 'Entered: 1' ? 'checked' : '' ?> required>
                  <p class="text">1</p>
                </label>
                <label class="label">
                  <input type="radio" name="q5" value="Entered: 2" <?= $house['Q5'] === 'Entered: 2' ? 'checked' : '' ?> required>
                  <p class="text">2</p>
                </label>
                <label class="label">
                    <input type="radio"  name="q5" value="Entered: 3" <?= $house['Q5'] === 'Entered: 3' ? 'checked' : '' ?> required>
                    <p class="text">3</p>
                  </label>
                  <label class="label">
                    <input type="radio" name="q5" value="Entered: 4" <?= $house['Q5'] === 'Entered: 4' ? 'checked' : '' ?> required>
                    <p class="text">4</p>
                  </label>
                  <label class="label">
                    <input type="radio"  name="q5" value="Entered: 5" <?= $house['Q5'] === 'Entered: 5' ? 'checked' : '' ?> required>
                    <p class="text">5</p>
                  </label>
              </div>
              
        </div>
        <!-- Q6 -->
        <div class="Q">
        <p><span class="q_no">Q6: </span>Monthly household Income (BDT) <span class="must">*</span></p>
        <div class="radio-input">
            <label class="label">
              <input type="radio" name="q6" value="<10k" <?= $house['Q6'] === '<10k' ? 'checked' : '' ?> required>
              <p class="text"><10k</p>
            </label>
            <label class="label">
              <input type="radio" name="q6" value="10-25k" <?= $house['Q6'] === '10-25k' ? 'checked' : '' ?>  required>
              <p class="text">10-25k</p>
            </label>
            <label class="label">
                <input type="radio"  name="q6" value="25-50k" <?= $house['Q6'] === '25-50k' ? 'checked' : '' ?>  required>
                <p class="text">25-50k</p>
              </label>
              <label class="label">
                <input type="radio" name="q6" value="50-75k" <?= $house['Q6'] === '50-75k' ? 'checked' : '' ?>  required>
                <p class="text">50-75k</p>
              </label>
              <label class="label">
                <input type="radio"  name="q6" value="75-100k" <?= $house['Q6'] === '75-100k' ? 'checked' : '' ?>  required>
                <p class="text">75-100k</p>
              </label>
              <label class="label">
                <input type="radio"  name="q6" value="1-2lac" <?= $house['Q6'] === '1-2lac' ? 'checked' : '' ?>  required>
                <p class="text">1-2lac</p>
              </label>
              <label class="label">
                <input type="radio"  name="q6" value=">2lac" <?= $house['Q6'] === '>2lac' ? 'checked' : '' ?>  required>
                <p class="text">>2lac</p>
              </label>
          </div>
          
        </div>
            <!-- Q7 -->
            <div class="Q">
            <p><span class="q_no">Q7: </span> Home Owned or rented? </p>
            <div class="radio-input">
                <label class="label">
                  <input type="radio" name="q7" value="Owned" <?= $house['Q7'] === 'Owned' ? 'checked' : '' ?>>
                  <p class="text">Owned</p>
                </label>
                <label class="label">
                  <input type="radio" name="q7" value="Rented" <?= $house['Q7'] === 'Rented' ? 'checked' : '' ?>>
                  <p class="text">Rented</p>
                </label>
                <label class="label">
                    <input type="radio" name="q7" value="" c<?= empty($vhcl['Q23']) ? 'checked' : '' ?>>
                    <p class="text">null</p>
              </label>  
              </div>
              
              </div>
            <!-- Q8 -->
            <div class="Q">
            <p><span class="q_no">Q8: </span> Does the household own any private vehicles?
                2 wheelers, cars or cycle <span class="must">*</span></p>
                <div class="radio-input">
                    <label class="label"> 
                      <input type="radio" name="q8" value="Yes" <?= $house['Q8'] === 'Yes' ? 'checked' : '' ?> required>
                      <p class="text">Yes</p>
                    </label>
                    <label class="label">
                      <input type="radio" name="q8" value="No" <?= $house['Q8'] === 'No' ? 'checked' : '' ?> required>
                      <p class="text">No</p>
                    </label>
                  </div>
                  
            </div>
            <!-- Q9 -->
            <div class="Q">
            <p><span class="q_no">Q9: </span> How many members live in this household? </p>
            <div class="radio-input">
            <label class="label">
                <input type="radio"  name="q9" value="1" <?= trim($house['Q9']) === '1' ? 'checked' : '' ?>>
                <p class="text">1</p>
              </label>
              <label class="label">
                <input type="radio"  name="q9" value="2" <?= trim($house['Q9']) === '2' ? 'checked' : '' ?>>
                <p class="text">2</p>
              </label>
              <label class="label">
                <input type="radio"  name="q9" value="3" <?= trim($house['Q9']) === '3' ? 'checked' : '' ?>>
                <p class="text">3</p>
              </label>
              <label class="label">
                <input type="radio"  name="q9" value="4" <?= trim($house['Q9']) === '4' ? 'checked' : '' ?>>
                <p class="text">4</p>
              </label>
              <label class="label">
                <input type="radio"  name="q9" value="5" <?= trim($house['Q9']) === '5' ? 'checked' : '' ?>>
                <p class="text">5</p>
              </label>
              <label class="label">
                <input type="radio"  name="q9" value="6" <?= trim($house['Q9']) === '6' ? 'checked' : '' ?>>
                <p class="text">6</p>
              </label>
              <label class="label">
                <input type="radio"  name="q9" value="7" <?= trim($house['Q9']) === '7' ? 'checked' : '' ?>>
                <p class="text">7</p>
              </label>
              <label class="label">
                <input type="radio"  name="q9" value="7+" <?=trim($house['Q9']) === '7+' ? 'checked' : '' ?>>
                <p class="text">7+</p>
              </label>
              <label class="label">
                <input type="radio" name="q9" value="" <?= empty($house['Q9']) ? 'checked' : '' ?>>
                <p class="text">null</p>
          </label>  
            </div>
            
            </div>
            <!-- Q10 -->
            <div class="Q">
                <div>
            <p><span class="q_no">Q10: </span> <h3>Travel Date</h3>
                Please select today if your household members have completed all trips of the day or else please select yesterday as travel day and fill out yesterday's information. But trip information of one whole day of the all household members is required for this research. </p>
                <label class="label">
                    <input type="date" name="q10" value="<?= htmlspecialchars($house['Q10'] ?? '') ?>">
                  </label> 
                </div>
                </div>

                <div class="bottom_btn">
                    <a class="next_btn" onclick="opentab('section2','section1')">Previous</a>
                    <a class="next_btn" onclick="opentab('section2','section3')">Next</a>
                </div>
            </div>
            <div class="section" id="section3">
            <h1>Vehicle Information</h1>
            <!-- Q11 -->
            <div class="Q">
            <p><span class="q_no">Q11: </span> Vehicle 1 type </p>
            <div class="radio-input">
                <label class="label">
                    <input type="radio"  name="q11" value="Motor Car" <?= $vhcl['Q11'] === 'Motor Car' ? 'checked' : '' ?>>
                        <p class="text">Motor Car</p>  
                </label>
                <label class="label">
                    <input type="radio"  name="q11" value="Motorcycle" <?= $vhcl['Q11'] === 'Motorcycle' ? 'checked' : '' ?>>
                        <p class="text">Motorcycle</p>  
                </label>
                <label class="label">
                    <input type="radio"  name="q11" value="Bicycle" <?= $vhcl['Q11'] === 'Bicycle' ? 'checked' : '' ?>>
                        <p class="text">Bicycle</p>  
                </label>
                <label class="label">
                    <input type="radio" name="q11" value="" <?= empty($vhcl['Q11']) ? 'checked' : '' ?>>
                    <p class="text">null</p>
              </label>  
                </div> 
            </div>

            <!-- Q12 -->
            <div class="Q">
                <p><span class="q_no">Q12: </span> Vehicle 1 fuel type </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q12" value="Petrol/Octane" <?= $vhcl['Q12'] === 'Petrol/Octane' ? 'checked' : '' ?>>
                             <p class="text">Petrol/Octane</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q12" value="Diesel" <?= $vhcl['Q12'] === 'Diesel' ? 'checked' : '' ?>>
                            <p class="text">Diesel</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q12" value="CNG" <?= $vhcl['Q12'] === 'CNG' ? 'checked' : '' ?>>
                        <p class="text">CNG</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q12" value="Mixed" <?= $vhcl['Q12'] === 'Mixed' ? 'checked' : '' ?>>
                            <p class="text">Mixed</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q12" value="None" <?= $vhcl['Q12'] === 'None' ? 'checked' : '' ?>>
                        <p class="text">None</p>
                    </label>
                </div> 
                
            </div>

            <!-- Q13 -->
            <div class="Q">
                <p><span class="q_no">Q13: </span> <h3>Vehicle 1 make model and year</h3>
                    Make model means the name of the company and the name of the car model for example: Honda civic 2000, Toyota corolla 2005, Toyota axio 2008 etc. Please keep blank if it is bicycle </p>
                    <input type="text" name="q13" placeholder="Your Answer" value="<?= htmlspecialchars($vhcl['Q13'] ?? '') ?>" >
                </div>

            <!-- Q14 -->
            <div class="Q">
                <p><span class="q_no">Q14: </span><h3> Vehicle 1 buying date </h3>
                    write when the vehicle was bought. Please try to provide accurate information for at least the month and year. </p>
                    <input type="date" name="q14" value="<?= htmlspecialchars($vhcl['Q14'] ?? '') ?>" >
                </div>

            
            <!-- Q15 -->
            <div class="Q">
                <p><span class="q_no">Q15: </span> Vehicle 2 type </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio"  name="q15" value="Motor Car" <?= $vhcl['Q15'] === 'Motor Car' ? 'checked' : '' ?> >
                            <p class="text">Motor Car</p>  
                    </label>
                    <label class="label">
                        <input type="radio"  name="q15" value="Motorcycle" <?= $vhcl['Q15'] === 'Motorcycle' ? 'checked' : '' ?>>
                            <p class="text">Motorcycle</p>  
                    </label>
                    <label class="label">
                        <input type="radio"  name="q15" value="Bicycle" <?= $vhcl['Q15'] === 'Bicycle' ? 'checked' : '' ?>>
                            <p class="text">Bicycle</p>  
                    </label>
                    <label class="label">
                        <input type="radio" name="q15" value="" <?= empty($vhcl['Q15']) ? 'checked' : '' ?>>
                        <p class="text">null</p>
                  </label>  
                    </div> 
                </div>
    
                <!-- Q16 -->
                <div class="Q">
                    <p><span class="q_no">Q16: </span> Vehicle 2 fuel type </p>
                    <div class="radio-input">
                        <label class="label">
                             <input type="radio"  name="q16" value="Petrol/Octane" <?= $vhcl['Q16'] === 'Petrol/Octane' ? 'checked' : '' ?> >
                                 <p class="text">Petrol/Octane</p>
                        </label>
                        <label class="label">
                            <input type="radio"  name="q16" value="Diesel" <?= $vhcl['Q16'] === 'Diesel' ? 'checked' : '' ?>>
                                <p class="text">Diesel</p>
                       </label>
                       <label class="label">
                        <input type="radio"  name="q16" value="CNG" <?= $vhcl['Q16'] === 'CNG' ? 'checked' : '' ?>>
                            <p class="text">CNG</p>
                        </label>
                        <label class="label">
                            <input type="radio"  name="q16" value="Mixed" <?= $vhcl['Q16'] === 'Mixed' ? 'checked' : '' ?>>
                                <p class="text">Mixed</p>
                        </label>
                        <label class="label">
                            <input type="radio"  name="q16" value="None" <?= $vhcl['Q16'] === 'None' ? 'checked' : '' ?>>
                            <p class="text">None</p>
                        </label>
                    </div> 
                    
                </div>
    
                <!-- Q17 -->
                <div class="Q">
                    <p><span class="q_no">Q17: </span> <h3>Vehicle 2 make model and year</h3>
                        Make model means the name of the company and the name of the car model for example: Honda civic 2000, Toyota corolla 2005, Toyota axio 2008 etc. Please keep blank if it is bicycle </p>
                        <input type="text" name="q17" placeholder="Your Answer" value="<?= htmlspecialchars($vhcl['Q17'] ?? '') ?>" >
                    </div>
    
                <!-- Q18 -->
                <div class="Q">
                    <p><span class="q_no">Q18: </span><h3> Vehicle 2 buying date </h3>
                        write when the vehicle was bought. Please try to provide accurate information for at least the month and year. </p>
                        <input type="date" name="q18" value="<?= htmlspecialchars($vhcl['Q18'] ?? '') ?>" >
                    </div>
    
                    <!-- Q19 -->
            <div class="Q">
                <p><span class="q_no">Q19: </span> Vehicle 3 type </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio"  name="q19" value="Motor Car" <?= $vhcl['Q19'] === 'Motor Car' ? 'checked' : '' ?> >
                            <p class="text">Motor Car</p>  
                    </label>
                    <label class="label">
                        <input type="radio"  name="q19" value="Motorcycle" <?= $vhcl['Q19'] === 'Motorcycle' ? 'checked' : '' ?>>
                            <p class="text">Motorcycle</p>  
                    </label>
                    <label class="label">
                        <input type="radio"  name="q19" value="Bicycle" <?= $vhcl['Q19'] === 'Bicycle' ? 'checked' : '' ?>>
                            <p class="text">Bicycle</p>  
                    </label>
                    <label class="label">
                        <input type="radio" name="q19" value="" <?= empty($vhcl['Q19']) ? 'checked' : '' ?>>
                        <p class="text">null</p>
                  </label>  
                    
                    </div> 
                </div>
    
                <!-- Q20 -->
                <div class="Q">
                    <p><span class="q_no">Q20: </span> Vehicle 3 fuel type </p>
                    <div class="radio-input">
                        <label class="label">
                             <input type="radio"  name="q20" value="Petrol/Octane" <?= $vhcl['Q20'] === 'Petrol/Octane' ? 'checked' : '' ?> >
                                 <p class="text">Petrol/Octane</p>
                        </label>
                        <label class="label">
                            <input type="radio"  name="q20" value="Diesel" <?= $vhcl['Q20'] === 'Diesel' ? 'checked' : '' ?>>
                                <p class="text">Diesel</p>
                       </label>
                       <label class="label">
                        <input type="radio"  name="q20" value="CNG" <?= $vhcl['Q20'] === 'CNG' ? 'checked' : '' ?>>
                            <p class="text">CNG</p>
                        </label>
                        <label class="label">
                            <input type="radio"  name="q20" value="Mixed" <?= $vhcl['Q20'] === 'Mixed' ? 'checked' : '' ?>>
                                <p class="text">Mixed</p>
                        </label>
                        <label class="label">
                            <input type="radio"  name="q20" value="None" <?= $vhcl['Q20'] === 'None' ? 'checked' : '' ?>>
                            <p class="text">None</p>
                        </label>
                    </div> 
                    
                </div>
    
                <!-- Q21 -->
                <div class="Q">
                    <p><span class="q_no">Q21: </span> <h3>Vehicle 3 make model and year</h3>
                        Make model means the name of the company and the name of the car model for example: Honda civic 2000, Toyota corolla 2005, Toyota axio 2008 etc. Please keep blank if it is bicycle </p>
                        <input type="text" name="q21" placeholder="Your Answer" value="<?= htmlspecialchars($vhcl['Q21'] ?? '') ?>">
                    </div>
    
                <!-- Q22 -->
                <div class="Q">
                    <p><span class="q_no">Q22: </span><h3> Vehicle 3 buying date </h3>
                        write when the vehicle was bought. Please try to provide accurate information for at least the month and year. </p>
                        <input type="date" name="q22" value="<?= htmlspecialchars($vhcl['Q22'] ?? '') ?>">
                    </div>
             <!-- Q22_1 -->
             <div class="Q">
                    <p><span class="q_no">Q22_1: </span><h3> Driver's Salary in thousands </h3></p>
                        <input type="text" name="q22_1" value="<?= htmlspecialchars($vhcl['Q22_1'] ?? '') ?>">
                    </div>
            <!-- Q23 -->
            <div class="Q">
                <p><span class="q_no">Q23: </span>Has more than 3 vehicles </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q23" value="Yes" <?= $vhcl['Q23'] === 'Yes' ? 'checked' : '' ?>>
                             <p class="text">Yes</p>

                    </label>
                    <label class="label">
                        <input type="radio"  name="q23" value="No" <?= $vhcl['Q23'] === 'No' ? 'checked' : '' ?>>
                            <p class="text">No</p>                            
                   </label>
                   <label class="label">
                    <input type="radio" name="q23" value="" <?= empty($vhcl['Q23']) ? 'checked' : '' ?>>
                    <p class="text">null</p>
                    </label> 
                    </div> 
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentab('section3','section2')">Previous</a>
                <button type="submit" class="submit_next">Update</button>
            </div>
            
        <!-- Submit a -->
        
    </form>
</div>



<!--Java Script-->
<script>
    function opentab(current,toop) {
            document.getElementById(current).classList.remove("active");
            document.getElementById(toop).classList.add("active");
            const targetElement = document.getElementById("toop");
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

        
</script>
</body>
</html>
