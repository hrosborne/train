<?php

include('function.php');
session_start();
db_connect();

$action= ($_POST['action']); 
$tid = ($_POST['tID']); 

switch($action) {

    case "check":
    $qry= "SELECT vacatet, entryt, entryt2, vacatet2 FROM train WHERE trainID = $tid"; // make settings
      $result = mysql_query($qry);
       while($row = mysql_fetch_assoc($result)) {

          echo "<label>Current Schedule (#1):</label>";
          
          echo "<br><br><h4>Entry: ".$row['entryt']."</h4>";

          echo"<h4>Vacate: ".$row['vacatet']."</h4>";

          if ($row['vacatet2'] > '0000-00-00 00:00:00') {

          echo "<label>Current Schedule (#2):</label>";
          
          echo "<br><br><h4>Entry: ".$row['entryt2']."</h4>";

          echo"<h4>Vacate: ".$row['vacatet2']."</h4>";

          }

            if (($row['vacatet']) < $today = date("Y-m-d"))
            {
              echo "<br><h4><font color='red'>This train has finished its schedule.</font></h4> <br>
              
              <h4>Would you like to reschedule it?</h4> "; ?>
                     
            &nbsp&nbsp<input value='YES' type='button' onclick='schedule("ajax/schedule.php","schedule")'> &nbsp&nbsp
    				<input value='NO' type='button' onclick="window.location='index.php';" /> <br><br>
                           
        <?php       } 
                    else {
                           echo "<br><h4><font color='green'>This train is currenty scheduled for service.</font></h4> <br>"; ?>

                            <h4><font color='red'>Are you sure you wish to change its schedule?</font></h4> 
                     
             &nbsp&nbsp<input value='YES' type='button' onclick='schedule("ajax/schedule.php","schedule")'> &nbsp&nbsp
            <input value='NO' type='button' onclick="window.location='index.php';" /> <br><br>
             
              <?php           }
                            
                           } // end while
    break;
    
    case "apply":

    $formvalue = array('e', 'ed', 'v', 'vd');   
       
    foreach($_POST AS $key => $value)
    {
      if(in_array($key, $formvalue) && $value == '')
      {
          $missed[] = "<h4><font color='red'>$key is required.</font></h4>";
      }      
    }
    if (isset($missed)) {
     
          foreach($missed as $missed)
          {
              echo $missed;
          }          
    }
    else
    {  

    $schedule = ($_POST['sch']);    
    $e = ($_POST['e']);
    $ed = ($_POST['ed']); 
    $v = ($_POST['v']); 
    $vd = ($_POST['vd']); 

    $entryTime  = date("H:i:s", strtotime($e)); // formatted time
    $vacateTime  = date("H:i:s", strtotime($v)); 

    $edf = date("Y-m-d", strtotime($ed)); // formatted dates
    $vdf = date("Y-m-d", strtotime($vd));

    $entryt = $edf." ".$entryTime; // combine date and time
    $vacatet = $vdf." ".$vacateTime;

    if ($entryt > $vacatet) {
      
      echo "<h4><font color='red'>The entry time and date must be before the vacate time/date.</font></h4>";

      } else {

    if ($schedule == 'schedule1') {

       $qry = "UPDATE train SET `entryt`= '$entryt', 
      `vacatet`='$vacatet' WHERE trainID = '$tid'"; 
    
    } else {

       $check= "SELECT trainID, vacatet, vacatet2, entryt, entryt2 FROM train WHERE trainID = $tid"; // make settings             
          $result = mysql_query($check);                  
              while($row = mysql_fetch_assoc($result)) {
                
                $s1vac = $row['vacatet'];
                $s1ent = $row['entryt'];

              }

        if ($s1ent > $entryt) {
          echo "<h4><font color='red'>The #2 Schedule entry time must be after the #1 entry or vacate time.</font></h4>";
        }
        
         if ($s1vac > $vacatet) {
          echo "<h4><font color='red'>The #2 Schedule vacate time must be after the #1 entry or vacate time.</font></h4>";
        }

      if (($s1ent > $entryt) || ($s1vac > $vacatet))  { 

        echo "<h4><font color='red'> Cannot apply Schedule. </font></h4>"; 
        
      } else { 

      $qry = "UPDATE train SET `entryt2`= '$entryt', 
      `vacatet2`='$vacatet' WHERE trainID = '$tid'"; 
    
    mysql_query($qry) or die ('died'); 

    echo "<h4><font color='green'>New schedule applied.</font></h4>";
    }
    } 
    }
    }
    break;

     case "schedule":
     $qry= "SELECT trainID, vacatet, vacatet2, entryt, entryt2 FROM train WHERE trainID = $tid"; // make settings
       $result = mysql_query($qry);
         while($row = mysql_fetch_assoc($result)) {
            echo "<label>Current Schedule (#1):</label>";
            echo "<br><br><h4>Entry : ".$row['entryt']."</h4>";
              echo"<h4>Vacate: ".$row['vacatet']."</h4>";          
                
                 if ($row['vacatet2'] > '0000-00-00 00:00:00') {
                    echo "<label>Current Schedule (#2):</label>";
                    echo "<br><br><h4>Entry: ".$row['entryt2']."</h4>";
                    echo"<h4>Vacate: ".$row['vacatet2']."</h4>";
                  }
          }

      echo "<form id='rescheduleform'>
      <label> Enter new schedule #1. </label><br><br>    
      <label for='input'>Entry time:</label>
      <input type='text' id= 'entry'  class='time' style='width: 98px'>
      <label for='input'>Entry Date:</label>
      <input type='text' id= 'entryD' name='entryD'  style='width: 98px'>
      <br>
      <label for='input'>Vacate time:</label>
      <input type='text' id='vacate'  class='time' style='width: 98px'>
      <label for='input'>Vacate Date:</label>
      <input type='text' id='vacateD' name='vacateD'  style='width: 98px'>
      <input type='hidden' id='sch' value='schedule1'>  ";  ?>       
             
    <br> <br> <input value='Apply Schedule' type='button' onclick='schedule("ajax/schedule.php","apply")'> </form> 

    <div id='confirm'> </div>

    <input value='Click to enter schedule #2' type='button' onclick='schedule("ajax/schedule.php","schedule2")'> </form>
    
    <?php
    break;

    

    case "schedule2":
      $qry= "SELECT trainID, vacatet, vacatet2, entryt, entryt2 FROM train WHERE trainID = $tid"; // make settings
       $result = mysql_query($qry);
         while($row = mysql_fetch_assoc($result)) {
            echo "<label>Current Schedule (#1):</label>";
            echo "<br><br><h4>Entry : ".$row['entryt']."</h4>";
              echo"<h4>Vacate: ".$row['vacatet']."</h4>";          
                
                 if ($row['vacatet2'] > '0000-00-00 00:00:00') {
                    echo "<label>Current Schedule (#2):</label>";
                    echo "<br><br><h4>Entry: ".$row['entryt2']."</h4>";
                    echo"<h4>Vacate: ".$row['vacatet2']."</h4>";
                  }
          }

      echo "<form id='rescheduleform'>
      <label> Enter schedule #2. </label><br><br>  
      <label for='input'>Entry time:</label>
      <input type='text' id= 'entry'  class='time' style='width: 98px'>
      <label for='input'>Entry Date:</label>
      <input type='text' id= 'entryD' name='entryD'  style='width: 98px'>
      <br>
      <label for='input'>Vacate time:</label>
      <input type='text' id='vacate'  class='time' style='width: 98px'>
      <label for='input'>Vacate Date:</label>
      <input type='text' id='vacateD' name='vacateD'  style='width: 98px'>  
      <input type='hidden' id='sch' value='schedule2'>";  ?>       
             
    <br> <input value='Apply Schedule' type='button' onclick='schedule("ajax/schedule.php","apply")'> </form> 
    
    <div id='confirm'> </div>
    <?php
    break;

  }

?>
