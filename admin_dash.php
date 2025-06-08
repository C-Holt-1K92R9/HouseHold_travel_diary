<?php
require "0_config.php";
$msg=$_GET['msg']?? '';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_id']!="00" ){
  header("Location: index.php");
  exit();
}

date_default_timezone_set('Asia/Dhaka');
$show = $_GET['type'] ?? null;
if ($show===null){
  $show="home";
}
$id=$_SESSION['user_id'];
$today=strval(date('-d.m.y'));
$sid="";
$edit='Add User';
$status='';
$deletebtn='none';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sid=$_POST['sid'];
    $deletebtn='block';
    $user_info=($conn->query("SELECT * from user where user_id='$sid'"))->fetch_assoc();
    if (isset($user_info['status'])){
      $status=$user_info['status'];
    }
    if (isset($_POST['edit_user'])){  
      $edit=$_POST['edit_user'];
    }
}

$Surveyor=($conn->query("SELECT * from user"))->fetch_all(MYSQLI_ASSOC);
$today_count=($conn->query("SELECT count(*) as count from aggriment where house_id like '%$today%'"))->fetch_assoc();
$all_count=($conn->query("SELECT count(*) as count from aggriment"))->fetch_assoc();
$person_count_today=($conn->query("SELECT count(*) as count from house_member_travle_info where member_id like '%$today%'"))->fetch_assoc();
$person_count=($conn->query("SELECT count(*) as count from house_member_travle_info"))->fetch_assoc();


