<?php 
if(isset($_SESSION['valid']) ) { ?>

<link rel='stylesheet' href='styles/datepicker.css'  type='text/css'>
<script>

// jquery datepicker initialized

  $(function() {
    $( "#datefrom").datepicker({
      showOtherMonths: true,
        changeMonth: true,
      changeYear: true,
      selectOtherMonths: true
    });
    $( "#datetill").datepicker({
      showOtherMonths: true,
        changeMonth: true,
      changeYear: true,
      selectOtherMonths: true
    });
  });


function ajax(url) {
// gets the element with the ID of 'report'.
var report = document.getElementById('report').value
// builds the variable sent via $_POST
  vars = 'rep=' + escape(report); 
// allows the updating of the page asynchronously
if (window.XMLHttpRequest) {   
// defines the request as xmlHttp                
  xmlHttp = new XMLHttpRequest();
  }
// sets the request up as POST, the url passed to this function
// is the destination php script that recieves the post data.
xmlHttp.open('POST', url, true);
xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                                
xmlHttp.onreadystatechange = function() {
// when the readystate is reached, 
// this means the script has sent back its response                                  
if (xmlHttp.readyState == 4) {
  // this places the responsetext into the div called visualchart.
        document.getElementById("visualchart").innerHTML=xmlHttp.responseText
    }

  }
// sends the built variable containing the POST data.
  xmlHttp.send(vars);
}
</script>

<?php

echo"<h2> Visualized Data </h2>

<a href='?view=sbreports'class='button'>View Data in List Format</a>
<a href='?view=visual'class='button'>Visualized Reports</a>

<br><br><br>
    
      <form id='dbsetup'>
                                  
    <label>Report type:</label>
        <select name='chart' id='report'>
            <option value='1'>Missed Sandboxes</option>
            <option value='2'>Trains Delayed</option>
            <option value='3'>Fault Occurance</option>
            <option value='4'>Average sand levels prior to filling</option>
        </select>"; ?>
                                 
  &nbsp;&nbsp;&nbsp;&nbsp;<input value="Get Charts" type="button" onclick='JavaScript:ajax("ajax/chart.php")'>

</form>  

      <div id='visualchart'> Chart not yet generated.  </div>

<br><br><br>
<br><br><br>
<br><br><br>

  <?php 

} else {

  echo "<br><h3>You must be a registered user to use this site. </h3>
     
      <br><h3>Please contact your administrator if you cannot login.</h3>

     <br><br><br>";
} ?>     