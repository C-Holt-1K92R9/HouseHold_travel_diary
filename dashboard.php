<?php
require "0_config.php";

//=================================================================================
session_start();
if (!isset($_SESSION['user_id'])){
  header("Location: index.php");
}
else if($_SESSION['user_id']=='00' || $_SESSION['user_id'] === '000'){
  header("Location: admin_dash.php");
}
date_default_timezone_set('Asia/Dhaka');

$show = $_GET['type'] ?? null;
if ($show===null){
  $show="home";
}

$current_date=strval(date('-d.m.y'));
$id=$_SESSION['user_id'];
$today=$id.$current_date;

$today_count=($conn->query("SELECT count(*) as count from aggriment where house_id like '$today%'"))->fetch_assoc();
$today_person_count=($conn->query("SELECT count(*) as count from house_member_travle_info where member_id like '$today%'"))->fetch_assoc();
$all_count=($conn->query("SELECT count(*) as count from aggriment where house_id like '$id%'"))->fetch_assoc();
$person_count=($conn->query("SELECT count(*) as count from house_member_travle_info where member_id like '$id%'"))->fetch_assoc();


$houses = ($conn->query("SELECT * from household_info where house_id like '$id-%' order by serial_id DESC"))->fetch_all(MYSQLI_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel Diary Dashboard</title>
  <style>
            * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
          }
          .green-button {
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
            padding: 10px 20px; /* Padding */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 16px; /* Font size */
          }

          .green-button:hover {
            background-color: #45a049; /* Darker green on hover */
          }
          body {
            font-family: Arial, sans-serif;
            display:flex;
            flex-direction: column;
            height: 100vh;
            color: #ffffff;
            background-color:#090d10;
            overflow: auto;
          }
          .form{
            padding: 10px 15px;
            width:100%;
            height:50px;
            background-color: #3cb371;
            border: none;
            color: #fff;
            border-radius: 10px;
            cursor: pointer;
          }
        .Q{
            border-radius: 10px;
            padding: 20px;
            background-color:#1d1d21;
            box-shadow: 0 0 10px #fcfcfd;
            margin-bottom:25px;
            
        }
        .Qit{
          gap:10px;
            display:flex;
            justify-content:center;
            align-items:center;
            border-radius: 10px;
            padding: 20px;
            background-color:#1d1d21;
            box-shadow: 0 0 10px #fcfcfd;
            margin-bottom:25px;
            
        }


        .header{
            position: sticky;
            top: 3%;
            display: flex;
            justify-content: space-between;

        }
        .imag{
            cursor: pointer;
            width: 60px;
        }

          .dashboard {
            display: flex;
            width: 100%;
          }
          
          .sidebar {
            width: 200px;
            background-color: rgba(30, 30, 46, 0.15); /* Semi-transparent background */
            color: #f0f0f0;
            padding: 20px;
            position: relative;
            backdrop-filter: blur(10px); /* Adds blur effect */
            transition: right 0.3s;
            z-index: 1;
          }
          
          .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            color:#fffffe;
          }
          /* Buttons */
          .log_out{
            font-size: 20px;
            display: block;
            width: 80%;
            padding: 10px;
            margin: 5px 0;
            background-color:#16161a4e;
            border: solid #ff0000;
            color: #f8f8f2;
            cursor: pointer;
            text-align: left;
            border-radius: 5px;
        }
        .log_out h3{
          text-align: center;
        }
          .butn {
            text-align: center;
            font-size: 20px;
            display: block;
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            background-color:#16161a4e;
            border: solid #fefefe;
            color: #f8f8f2;
            cursor: pointer;
            text-align: left;
            border-radius: 5px;
          }
          .sidebar nav button h3{
            text-align: center;
          }
          .edit {
            font-size: 20px;
            display: block;
            padding: 10px;
            margin: 5px 0;
            background-color:#16161a4e;
            border: solid #3cb371;
            color: #f8f8f2;
            cursor: pointer;
            text-align: center;
            border-radius: 10px;
          }
          .edit p{
            
            text-align: center;
          }
          .edit:hover{
            background-color:#3cb371;
            border: solid #fff;
            color: #000;
          }
          /* Buttons */

          .sidebar nav button:hover {
            background-color: #3cb371;
          }
          .sidebar nav button:after {
            background-color: #2b8a56;
          }
          .content {
            flex-grow: 1;
            padding: 20px;
          }
          
          .tab {
            display: none;
          }
          
          .tab.active {
            display: block;
          }
          
          /* Mobile Styles */
          .menu-btn {
            display: none;
            padding: 10px;
            background-color: #1e1e2e;
            color: #ffffff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
          }
          
          @media (max-width: 1081px) {
            .sidebar {
              position: fixed;
              right: -200px;
              height: 100%;
              z-index: 2;
            }
          
            .sidebar.open {
              right: 0;
            }
          
            .menu-btn {
              display: inline-block;
            }
          
            .content {
            
              padding-top: 50px;
              padding-left: 20px;
              padding-right: 20px;
            }
            .menu{
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
          }
          
  </style>

</head>
<body >
    
  <div class="dashboard">
    <div class="sidebar" id="sidebar">
      
      <h2>Dashboard</h2>
      <nav>
      <button class="butn" onclick="window.location.href='dashboard.php';"><h3>Home</h3></button>
        <button class="butn" onclick="showTab('edit-part1')"><h3>Submissions</h3></button>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <button class="log_out" onclick="log_out()"><h3>Log Out</h3></button>
      </nav>
      
      </div>
    
    <div class="content" >
      <h1>Welcome <?= $_SESSION['name']?></h1>
       <div class="header">
            <img onclick="showTab('personal-info')" class="imag"  src="profile.png">
            <button class="menu-btn" onclick="toggleSidebar()" ><h2>☰ Menu</h2></button>
        </div>
   
    <br><br><br>
    <div onclick="closesidebar()">

      
      <div>
      <div id="home" class="tab">
        <div class="Q">
        <h1>Survey Status</h1><br>
        <p>Total survey done today: <br><br> <div class="Q"> <?= $today_count['count'] ?></div></p>
        <p>Total member surveyed today:<br><br> <div class="Q T"> <?= $today_person_count['count'] ?></div></p>
        <p>Total survey: <br><br> <div class="Q T"><?= $all_count['count'] ?></div></p>
        <p>Total member surveyed:<br><br> <div class="Q T"> <?= $person_count['count'] ?></div></p>
        </div>
        <button class="form" onclick="openform()"><h2>Go to Form</h2></button>
      </div>

      <div id="edit-part1" class="tab">
        <br><br>
            <?php foreach ($houses as $house): ?>
              
              <?php 
                $hid=$house['house_id'];
                $members = ($conn->query("SELECT * from house_member_travle_info where member_id like '$hid%' order by member_id DESC"))->fetch_all(MYSQLI_ASSOC); 
                
                ?> 
              <div class="Q">
               
              <h2>House ID: <?= $house['house_id'] ?></h2><br> <button class="edit" style="width:100%;" onclick="edithouse('<?= $hid ?>')"><p>Edit House Information</p></button> <br>
              <form action="delete_form.php" method="POST" onsubmit="return confirm('Deleting house information will delete everything associated with this house. Are you sure you want to delete this?');">
                <input type="hidden" name="hid" value="<?= $house['house_id'] ?>">
              <button type="submit" class="edit"  style="border: solid red; width:100%;" onclick="confirmdelete('house')"><p>Delete house</p></button>
              </form>
              
                  <?php foreach ($members as $member): 
                    
                    ?>
                      <div class="Qit">
                        <p>Member ID: <?= $member['member_id']?></p>
                        <form action="delete_form.php" method="POST" onsubmit="return confirm('Are you sure, you want to delete this member?');">
                            <input type="hidden" name="mid" value="<?=  $member['member_id'] ?>">
                            <button type="submit" class="edit" style="border: solid red;" onclick="confirmdelete('member')"><p>Delete</p></button>
                        </form>
                        <button class="edit" onclick="editmember('<?= $member['member_id']?> ')" ><p>Edit</p></button>
                      </div>
                      <?php endforeach; ?>
                  <button onclick="window.location.href = 'trip_form.php?type=<?=$house['house_id']?>';" class="edit"  style=" width:100%;" >Survey More Member</button>
              </div>
              
              <?php endforeach; ?>
      </div>
        

            <div id="personal-info" class="tab">
              <div class="Q">
                  <h2>Personal Info</h2><br><br>
                  <p>Surveyor Name: <br><br> <div class="Q T"><?= $_SESSION['name'] ?></div> </p>
                  <p>Surveyor ID: <br> <br><div class="Q T"><?= $_SESSION['user_id'] ?></div> </p>
                  <p>Surveyor phone Number: <br><br> <div class="Q T"><?= $_SESSION['phone_number'] ?></div> </p>
                  <p>Surveyor email: <br><br> <div class="Q T"><?= $_SESSION['email'] ?></div> </p>
                  <button class="green-button" onclick="window.location.href='reset_pass.php? id=<?=$_SESSION['user_id']?>';">Change Password</button>
              </div>
            </div>
      
        </div>
      </div>
</div>

  <script>
    
    
    function editmember(member_ids){
      window.open('edit_trip.php?type='+member_ids, '_parent');
    }

    function edithouse(house_ids){
      window.open('edit_house_form.php?type='+house_ids, '_parent');
    }
    function log_out(){
      window.location.href = "log_out.php";
    }
      function openform(){
        window.location.href = "house_form.php";
      }
      function showTab(tabId) {
        const tabs = document.querySelectorAll('.tab');
        tabs.forEach(tab => {
          tab.classList.remove('active');
        });
        document.getElementById(tabId).classList.add('active');

        // Close sidebar on mobile after selecting a tab
          document.getElementById('sidebar').classList.remove('open');
        
      }

      // Set default tab to 'home'
      showTab('<?= $show ?>');

      function closesidebar(){
        document.getElementById('sidebar').classList.remove('open');
      }
      function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('open');
      }


  </script>
</body>
</html>
