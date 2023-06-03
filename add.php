<?php
    session_start();
    if($_SESSION['user']){
    }
    else{ 
       header("location:index.php");
    }

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
       $dbh = mysqli_connect("localhost","root","1234") or die(mysqli_error($dbh));       //Connect to server
       mysqli_select_db($dbh, "first_db") or die("Cannot connect to database"); //Connect to database
    
       $details = mysqli_real_escape_string($dbh, $_POST['details']);
       $time = strftime("%X"); //time
       $date = strftime("%B %d, %Y"); //date
       $decision = "no";

       foreach($_POST['public'] as $each_check)                          //gets the data from                                                         //the checkbox
       {
          if($each_check != null){ //checks if checkbox is checked
             $decision = "yes"; // sets the value
          }
       }

       mysqli_query($dbh, "INSERT INTO list(details, date_posted, time_posted, public) VALUES ('$details','$date','$time','$decision')"); //SQL query
       header("location:home.php");
    }
    else
    {
       header("location:home.php"); //redirects back to home
    }
?>