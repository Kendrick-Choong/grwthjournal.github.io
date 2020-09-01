<?php

  $con = mysqli_connect('127.0.0.1','root','');

  if(!$con){
    echo "Not connected to server";
  }

  if(!mysqli_select_db($con,'test_database')){
    echo "Database not selected";
  }

  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $age = $_POST['age'];

  $sql = "INSERT INTO test_table(first_name,last_name,age) VALUES ('$fname','$lname','$age')";

  if(!mysqli_query($con,$sql)){
    echo 'Not inserted';
  } else {
    echo 'Inserted';
  }

  header("refresh:2; url = testform.html");
?>
