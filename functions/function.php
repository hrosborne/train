<?php

function user_activity()
{
	// time to log out in seconds - 8 mins
	$inactivity = 480;

	if(isset($_SESSION['timeout']) ) {

		$active_session = time() - $_SESSION['timeout'];

		if($active_session > $inactivity) { 
			session_destroy(); 
			timeout(); 
		}
	}

	$_SESSION['timeout'] = time();

}

function update_schedule()
{

	// If a train has a schedule #2 and now (+ 2hours) > schedule #1 then #2 is made #1

	$userID = $_SESSION['userid']; 

	$s_check = "SELECT trainID, entryt, vacatet, entryt2, vacatet2 FROM train WHERE userID = $userID";
	$s_check_res=mysql_query($s_check);
		
		while($s_check_arr = mysql_fetch_assoc($s_check_res)) {

			$now = new DateTime();	
			$schedulechange = $now->modify('+2 hours');
			$vacate = new DateTime($s_check_arr['vacatet']);

				if (($schedulechange > $vacate) && ($s_check_arr['vacatet2'] > '0000-00-00 00:00:00')) {

					$entryt = $s_check_arr['entryt2'];
					$vacatet = $s_check_arr['vacatet2'];
					$trainID = $s_check_arr['trainID'];

					//echo $trainID;
					//echo "has has its schedule 2 set.";

					$update = "UPDATE train SET `entryt`= '$entryt', 
	      			`vacatet`='$vacatet' WHERE trainID = '$trainID' "; 

	      				mysql_query($update);  	   

	      					$remove = "UPDATE train SET `entryt2`= '0000-00-00 00:00:00', 
	      					`vacatet2`='0000-00-00 00:00:00' WHERE trainID = '$trainID' "; 

	      					mysql_query($remove);  	   
			}
		}	
}

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
			$qry= "SELECT * FROM user WHERE username='$user' AND password='$pw'"; 
			$result = mysql_query($qry);
			$row = mysql_fetch_array($result);	

				//sets the session data for this user
			    session_regenerate_id (); //this is a security measure
				$_SESSION['valid'] = 1;
				$_SESSION['userid'] = $result;
				$_SESSION['type'] = $row['type'];
				$_SESSION['name'] = $row['firstname']. ' ' .$row['surname'];

			$qry = "SELECT * FROM settings";
			$result = mysql_query($qry);
			$row = mysql_fetch_array($result);	

				$_SESSION['maxsb'] = $row['addMaxSB'];

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

function timeout()
{
    $_SESSION = array(); //destroy all of the session variables
    session_destroy();
	header('Location: ?view=timeout');
}



function db_connect()
//connects to sots and selects database
 {
		
  $connection = mysql_pconnect('fdb6.awardspace.net', '1597520_09034276', 'Ticket12');
		
	if(!$connection)
	{
		return false;	
	}
		
	if(!mysql_select_db('1597520_09034276'))
	{
		  return false;	
	}
	
	return $connection;
		
 }

function db_setup_menu()
{

	echo"<h1> Train and Scheduling Setup </h1> 
	<div id='center'>
	<table><tr>
    <td><a href='?view=trains' class='button'>Add Train</a></td>
    <td><a href='?view=change' class='button'>Change User-Train</a></td>
    <td><a href='?view=schedule' class='button'>Setup Schedule</a></td>
    <td><a href='?view=edit' class='button'>Edit/Delete Train</a></td>
    </tr></table>
    </div>";
   
}

function scripts_css()
{

	echo"<link rel='stylesheet' href='styles/style.css'  type='text/css'>";

}


function jquery_scripts()
{

echo"
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>

  <script src='//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js'></script>

  <script type='text/javascript' src='js/jquery.timepicker.js'></script>
  <link rel='stylesheet' type='text/css' href='styles/jquery.timepicker.css' />
    <link rel='stylesheet' type='text/css' href='styles/jquery.ui.datepicker.css' />
  <link rel='stylesheet' type='text/css' href='styles/datepicker.css' />
  <link rel='stylesheet' type='text/css' href='styles/base.css' />";


}


?>