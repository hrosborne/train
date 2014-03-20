<?php

// includes all functions.
include('functions/function.php');

//creates/resumes the session.
session_start();

// defaults to index view unless a different view is requested.
$view = empty($_GET['view']) ? 'home' : $_GET['view'];

// set useractivity in user table for login autenthentication
user_activity();

// updates the scheduling for the trains. 
// If a train has a schedule #2 and now (+ 2hours) > schedule #1 then #2 is made #1
//update_schedule();




switch($view) {
// when logout or login is pressed, view intercepts and runs the respective function.
	case "logout":
	logout();
	exit;	
	break;

	case "login":
	login();
	exit;
	break;
}

// checks if there is an active session. if there is, 
//it sets the default layout to the logged in version
// else the logged out layout is used.
if(isset($_SESSION['valid']) && $_SESSION['valid']) {
    include 'views/main/loggedin.php';
}
else {
include 'views/main/layout.php';
} 

?>