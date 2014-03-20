<?php

if(isset($_SESSION['valid']) ) {

 $type = ($_SESSION['type']); 
if ($type == "admin") 
{
  
db_connect();

echo"<h1> User Setup </h1> ";

	$qry = "SELECT * FROM user"; 
	$result = mysql_query($qry);

// create table
echo "<br><form><div id='dbsetup'><table id='table'>";
echo "<tr><th>Firstname</th><th>Surname</th><th>User Type</th><th>Username</th><th>Password</th><th>Email</th></tr>";

// no need for validation as there must be a user to be on this page

while($row = mysql_fetch_assoc($result))
{

  echo "<tr>
  <td><b>".$row['firstname']."</b></td>
  <td><b>".$row['surname']."</b></td>
  <td><b>".$row['type']."</b></td>
  <td><b>".$row['username']."</b>
  <td><b>".$row['password']."</b>
  <td><b>".$row['email']."</b></tr>"; }  ?>

</table>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 


</form>

<h4>To perform an action on a user, please select one from the drop down menu: (you need to refresh to reflect changes of Add and Modify)</h4>

<?php 

echo"<select id='modify'>";

$result = mysql_query($qry);

while($row = mysql_fetch_assoc($result)) {

echo "<option value='".$row['userid']."'>".$row['surname']."</option>"; }

echo "</select>"; ?><br>

&nbsp; &nbsp; <input value="Add New User" type="button"  onclick='user("ajax/user.php","add")'>
<input value="Modify Selected User" type="button"  onclick='user("ajax/user.php","modify")'>
<input value="Delete Selected User" type="button"  onclick='user("ajax/user.php","delete")'> </div> 

<br><br><div id='dbsetup'>  <div id="userresponse"> Press a button to carry out an action. </div> </div><br><br>


<?php } else { // IF USER DOES NOT HAVE CORRECT ADMIN ACCOUNT ?>

<h1>Users</h1>
<br>
<h2> You do not have the correct level of access to view this page. </h2>
<br>
<h2> Please contact your administrator if you have any questions. </h2>
<br><br><br><br><br><br><br><br><br><br><br>
<?php } ?>


<script>

function user(url, form) {                                       
//var modify= document.getElementById('modify').value

switch(form)
{

case 'add':
  string= 'action=add'; 
break;

case 'adduser':

  var fn= document.getElementById('firstname').value
  var sn= document.getElementById('surname').value
  var um= document.getElementById('username').value
  var pw= document.getElementById('password').value
  var type= document.getElementById('type').value
  var mail= document.getElementById('email').value

  string= 'action=adduser' + '&fn=' + escape(fn) + '&sn=' + escape(sn) 
  + '&um=' + escape(um) + '&pw=' + escape(pw) + '&type=' + escape(type) + '&mail=' + escape(mail); 
break;

case 'modify':
  var modify= document.getElementById('modify').value
  string= 'modify=' + escape(modify) + '&action=modify'; 
break;

case 'modifyuser':
  var modify= document.getElementById('modify').value
  var fn= document.getElementById('mfirstname').value
  var sn= document.getElementById('surname').value
  var um= document.getElementById('username').value
  var pw= document.getElementById('password').value
  var type= document.getElementById('type').value
  var mail= document.getElementById('email').value

  string= 'action=modifyuser' + '&fn=' + escape(fn) + '&sn=' + escape(sn) 
  + '&um=' + escape(um) + '&pw=' + escape(pw) + '&type=' + escape(type) 
  + '&mail=' + escape(mail) + '&modify=' + escape(modify); 

break;

case 'delete':
  var modify= document.getElementById('modify').value
  string= 'modify=' + escape(modify) + '&action=delete'; 
break;

case 'deleteuser':
  var modify= document.getElementById('modify').value
  string= 'modify=' + escape(modify) + '&action=deleteuser'; 
break;

}
                 
xmlHttp = new XMLHttpRequest();
xmlHttp.open('POST', url, true);
xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


                                
xmlHttp.onreadystatechange = function() {
                                   
if (xmlHttp.readyState == 4) {

      switch(form)
        {
         
        case 'add':
        document.getElementById("userresponse").innerHTML=xmlHttp.responseText
        break;

        case 'adduser':
          document.getElementById("addvalidate").innerHTML=xmlHttp.responseText
          
        break;

        case 'modify':
         document.getElementById("userresponse").innerHTML=xmlHttp.responseText
        break;

        case 'modifyuser':
          document.getElementById("modifyvalidate").innerHTML=xmlHttp.responseText
          
        break;

        case 'delete':
         document.getElementById("userresponse").innerHTML=xmlHttp.responseText 
        break;

        case 'deleteuser':
          document.getElementById("userresponse").innerHTML=xmlHttp.responseText
          window.setTimeout(function(){location.reload()},3000)
        break;

        }

    }

}
xmlHttp.send(string);
}   

</script>


<?php 

} else {

  echo "<br><h3>You must be a registered user to use this site. </h3>
     
      <br><h3>Please contact your administrator if you cannot login.</h3>

     <br><br><br>";
} ?>

