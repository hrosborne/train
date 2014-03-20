<?php 
if(isset($_SESSION['valid']) ) { ?>

<script>

function send(url, form) {
                                             
var head= document.getElementById('heading').value
var cont= document.getElementById('content').value
var numb= document.getElementById('numb').value
var max= document.getElementById('max').value
var loginm= document.getElementById('logmessage').value
var mobhead= document.getElementById('mobhead').value
var mobcont= document.getElementById('mobcont').value

switch(form)
{

case 'news':
string= 'head=' + escape(head) + '&cont=' + escape(cont) + '&numb=' + escape(numb);  
  break;

case 'max':
string= 'max=' + escape(max);  
  break;

    case 'mnews':
string= 'head=' + escape(mobhead) + '&cont=' + escape(mobcont);  
  break;

     case 'mlogin':
string= 'message=' + escape(loginm);  
  break;



}
                     
xmlHttp = new XMLHttpRequest();
xmlHttp.open('POST', url, true);
xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                
xmlHttp.onreadystatechange = function() {
                                   
if (xmlHttp.readyState == 4) {

		switch(form)
		{

		case 'news':
		 document.getElementById("news").innerHTML=xmlHttp.responseText
		  break;

		case 'max':
		document.getElementById("maxset").innerHTML=xmlHttp.responseText
		  break;

		    case 'mnews':
		document.getElementById("mnewsresponse").innerHTML=xmlHttp.responseText
		  break;

		   case 'mlogin':
		document.getElementById("mloginresponse").innerHTML=xmlHttp.responseText
		  break;
		
		}

    }

}
xmlHttp.send(string);
}   

</script>



<h1> Settings </h1>

<form id='dbsetup'><h4><u>Post news on front page:</u></h4>

<p>Note: there are a maximum of 3 news items, to delete, simply save new news over the existing number.</p>

<label>Heading:</label><br><input type='text' value='Put heading here...' style='height: 25px; width: 250px;' id='heading'/>
 
<label>Save as news number:</label> 
	<select id='numb'><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option>
 </select><br><br>
           
<label>Content:</label><input type='text' value='Put content here...' style='height: 25px; width: 500px;' id='content'/><br>

<input value="Save" type="button" onclick='JavaScript:send("ajax/settings/news.php","news")'>

<div id="news"> </div> </form>




<br><form id='dbsetup'>
	<h4><u>Set mobile application login message.</u></h4>
	<input type='text' value='Login Message' style='height: 25px; width: 500px;' id='logmessage'/>
	&nbsp&nbsp<input value="Set" type="button" onclick='JavaScript:send("ajax/settings/moblogin.php","mlogin")'>
	<div id="mloginresponse"> </div>


	<br><br><h4><u>Set mobile application news.</u></h4>
	<input type='text' value='Put heading here...' style='height: 25px; width: 350px;' id='mobhead'/><br><br>
	<input type='text' value='Content here...' style='height: 25px; width: 500px;'  id='mobcont'/>
	&nbsp&nbsp<input value="Set" type="button" onclick='JavaScript:send("ajax/settings/mobilenews.php","mnews")'>
	<div id="mnewsresponse"> </div>

	<br><h4><u>Download mobile app .apk.</u></h4>
	<h5>After downloading, email or copy over usb the apk to the phone.</h5> 
	<h5>Navigate to the file using File Manager and tap the icon, then press Install. </h5>
	&nbsp&nbsp<input type=button onClick="location.href='ajax/settings/dload.php'" value='Download'>	
</form>


<br><form id='dbsetup'>
	<h4><u>Set maximum number of sandboxes a train can have.</u></h4>
	<select id='max'>
			<option value='2'>2</option>
            <option value='4'>4</option>
            <option value='6'>6</option>
     </select>
        <input value="Save" type="button" onclick='JavaScript:send("ajax/settings/max.php","max")'>

         <div id="maxset"> </div>
</form>



<br><br><br><br><br><br>


<?php 

} else {

  echo "<br><h3>You must be a registered user to use this site. </h3>
     
      <br><h3>Please contact your administrator if you cannot login.</h3>

     <br><br><br>";
} ?>




