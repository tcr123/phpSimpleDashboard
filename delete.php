<?php
    session_start(); //starts the session
    if($_SESSION['user']){           //checks if user is logged in
    }
    else {
       header("location:index.php"); //redirects if user is not logged in.
    }

    if($_SERVER['REQUEST_METHOD'] == "GET")
    {
       $dbh = mysqli_connect("localhost", "root", "1234") or die(mysqli_connect_error($dbh));     //connect to server
       mysqli_select_db($dbh, "first_db") or die("cannot connect to database"); //Connect to database
       $id = $_GET['id'];
       mysqli_query($dbh, "DELETE FROM list WHERE id='$id'");
       header("location:home.php");
    }
?>