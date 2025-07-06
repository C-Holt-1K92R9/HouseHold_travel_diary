<?php
require "0_config.php";
// ========================================================
session_start();
if (!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
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
<div class="container">
    <h2 id="Q11">Survey Form</h2>
    <p><span class="must">* Indicated required questions.</span></p>
    <p>Note: Select <span class="must">"null"</span> if not answered. [For the questions that are not mandatory]</p>
    <h2 class="must" style="font-weight='bold';font-style='italic';" id="to"></h2>
    <form action="house_form_process.php" method="POST">
        <div class="section active" id="section1">
        <h1>Agreement</h1>
        <div class="Q">
            <div id="survey-information" style="font-family: Arial, sans-serif; color: #ffff;">

    <h2>📝Household Travel Survey - Participant Information and Consent</h2>

    <p>
        The survey is conducted for the M.Sc Thesis titled <strong><em>"A COMPARATIVE ANALYSIS OF TRADITIONAL AND ADVANCED PREDICTIVE APPROACHES FOR MODELING URBAN MOBILITY IN CHATTOGRAM."</em></strong> by Kamol Debnath Dip, M.Sc. student, CE, Bangladesh University of Engineering & Technology.
    </p>
    <p>
        The research aims to understand how people in Chattogram travel within the city and how different models perform in predicting travel behavior. We are collecting data on travel patterns and household demographics through brief interviews with residents. This information will be used to develop and compare different models for predicting travel behavior in Chattogram, which can help city planners improve transportation systems.
    </p>

    <hr>

    <h3>🔷What will you be asked to do?</h3>
    <p>
        A trained surveyor will help you complete a questionnaire using a mobile device. You'll be asked questions about:
    </p>
    <ul>
        <li>Your <strong>age, gender, education,</strong> and <strong>occupation</strong></li>
        <li><strong>Household information</strong> like income, housing type, ownership, and home location using a map</li>
        <li><strong>Vehicle information</strong> like vehicle type, fuel type, make model and buying date</li>
        <li><strong>Trips made yesterday</strong> by you and members of your household (including children), such as:
            <ul>
                <li>Where each trip started and ended (using an interactive map)</li>
                <li>When the trip happened</li>
                <li>What transportation modes were used and alternatives</li>
                <li>Trip purpose, cost, and how many people went along</li>
            </ul>
        </li>
    </ul>
    <p>
        The survey will take about <strong>40-50 minutes</strong>.
    </p>

    <hr>

    <h3>🔷Are children included?</h3>
    <p>
        Yes. If a child (under 18) in your household made a trip yesterday, we may ask you to provide some basic travel details for them. If your child is aged <strong>  8 or older </strong>, we also request that you briefly explain the survey to them and ask for their agreement to participate.
    </p>

    <hr>

    <h3>🔷Risks and Benefits</h3>
    <h4><strong>Risks:</strong></h4>
    <p>
        There are <strong>no known physical, psychological, or legal risks</strong> involved in this survey. The questions are about regular daily activities and do not require sharing sensitive or personal identifiers.
    </p>
    <h4><strong>Benefits:</strong></h4>
    <p>
        Although you will not receive direct benefits, your participation will help improve local transportation planning and services. The data may support more efficient public transit systems, safer roads, and better travel options in your community.
    </p>

    <hr>

    <h3>🔷Will your data be safe?</h3>
    <p>
        Yes. All information you provide will be kept <strong>confidential</strong> and used only for research purposes.
    </p>
    <ul>
        <li>Your responses will be stored securely.</li>
        <li>No names or personal identifiers will appear in any reports or publications.</li>
        <li>Location data (like GPS coordinates) will only be used for producing aggregate data summary and will not be linked to individual identities.</li>
    </ul>

    <hr>

    <h3>🔷Is participation voluntary?</h3>
    <p>
        Yes. You can <strong>choose not to participate,</strong> skip any question, or stop the survey at any time without any problem.
    </p>
    
    <hr>
    
    <h3>🔷Whom to contact?</h3>
    <p>
        If you have any questions, please do not hesitate to contact the research team.
    </p>
    <p>
        <strong>Dr. Annesha Enam, Associate Professor</strong><br>
        Department of Civil Engineering, BUET<br>
        Mobile: <a href="tel:+8801730715209" style="color:skyblue;">01730715209</a>; Email: <a href="mailto:annesha@ce.buet.ac.bd" style="color:skyblue;">annesha@ce.buet.ac.bd</a>
    </p>
    <p>
        <strong>Kamol Debnath Dip, M.Sc. Student</strong><br>
        Department of Civil Engineering, BUET<br>
        Mobile: <a href="tel:+8801521301787" style="color:skyblue;">01521301787</a>; Email: 
        <a href="mailto:kamoldebnathdip@gmail.com" style="color:skyblue;">kamoldebnathdip@gmail.com</a> 
        or 
        <a href="mailto:0421042407@ce.buet.ac.bd" style="color:skyblue;">0421042407@ce.buet.ac.bd</a>
    </p>

</div>
        </div>
        <!-- Q1 -->
        <div class="Q">
            <div class="radio-input">
                <p><span class="q_no"><strong>Q1: Consent to participate (adult) </strong></span><br><br>I confirm that I have read and understood the information about this travel survey. I voluntarily 
                            agree to participate and provide information about my own travel behavior.<span class="must">*</span> <br> </p>
                    <label class="label">
                    <input type="radio" name="q1" id="q1" value="I agree" required>
                    <p class="text">I agree</p>
            </div>
              
        </div>
         
        <div class="Q">
            <div class="radio-input">
                <p><span class="q_no"><strong>Q1.1: Parental consent (for child participation) </strong></span><br><br>If you are a parent/guardian, please confirm: 
                                    I understand that travel information about my child(ren) may be collected through me, 
                                    and I give permission for their participation in this study.<span class="must">*</span> <br> </p>
                    <label class="label">
                    <input type="radio" name="q1_1" value=" I give consent for my child(ren)'s participation" required>
                    <p class="text"> I give consent for my child(ren)'s participation</p>
            </label>
            <label class="label">
                    <input type="radio" name="q1_1" value="Not Applicable (If no minor is involved)" required>
                    <p class="text">Not Applicable (If no minor is involved)</p>
                </label>
            </div>
              
        </div>
        
        <div class="Q">
            <div class="radio-input">
                <p><span class="q_no"><strong>Q1.2: Child assent (for age-appropriate children)  </strong></span><br><br>If your child is old enough to understand (e.g., 8–17), please confirm this assent with them: 
                                    “Do you agree to let us ask about your travel yesterday for our research?” 
                                    If they say yes, please confirm below: <span class="must">*</span> <br> </p>
                    <label class="label">
                    <input type="radio" name="q1_2" value="My child gives their assent to participate" required>
                    <p class="text">My child gives their assent to participate </p>
            </label>
            <label class="label">
                    <input type="radio" name="q1_2" value="Not Applicable (If no minor is involved)" required>
                    <p class="text">Not Applicable (If no minor is involved) </p>
                </label>
            </div>
              
        </div>  
        <!-- Q2 -->
        <div class="Q">
        <p><span class="q_no">Q2: </span>Your Mobile Number if you want to attend lucky draw. </p>
        
        <input type="text" id="p_num" name="q2" placeholder="Phone">
        </div> 
        
        <div class="bottom_btn">
            <p></p>
            <a class="next_btn" id ="next_btn" onclick="opentab('section1','section2','q1,q1_1,q1_2')" href="#Q11">Next</a>
        </div>
                
        </div>

        <div class="section" id="section2">
        <h1>Household Information</h1>
        <!-- Q3 -->
        <div class="Q">
        <p><span class="q_no">Q3: </span>Ward NO.<span class="must">*</span> </p>
        
        <input type="number" id="q3" name="q3" placeholder="Ware no."  required>
        
        </div>
        <!-- Q4-->
        <div class="Q">
            <p><span class="q_no">Q4: Home Address</span><span class="must">*</span></p>
            <div>
                <label for="q4_lat">Latitude:</label>
                <input type="number" step="0.000000000000001" id="q4_lat" name="q4_a" required>
                <label for="q4_lng">Longitude:</label>
                <input type="number" step="0.000000000000001" id="q4_lng" name="q4_b" required>
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
                  <input type="radio" name="q5" value="Entered: 1" required>
                  <p class="text">1</p>
                </label>
                <label class="label">
                  <input type="radio" name="q5" value="Entered: 2" required>
                  <p class="text">2</p>
                </label>
                <label class="label">
                    <input type="radio"  name="q5" value="Entered: 3" required>
                    <p class="text">3</p>
                  </label>
                  <label class="label">
                    <input type="radio" name="q5" value="Entered: 4" required>
                    <p class="text">4</p>
                  </label>
                  <label class="label">
                    <input type="radio"  name="q5" value="Entered: 5" required>
                    <p class="text">5</p>
                  </label>
              </div>
              
        </div>
        <!-- Q6 -->
        <div class="Q">
        <p><span class="q_no">Q6: </span>Monthly household Income (BDT) <span class="must">*</span></p>
        <div class="radio-input">
            <label class="label">
              <input type="radio" name="q6" value="<10k" required>
              <p class="text"><10k</p>
            </label>
            <label class="label">
              <input type="radio" name="q6" value="10-25k" required>
              <p class="text">10-25k</p>
            </label>
            <label class="label">
                <input type="radio"  name="q6" value="25-50k" required>
                <p class="text">25-50k</p>
              </label>
              <label class="label">
                <input type="radio" name="q6" value="50-75k" required>
                <p class="text">50-75k</p>
              </label>
              <label class="label">
                <input type="radio"  name="q6" value="75-100k" required>
                <p class="text">75-100k</p>
              </label>
              <label class="label">
                <input type="radio"  name="q6" value="1-2lac" required>
                <p class="text">1-2lac</p>
              </label>
              <label class="label">
                <input type="radio"  name="q6" value=">2lac" required>
                <p class="text">>2lac</p>
              </label>
          </div>
          
        </div>
            <!-- Q7 -->
            <div class="Q">
            <p><span class="q_no">Q7: </span> Home Owned or rented? </p>
            <div class="radio-input">
                <label class="label">
                  <input type="radio" name="q7" value="Owned" >
                  <p class="text">Owned</p>
                </label>
                <label class="label">
                  <input type="radio" name="q7" value="Rented" >
                  <p class="text">Rented</p>
                </label>
                <label class="label">
                    <input type="radio" name="q7" value="" checked="">
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
                      <input type="radio" name="q8" id="q8" value="Yes" onclick="showbtn(true)" required>
                      <p class="text">Yes</p>
                    </label>
                    <label class="label">
                      <input type="radio" name="q8" id="q8" value="No" onclick="showbtn(false)" required>
                      <p class="text">No</p>
                    </label>
                  </div>
                  
            </div>
            <!-- Q9 -->
            <div class="Q">
            <p><span class="q_no">Q9: </span> How many members live in this household?<span class="must">*</span> </p>
            <div class="radio-input">
            <label class="label">
                <input type="radio"  name="q9" value="1" required>
                <p class="text">1</p>
              </label>
              <label class="label">
                <input type="radio"  name="q9" value="2" required>
                <p class="text">2</p>
              </label>
              <label class="label">
                <input type="radio"  name="q9" value="3" required>
                <p class="text">3</p>
              </label>
              <label class="label">
                <input type="radio"  name="q9" value="4" required>
                <p class="text">4</p>
              </label>
              <label class="label">
                <input type="radio"  name="q9" value="5" required>
                <p class="text">5</p>
              </label>
              <label class="label">
                <input type="radio"  name="q9" value="6" required>
                <p class="text">6</p>
              </label>
              <label class="label">
                <input type="radio"  name="q9" value="7" required>
                <p class="text">7</p>
              </label>
              <label class="label">
                <input type="radio"  name="q9" value="7+" required>
                <p class="text">7+</p>
              </label>
                
            </div>
            
            </div>
            <!-- Q10 -->
            <div class="Q">
                <div>
            <p><span class="q_no">Q10: </span> <h3>Travel Date <span class="must">*</span></h3>
                Please select today if your household members have completed all trips of the day or else please select yesterday as travel day and fill out yesterday's information. But trip information of one whole day of the all household members is required for this research. </p>
                <label class="label">
                    <input type="date" id="q10" name="q10" required>
                  </label> 
                </div>
                </div>

                <div class="bottom_btn">
                    <a class="next_btn" onclick="opentabto('section2','section1')" href="#Q11">Previous</a>
                    <a class="next_btn" id="vhcl_page" style="display:block;" onclick="opentab('section2','section3','q3,q4,q5,q6,q8,q9,q10')" href="#Q11">Next</a>
                    <button type="submit" id="submit_nextp" style="display:none;" class="submit_next">Submit & Next</button>
                </div>
            </div>
            <div class="section" id="section3" >
            <h1 >Vehicle Information</h1>
            <!-- Q11 -->
            <div  class="Q">
            <p><span class="q_no">Q11: </span> Vehicle 1 type </p>
            <div class="radio-input">
                <label class="label">
                    <input type="radio"  name="q11" value="Motor Car" >
                        <p class="text">Motor Car</p>  
                </label>
                <label class="label">
                    <input type="radio"  name="q11" value="Motorcycle" >
                        <p class="text">Motorcycle</p>  
                </label>
                <label class="label">
                    <input type="radio"  name="q11" value="Motor Car" >
                        <p class="text">Bicycle</p>  
                </label>
                <label class="label">
                    <input type="radio" name="q11" value="" checked="">
                    <p class="text">null</p>
              </label>  
                </div> 
            </div>

            <!-- Q12 -->
            <div class="Q">
                <p><span class="q_no">Q12: </span> Vehicle 1 fuel type </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q12" value="Petrol/Octane" >
                             <p class="text">Petrol/Octane</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q12" value="Diesel" >
                            <p class="text">Diesel</p>
                   </label>
                   <label class="label">
                    <input type="radio"  name="q12" value="CNG" >
                        <p class="text">CNG</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q12" value="Mixed" >
                            <p class="text">Mixed</p>
                    </label>
                    <label class="label">
                        <input type="radio"  name="q12" value="None" checked="">
                        <p class="text">None</p>
                    </label>
                </div> 
                
            </div>

            <!-- Q13 -->
            <div class="Q">
                <p><span class="q_no">Q13: </span> <h3>Vehicle 1 make model and year</h3>
                    Make model means the name of the company and the name of the car model for example: Honda civic 2000, Toyota corolla 2005, Toyota axio 2008 etc. Please keep blank if it is bicycle </p>
                    <input type="text" name="q13" placeholder="Your Answer">
                </div>

            <!-- Q14 -->
            <div class="Q">
                <p><span class="q_no">Q14: </span><h3> Vehicle 1 buying date </h3>
                    write when the vehicle was bought. Please try to provide accurate information for at least the month and year. </p>
                    <input type="date" name="q14" >
                </div>

            
            <!-- Q15 -->
            <div class="Q">
                <p><span class="q_no">Q15: </span> Vehicle 2 type </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio"  name="q15" value="Motor Car" >
                            <p class="text">Motor Car</p>  
                    </label>
                    <label class="label">
                        <input type="radio"  name="q15" value="Motorcycle" >
                            <p class="text">Motorcycle</p>  
                    </label>
                    <label class="label">
                        <input type="radio"  name="q15" value="Motor Car" >
                            <p class="text">Bicycle</p>  
                    </label>
                    <label class="label">
                        <input type="radio" name="q15" value="" checked="">
                        <p class="text">null</p>
                  </label>  
                    </div> 
                </div>
    
                <!-- Q16 -->
                <div class="Q">
                    <p><span class="q_no">Q16: </span> Vehicle 2 fuel type </p>
                    <div class="radio-input">
                        <label class="label">
                             <input type="radio"  name="q16" value="Petrol/Octane" >
                                 <p class="text">Petrol/Octane</p>
                        </label>
                        <label class="label">
                            <input type="radio"  name="q16" value="Diesel" >
                                <p class="text">Diesel</p>
                       </label>
                       <label class="label">
                        <input type="radio"  name="q16" value="CNG" >
                            <p class="text">CNG</p>
                        </label>
                        <label class="label">
                            <input type="radio"  name="q16" value="Mixed" >
                                <p class="text">Mixed</p>
                        </label>
                        <label class="label">
                            <input type="radio"  name="q16" value="None" checked="">
                            <p class="text">None</p>
                        </label>
                    </div> 
                    
                </div>
    
                <!-- Q17 -->
                <div class="Q">
                    <p><span class="q_no">Q17: </span> <h3>Vehicle 2 make model and year</h3>
                        Make model means the name of the company and the name of the car model for example: Honda civic 2000, Toyota corolla 2005, Toyota axio 2008 etc. Please keep blank if it is bicycle </p>
                        <input type="text" name="q17" placeholder="Your Answer">
                    </div>
    
                <!-- Q18 -->
                <div class="Q">
                    <p><span class="q_no">Q18: </span><h3> Vehicle 2 buying date </h3>
                        write when the vehicle was bought. Please try to provide accurate information for at least the month and year. </p>
                        <input type="date" name="q18" >
                    </div>
    
                    <!-- Q19 -->
            <div class="Q">
                <p><span class="q_no">Q19: </span> Vehicle 3 type </p>
                <div class="radio-input">
                    <label class="label">
                        <input type="radio"  name="q19" value="Motor Car" >
                            <p class="text">Motor Car</p>  
                    </label>
                    <label class="label">
                        <input type="radio"  name="q19" value="Motorcycle" >
                            <p class="text">Motorcycle</p>  
                    </label>
                    <label class="label">
                        <input type="radio"  name="q19" value="Motor Car" >
                            <p class="text">Bicycle</p>  
                    </label>
                    <label class="label">
                        <input type="radio" name="q19" value="" checked="">
                        <p class="text">null</p>
                  </label>  
                    
                    </div> 
                </div>
    
                <!-- Q20 -->
                <div class="Q">
                    <p><span class="q_no">Q20: </span> Vehicle 3 fuel type </p>
                    <div class="radio-input">
                        <label class="label">
                             <input type="radio"  name="q20" value="Petrol/Octane" >
                                 <p class="text">Petrol/Octane</p>
                        </label>
                        <label class="label">
                            <input type="radio"  name="q20" value="Diesel" >
                                <p class="text">Diesel</p>
                       </label>
                       <label class="label">
                        <input type="radio"  name="q20" value="CNG" >
                            <p class="text">CNG</p>
                        </label>
                        <label class="label">
                            <input type="radio"  name="q20" value="Mixed" >
                                <p class="text">Mixed</p>
                        </label>
                        <label class="label">
                            <input type="radio"  name="q20" value="None" checked="">
                            <p class="text">None</p>
                        </label>
                    </div> 
                    
                </div>
    
                <!-- Q21 -->
                <div class="Q">
                    <p><span class="q_no">Q21: </span> <h3>Vehicle 3 make model and year</h3>
                        Make model means the name of the company and the name of the car model for example: Honda civic 2000, Toyota corolla 2005, Toyota axio 2008 etc. Please keep blank if it is bicycle </p>
                        <input type="text" name="q21" placeholder="Your Answer">
                    </div>
    
                <!-- Q22 -->
                <div class="Q">
                    <p><span class="q_no">Q22: </span><h3> Vehicle 3 buying date </h3>
                        write when the vehicle was bought. Please try to provide accurate information for at least the month and year. </p>
                        <input type="date" name="q22" >
                    </div>
            <!-- Q22_1 -->
            <div class="Q">
                    <p><span class="q_no">Q22_1: </span><h3> Driver's Salary in thousands </h3></p>
                        <input type="text" name="q22_1" placeholder="Your Answer" >
                    </div>
            <!-- Q23 -->
            <div class="Q">
                <p><span class="q_no">Q23: </span>Has more than 3 vehicles </p>
                <div class="radio-input">
                    <label class="label">
                         <input type="radio"  name="q23" value="Yes" >
                             <p class="text">Yes</p>

                    </label>
                    <label class="label">
                        <input type="radio"  name="q23" value="No" >
                            <p class="text">No</p>                            
                   </label>
                   <label class="label">
                    <input type="radio" name="q23" value="" checked="">
                    <p class="text">null</p>
                    </label> 
                    </div> 
            </div>
            <div class="bottom_btn">
                <a class="next_btn" onclick="opentabto('section3','section2')">Previous</a>
                <button type="submit" class="submit_next">Submit & Next</button>
            </div>
            
        <!-- Submit a -->
        
    </form>
</div>



<!--Java Script-->
<script>
    function showbtn(show){
        if (show){
            document.getElementById("vhcl_page").style.display='block';
            document.getElementById("submit_nextp").style.display='none';
        }
        else{
            document.getElementById("submit_nextp").style.display='block';
            document.getElementById("vhcl_page").style.display='none';
        }
    }
    function opentabto(current,toop){
            document.getElementById(current).classList.remove("active");
            document.getElementById(toop).classList.add("active");
            const targetElement = document.getElementById("toop");
            document.getElementById('to').innerHTML="";
    }
    function opentab(current, toop, qs) {
    qs = qs.split(",");      
        var allQuestionsAnswered = true; // Global flag for all questions
        var unselectedQuestions = []; // Collect unselected questions

        for (var x = 0; x < qs.length; x++) {
            var fq = false;
            var rad = document.getElementsByName(qs[x]);
            
            if (qs[x]=="q3" || qs[x]=='q10'){
                if(document.getElementById(qs[x]).value === ""){
                    fq = false;
                }
                else{
                    fq=true;
                }
            }
            else if(qs[x]=='q4'){
                if(document.getElementById("q4_lat").value === "" && document.getElementById("q4_lng").value === ""){
                    fq = false;
                }
                else{
                    fq=true;
                }
            }
            
            else{
            for (var i = 0; i < rad.length; i++) {
                if (rad[i].checked) {
                    fq = true; // Question is answered
                    break;
                }
            }}
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
