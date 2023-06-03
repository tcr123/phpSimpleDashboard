<html>
    <head>
        <title>My first PHP Website</title>
    </head>
    <?php
    session_start();       //starts the session
    if($_SESSION['user']){ // checks if the user is logged in  
    }
    else{
        header("location: index.php"); // redirects if user is not logged in
    }
    $user = $_SESSION['user']; //assigns user value
    ?>
    <body>
        <h2>Home Page</h2>
        <p>Hello <?php Print "$user"?>!</p> <!--Display's user name-->
        <a href="logout.php">Click here to go logout</a><br/><br/>
        <a href="home.php">Return to home page</a>
        <h2 align="center">Currently Selected</h2>
        <table border="1px" width="100%">
	    	<tr>
		    	<th>Id</th>
			    <th>Details</th>
			    <th>Post Time</th>
			    <th>Edit Time</th>
			    <th>Public Post</th>
		    </tr>
            <?php
                $id_exists = true;
                $id = $_GET['id'];
                if(!empty($id))
                {
                    $id = $_GET['id'];
                    $_SESSION['id'] = $id;
                    $dbh =  mysqli_connect("localhost", "root","1234") or die(mysqli_connect_error($dbh));          //Connect to server
                    mysqli_select_db($dbh, "first_db") or die("Cannot connect to database"); //Connect to database
                    $query = mysqli_query($dbh, "Select * from list");      // SQL Query
                    $count = mysqli_num_rows($query);
                    if($count > 0)
                    {
                        while($row = mysqli_fetch_array($query))
                        {
                            $query = mysqli_query($dbh, "Select * from list"); // SQL Query
                            $count = mysqli_num_rows($query);
                            if($count > 0)
                            {
                                while($row = mysqli_fetch_array($query))
                                {
                                    Print "<tr>";
                                        Print '<td align="center">' . $row['id'] . "</td>";
                                        Print '<td align="center">' . $row['details'] . "</td>";
                                        Print '<td align="center">' . $row['date_posted'] . " - " . $row['time_posted']."</td>";
                                        Print '<td align="center">' . $row['date_edited'] . " - " . $row['time_edited']."</td>";
                                        Print '<td align="center">' . $row['public'] . "</td>";
                                    Print "</tr>";
                                 }
                             }
                             else
                             {
                                 $id_exists = false;
                             }
                        }
                    }
                }
            ?>
        </table>      
        <br/>

        <?php
            if($id_exists)
            {
                Print '
                <form action="edit.php" method="post">
                    Enter new detail: <input type="text" name="details"/><br/> 
                    public post? <input type="checkbox name="public[]" value="yes"/><br/> 
                    <input type="submit" value="Update List"/> 
                </form> 
                '; 
            }
            else
            {
                Print '<h2 align="center">There is not data to be edited.</h2>';
            } 
         ?>
    </body>
</html>

<?php
   if($_SERVER['REQUEST_METHOD'] == "POST")
   {
      $dbh = mysqli_connect("localhost", "root", "1234") or die (mysqli_connect_error());    //Connect to server
      mysqli_select_db($dbh, "first_db") or die ("Cannot connect to database");//Connect to database
      $details = mysqli_real_escape_string($dbh, $_POST['details']);
      $public = "no";
      $id = $_SESSION['id'];
      $time = strftime("%X"); //time
      $date = strftime("%B %D, %Y"); //date

      foreach($_POST['public'] as $list)
      {
         if($list != null)
         {
            $public = "yes";
         }
      }
      mysqli_query($dbh, "UPDATE list SET details='$details',
      public='$public', date_edited='$date', time_edited='$time' WHERE id='$id'");
      header("location:home.php");
   }
?>