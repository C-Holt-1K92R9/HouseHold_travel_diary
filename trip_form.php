<?php
session_start();
if (!isset($_SESSION['user_id'])){
    header("Location: index.php");
    session_abort();
    exit();
}
$house_id = $_GET['type'] ?? null;


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

        <h2 class="must" style="font-weight='bold';font-style='italic';" id="to"></h2>
    <form action="trip_process.php" method="POST">
        <input type="hidden" value="<?= $house_id ?>" name="house_id">
        <div class="section active" id="section1">
            <!-- Q24 -->
             <h1>Personal Information</h1>
            <div class="Q">
                <p><span class="q_no">Q24: </span> Gender <span class="must">*</span> </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q24" value="Male" required>
                             <p class="text">Male</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q24" value="Female" required>
                            <p class="text">Female</p>
                   </label>
                    </div> 
            </div>

            <!-- Q25 -->
            <div class="Q">
                <p><span class="q_no">Q25: </span> Age<span class="must">*</span>  </p>
                <div class="radio-input">
                <input type="number" id="q25" name="q25" placeholder="Age"  required>
                

                    </div> 
            </div>

            <!-- Q26 -->
            <div class="Q">
                <p><span class="q_no">Q26: </span> Has Driving license.<span class="must">*</span> </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q26" value="Only car- Non professional" required>
                             <p class="text">Only car- Non professional</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q26" value="Only 2 wheeler- non professional" required>
                            <p class="text">Only 2 wheeler- non professional</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q26" value="Both Non professional" required>
                            <p class="text">Both Non professional</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q26" value="Professional" required>
                            <p class="text">Professional</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q26" value="None" required>
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
                         <input type="radio"  name="q27" value="Phd or equivalent" required>
                             <p class="text">Phd or equivalent</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q27" value="Masters or equivalent" required>
                            <p class="text">Masters or equivalent</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q27" value="Bachelor or equivalent" required>
                        <p class="text">Bachelor or equivalent</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q27" value="Technical or equivalent" required>
                            <p class="text">Technical or equivalent</p>
                   </label>
                   <label class="label">
                       <input type="radio"  name="q27" value="Higher Secondary" required>
                           <p class="text">Higher Secondary</p>
                  </label>
                  <label class="label">
                   <input type="radio"  name="q27" value="Secondary" required>
                       <p class="text">Secondary</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q27" value="Primary" required>
                        <p class="text">Primary</p>
               </label>
               <label class="label">
                   <input type="radio"  name="q27" value="Illeterate" required>
                       <p class="text">Illeterate</p>
              </label>
              <label class="label">
                <input type="radio"  name="q27" value="Other" required>
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
                         <input type="radio"  name="q28" value="Govt. Employee" required>
                             <p class="text">Govt. Employee</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q28" value="Private Employee" required>
                            <p class="text">Private Employee</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q28" value="Businessman" required>
                        <p class="text">Businessman</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q28" value="Student" required>
                            <p class="text">Student</p>
                   </label>
                   <label class="label">
                       <input type="radio"  name="q28" value="Housewife" required>
                           <p class="text">Housewife</p>
                  </label>
                  <label class="label">
                   <input type="radio"  name="q28" value="Tuition" required>
                       <p class="text">Tuition</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q28" value="Freelancer" required>
                        <p class="text">Freelancer: </p>
                        
               </label>
               <label class="label">
                   <input type="radio"  name="q28" value="Staff" class="otherRad">
                       <p class="text">Staff: </p>
              </label>
              <label class="label">
                <input type="radio"  name="q28" value="Unemployed" >
                    <p class="text">Unemployed</p>
                </label>
                <label class="label">
                    <input type="radio"  name="q28" value="Other" >
                        <p class="text">Other</p>
                    </label>
                </div>
                </div>
                <div class="bottom_btn">
                    <p></p>
                    <a class="next_btn" onclick="opentab('section1','part2','q24,q25,q26,q27,q28')" href="#head_start">Next</a>
                
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
                    <input type="time" name="q29" id='q29'>
            </div>

            <!-- Q30 -->
            <div class="Q">
                <p><span class="q_no">Q30: Origin address (please write specifically so that we can pinpoint roughly on map)</span></p>
                <div>
                    <label for="q30_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q30_lat" name="q30_a" >
                    <label for="q30_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q30_lng" name="q30_b" >
                    <button type="button" onclick="openMap('q30')" class="locator">Open Map</button>
                </div>
        
            </div>

            <!-- Q31 -->
            <div class="Q">
                <p><span class="q_no">Q31: </span> Origin Type </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q31" value="Home" >
                             <p class="text">Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q31" value="Work" >
                            <p class="text">Work</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q31" value="Education" >
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q31" value="Shopping" >
                            <p class="text">Shopping</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q31" value="Social/Recreational/Personal" >
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q31" value="Pickup or Drop off" >
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q31" value="Medical" >
                            <p class="text">Medical</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q31" value="Others" >
                            <p class="text">Others</p>
                   </label>

                   <label class="label">
                    <input type="radio" id="value-1" name="q31" value="" checked="">
                    <p class="text">null</p>
              </label>  
                    </div> 
            </div>

            <!-- Q32 -->
            <div class="Q">
                <p><span class="q_no">Q32: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="start_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q32_lat" name="q32_a" >
                    <label for="start_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q32_lng" name="q32_b" >
                    <button type="button" onclick="openMap('q32')" class="locator">Open Map</button>
                </div>
        
            </div>

            <!-- Q33 -->
            <div class="Q">
                <p><span class="q_no">Q33: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q33" value="Work" >
                             <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q33" value="Education" >
                            <p class="text">Education</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q33" value="Shopping" >
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                    <input type="radio"  name="q33" value="Social/Recreational/Personal" >
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                    <input type="radio"  name="q33" value="Return to Home" >
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q33" value="Pickup or Drop off" >
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q33" value="Medical" >
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio"  name="q33" value="Others" >
                    <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" id="value-1" name="q33" value="" checked="">
                        <p class="text">null</p>
                  </label> 
                  </null->
                    </div> 
            </div>

            <!-- Q34 -->
            <div class="Q">
                <p><span class="q_no">Q34: </span> Modes used for stages </p>
                <div class="radio-input">
                    
                    <input type="hidden" name="limit34" value="14">
                    <input type="hidden" name="q34-1" value="">
                    <input type="hidden" name="q34-2" value="">
                    <input type="hidden" name="q34-3" value="">
                    <input type="hidden" name="q34-4" value="">
                    <input type="hidden" name="q34-5" value="">
                    <input type="hidden" name="q34-6" value="">
                    <input type="hidden" name="q34-7" value="">
                    <input type="hidden" name="q34-8" value="">
                    <input type="hidden" name="q34-9" value="">
                    <input type="hidden" name="q34-10" value="">
                    <input type="hidden" name="q34-11" value="">
                    <input type="hidden" name="q34-12" value="">
                    <input type="hidden" name="q34-13" value="">
                    <input type="hidden" name="q34-14" value="">
                    
                    <label class="label">
                    <input type="checkbox"  name="q34-1" value="Bus" >
                        <p class="text">Bus</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q34-2" value="Private Bus (Office bus/ school bus etc)" >
                            <p class="text">Private Bus (Office bus/ school bus etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q34-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                        <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q34-4" value="Paddle Rickshaw" >
                        <p class="text">Paddle Rickshaw</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q34-5" value="Auto Rickshaw" >
                        <p class="text">Auto Rickshaw</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q34-6" value="CNG/taxi" >
                            <p class="text">CNG/taxi</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q34-7" value="Personal Car" >
                            <p class="text">Personal Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q34-8" value="Rented or ride sharing Car" >
                        <p class="text">Rented or ride sharing Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q34-9" value="Personal 2 wheeler" >
                        <p class="text">Personal 2 wheeler</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q34-10" value="Ride sharing 2 wheeler" >
                        <p class="text">Ride sharing 2 wheeler</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q34-11" value="Bicycle" >
                            <p class="text">Bicycle</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q34-12" value="Walk" >
                        <p class="text">Walk</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q34-13" value="Train" >
                        <p class="text">Train</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q34-14" value="Other" >
                        <p class="text">Other</p>
                    </label>


                </div> 
            </div>
         <!---Q34-1-->
         <div class="Q">
                    <p><span class="q_no">Q34.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason? </p>
                    <div class="radio-input">
                        <input type="hidden" name="limit34.1" value="14">
                        <input type="hidden" name="q34-1-1" value="">
                        <input type="hidden" name="q34-1-2" value="">
                        <input type="hidden" name="q34-1-3" value="">
                        <input type="hidden" name="q34-1-4" value="">
                        <input type="hidden" name="q34-1-5" value="">
                        <input type="hidden" name="q34-1-6" value="">
                        <input type="hidden" name="q34-1-7" value="">
                        <input type="hidden" name="q34-1-8" value="">
                        <input type="hidden" name="q34-1-9" value="">
                        <input type="hidden" name="q34-1-10" value="">
                        <input type="hidden" name="q34-1-11" value="">
                        <input type="hidden" name="q34-1-12" value="">
                        <input type="hidden" name="q34-1-13" value="">
                        <input type="hidden" name="q34-1-14" value="">
                        
                        <label class="label">
                        <input type="checkbox"  name="q34-1-1" value="Bus" >
                            <p class="text">Bus</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q34-1-2" value="Private Bus (Office bus/ school bus etc)" >
                                <p class="text">Private Bus (Office bus/ school bus etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q34-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                            <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q34-1-4" value="Paddle Rickshaw" >
                            <p class="text">Paddle Rickshaw</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q34-1-5" value="Auto Rickshaw" >
                            <p class="text">Auto Rickshaw</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q34-1-6" value="CNG/taxi" >
                                <p class="text">CNG/taxi</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q34-1-7" value="Personal Car" >
                                <p class="text">Personal Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q34-1-8" value="Rented or ride sharing Car" >
                            <p class="text">Rented or ride sharing Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q34-1-9" value="Personal 2 wheeler" >
                            <p class="text">Personal 2 wheeler</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q34-1-10" value="Ride sharing 2 wheeler" >
                            <p class="text">Ride sharing 2 wheeler</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q34-1-11" value="Bicycle" >
                                <p class="text">Bicycle</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q34-1-12" value="Walk" >
                            <p class="text">Walk</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q34-1-13" value="Train" >
                            <p class="text">Train</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q34-1-14" value="Other" >
                            <p class="text">Other</p>
                        </label>


                    </div> 
                </div>
    

            <!-- Q35 -->
            <div class="Q">
                <p><span class="q_no">Q35: </span> <h3>End Time</h3>
                <p style="color:red;" id="w1"></p>
                    (approximately when you arrived at destination)</p>
                    <input type="time" name="q35" id='q35'>
            </div>

            <!-- Q36 -->
            <div class="Q">
                <p><span class="q_no">Q36: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q36" value="Alone" >
                             <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36" value="1 person" >
                            <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36" value="2 persons" >
                            <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q36" value="3 persons" >
                           <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36" value="3+ persons" >
                            <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q36" value="" checked="">
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
                         <input type="radio"  name="q36_1" value="0-5 mins" >
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36_1" value="5-10 mins" >
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36_1" value="10-15 mins" >
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q36_1" value="15-20 mins" >
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36_1" value="20-30 mins" >
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36_1" value="30-45 mins" >
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q36_1" value="45+ mins" >
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q36_1" value="" checked="">
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q37 -->
            <div class="Q">
                <p><span class="q_no">Q37: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home  that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                    <input type="text" name="q37">
                </div>
                <div class="bottom_btn">
                    <a class="next_btn" onclick="opentabto('part2','section1')" href="#head_start">Previous</a>
                    <a class="next_btn" onclick="opentabto('section2','section3')" href="#head_start">Next</a>
                </div>
            </div>
            
            <div class="section" id="section3">
            <h1>Trip 2</h1>
            <!-- Q38 -->
            <div class="Q">
                <p><span class="q_no">Q38: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q38">
            </div>

            <!-- Q39 -->
            <div class="Q">
                <p><span class="q_no">Q39: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q39_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q39_lat" name="q39_a" >
                    <label for="q39_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q39_lng" name="q39_b" >
                    <button type="button" onclick="openMap('q39')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q40 -->
            <div class="Q">
                <p><span class="q_no">Q40: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q40" value="Work">
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q40" value="Education">
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q40" value="Shopping">
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q40" value="Social/Recreational/Personal">
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q40" value="Return to Home">
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q40" value="Pickup or Drop off" >
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q40" value="Medical" >
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q40" value="Others">
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" id="value-1" name="q40" value="" checked="">
                        <p class="text">null</p>
                    </label>
                </div>
            </div>

            <!-- Q41 -->
            
            <div class="Q">
                <p><span class="q_no">Q41: </span> Modes used for stages </p>
                <div class="radio-input">
                    
                    <input type="hidden" name="limit41" value="14">
                    <input type="hidden" name="q41-1" value="">
                    <input type="hidden" name="q41-2" value="">
                    <input type="hidden" name="q41-3" value="">
                    <input type="hidden" name="q41-4" value="">
                    <input type="hidden" name="q41-5" value="">
                    <input type="hidden" name="q41-6" value="">
                    <input type="hidden" name="q41-7" value="">
                    <input type="hidden" name="q41-8" value="">
                    <input type="hidden" name="q41-9" value="">
                    <input type="hidden" name="q41-10" value="">
                    <input type="hidden" name="q41-11" value="">
                    <input type="hidden" name="q41-12" value="">
                    <input type="hidden" name="q41-13" value="">
                    <input type="hidden" name="q41-14" value="">
                    
                    <label class="label">
                    <input type="checkbox"  name="q41-1" value="Bus" >
                        <p class="text">Bus</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q41-2" value="Private Bus (Office bus/ school bus etc)" >
                            <p class="text">Private Bus (Office bus/ school bus etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q41-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                        <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q41-4" value="Paddle Rickshaw" >
                        <p class="text">Paddle Rickshaw</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q41-5" value="Auto Rickshaw" >
                        <p class="text">Auto Rickshaw</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q41-6" value="CNG/taxi" >
                            <p class="text">CNG/taxi</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q41-7" value="Personal Car" >
                            <p class="text">Personal Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q41-8" value="Rented or ride sharing Car" >
                        <p class="text">Rented or ride sharing Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q41-9" value="Personal 2 wheeler" >
                        <p class="text">Personal 2 wheeler</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q41-10" value="Ride sharing 2 wheeler" >
                        <p class="text">Ride sharing 2 wheeler</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q41-11" value="Bicycle" >
                            <p class="text">Bicycle</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q41-12" value="Walk" >
                        <p class="text">Walk</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q41-13" value="Train" >
                        <p class="text">Train</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q41-14" value="Other" >
                        <p class="text">Other</p>
                    </label>


                </div> 
            </div>
         <!---Q41-1-->
         <div class="Q">
                    <p><span class="q_no">Q41.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason? </p>
                    <div class="radio-input">
                        <input type="hidden" name="limit41.1" value="14">
                        <input type="hidden" name="q41-1-1" value="">
                        <input type="hidden" name="q41-1-2" value="">
                        <input type="hidden" name="q41-1-3" value="">
                        <input type="hidden" name="q41-1-4" value="">
                        <input type="hidden" name="q41-1-5" value="">
                        <input type="hidden" name="q41-1-6" value="">
                        <input type="hidden" name="q41-1-7" value="">
                        <input type="hidden" name="q41-1-8" value="">
                        <input type="hidden" name="q41-1-9" value="">
                        <input type="hidden" name="q41-1-10" value="">
                        <input type="hidden" name="q41-1-11" value="">
                        <input type="hidden" name="q41-1-12" value="">
                        <input type="hidden" name="q41-1-13" value="">
                        <input type="hidden" name="q41-1-14" value="">
                        
                        <label class="label">
                        <input type="checkbox"  name="q41-1-1" value="Bus" >
                            <p class="text">Bus</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q41-1-2" value="Private Bus (Office bus/ school bus etc)" >
                                <p class="text">Private Bus (Office bus/ school bus etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q41-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                            <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q41-1-4" value="Paddle Rickshaw" >
                            <p class="text">Paddle Rickshaw</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q41-1-5" value="Auto Rickshaw" >
                            <p class="text">Auto Rickshaw</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q41-1-6" value="CNG/taxi" >
                                <p class="text">CNG/taxi</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q41-1-7" value="Personal Car" >
                                <p class="text">Personal Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q41-1-8" value="Rented or ride sharing Car" >
                            <p class="text">Rented or ride sharing Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q41-1-9" value="Personal 2 wheeler" >
                            <p class="text">Personal 2 wheeler</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q41-1-10" value="Ride sharing 2 wheeler" >
                            <p class="text">Ride sharing 2 wheeler</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q41-1-11" value="Bicycle" >
                                <p class="text">Bicycle</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q41-1-12" value="Walk" >
                            <p class="text">Walk</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q41-1-13" value="Train" >
                            <p class="text">Train</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q41-1-14" value="Other" >
                            <p class="text">Other</p>
                        </label>


                    </div> 
                </div>
    



            <!-- Q42 -->
            <div class="Q">
                <p><span class="q_no">Q42: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q42">
            </div>

            <!-- Q43 -->
            <div class="Q">
                <p><span class="q_no">Q43: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q43" value="Alone">
                        <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q43" value="1 person">
                        <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q43" value="2 persons">
                        <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q43" value="3 persons">
                        <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q43" value="3+ persons">
                        <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q43" value="" checked="">
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
                         <input type="radio"  name="q43_1" value="0-5 mins" >
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q43_1" value="5-10 mins" >
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q43_1" value="10-15 mins" >
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q43_1" value="15-20 mins" >
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q43_1" value="20-30 mins" >
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q43_1" value="30-45 mins" >
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q43_1" value="45+ mins" >
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q43_1" value="" checked="">
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q44 -->
            <div class="Q">
                <p><span class="q_no">Q44: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q44">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentabto('section3','section2')" href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentabto('section3','section4')" href="#head_start">Next</a>
            </div>
            </div>
            <div class="section" id="section4">
            <h1>Trip 3</h1>
            <!-- Q45 -->
            <div class="Q">
                <p><span class="q_no">Q45: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q45">
            </div>

            <!-- Q46 -->
            <div class="Q">
                <p><span class="q_no">Q46: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q46_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q46_lat" name="q46_a" >
                    <label for="q46_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q46_lng" name="q46_b" >
                    <button type="button" onclick="openMap('q46')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q47 -->
            <div class="Q">
                <p><span class="q_no">Q47: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q47" value="Work">
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q47" value="Education">
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q47" value="Shopping">
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q47" value="Social/Recreational/Personal">
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q47" value="Return to Home">
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q47" value="Pickup or Drop off" >
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q47" value="Medical" >
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q47" value="Others">
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" id="value-1" name="q47" value="" checked="">
                        <p class="text">null</p>
                    </label>
                </div>
            </div>

            <!-- Q48 -->
            
<div class="Q">
                <p><span class="q_no">Q48: </span> Modes used for stages </p>
                <div class="radio-input">
                    
                    <input type="hidden" name="limit48" value="14">
                    <input type="hidden" name="q48-1" value="">
                    <input type="hidden" name="q48-2" value="">
                    <input type="hidden" name="q48-3" value="">
                    <input type="hidden" name="q48-4" value="">
                    <input type="hidden" name="q48-5" value="">
                    <input type="hidden" name="q48-6" value="">
                    <input type="hidden" name="q48-7" value="">
                    <input type="hidden" name="q48-8" value="">
                    <input type="hidden" name="q48-9" value="">
                    <input type="hidden" name="q48-10" value="">
                    <input type="hidden" name="q48-11" value="">
                    <input type="hidden" name="q48-12" value="">
                    <input type="hidden" name="q48-13" value="">
                    <input type="hidden" name="q48-14" value="">
                    
                    <label class="label">
                    <input type="checkbox"  name="q48-1" value="Bus" >
                        <p class="text">Bus</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q48-2" value="Private Bus (Office bus/ school bus etc)" >
                            <p class="text">Private Bus (Office bus/ school bus etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q48-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                        <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q48-4" value="Paddle Rickshaw" >
                        <p class="text">Paddle Rickshaw</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q48-5" value="Auto Rickshaw" >
                        <p class="text">Auto Rickshaw</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q48-6" value="CNG/taxi" >
                            <p class="text">CNG/taxi</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q48-7" value="Personal Car" >
                            <p class="text">Personal Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q48-8" value="Rented or ride sharing Car" >
                        <p class="text">Rented or ride sharing Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q48-9" value="Personal 2 wheeler" >
                        <p class="text">Personal 2 wheeler</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q48-10" value="Ride sharing 2 wheeler" >
                        <p class="text">Ride sharing 2 wheeler</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q48-11" value="Bicycle" >
                            <p class="text">Bicycle</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q48-12" value="Walk" >
                        <p class="text">Walk</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q48-13" value="Train" >
                        <p class="text">Train</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q48-14" value="Other" >
                        <p class="text">Other</p>
                    </label>


                </div> 
            </div>
         <!---Q48-1-->
         <div class="Q">
                    <p><span class="q_no">Q48.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason? </p>
                    <div class="radio-input">
                        <input type="hidden" name="limit48-1" value="14">
                        <input type="hidden" name="q48-1-1" value="">
                        <input type="hidden" name="q48-1-2" value="">
                        <input type="hidden" name="q48-1-3" value="">
                        <input type="hidden" name="q48-1-4" value="">
                        <input type="hidden" name="q48-1-5" value="">
                        <input type="hidden" name="q48-1-6" value="">
                        <input type="hidden" name="q48-1-7" value="">
                        <input type="hidden" name="q48-1-8" value="">
                        <input type="hidden" name="q48-1-9" value="">
                        <input type="hidden" name="q48-1-10" value="">
                        <input type="hidden" name="q48-1-11" value="">
                        <input type="hidden" name="q48-1-12" value="">
                        <input type="hidden" name="q48-1-13" value="">
                        <input type="hidden" name="q48-1-14" value="">
                        
                        <label class="label">
                        <input type="checkbox"  name="q48-1-1" value="Bus" >
                            <p class="text">Bus</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q48-1-2" value="Private Bus (Office bus/ school bus etc)" >
                                <p class="text">Private Bus (Office bus/ school bus etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q48-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                            <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q48-1-4" value="Paddle Rickshaw" >
                            <p class="text">Paddle Rickshaw</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q48-1-5" value="Auto Rickshaw" >
                            <p class="text">Auto Rickshaw</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q48-1-6" value="CNG/taxi" >
                                <p class="text">CNG/taxi</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q48-1-7" value="Personal Car" >
                                <p class="text">Personal Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q48-1-8" value="Rented or ride sharing Car" >
                            <p class="text">Rented or ride sharing Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q48-1-9" value="Personal 2 wheeler" >
                            <p class="text">Personal 2 wheeler</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q48-1-10" value="Ride sharing 2 wheeler" >
                            <p class="text">Ride sharing 2 wheeler</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q48-1-11" value="Bicycle" >
                                <p class="text">Bicycle</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q48-1-12" value="Walk" >
                            <p class="text">Walk</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q48-1-13" value="Train" >
                            <p class="text">Train</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q48-1-14" value="Other" >
                            <p class="text">Other</p>
                        </label>


                    </div> 
                </div>
    


            <!-- Q49 -->
            <div class="Q">
                <p><span class="q_no">Q49: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q49">
            </div>

            <!-- Q50 -->
            <div class="Q">
                <p><span class="q_no">Q50: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q50" value="Alone">
                        <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q50" value="1 person">
                        <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q50" value="2 persons">
                        <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q50" value="3 persons">
                        <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q50" value="3+ persons">
                        <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q50" value="" checked="">
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
                         <input type="radio"  name="q50_1" value="0-5 mins" >
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q50_1" value="5-10 mins" >
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q50_1" value="10-15 mins" >
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q50_1" value="15-20 mins" >
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q50_1" value="20-30 mins" >
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q50_1" value="30-45 mins" >
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q50_1" value="45+ mins" >
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q50_1" value="" checked="">
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q51 -->
            <div class="Q">
                <p><span class="q_no">Q51: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q51">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentabto('section4','section3')" href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentabto('section4','section5')" href="#head_start">Next</a>
            </div>
            </div>
            <div class="section" id="section5">
            <h1>Trip 4</h1>
            <!-- Q52 -->
            <div class="Q">
                <p><span class="q_no">Q52: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q52">
            </div>

            <!-- Q53 -->
            <div class="Q">
                <p><span class="q_no">Q53: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q53_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q53_lat" name="q53_a" >
                    <label for="q53_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q53_lng" name="q53_b" >
                    <button type="button" onclick="openMap('q53')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q54 -->
            <div class="Q">
                <p><span class="q_no">Q54: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q54" value="Work">
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q54" value="Education">
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q54" value="Shopping">
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q54" value="Social/Recreational/Personal">
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q54" value="Return to Home">
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q54" value="Pickup or Drop off" >
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q54" value="Medical" >
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q54" value="Others">
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" id="value-1" name="q54" value="" checked="">
                        <p class="text">null</p>
                    </label>
                </div>
            </div>

            <!-- Q55 -->
            
            <div class="Q">
                <p><span class="q_no">Q55: </span> Modes used for stages </p>
                <div class="radio-input">
                    
                    <input type="hidden" name="limit55" value="14">
                    <input type="hidden" name="q55-1" value="">
                    <input type="hidden" name="q55-2" value="">
                    <input type="hidden" name="q55-3" value="">
                    <input type="hidden" name="q55-4" value="">
                    <input type="hidden" name="q55-5" value="">
                    <input type="hidden" name="q55-6" value="">
                    <input type="hidden" name="q55-7" value="">
                    <input type="hidden" name="q55-8" value="">
                    <input type="hidden" name="q55-9" value="">
                    <input type="hidden" name="q55-10" value="">
                    <input type="hidden" name="q55-11" value="">
                    <input type="hidden" name="q55-12" value="">
                    <input type="hidden" name="q55-13" value="">
                    <input type="hidden" name="q55-14" value="">
                    
                    <label class="label">
                    <input type="checkbox"  name="q55-1" value="Bus" >
                        <p class="text">Bus</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q55-2" value="Private Bus (Office bus/ school bus etc)" >
                            <p class="text">Private Bus (Office bus/ school bus etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q55-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                        <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q55-4" value="Paddle Rickshaw" >
                        <p class="text">Paddle Rickshaw</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q55-5" value="Auto Rickshaw" >
                        <p class="text">Auto Rickshaw</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q55-6" value="CNG/taxi" >
                            <p class="text">CNG/taxi</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q55-7" value="Personal Car" >
                            <p class="text">Personal Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q55-8" value="Rented or ride sharing Car" >
                        <p class="text">Rented or ride sharing Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q55-9" value="Personal 2 wheeler" >
                        <p class="text">Personal 2 wheeler</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q55-10" value="Ride sharing 2 wheeler" >
                        <p class="text">Ride sharing 2 wheeler</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q55-11" value="Bicycle" >
                            <p class="text">Bicycle</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q55-12" value="Walk" >
                        <p class="text">Walk</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q55-13" value="Train" >
                        <p class="text">Train</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q55-14" value="Other" >
                        <p class="text">Other</p>
                    </label>


                </div> 
            </div>

         <!---Q55-1-->
         <div class="Q">
                    <p><span class="q_no">Q55.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason? </p>
                    <div class="radio-input">
                        <input type="hidden" name="limit55.1" value="14">
                        <input type="hidden" name="q55-1-1" value="">
                        <input type="hidden" name="q55-1-2" value="">
                        <input type="hidden" name="q55-1-3" value="">
                        <input type="hidden" name="q55-1-4" value="">
                        <input type="hidden" name="q55-1-5" value="">
                        <input type="hidden" name="q55-1-6" value="">
                        <input type="hidden" name="q55-1-7" value="">
                        <input type="hidden" name="q55-1-8" value="">
                        <input type="hidden" name="q55-1-9" value="">
                        <input type="hidden" name="q55-1-10" value="">
                        <input type="hidden" name="q55-1-11" value="">
                        <input type="hidden" name="q55-1-12" value="">
                        <input type="hidden" name="q55-1-13" value="">
                        <input type="hidden" name="q55-1-14" value="">
                        
                        <label class="label">
                        <input type="checkbox"  name="q55-1-1" value="Bus" >
                            <p class="text">Bus</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q55-1-2" value="Private Bus (Office bus/ school bus etc)" >
                                <p class="text">Private Bus (Office bus/ school bus etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q55-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                            <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q55-1-4" value="Paddle Rickshaw" >
                            <p class="text">Paddle Rickshaw</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q55-1-5" value="Auto Rickshaw" >
                            <p class="text">Auto Rickshaw</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q55-1-6" value="CNG/taxi" >
                                <p class="text">CNG/taxi</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q55-1-7" value="Personal Car" >
                                <p class="text">Personal Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q55-1-8" value="Rented or ride sharing Car" >
                            <p class="text">Rented or ride sharing Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q55-1-9" value="Personal 2 wheeler" >
                            <p class="text">Personal 2 wheeler</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q55-1-10" value="Ride sharing 2 wheeler" >
                            <p class="text">Ride sharing 2 wheeler</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q55-1-11" value="Bicycle" >
                                <p class="text">Bicycle</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q55-1-12" value="Walk" >
                            <p class="text">Walk</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q55-1-13" value="Train" >
                            <p class="text">Train</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q55-1-14" value="Other" >
                            <p class="text">Other</p>
                        </label>


                    </div> 
                </div>
    


            <!-- Q56 -->
            <div class="Q">
                <p><span class="q_no">Q56: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q56">
            </div>
            
          
            
            <!-- Q57 -->
            <div class="Q">
                <p><span class="q_no">Q57: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q57" value="Alone">
                        <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q57" value="1 person">
                        <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q57" value="2 persons">
                        <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q57" value="3 persons">
                        <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q57" value="3+ persons">
                        <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q57" value="" checked="">
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
                         <input type="radio"  name="q57_1" value="0-5 mins" >
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q57_1" value="5-10 mins" >
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q57_1" value="10-15 mins" >
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q57_1" value="15-20 mins" >
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q57_1" value="20-30 mins" >
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q57_1" value="30-45 mins" >
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q57_1" value="45+ mins" >
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q57_1" value="" checked="">
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q58 -->
            <div class="Q">
                <p><span class="q_no">Q58: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q58">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentabto('section5','section4')" href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentabto('section5','section6')" href="#head_start">Next</a>
            </div>
        </div>
        
        <div class="section" id="section6">
            <h1>Trip 5</h1>
            <!-- Q59 -->
            <div class="Q">
                <p><span class="q_no">Q59: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q59">
            </div>

            <!-- Q60 -->
            <div class="Q">
                <p><span class="q_no">Q60: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q60_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q60_lat" name="q60_a" >
                    <label for="q60_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q60_lng" name="q60_b" >
                    <button type="button" onclick="openMap('q60')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q61 -->
            <div class="Q">
                <p><span class="q_no">Q61: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q61" value="Work">
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q61" value="Education">
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q61" value="Shopping">
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q61" value="Social/Recreational/Personal">
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q61" value="Return to Home">
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q61" value="Pickup or Drop off" >
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q61" value="Medical" >
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q61" value="Others">
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" id="value-1" name="q61" value="" checked="">
                        <p class="text">null</p>
                    </label>
                </div>
                
            </div>

            <!-- Q62 -->
            
            <div class="Q">
                <p><span class="q_no">Q62: </span> Modes used for stages </p>
                <div class="radio-input">
                    
                    <input type="hidden" name="limit62" value="14">
                    <input type="hidden" name="q62-1" value="">
                    <input type="hidden" name="q62-2" value="">
                    <input type="hidden" name="q62-3" value="">
                    <input type="hidden" name="q62-4" value="">
                    <input type="hidden" name="q62-5" value="">
                    <input type="hidden" name="q62-6" value="">
                    <input type="hidden" name="q62-7" value="">
                    <input type="hidden" name="q62-8" value="">
                    <input type="hidden" name="q62-9" value="">
                    <input type="hidden" name="q62-10" value="">
                    <input type="hidden" name="q62-11" value="">
                    <input type="hidden" name="q62-12" value="">
                    <input type="hidden" name="q62-13" value="">
                    <input type="hidden" name="q62-14" value="">
                    
                    <label class="label">
                    <input type="checkbox"  name="q62-1" value="Bus" >
                        <p class="text">Bus</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q62-2" value="Private Bus (Office bus/ school bus etc)" >
                            <p class="text">Private Bus (Office bus/ school bus etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q62-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                        <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q62-4" value="Paddle Rickshaw" >
                        <p class="text">Paddle Rickshaw</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q62-5" value="Auto Rickshaw" >
                        <p class="text">Auto Rickshaw</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q62-6" value="CNG/taxi" >
                            <p class="text">CNG/taxi</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q62-7" value="Personal Car" >
                            <p class="text">Personal Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q62-8" value="Rented or ride sharing Car" >
                        <p class="text">Rented or ride sharing Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q62-9" value="Personal 2 wheeler" >
                        <p class="text">Personal 2 wheeler</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q62-10" value="Ride sharing 2 wheeler" >
                        <p class="text">Ride sharing 2 wheeler</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q62-11" value="Bicycle" >
                            <p class="text">Bicycle</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q62-12" value="Walk" >
                        <p class="text">Walk</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q62-13" value="Train" >
                        <p class="text">Train</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q62-14" value="Other" >
                        <p class="text">Other</p>
                    </label>


                </div> 
            </div>

                     <!---Q62-1-->
                     <div class="Q">
                    <p><span class="q_no">Q62.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason? </p>
                    <div class="radio-input">
                        <input type="hidden" name="limit62.1" value="14">
                        <input type="hidden" name="q62-1-1" value="">
                        <input type="hidden" name="q62-1-2" value="">
                        <input type="hidden" name="q62-1-3" value="">
                        <input type="hidden" name="q62-1-4" value="">
                        <input type="hidden" name="q62-1-5" value="">
                        <input type="hidden" name="q62-1-6" value="">
                        <input type="hidden" name="q62-1-7" value="">
                        <input type="hidden" name="q62-1-8" value="">
                        <input type="hidden" name="q62-1-9" value="">
                        <input type="hidden" name="q62-1-10" value="">
                        <input type="hidden" name="q62-1-11" value="">
                        <input type="hidden" name="q62-1-12" value="">
                        <input type="hidden" name="q62-1-13" value="">
                        <input type="hidden" name="q62-1-14" value="">
                        
                        <label class="label">
                        <input type="checkbox"  name="q62-1-1" value="Bus" >
                            <p class="text">Bus</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q62-1-2" value="Private Bus (Office bus/ school bus etc)" >
                                <p class="text">Private Bus (Office bus/ school bus etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q62-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                            <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q62-1-4" value="Paddle Rickshaw" >
                            <p class="text">Paddle Rickshaw</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q62-1-5" value="Auto Rickshaw" >
                            <p class="text">Auto Rickshaw</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q62-1-6" value="CNG/taxi" >
                                <p class="text">CNG/taxi</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q62-1-7" value="Personal Car" >
                                <p class="text">Personal Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q62-1-8" value="Rented or ride sharing Car" >
                            <p class="text">Rented or ride sharing Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q62-1-9" value="Personal 2 wheeler" >
                            <p class="text">Personal 2 wheeler</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q62-1-10" value="Ride sharing 2 wheeler" >
                            <p class="text">Ride sharing 2 wheeler</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q62-1-11" value="Bicycle" >
                                <p class="text">Bicycle</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q62-1-12" value="Walk" >
                            <p class="text">Walk</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q62-1-13" value="Train" >
                            <p class="text">Train</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q62-1-14" value="Other" >
                            <p class="text">Other</p>
                        </label>


                    </div> 
                </div>
    



            <!-- Q63 -->
            <div class="Q">
                <p><span class="q_no">Q63: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q63">
            </div>

            <!-- Q64 -->
            <div class="Q">
                <p><span class="q_no">Q64: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q64" value="Alone">
                        <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q64" value="1 person">
                        <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q64" value="2 persons">
                        <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q64" value="3 persons">
                        <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q64" value="3+ persons">
                        <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q64" value="" checked="">
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
                         <input type="radio"  name="q64_1" value="0-5 mins" >
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q64_1" value="5-10 mins" >
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q64_1" value="10-15 mins" >
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q64_1" value="15-20 mins" >
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q64_1" value="20-30 mins" >
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q64_1" value="30-45 mins" >
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q64_1" value="45+ mins" >
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q64_1" value="" checked="">
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q65 -->
            <div class="Q">
                <p><span class="q_no">Q65: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q65">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentabto('section6','section5')"href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentabto('section6','section7')" href="#head_start">Next</a>
            </div>
        </div>
            <div class="section" id="section7">
            <h1>Trip 6</h1>
            <!-- Q66 -->
            <div class="Q">
                <p><span class="q_no">Q66: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q66">
            </div>

            <!-- Q67 -->
            <div class="Q">
                <p><span class="q_no">Q67: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q67_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q67_lat" name="q67_a" >
                    <label for="q67_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q67_lng" name="q67_b" >
                    <button type="button" onclick="openMap('q67')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q68 -->
            <div class="Q">
                <p><span class="q_no">Q68: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q68" value="Work">
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q68" value="Education">
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q68" value="Shopping">
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q68" value="Social/Recreational/Personal">
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q68" value="Return to Home">
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q68" value="Pickup or Drop off" >
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q68" value="Medical" >
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q68" value="Others">
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" id="value-1" name="q68" value="" checked="">
                        <p class="text">null</p>
                    </label>
                </div>
            </div>

            <!-- Q69 -->
            
            <div class="Q">
                <p><span class="q_no">Q69: </span> Modes used for stages </p>
                <div class="radio-input">
                    
                    <input type="hidden" name="limit69" value="14">
                    <input type="hidden" name="q69-1" value="">
                    <input type="hidden" name="q69-2" value="">
                    <input type="hidden" name="q69-3" value="">
                    <input type="hidden" name="q69-4" value="">
                    <input type="hidden" name="q69-5" value="">
                    <input type="hidden" name="q69-6" value="">
                    <input type="hidden" name="q69-7" value="">
                    <input type="hidden" name="q69-8" value="">
                    <input type="hidden" name="q69-9" value="">
                    <input type="hidden" name="q69-10" value="">
                    <input type="hidden" name="q69-11" value="">
                    <input type="hidden" name="q69-12" value="">
                    <input type="hidden" name="q69-13" value="">
                    <input type="hidden" name="q69-14" value="">
                    
                    <label class="label">
                    <input type="checkbox"  name="q69-1" value="Bus" >
                        <p class="text">Bus</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q69-2" value="Private Bus (Office bus/ school bus etc)" >
                            <p class="text">Private Bus (Office bus/ school bus etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q69-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                        <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q69-4" value="Paddle Rickshaw" >
                        <p class="text">Paddle Rickshaw</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q69-5" value="Auto Rickshaw" >
                        <p class="text">Auto Rickshaw</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q69-6" value="CNG/taxi" >
                            <p class="text">CNG/taxi</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q69-7" value="Personal Car" >
                            <p class="text">Personal Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q69-8" value="Rented or ride sharing Car" >
                        <p class="text">Rented or ride sharing Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q69-9" value="Personal 2 wheeler" >
                        <p class="text">Personal 2 wheeler</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q69-10" value="Ride sharing 2 wheeler" >
                        <p class="text">Ride sharing 2 wheeler</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q69-11" value="Bicycle" >
                            <p class="text">Bicycle</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q69-12" value="Walk" >
                        <p class="text">Walk</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q69-13" value="Train" >
                        <p class="text">Train</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q69-14" value="Other" >
                        <p class="text">Other</p>
                    </label>


                </div> 
            </div>

                     <!---Q69-1-->
                     <div class="Q">
                    <p><span class="q_no">Q69.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason? </p>
                    <div class="radio-input">
                        <input type="hidden" name="limit69.1" value="14">
                        <input type="hidden" name="q69-1-1" value="">
                        <input type="hidden" name="q69-1-2" value="">
                        <input type="hidden" name="q69-1-3" value="">
                        <input type="hidden" name="q69-1-4" value="">
                        <input type="hidden" name="q69-1-5" value="">
                        <input type="hidden" name="q69-1-6" value="">
                        <input type="hidden" name="q69-1-7" value="">
                        <input type="hidden" name="q69-1-8" value="">
                        <input type="hidden" name="q69-1-9" value="">
                        <input type="hidden" name="q69-1-10" value="">
                        <input type="hidden" name="q69-1-11" value="">
                        <input type="hidden" name="q69-1-12" value="">
                        <input type="hidden" name="q69-1-13" value="">
                        <input type="hidden" name="q69-1-14" value="">
                        
                        <label class="label">
                        <input type="checkbox"  name="q69-1-1" value="Bus" >
                            <p class="text">Bus</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q69-1-2" value="Private Bus (Office bus/ school bus etc)" >
                                <p class="text">Private Bus (Office bus/ school bus etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q69-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                            <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q69-1-4" value="Paddle Rickshaw" >
                            <p class="text">Paddle Rickshaw</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q69-1-5" value="Auto Rickshaw" >
                            <p class="text">Auto Rickshaw</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q69-1-6" value="CNG/taxi" >
                                <p class="text">CNG/taxi</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q69-1-7" value="Personal Car" >
                                <p class="text">Personal Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q69-1-8" value="Rented or ride sharing Car" >
                            <p class="text">Rented or ride sharing Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q69-1-9" value="Personal 2 wheeler" >
                            <p class="text">Personal 2 wheeler</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q69-1-10" value="Ride sharing 2 wheeler" >
                            <p class="text">Ride sharing 2 wheeler</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q69-1-11" value="Bicycle" >
                                <p class="text">Bicycle</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q69-1-12" value="Walk" >
                            <p class="text">Walk</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q69-1-13" value="Train" >
                            <p class="text">Train</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q69-1-14" value="Other" >
                            <p class="text">Other</p>
                        </label>


                    </div> 
                </div>
    


            <!-- Q70 -->
            <div class="Q">
                <p><span class="q_no">Q70: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q70">
            </div>

            <!-- Q71 -->
            <div class="Q">
                <p><span class="q_no">Q71: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q71" value="Alone">
                        <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q71" value="1 person">
                        <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q71" value="2 persons">
                        <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q71" value="3 persons">
                        <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q71" value="3+ persons">
                        <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q71" value="" checked="">
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
                         <input type="radio"  name="q71_1" value="0-5 mins" >
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q71_1" value="5-10 mins" >
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q71_1" value="10-15 mins" >
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q71_1" value="15-20 mins" >
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q71_1" value="20-30 mins" >
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q71_1" value="30-45 mins" >
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q71_1" value="45+ mins" >
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q71_1" value="" checked="">
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q72 -->
            <div class="Q">
                <p><span class="q_no">Q72: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q72">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentabto('section7','section6')" href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentabto('section7','section8')" href="#head_start">Next</a>
            </div>
            </div>
            <div class="section" id="section8">
            <h1>Trip 7</h1>
            <!-- Q73 -->
            <div class="Q">
                <p><span class="q_no">Q73: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q73">
            </div>

            <!-- Q74 -->
            <div class="Q">
                <p><span class="q_no">Q74: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q74_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q74_lat" name="q74_a" >
                    <label for="q74_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q74_lng" name="q74_b" >
                    <button type="button" onclick="openMap('q74')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q75 -->
            <div class="Q">
                <p><span class="q_no">Q75: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q75" value="Work">
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q75" value="Education">
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q75" value="Shopping">
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q75" value="Social/Recreational/Personal">
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q75" value="Return to Home">
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q75" value="Pickup or Drop off" >
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q75" value="Medical" >
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q75" value="Others">
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" id="value-1" name="q75" value="" checked="">
                        <p class="text">null</p>
                    </label>
                </div>
            </div>

            <!-- Q76 -->
            
                <div class="Q">
                <p><span class="q_no">Q76: </span> Modes used for stages </p>
                <div class="radio-input">
                    
                    <input type="hidden" name="limit76" value="14">
                    <input type="hidden" name="q76-1" value="">
                    <input type="hidden" name="q76-2" value="">
                    <input type="hidden" name="q76-3" value="">
                    <input type="hidden" name="q76-4" value="">
                    <input type="hidden" name="q76-5" value="">
                    <input type="hidden" name="q76-6" value="">
                    <input type="hidden" name="q76-7" value="">
                    <input type="hidden" name="q76-8" value="">
                    <input type="hidden" name="q76-9" value="">
                    <input type="hidden" name="q76-10" value="">
                    <input type="hidden" name="q76-11" value="">
                    <input type="hidden" name="q76-12" value="">
                    <input type="hidden" name="q76-13" value="">
                    <input type="hidden" name="q76-14" value="">
                    
                    <label class="label">
                    <input type="checkbox"  name="q76-1" value="Bus" >
                        <p class="text">Bus</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q76-2" value="Private Bus (Office bus/ school bus etc)" >
                            <p class="text">Private Bus (Office bus/ school bus etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q76-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                        <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q76-4" value="Paddle Rickshaw" >
                        <p class="text">Paddle Rickshaw</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q76-5" value="Auto Rickshaw" >
                        <p class="text">Auto Rickshaw</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q76-6" value="CNG/taxi" >
                            <p class="text">CNG/taxi</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q76-7" value="Personal Car" >
                            <p class="text">Personal Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q76-8" value="Rented or ride sharing Car" >
                        <p class="text">Rented or ride sharing Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q76-9" value="Personal 2 wheeler" >
                        <p class="text">Personal 2 wheeler</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q76-10" value="Ride sharing 2 wheeler" >
                        <p class="text">Ride sharing 2 wheeler</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q76-11" value="Bicycle" >
                            <p class="text">Bicycle</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q76-12" value="Walk" >
                        <p class="text">Walk</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q76-13" value="Train" >
                        <p class="text">Train</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q76-14" value="Other" >
                        <p class="text">Other</p>
                    </label>
                </div> 
            </div>
             <!---Q76-1-->
             <div class="Q">
                    <p><span class="q_no">Q76.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason? </p>
                    <div class="radio-input">
                        <input type="hidden" name="limit76.1" value="14">
                        <input type="hidden" name="q76-1-1" value="">
                        <input type="hidden" name="q76-1-2" value="">
                        <input type="hidden" name="q76-1-3" value="">
                        <input type="hidden" name="q76-1-4" value="">
                        <input type="hidden" name="q76-1-5" value="">
                        <input type="hidden" name="q76-1-6" value="">
                        <input type="hidden" name="q76-1-7" value="">
                        <input type="hidden" name="q76-1-8" value="">
                        <input type="hidden" name="q76-1-9" value="">
                        <input type="hidden" name="q76-1-10" value="">
                        <input type="hidden" name="q76-1-11" value="">
                        <input type="hidden" name="q76-1-12" value="">
                        <input type="hidden" name="q76-1-13" value="">
                        <input type="hidden" name="q76-1-14" value="">
                        
                        <label class="label">
                        <input type="checkbox"  name="q76-1-1" value="Bus" >
                            <p class="text">Bus</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q76-1-2" value="Private Bus (Office bus/ school bus etc)" >
                                <p class="text">Private Bus (Office bus/ school bus etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q76-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                            <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q76-1-4" value="Paddle Rickshaw" >
                            <p class="text">Paddle Rickshaw</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q76-1-5" value="Auto Rickshaw" >
                            <p class="text">Auto Rickshaw</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q76-1-6" value="CNG/taxi" >
                                <p class="text">CNG/taxi</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q76-1-7" value="Personal Car" >
                                <p class="text">Personal Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q76-1-8" value="Rented or ride sharing Car" >
                            <p class="text">Rented or ride sharing Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q76-1-9" value="Personal 2 wheeler" >
                            <p class="text">Personal 2 wheeler</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q76-1-10" value="Ride sharing 2 wheeler" >
                            <p class="text">Ride sharing 2 wheeler</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q76-1-11" value="Bicycle" >
                                <p class="text">Bicycle</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q76-1-12" value="Walk" >
                            <p class="text">Walk</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q76-1-13" value="Train" >
                            <p class="text">Train</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q76-1-14" value="Other" >
                            <p class="text">Other</p>
                        </label>


                    </div> 
                </div>
    



            <!-- Q77 -->
            <div class="Q">
                <p><span class="q_no">Q77: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q77">
            </div>

            <!-- Q78 -->
            <div class="Q">
                <p><span class="q_no">Q78: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q78" value="Alone">
                        <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q78" value="1 person">
                        <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q78" value="2 persons">
                        <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q78" value="3 persons">
                        <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q78" value="3+ persons">
                        <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q78" value="" checked="">
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
                         <input type="radio"  name="q78_1" value="0-5 mins" >
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q78_1" value="5-10 mins" >
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q78_1" value="10-15 mins" >
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q78_1" value="15-20 mins" >
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q78_1" value="20-30 mins" >
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q78_1" value="30-45 mins" >
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q78_1" value="45+ mins" >
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q78_1" value="" checked="">
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q79 -->
            <div class="Q">
                <p><span class="q_no">Q79: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q79">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentabto('section8','section7')" href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentabto('section8','section9')" href="#head_start">Next</a>
            </div>
            </div>
            <div class="section" id="section9">
            <h1>Trip 8</h1>
            <!-- Q80 -->
            <div class="Q">
                <p><span class="q_no">Q80: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q80">
            </div>

            <!-- Q81 -->
            <div class="Q">
                <p><span class="q_no">Q81: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q81_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q81_lat" name="q81_a" >
                    <label for="q81_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q81_lng" name="q81_b" >
                    <button type="button" onclick="openMap('q81')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q82 -->
            <div class="Q">
                <p><span class="q_no">Q82: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q82" value="Work">
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q82" value="Education">
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q82" value="Shopping">
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q82" value="Social/Recreational/Personal">
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q82" value="Return to Home">
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q82" value="Pickup or Drop off" >
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q82" value="Medical" >
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q82" value="Others">
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" id="value-1" name="q82" value="" checked="">
                        <p class="text">null</p>
                    </label>
                </div>
            </div>

            <!-- Q83 -->
            
            <div class="Q">
                <p><span class="q_no">Q83: </span> Modes used for stages </p>
                <div class="radio-input">
                    
                    <input type="hidden" name="limit83" value="14">
                    <input type="hidden" name="q83-1" value="">
                    <input type="hidden" name="q83-2" value="">
                    <input type="hidden" name="q83-3" value="">
                    <input type="hidden" name="q83-4" value="">
                    <input type="hidden" name="q83-5" value="">
                    <input type="hidden" name="q83-6" value="">
                    <input type="hidden" name="q83-7" value="">
                    <input type="hidden" name="q83-8" value="">
                    <input type="hidden" name="q83-9" value="">
                    <input type="hidden" name="q83-10" value="">
                    <input type="hidden" name="q83-11" value="">
                    <input type="hidden" name="q83-12" value="">
                    <input type="hidden" name="q83-13" value="">
                    <input type="hidden" name="q83-14" value="">
                    
                    <label class="label">
                    <input type="checkbox"  name="q83-1" value="Bus" >
                        <p class="text">Bus</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q83-2" value="Private Bus (Office bus/ school bus etc)" >
                            <p class="text">Private Bus (Office bus/ school bus etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q83-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                        <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q83-4" value="Paddle Rickshaw" >
                        <p class="text">Paddle Rickshaw</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q83-5" value="Auto Rickshaw" >
                        <p class="text">Auto Rickshaw</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q83-6" value="CNG/taxi" >
                            <p class="text">CNG/taxi</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q83-7" value="Personal Car" >
                            <p class="text">Personal Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q83-8" value="Rented or ride sharing Car" >
                        <p class="text">Rented or ride sharing Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q83-9" value="Personal 2 wheeler" >
                        <p class="text">Personal 2 wheeler</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q83-10" value="Ride sharing 2 wheeler" >
                        <p class="text">Ride sharing 2 wheeler</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q83-11" value="Bicycle" >
                            <p class="text">Bicycle</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q83-12" value="Walk" >
                        <p class="text">Walk</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q83-13" value="Train" >
                        <p class="text">Train</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q83-14" value="Other" >
                        <p class="text">Other</p>
                    </label>


                </div> 
            </div>
             <!---Q83-1-->
             <div class="Q">
                    <p><span class="q_no">Q83.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason? </p>
                    <div class="radio-input">
                        <input type="hidden" name="limit83.1" value="14">
                        <input type="hidden" name="q83-1-1" value="">
                        <input type="hidden" name="q83-1-2" value="">
                        <input type="hidden" name="q83-1-3" value="">
                        <input type="hidden" name="q83-1-4" value="">
                        <input type="hidden" name="q83-1-5" value="">
                        <input type="hidden" name="q83-1-6" value="">
                        <input type="hidden" name="q83-1-7" value="">
                        <input type="hidden" name="q83-1-8" value="">
                        <input type="hidden" name="q83-1-9" value="">
                        <input type="hidden" name="q83-1-10" value="">
                        <input type="hidden" name="q83-1-11" value="">
                        <input type="hidden" name="q83-1-12" value="">
                        <input type="hidden" name="q83-1-13" value="">
                        <input type="hidden" name="q83-1-14" value="">
                        
                        <label class="label">
                        <input type="checkbox"  name="q83-1-1" value="Bus" >
                            <p class="text">Bus</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q83-1-2" value="Private Bus (Office bus/ school bus etc)" >
                                <p class="text">Private Bus (Office bus/ school bus etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q83-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                            <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q83-1-4" value="Paddle Rickshaw" >
                            <p class="text">Paddle Rickshaw</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q83-1-5" value="Auto Rickshaw" >
                            <p class="text">Auto Rickshaw</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q83-1-6" value="CNG/taxi" >
                                <p class="text">CNG/taxi</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q83-1-7" value="Personal Car" >
                                <p class="text">Personal Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q83-1-8" value="Rented or ride sharing Car" >
                            <p class="text">Rented or ride sharing Car</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q83-1-9" value="Personal 2 wheeler" >
                            <p class="text">Personal 2 wheeler</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q83-1-10" value="Ride sharing 2 wheeler" >
                            <p class="text">Ride sharing 2 wheeler</p>
                        </label>
                        <label class="label">
                            <input type="checkbox"  name="q83-1-11" value="Bicycle" >
                                <p class="text">Bicycle</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q83-1-12" value="Walk" >
                            <p class="text">Walk</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q83-1-13" value="Train" >
                            <p class="text">Train</p>
                        </label>
                        <label class="label">
                        <input type="checkbox"  name="q83-1-14" value="Other" >
                            <p class="text">Other</p>
                        </label>


                    </div> 
                </div>
    



            <!-- Q84 -->
            <div class="Q">
                <p><span class="q_no">Q84: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q84">
            </div>

            <!-- Q85 -->
            <div class="Q">
                <p><span class="q_no">Q85: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q85" value="Alone">
                        <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q85" value="1 person">
                        <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q85" value="2 persons">
                        <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q85" value="3 persons">
                        <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q85" value="3+ persons">
                        <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q85" value="" checked="">
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
                         <input type="radio"  name="q85_1" value="0-5 mins" >
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q85_1" value="5-10 mins" >
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q85_1" value="10-15 mins" >
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q85_1" value="15-20 mins" >
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q85_1" value="20-30 mins" >
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q85_1" value="30-45 mins" >
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q85_1" value="45+ mins" >
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q85_1" value="" checked="">
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q86 -->
            <div class="Q">
                <p><span class="q_no">Q86: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q86">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentabto('section9','section8')" href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentabto('section9','section10')" href="#head_start">Next</a>
            </div>
            </div>
            <div class="section" id="section10">
            <h1>Trip 9</h1>
            <!-- Q87 -->
            <div class="Q">
                <p><span class="q_no">Q87: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q87">
            </div>

            <!-- Q88 -->
            <div class="Q">
                <p><span class="q_no">Q88: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q88_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q88_lat" name="q88_a" >
                    <label for="q88_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q88_lng" name="q88_b" >
                    <button type="button" onclick="openMap('q88')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q89 -->
            <div class="Q">
                <p><span class="q_no">Q89: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q89" value="Work">
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q89" value="Education">
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q89" value="Shopping">
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q89" value="Social/Recreational/Personal">
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q89" value="Return to Home">
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q89" value="Pickup or Drop off" >
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q89" value="Medical" >
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q89" value="Others">
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" id="value-1" name="q89" value="" checked="">
                        <p class="text">null</p>
                    </label>
                </div>
            </div>

            <!-- Q90 -->
            
            <div class="Q">
                <p><span class="q_no">Q90: </span> Modes used for stages </p>
                <div class="radio-input">
                    
                    <input type="hidden" name="limit90" value="14">
                    <input type="hidden" name="q90-1" value="">
                    <input type="hidden" name="q90-2" value="">
                    <input type="hidden" name="q90-3" value="">
                    <input type="hidden" name="q90-4" value="">
                    <input type="hidden" name="q90-5" value="">
                    <input type="hidden" name="q90-6" value="">
                    <input type="hidden" name="q90-7" value="">
                    <input type="hidden" name="q90-8" value="">
                    <input type="hidden" name="q90-9" value="">
                    <input type="hidden" name="q90-10" value="">
                    <input type="hidden" name="q90-11" value="">
                    <input type="hidden" name="q90-12" value="">
                    <input type="hidden" name="q90-13" value="">
                    <input type="hidden" name="q90-14" value="">
                    
                    <label class="label">
                    <input type="checkbox"  name="q90-1" value="Bus" >
                        <p class="text">Bus</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q90-2" value="Private Bus (Office bus/ school bus etc)" >
                            <p class="text">Private Bus (Office bus/ school bus etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                        <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-4" value="Paddle Rickshaw" >
                        <p class="text">Paddle Rickshaw</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-5" value="Auto Rickshaw" >
                        <p class="text">Auto Rickshaw</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q90-6" value="CNG/taxi" >
                            <p class="text">CNG/taxi</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q90-7" value="Personal Car" >
                            <p class="text">Personal Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-8" value="Rented or ride sharing Car" >
                        <p class="text">Rented or ride sharing Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-9" value="Personal 2 wheeler" >
                        <p class="text">Personal 2 wheeler</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-10" value="Ride sharing 2 wheeler" >
                        <p class="text">Ride sharing 2 wheeler</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q90-11" value="Bicycle" >
                            <p class="text">Bicycle</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-12" value="Walk" >
                        <p class="text">Walk</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-13" value="Train" >
                        <p class="text">Train</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-14" value="Other" >
                        <p class="text">Other</p>
                    </label>


                </div> 
            </div>

            <!---Q90-1-->

            <div class="Q">
                <p><span class="q_no">Q90.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason? </p>
                <div class="radio-input">
                    <input type="hidden" name="limit90.1" value="14">
                    <input type="hidden" name="q90-1-1" value="">
                    <input type="hidden" name="q90-1-2" value="">
                    <input type="hidden" name="q90-1-3" value="">
                    <input type="hidden" name="q90-1-4" value="">
                    <input type="hidden" name="q90-1-5" value="">
                    <input type="hidden" name="q90-1-6" value="">
                    <input type="hidden" name="q90-1-7" value="">
                    <input type="hidden" name="q90-1-8" value="">
                    <input type="hidden" name="q90-1-9" value="">
                    <input type="hidden" name="q90-1-10" value="">
                    <input type="hidden" name="q90-1-11" value="">
                    <input type="hidden" name="q90-1-12" value="">
                    <input type="hidden" name="q90-1-13" value="">
                    <input type="hidden" name="q90-1-14" value="">
                    
                    <label class="label">
                    <input type="checkbox"  name="q90-1-1" value="Bus" >
                        <p class="text">Bus</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q90-1-2" value="Private Bus (Office bus/ school bus etc)" >
                            <p class="text">Private Bus (Office bus/ school bus etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                        <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-1-4" value="Paddle Rickshaw" >
                        <p class="text">Paddle Rickshaw</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-1-5" value="Auto Rickshaw" >
                        <p class="text">Auto Rickshaw</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q90-1-6" value="CNG/taxi" >
                            <p class="text">CNG/taxi</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q90-1-7" value="Personal Car" >
                            <p class="text">Personal Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-1-8" value="Rented or ride sharing Car" >
                        <p class="text">Rented or ride sharing Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-1-9" value="Personal 2 wheeler" >
                        <p class="text">Personal 2 wheeler</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-1-10" value="Ride sharing 2 wheeler" >
                        <p class="text">Ride sharing 2 wheeler</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q90-1-11" value="Bicycle" >
                            <p class="text">Bicycle</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-1-12" value="Walk" >
                        <p class="text">Walk</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-1-13" value="Train" >
                        <p class="text">Train</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q90-1-14" value="Other" >
                        <p class="text">Other</p>
                    </label>


                </div> 
            </div>



            <!-- Q91 -->
            <div class="Q">
                <p><span class="q_no">Q91: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q91">
            </div>

            <!-- Q92 -->
            <div class="Q">
                <p><span class="q_no">Q92: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q92" value="Alone">
                        <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q92" value="1 person">
                        <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q92" value="2 persons">
                        <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q92" value="3 persons">
                        <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q92" value="3+ persons">
                        <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q92" value="" checked="">
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
                         <input type="radio"  name="q92_1" value="0-5 mins" >
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q92_1" value="5-10 mins" >
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q92_1" value="10-15 mins" >
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q92_1" value="15-20 mins" >
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q92_1" value="20-30 mins" >
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q92_1" value="30-45 mins" >
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q92_1" value="45+ mins" >
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q92_1" value="" checked="">
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q93 -->
            <div class="Q">
                <p><span class="q_no">Q93: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q93">
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentabto('section10','section9')" href="#head_start">Previous</a>
                <a class="next_btn" onclick="opentabto('section10','section11')" href="#head_start">Next</a>
            </div>
        </div>
        <div class="section" id="section11">
            <h1>Trip 10</h1>
            <!-- Q94 -->
            <div class="Q">
                <p><span class="q_no">Q94: </span> <h3>Start Time</h3>
                    Trip start time </p>
                <input type="time" name="q94">
            </div>

            <!-- Q95 -->
            <div class="Q">
                <p><span class="q_no">Q95: Destination address (please write specifically where the trip ended) </span></p>
                <div>
                    <label for="q95_lat">Starting Location Latitude:</label>
                    <input type="number" step="0.000000000000001" id="q95_lat" name="q95_a" >
                    <label for="q95_lng">Starting Location Longitude:</label>
                    <input type="number" step="0.000000000000001" id="q95_lng" name="q95_b" >
                    <button type="button" onclick="openMap('q95')" class="locator">Open Map</button>
                </div>
            </div>

            <!-- Q96 -->
            <div class="Q">
                <p><span class="q_no">Q96: </span> Trip Purpose </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q96" value="Work">
                        <p class="text">Work</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q96" value="Education">
                        <p class="text">Education</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q96" value="Shopping">
                        <p class="text">Shopping</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q96" value="Social/Recreational/Personal">
                        <p class="text">Social/Recreational/Personal</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q96" value="Return to Home">
                        <p class="text">Return to Home</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q96" value="Pickup or Drop off" >
                            <p class="text">Pickup or Drop off</p>
                   </label>
                   <label class="label">
                        <input type="radio"  name="q96" value="Medical" >
                            <p class="text">Medical</p>
                   </label>
                    <label class="label">
                        <input type="radio" name="q96" value="Others">
                        <p class="text">Others</p>
                    </label>
                    <label class="label">
                        <input type="radio" id="value-1" name="q96" value="" checked="">
                        <p class="text">null</p>
                    </label>
                </div>
            </div>

            <!-- Q97 -->
            
            <div class="Q">
                <p><span class="q_no">Q97: </span> Modes used for stages </p>
                <div class="radio-input">
                    
                    <input type="hidden" name="limit97" value="14">
                    <input type="hidden" name="q97-1" value="">
                    <input type="hidden" name="q97-2" value="">
                    <input type="hidden" name="q97-3" value="">
                    <input type="hidden" name="q97-4" value="">
                    <input type="hidden" name="q97-5" value="">
                    <input type="hidden" name="q97-6" value="">
                    <input type="hidden" name="q97-7" value="">
                    <input type="hidden" name="q97-8" value="">
                    <input type="hidden" name="q97-9" value="">
                    <input type="hidden" name="q97-10" value="">
                    <input type="hidden" name="q97-11" value="">
                    <input type="hidden" name="q97-12" value="">
                    <input type="hidden" name="q97-13" value="">
                    <input type="hidden" name="q97-14" value="">
                    
                    <label class="label">
                    <input type="checkbox"  name="q97-1" value="Bus" >
                        <p class="text">Bus</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q97-2" value="Private Bus (Office bus/ school bus etc)" >
                            <p class="text">Private Bus (Office bus/ school bus etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                        <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-4" value="Paddle Rickshaw" >
                        <p class="text">Paddle Rickshaw</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-5" value="Auto Rickshaw" >
                        <p class="text">Auto Rickshaw</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q97-6" value="CNG/taxi" >
                            <p class="text">CNG/taxi</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q97-7" value="Personal Car" >
                            <p class="text">Personal Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-8" value="Rented or ride sharing Car" >
                        <p class="text">Rented or ride sharing Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-9" value="Personal 2 wheeler" >
                        <p class="text">Personal 2 wheeler</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-10" value="Ride sharing 2 wheeler" >
                        <p class="text">Ride sharing 2 wheeler</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q97-11" value="Bicycle" >
                            <p class="text">Bicycle</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-12" value="Walk" >
                        <p class="text">Walk</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-13" value="Train" >
                        <p class="text">Train</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-14" value="Other" >
                        <p class="text">Other</p>
                    </label>
                </div> 
            </div>

            <!-- Q97.1 -->
            <div class="Q">
                <p><span class="q_no">Q97.1: </span> What alternative modes were available to you for this trip if the selected modes were unavailable for any reason? </p>
                <div class="radio-input">
                    <input type="hidden" name="limit97.1" value="14">
                    <input type="hidden" name="q97-1-1" value="">
                    <input type="hidden" name="q97-1-2" value="">
                    <input type="hidden" name="q97-1-3" value="">
                    <input type="hidden" name="q97-1-4" value="">
                    <input type="hidden" name="q97-1-5" value="">
                    <input type="hidden" name="q97-1-6" value="">
                    <input type="hidden" name="q97-1-7" value="">
                    <input type="hidden" name="q97-1-8" value="">
                    <input type="hidden" name="q97-1-9" value="">
                    <input type="hidden" name="q97-1-10" value="">
                    <input type="hidden" name="q97-1-11" value="">
                    <input type="hidden" name="q97-1-12" value="">
                    <input type="hidden" name="q97-1-13" value="">
                    <input type="hidden" name="q97-1-14" value="">
                    
                    <label class="label">
                    <input type="checkbox"  name="q97-1-1" value="Bus" >
                        <p class="text">Bus</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q97-1-2" value="Private Bus (Office bus/ school bus etc)" >
                            <p class="text">Private Bus (Office bus/ school bus etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-1-3" value="Human Hauler ( 9 or 14 seater tempu etc)" >
                        <p class="text">Human Hauler ( 9 or 14 seater tempu etc)</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-1-4" value="Paddle Rickshaw" >
                        <p class="text">Paddle Rickshaw</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-1-5" value="Auto Rickshaw" >
                        <p class="text">Auto Rickshaw</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q97-1-6" value="CNG/taxi" >
                            <p class="text">CNG/taxi</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q97-1-7" value="Personal Car" >
                            <p class="text">Personal Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-1-8" value="Rented or ride sharing Car" >
                        <p class="text">Rented or ride sharing Car</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-1-9" value="Personal 2 wheeler" >
                        <p class="text">Personal 2 wheeler</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-1-10" value="Ride sharing 2 wheeler" >
                        <p class="text">Ride sharing 2 wheeler</p>
                    </label>
                    <label class="label">
                        <input type="checkbox"  name="q97-1-11" value="Bicycle" >
                            <p class="text">Bicycle</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-1-12" value="Walk" >
                        <p class="text">Walk</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-1-13" value="Train" >
                        <p class="text">Train</p>
                    </label>
                    <label class="label">
                    <input type="checkbox"  name="q97-1-14" value="Other" >
                        <p class="text">Other</p>
                    </label>


                </div> 
            </div>



            <!-- Q98 -->
            <div class="Q">
                <p><span class="q_no">Q98: </span> <h3>End Time</h3>
                    (approximately when you arrived at destination)</p>
                <input type="time" name="q98">
            </div>

            <!-- Q99 -->
            <div class="Q">
                <p><span class="q_no">Q99: </span> Accompanied by </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio" name="q99" value="Alone">
                        <p class="text">Alone</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q99" value="1 person">
                        <p class="text">1 person</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q99" value="2 persons">
                        <p class="text">2 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q99" value="3 persons">
                        <p class="text">3 persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q99" value="3+ persons">
                        <p class="text">3+ persons</p>
                    </label>
                    <label class="label">
                        <input type="radio" name="q99" value="" checked="">
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
                         <input type="radio"  name="q99_1" value="0-5 mins" >
                             <p class="text">0-5 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q99_1" value="5-10 mins" >
                            <p class="text">5-10 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q99_1" value="10-15 mins" >
                            <p class="text">10-15 mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q99_1" value="15-20 mins" >
                           <p class="text">15-20 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q99_1" value="20-30 mins" >
                            <p class="text">20-30 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q99_1" value="30-45 mins" >
                            <p class="text">30-45 mins</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q99_1" value="45+ mins" >
                            <p class="text">45+ mins</p>
                    </label>
                    <label class="label">
                       <input type="radio"  name="q99_1" value="" checked="">
                           <p class="text">null</p>
                    </label>
                    </div> 
            </div>
            <!-- Q100 -->
            <div class="Q">
                <p><span class="q_no">Q100: </span><h3>Trip Cost (BDT)</h3>
                    Write down the total amount of cost to make this trip, for example you have taken a rickshaw from your home that cost you 30 taka, and arrived at a bus station from there you used human hauler which cost you 10 taka to travel to another place and finally walked to your final destination so your trip cost is total 40 taka. </p>
                <input type="text" name="q100">
            </div>
            <div class="Q">
                <p><span class="q_no">(Optional): </span>Additional Information</p>
                <input type="text" name="q102">
            </div>

            <!-- Q101 -->
            
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentabto('section11','section10')" href="#head_start">Previous</a>
                
            </div>
            
        </div>
        <br><br>
        <p><span class="must">Note:</span><em>  If no other trip is made by the person, you can submit or else press next.</p></em>
        <div class="Q">
                <p><span class="q_no">Q: </span> Have more household member?<span class="must">*</span>  </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q101" value="Yes" required>
                             <p class="text">Yes</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q101" value="No" required>
                            <p class="text">No</p>
                   </label>
                </div> 
            </div>
        
        <button type="submit" class="submit final">Submit</button>
    </div>
    </form>
    <script>
        function opentabto(current,toop){
            document.getElementById(current).classList.remove("active");
            document.getElementById(toop).classList.add("active");
            document.getElementById('to').innerHTML="";
    }
    function opentab(current, toop, qs) {
    qs = qs.split(",");
        var allQuestionsAnswered = true; // Global flag for all questions
        var unselectedQuestions = []; // Collect unselected questions

        for (var x = 0; x < qs.length; x++) {
            if (qs[x]!="q25"){
            var fq = false;
            var rad = document.getElementsByName(qs[x]);
            for (var i = 0; i < rad.length; i++) {
                if (rad[i].checked) {
                    fq = true; // Question is answered
                    break;
                }
            }}
            else{
                if(document.getElementById("q25").value == ""){
                    fq=false;
                }
                else{
                    fq=true;}
            }

            if (!fq) {
            allQuestionsAnswered = false; // Set global flag
            unselectedQuestions.push(qs[x]); // Add unselected question name
        }
       
    }
    if (allQuestionsAnswered) {
        opentabto(current, toop); // Proceed only if all questions are answered
    }
    else{
         document.getElementById('to').innerHTML=`Please select the following questions: ${unselectedQuestions.join(", ")}`;
        
    }
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