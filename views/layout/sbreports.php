<?php 
if(isset($_SESSION['valid']) ) { ?>

<script>

function send(url) {

var term= document.getElementById('terms').value                        
                                            
data = 'term=' + escape(term);

var xmlHttp = false;

if (window.XMLHttpRequest) {
    xmlHttp = new XMLHttpRequest();
}

xmlHttp.open('POST', url, true);
xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xmlHttp.onreadystatechange = function() {
                                   
        if (xmlHttp.readyState == 4) {
        
            document.getElementById("visualchart").innerHTML=xmlHttp.responseText
        }

    }

xmlHttp.send(data);
}


</script>


<h1> View Data in List </h1>

<a href='?view=sbreports'class='button'>View Data in List Format</a>
<a href='?view=visual'class='button'>Visualized Reports</a>

   

<br><br><br>
   
<div id='visual'>
 <form>                              
    <label for='input'>View in list format:</label>
              
        <select name='chart' id='terms'>
            <option value='user'>Users</option>
            <option value='train'>Trains</option>
            <option value='sandbox'>Sandbox</option>
            <option value='traintypes'>Train Types</option>
            <option value='repair'>Repairs</option>
            
        </select>

<input value="View" type="button" onclick='JavaScript:send("ajax/list.php")'>


</div>  

<div id='visualchart'> Please select something to view. </div> </form>


<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>

<?php 


} else {

  echo "<br><h3>You must be a registered user to use this site. </h3>
     
      <br><h3>Please contact your administrator if you cannot login.</h3>

     <br><br><br>";
} ?>