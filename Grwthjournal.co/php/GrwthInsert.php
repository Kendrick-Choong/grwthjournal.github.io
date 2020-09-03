<?php
/*  Application: Grwth Insert File
 *  Script Name: GrwthInsert.php
 *  Description: inserts basic form data into a SQL database.
 *  Last Change/Update: 09/02/2020
*/

 // Try and test the SQL to see if it will insert since the inputs may not all be simple number or text boxes. They could be a bunch of radio buttons. Also look into using the isset function to validate any empty radio button thingies like freq_journal or journal_type. //
  $con = mysqli_connect('localhost:3306','aismarth_inonly','INonlyPassword');
  if(!$con){
    echo "Not connected to server";
  }

  if(!mysqli_select_db($con,'test_database')){
    echo "Database not selected";
  }




      $journal_type_like = $_POST['journal_type_like'];
      $freq_journal = $_POST['freq_journal'];
      $checkbox = $_POST['journaltype'];
      $journal_number = $_POST['journal_number'];
      $comfort_level = $_POST['comfort_level'];
      $comfort_level2 = $_POST['comfort_level2'];
      $additional_comments = $_POST['additional_comments'];
      $journal_type = "";

      if(isset($_POST['submit'])){
        foreach($checkbox as $checkboxresult){
          $journal_type.=$checkboxresult.",";
        }
      }

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

      $sql = "INSERT INTO grwth_test(journal_type_like,freq_journal,journal_type_exp,prev_journal_num,comfort_with_journal,comfort_with_journal_v2,comments, ip_address)
              VALUES ('$journal_type_like','$freq_journal','$journal_type','$journal_number','$comfort_level','$comfort_level2','$additional_comments','$ip_address')";

      if(!mysqli_query($con,$sql)){
        echo 'Not Inserted';
      } else {
        echo 'Inserted';
      }

// '<script>alert("Not Inserted")</script>';
// '<script>alert("Inserted")</script>';
  header("refresh:2; url = grwthjournal.co");
  mysqli_close($con);
?>
