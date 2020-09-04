<?php
/*  Application: Grwth Login Insert File
 *  Script Name: GrwthLoginInsert.php
 *  Description: Inserts basic login data into a SQL database.
 *  Last Change/Update: 08/26/2020
*/

  $con = mysqli_connect('localhost:3306','aismarth_login','grwthlogin');

  if(!$con){
    echo "Not connected to server";
  }

  if(!mysqli_select_db($con,'aismarth_grwth')){
    echo "Database not selected";
  }

  $username = $_POST['username'];
  $password = $_POST['password'];

  //whether ip is from share internet
  if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
      $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    }
  //whether ip is from proxy
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
      $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
  //whether ip is from remote address
  else
    {
      $ip_address = $_SERVER['REMOTE_ADDR'];
    }

  $sql = "INSERT INTO grwth_login(username,password,ip_address)
          VALUES ('$username','$password','$ip_address')";

  if(!mysqli_query($con,$sql)){
    echo 'Not Inserted';
  } else {
    echo 'Inserted';
  }

  header("refresh:2; url = promptTemplate.html");
  mysqli_close($con);
?>
