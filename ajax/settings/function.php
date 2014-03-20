<?php

function login()
{
    $user = ($_POST['username']); 
	$pw = ($_POST['password']);
	session_start(); //must call session_start before using any $_SESSION variables
	db_connect();
	$qry = "SELECT userid FROM user WHERE username='$user' AND password='$pw'"; 
	$result = mysql_query($qry);
	
		if(mysql_num_rows($result) < 1) //no such user exists
		{
			header('Location: ?view=loginfail');
			die();
		}
			else
		{
			$qry2= "SELECT * FROM user WHERE username='$user' AND password='$pw'"; 
			$result2 = mysql_query($qry2);
			$row = mysql_fetch_array($result2);	

				//sets the session data for this user
			    session_regenerate_id (); //this is a security measure
				$_SESSION['valid'] = 1;
				$_SESSION['userid'] = $result;
				$_SESSION['type'] = $row['type'];
				$_SESSION['name'] = $row['firstname']. ' ' .$row['surname'];
		}
				//redirect to another page or display "login success" message
				header('Location: ?view=home');
}



function logout()
{
    $_SESSION = array(); //destroy all of the session variables
    session_destroy();
	header('Location: ?view=home');
}


function db_connect()
//connects to sots and selects database
 {
		
  $connection = mysql_pconnect('localhost', '09034276', 'Ticket1');
		
	if(!$connection)
	{
		return false;	
	}
		
	if(!mysql_select_db('09034276'))
	{
		  return false;	
	}
	
	return $connection;
		
 }


function scripts_css()
{

	echo"
	<link rel='stylesheet' href='styles/style.css'  type='text/css'>

	<script src='//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>

	<script src='//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js'></script>

	<script type='text/javascript' charset='utf-8' src='js/enhance.js'></script>";

}


?>