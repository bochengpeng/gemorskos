<?php

session_start(); // Start the session

if(isset($_GET['page'])){
    //If GET is present -> include that page
    include($_GET['page'].".php");

    // Display logout message
    echo "<p>You have successfully logged out.</p>";
    echo "<a href='login.php'>Click here to log in</a>";
} elseif (isset($_SESSION['loggedin'])) {
    // If the user is logged in, provide a link to log out
    echo "<p>Are you sure to log out?</p>";
    echo "<a href='?page=logout'>Click here to log out</a>";
} else {
    // If the user is not logged in, show login form
    echo "<p>You have not logged in, please log in first</p>";
    include("login.php");
}
?>