$houses = ($conn->query("SELECT * from household_info where house_id like '$sid-%' order by serial_id DESC"))->fetch_all(MYSQLI_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
            * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
          }
          input[type="text"],
          input[type="email"],
            input[type="password"],
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
          body {
            font-family: Arial, sans-serif;
            display:flex;
            flex-direction: column;
            height: 100vh;
            color: #ffffff;
            background-color:#090d10;
            overflow: auto;
          }
          .radio-input label {
                display: flex;
                align-items: center;
                justify-content:center;
                gap: 20px;
                padding: 0px 10px;
                width: 220px;
                cursor: pointer;
                height: 50px;
                position: relative;
            }

            .radio-input .label input[type="option"] {
                width: 17px;
                height: 17px;
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
            color:white;
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
          .radio-input label {
                display: flex;
                flex-direction: column;
                gap: 15px;
                padding: 0px 10px;
                width: 220px;
                cursor: pointer;
                height: 50px;
                position: relative;
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
            input[type="text"],
            input[type="email"],
            input[type="password"],
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
<body >
    
<div class="dashboard">
            <div class="sidebar" id="sidebar">
              
              <h2>Dashboard</h2>
              <nav>
                <button class="butn" onclick="window.location.href='admin_dash.php?type=home'"><h3>Home</h3></button>
                <button class="butn" onclick="showTab('edit-part1')"><h3>Export Data</h3></button>
                <button class="butn" onclick="showTab('submissions')"><h3>Submissions</h3></button>
                <button class="butn" onclick="showTab('users')"><h3>Users</h3></button>
                <button class="butn" onclick="window.location.href='report_admin.php'"><h3>Reports</h3></button>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <button class="log_out" onclick="log_out()"><h3>Log Out</h3></button>
              </nav>
              
            </div>
    
  <div class="content" >
              <div class="header">
                    <img onclick="showTab('personal-info')" class="imag"  src="profile.png">
                    <button class="menu-btn" onclick="toggleSidebar()" ><h2>☰ Menu</h2></button>
              </div>
    <div onclick="closesidebar()">

      <br><br><br>
      
      <div id="home" class="tab">
      <h1>Welcome <?= $_SESSION['name']?></h1> <br><br>
              <div class="Q">
                  <h1>Survey Status</h1><br>
                  <p>Total Surveyor: <br><br> <div class="Q"> <?= count($Surveyor)-2 ?></div></p>
                  <p>Total survey done today: <br><br> <div class="Q"> <?= $today_count['count'] ?></div></p>
                  <p>Total survey: <br><br> <div class="Q T"><?= $all_count['count'] ?></div></p>
                  <p>Total member surveyed today:<br><br> <div class="Q T"> <?= $person_count_today['count'] ?></div></p>
                  <p>Total member surveyed:<br><br> <div class="Q T"> <?= $person_count['count'] ?></div></p>
                  <button class="form" onclick="openform()"><h2>Go to Form</h2></button>
              </div>
        </div>
      
        <!--end of home-->
      <div id="edit-part1" class="tab">
            <h1>Export tables to Excel</h1>
              <form action="export.php" method="POST">
                        <div class="Q">
                          <label for="table_name">Select User: <br><br>
                              <select name="sid" class="label Qit" required>
                                  <div class="radio-input Qit">
                                  <option class="Qit" value="all" selected>All</option>
                                    <?php foreach ($Surveyor as $sv): ?>
                                      <option class="Qit" value="<?=$sv['user_id']?>" <?= $sid === $sv['user_id'] ? 'selected' : '' ?>><?= $sv['user_id'].": ".$sv['name'] ?></option>
                                      <?php endforeach; ?>
                                  </div>
                              </select>
                          </label>
                      </div>


                      <div class="Q">
                          <label for="table_name">Select Information Type: <br><br>
                              <select name="table_name" class="label Qit" required>
                                  <div class="radio-input Qit">
                                    <option class="Qit" value="user">User data</option>
                                      <option class="Qit" value="aggriment" >Aggrement (Q1-Q2)</option>
                                      <option class="Qit" value="household_info" selected>Household Information (Q3-Q10)</option>
                                      <option class="Qit" value="vehicle_info">Vehicle Information (Q11-Q23)</option>
                                      <option class="Qit" value="house_member_travle_info">House Member Travel Information (Q24-Q101)</option>
                                  </div>
                              </select>
                          </label>
                          <button type="submit" class="form">Download</button>
                      </div>
              </form>
        </div>
        <!--end of download-->

              <div id="personal-info" class="tab">
                    <div class="Q">
                        <h2>Personal Info</h2><br><br>
                        <p>Surveyor Name: <br><br> <div class="Q T"><?= $_SESSION['name'] ?></div> </p>
                        <p>Surveyor ID: <br> <br><div class="Q T"><?= $_SESSION['user_id'] ?></div> </p>
                        <p>Surveyor phone Number: <br><br> <div class="Q T"><?= $_SESSION['phone_number'] ?></div> </p>
                        <p>Surveyor email: <br><br> <div class="Q T"><?= $_SESSION['email'] ?></div> </p>
                    </div>
              </div>
          <!--end of personal info-->
              <div id="submissions" class="tab">
                    <h1>Submissions</h1>

                        <form action="admin_dash.php?type=submissions" method="POST">
                        <div class="Q">
                          <label for="table_name">Select User: <br><br>
                              <select name="sid" class="label Qit" required>
                                  <div class="radio-input Qit">
                                    <?php foreach ($Surveyor as $sv): ?>
                                      <?php  $cid=$sv['user_id'];
                                      $ctc=$cid.$today;
                                        $count_sv=($conn->query("SELECT count(*) as countsv from aggriment where house_id like '$cid%'"))->fetch_assoc(); 
                                        $today_count_serv=($conn->query("SELECT count(*) as counttoday from aggriment where house_id like '$ctc%'"))->fetch_assoc();
                                        ?>
                                      <option class="Qit" value="<?=$sv['user_id']?>" <?= $sid === $sv['user_id'] ? 'selected' : '' ?>><?= $sv['user_id'].": ".$sv['name'].' ('.$count_sv['countsv'].')' .' { Today : '.$today_count_serv['counttoday'].' }'?></option>
                                      <?php endforeach; ?>
                                  </div>
                              </select>
                          </label>
                          <button type="submit" class="form">View</button>
                      </div>
                        </form>

                      <?php foreach ($houses as $house): ?>
                      <?php 
                        $hid=$house['house_id'];
                        $members = ($conn->query("SELECT * from house_member_travle_info where member_id like '$hid%' order by member_id DESC"))->fetch_all(MYSQLI_ASSOC); 
                        ?> 
                          <div class="Q">
                          <h2>House ID: <?= $house['house_id'] ?></h2><br> <button class="edit" style="width:100%;" onclick="edithouse('<?= $hid ?>')"><p>Edit House Information</p></button> <br>
                          <form action="delete_form.php" method="POST" onsubmit="return confirm('Deleting house information will delete everything associated with this house ID. Are you sure you want to delete this?');">
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
                                <button class="edit" onclick="editmember('<?= $member['member_id']?> ')"><p>Edit</p></button>
                                  </div>
                                  
                                  <?php endforeach; ?>

                                  <button onclick="window.location.href = 'trip_form.php?type=<?=$house['house_id']?>';" class="edit"  style=" width:100%;" >Survey More Member</button>
                          </div>
                          <?php endforeach; ?>
              </div>
             <!--end of submission--> 
              <div id="users" class="tab">
              <h3 style="color:green;"><?= $msg ?></h3><br>
                  <form action="admin_dash.php?type=users" method="POST">
                    <input type="hidden" name="edit_user" value="Edit User">
                  <div class="Q">
                          <label for="table_name">Select User: <br><br>
                              <select name="sid" class="label Qit" required>
                                  <div class="radio-input Qit">
                                    <?php foreach ($Surveyor as $sv): ?>
                                      <option class="Qit" value="<?=$sv['user_id']?>" <?= $sid === $sv['user_id'] ? 'selected' : '' ?>><?= $sv['user_id'].": ".$sv['name'] ?></option>
                                      <?php endforeach; ?>
                                  </div>
                              </select>
                          </label>
                          <button type="submit" class="form">View</button>
                      </div>
                  </form>

                  <form action="alter_user.php" method="POST">
                  
                      <div class="Q">
                      <label for="label Qit">
                        <input type="hidden" name="alter_user" id="process_user" value="<?=$edit?>">
                        <input type="hidden" name="userid" id="process_user" value="<?=isset($user_info['user_id']) ? $user_info['user_id'] : '' ?>">
                        <input id="name" class="Qit" type="text" name="name" placeholder="Name" value='<?=isset($user_info['name']) ? $user_info['name'] : '' ?>'>
                        <input id="number" class="Qit" type="number" name="number" placeholder="Phone Number" value='<?= isset($user_info['phone_number']) ? $user_info['phone_number'] : '' ?>'>
                        <input id="email" class="Qit" type="email" name="email" placeholder="Email" value='<?=isset($user_info['email']) ? $user_info['email'] : '' ?>'>
                        <input id="pass" class="Qit" type="password" name="pass" value="" placeholder="Password">
                        <select class="label Qit" name="status" id="stat" placeholder="Status">
                          <option id="op" class="Qit" value="1" <?=$status==1 ? 'selected' : '' ?>>Active</option>
                          <option class="Qit" value="0" <?=$status==0 ? 'selected' : '' ?>>Deactive</option>
                        </select>
                        
                        </label>
                        <a class="form" style="width:40%; height:40px; background-color:red;" onclick="clearslc()">Clear</a> <br><br>
                        <button type="submit" class="form" id="edit-btn" ><?=$edit?></button>

                        </div>
                     
                  </form>
                  <form action="alter_user.php" method="POST">
                  <input type="hidden" name="userid" id="process_user" value="<?=isset($user_info['user_id']) ? $user_info['user_id'] : '' ?>">
                  <input type="hidden" name="alter_user" id="delete_user">
                  <button type="submit" class="form" id="delete_btn"
                onclick="return confirm('Are you sure you want to delete this user? This action will delete all associated data in other tables as well!')"
                style="background-color:#ff4d4d; margin-left: 10px; display:<?=$deletebtn?>">
            Delete User
        </button>
                  </form>
                
              </div>
    </div>
</div>

  <script>
    function clearslc(){
      document.getElementById("process_user").value='Add User';
      document.getElementById("name").value='';
      document.getElementById("number").value='';
      document.getElementById("email").value='';
      document.getElementById("pass").value='';
      document.getElementById("stat").value=1;
      document.getElementById('edit-btn').innerHTML="Add User";
      document.getElementById('delete_btn').style.display='none';

    }
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
