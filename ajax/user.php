<?php

include('function.php');
session_start();
db_connect();

$action= ($_POST['action']); 

switch($action) {
	
	case "add":
	echo"<h4>Add User</h4>
	<div id='right'> <h4 id = 'addvalidate'>  </h4>  </div>				
	<label for='input'>Forename:</label> 
	<input type='textarea' id='firstname'>
	 
	 <br><label for='input'>Surname:</label>
	 <input type='textarea' id='surname'>

	 <br><label for='input'>Username:</label>
	 <input type='textarea' id='username'>
	 
	 <br><label for='input'>Password:</label>
	 <input type='textarea' id='password'>
	 
	 <br><label for='input'>Type:</label>
	 <select id = 'type'>
	 	<option value='user'>user</option>
		<option value='admin'>admin</option>
		<option value='eng'>eng</option></select>
		
	 <br><label for='input'>Email:</label>
	 <input type='textarea' id='email'>"; ?>

	<input value="ADD" type="button"  onclick='user("ajax/user.php","adduser")'>
	<?php
	break;



	case "adduser":

	$formvalue = array('fn', 'sn', 'um', 'pw', 'type', 'mail');	

	foreach($_POST AS $key => $value)
	{
		if(in_array($key, $formvalue) && $value == '')
		{
		    $missed[] = "<h4><font color='red'>$key is required.</font></h4>";
		}	

		if(in_array($key, $formvalue) && (strlen($value) >= 15))
		{
		    $length[] = "<h4><font color='red'>$key is too long (>15).</font></h4>";
		}	     
	}

	if (isset($length)) {
	 
		    foreach($length as $length)
		    {
		        echo $length;
		    }	  	     
	}

	if (isset($missed)) {
	 
		    foreach($missed as $missed)
		    {
		        echo $missed;
		    }	  	     
	}

	$email = trim($_POST['mail']);
	if(!checkEmail($email)) {  
		echo "<h4><font color='red'>Invalid email address!</font></h4>
		<h4><font color='red'>BUG - add it anyway.</font></h4>";
	}
	else {
		echo "<h4><font color='green'>Email address is valid</font></h4>";
	}
 

	//if ((isset($missed)) || (isset($length)) || (!checkEmail($email)))  { }
	if ((isset($missed)) || (isset($length)))  { }

	else
	{    
	
	$fn= ($_POST['fn']);
	$sn= ($_POST['sn']); 
	$um= ($_POST['um']); 
	$pw= ($_POST['pw']); 
	$type= ($_POST['type']); 
	$mail= ($_POST['mail']);  

	$qry = "SELECT username FROM user"; 
	$result = mysql_query($qry); while($row = mysql_fetch_assoc($result)) {
		$uma[] = $row['username']; }
	
		if(in_array($um, $uma))
		{
		   echo "<h4><font color='red'>Username is taken.</h4>
		   <br<h4>Please choose another.</h4>"; 
		} else {

			$qry = "INSERT INTO  `09034276`.`user` (
			`userid` ,
			`username` ,
			`password` ,
			`firstname` ,
			`surname` ,
			`type` ,
			`lastactivity` ,
			`email`
			)
			
			VALUES (NULL ,  '$um',  '$pw',  '$fn',  '$sn',  '$type',  '',  '$mail');"; 
	
	mysql_query($qry); 

	echo "<h4><font color='green'>User has been added.</font></h4>";

	echo "<br><br> <h4>Refresh to see new list.</h4>";
		
		}     
	}

	break;



	case "modify":

	$modify= ($_POST['modify']); 
	$qry = "SELECT * FROM user WHERE userid ='$modify'"; 
	$result = mysql_query($qry); while($row = mysql_fetch_assoc($result)) {
	echo " <h4>Modifying User: <b>".$row['firstname']." ".$row['surname']."</b> - ".$row['type']."</h4>"; 		
	echo"
	<div id='right'> <h4 id = 'modifyvalidate'>  </h4>  </div>
	<label for='input'>Forename:</label> 
	<input type='textarea' id='mfirstname' style ='width: 210px;' placeholder='".$row['firstname']."'>
	 
	 <br><label for='input'>Surname:</label>
	 <input type='textarea' id='surname'  style ='width: 210px;' placeholder='".$row['surname']."'>

	 <br><label for='input'>Username:</label>
	 <input type='textarea' id='username' style ='width: 210px;' placeholder='".$row['username']."'>
	 
	 <br><label for='input'>Password:</label>
	 <input type='textarea' id='password' style ='width: 210px;' placeholder='".$row['password']."'>
	 
	 <br><label for='input'>Type:</label>
	 <select id = 'type'>
	 	<option value='user'>user</option>
		<option value='admin'>admin</option>
		<option value='eng'>eng</option></select>
		
	 <br><label for='input'>Email:</label>
	 <input type='textarea' id='email' style ='width: 210px;' placeholder='".$row['email']."'>"; }  ?><br>

	<input value="Modify" type="button"  onclick='user("ajax/user.php","modifyuser")'>
	 
	<?php
	break;

	

	case "modifyuser":
	$uid= ($_POST['modify']);
	$formvalue = array('fn', 'sn', 'um', 'pw', 'type');	

	foreach($_POST AS $key => $value)
	{
		if(in_array($key, $formvalue) && $value == '')
		{
		    $missed[] = "<h4><font color='red'>$key is required.</font></h4>";
		}	

		if(in_array($key, $formvalue) && (strlen($value) >= 15))
		{
		    $length[] = "<h4><font color='red'>$key is too long (>15).</font></h4>";
		}	     
	}

	if (isset($length)) {
	 
		    foreach($length as $length)
		    {
		        echo $length;
		    }	  	     
	}

	if (isset($missed)) {
	 
		    foreach($missed as $missed)
		    {
		        echo $missed;
		    }	  	     
	}

	$email = trim($_POST['mail']);
	if(!checkEmail($email)) {  
		echo "<h4><font color='red'>Invalid email address!</font></h4>";
	}
	else {
		//echo "<h4><font color='green'>Email address is valid</font></h4>";
	}
 

	if ((isset($missed)) || (isset($length)))  { }
		
	else
	{    

	$fn= ($_POST['fn']);
	$sn= ($_POST['sn']); 
	$un= ($_POST['um']); 
	$pw= ($_POST['pw']); 
	$type= ($_POST['type']); 
	$mail= ($_POST['mail']);  	

	$qry = "SELECT username FROM user"; 
	$result = mysql_query($qry); while($row = mysql_fetch_assoc($result)) {
		$uma[] = $row['username']; }
	
		if(in_array($um, $uma))
		{
		   echo "<h4><font color='red'>Username is taken.</h4>
		   <br<h4>Please choose another.</h4>"; 
		} else {  
	// if all fields are present 
	$qry = "UPDATE `user` SET `username`= '$un',
	`password`='$pw', `firstname`='$fn', `surname`='$sn',
	`type`='$type', `email`='$mail'
	WHERE `userid` = '$uid'"; 
	mysql_query($qry); 
	echo "<br>User ".$uid." has been updated.";

		}
	}
	break;

	
	case "delete":
	$modify= ($_POST['modify']); 
	$qry = "SELECT  `firstname`, `surname` FROM user WHERE userid ='$modify'"; 
	$result = mysql_query($qry); while($row = mysql_fetch_assoc($result)) {
	echo "Are you sure you wish to delete the user: <b>".$row['firstname']." ".$row['surname']."?</b>"; } ?>
	
	 <input value="Yes" type="button"  onclick='user("ajax/user.php","deleteuser")'>
	 <input value="No" type="button"  onclick=''>
	
	<?php
	break;


	case "deleteuser":
	$modify= ($_POST['modify']); 
	$qry = "SELECT  `firstname`, `surname` FROM user WHERE userid ='$modify'"; 
	$result = mysql_query($qry); while($row = mysql_fetch_assoc($result)) {
	if ($_SESSION['name'] == $row['firstname']. ' ' .$row['surname']) {
		echo "<h4><font color='red'>Cannot delete the user you are logged in as.</font></h4>";
	} else {
		$delete = "DELETE FROM user WHERE userid = '$modify'";
		mysql_query($delete);
		echo "User: <b>".$row['firstname']." ".$row['surname']." has been deleted.</b>
		<br> Page will now refresh.";
	}
	}
	break;


}

function checkEmail($email) {

	// http://www.devshed.com/c/a/PHP/Email-Address-Verification-with-PHP/2/

  if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])
  ↪*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",
               $email)){
    list($username,$domain)=split('@',$email);
    if(!checkdnsrr($domain,'MX')) {
      return false;
    }
    return true;
  }
  return false;
}


?>