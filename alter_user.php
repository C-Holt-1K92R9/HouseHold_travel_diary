<?php
require "0_config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['alter_user'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $number=$_POST['number'];
        $uid=$_POST['userid'];
        $pass=password_hash($_POST['pass'] , PASSWORD_DEFAULT);
        $status=$_POST['status'];  
    
        if ($_POST['alter_user']=='Add User'){
            $user_id="";
            $check_t=$conn->query("SELECT user_id from user order by user_id DESC limit 1");
            $check= $check_t->fetch_assoc();
            if($check["user_id"]<10){
            $user_id="0".strval($check["user_id"]+1);}
            else{
                $user_id=strval($check["user_id"]+1);
            }
    
          $conn->query("INSERT INTO user (user_id, password, email, phone_number, name, is_verified, status) 
                           VALUES ('$user_id', '$pass', '$email', '$number', '$name', '1', '$status')");
            header("Location: admin_dash.php?type=users&msg=Successfully added $name!");
        }
        
        else if($_POST['alter_user']=='Edit User'){
          $conn->query("UPDATE user
          SET email='$email',
              phone_number='$number',
              name='$name',
              status='$status'
              where user_id='$uid'");
              if ($_POST['pass']){
                    $conn->query("UPDATE user
                    SET password='$pass'
                    where user_id='$uid'");
              }
            header("Location: admin_dash.php?type=users&msg=Changes saved for $name!");
        }
        else {
          // Ensure a safe user ID
              $uid = $conn->real_escape_string($uid);

              // Start a transaction
              $conn->begin_transaction();

              try {
                  // Delete related records from other tables
                  $conn->query("DELETE FROM house_member_travle_info WHERE member_id LIKE '$uid%'");
                  $conn->query("DELETE FROM household_info WHERE house_id LIKE '$uid%'");
                  $conn->query("DELETE FROM aggriment WHERE house_id LIKE '$uid%'");
                  $conn->query("DELETE FROM vehicle_info WHERE house_id LIKE '$uid%'");

                  // Finally, delete the user
                  $conn->query("DELETE FROM user WHERE user_id = '$uid'");

                  // Commit the transaction
                  $conn->commit();

                  
              } catch (Exception $e) {
                  // Rollback transaction in case of an error
                  $conn->rollback();
                  echo "Error deleting user: " . $e->getMessage();
              }


          header("Location: admin_dash.php?type=users&msg=User and all associated data deleted successfully!");

        }
      }
    
    }

?>