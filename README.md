# HouseHold_travel_diary


**About**

This project is purely constructed with HTML, CSS, PHP and MYSWQL.
A survey was being done for a Thesis and this is the web-based survey form for the survey, which is specificly made for this theisis research.

# Architecture of this web-based survey form

The architecture of the web-based survey management system designed for efficient data collection and administration. The system operates through two distinct user roles: the Surveyor, who is responsible for field data entry via a user interface that communicates with a central Web Server, and the admin, who possesses comprehensive oversight privileges. Data submitted by surveyors, including consent forms, household information, member details, travel history, and vehicle data, is processed by the web server and stored in a structured Database. A critical security feature of this design is that surveyors can only view and modify the data that they have personally collected, ensuring strict data segregation between field agents. In contrast, the admin can manage surveyor accounts, view all submitted data, monitor the overall survey status, export data as CSV, and review bug reports. This architecture establishes a clear, role-based workflow with robust access controls, ensuring data integrity from collection to analysis while facilitating system maintenance through user feedback channels.

# Description of the web-based form and its features:

In this web-based form, hired surveyors were required to create a verified account. While creating an account, their email addresses were verified through a automated confirmation email sent from the server. After verifying they were good to go. Again, after logging in, at the home page there is a quick status dashboard, from where the surveyors can see how many houses they have surveyed that day, and the cumulative count of the surveys as well as how many members they surveyed that day and cumulative count of surveyed household members. 

The web-based survey form is designed to have an optimal performance throughout a plethora of smart devices regardless of their OS (operating system) versions or type of device. As the BYOD system is being implemented, the web page file size was kept under 100kb (each PHP/HTML file) to deliver the web page even with a low bandwidth reducing the wait time on the client side. The front-end was kept simple using basic HTML and CSS. Logic was handled on the server with PHP to deliver this simple code, which helped reduce the client-side rendering time and processing power to a minimum. Moreover, employing readily available web browsers on existing devices significantly reduced the expenditure associated with procuring dedicated survey equipment. For hosting the website, to minimize the hosting cost a shared web hosting service was bought and simplified logic was implemented to process the data for storing them in the database.

  At some point of the survey, the address of the house that is being surveyed and the locations that were visited by the household members were needed for the completion of the survey. Again, bearing in mind the goal of minimizing the cost, “OpenStreetMap” Api was used for fetching the latitude and longitude of the desired locations. Which is an open-source map database that is free to use. Integrating this into the web-based form helped the surveyors to get the exact location of the house and the visited locations, pinpointing them with great accuracy.
 
# About the Survey:
* The survey is conducted for the M.Sc Thesis titled “Modeling Urban Mobility in Chattogram: A Comparative Analysis of Traditional and Machine Learning Approaches.” by Kamol Debnath Dip, Lecturer, CE, CUET. The research aims to understand how people in Chattogram travel within the city.

* We are collecting data on travel patterns and household demographics through brief interviews with residents. This information will be used to develop and compare different models for predicting travel behavior in Chattogram, which can help city planners improve transportation systems.

**Personal comment:** My First official project that was utilized for a research research. Doing this project, I learned a lot aboout web development. Huge thanks to *"Kamol Debnath Dip*, *Lecturer of CUET"*.
