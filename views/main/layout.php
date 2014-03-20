<!doctype html><html><head><meta charset="utf-8">

<title>SMS - Not logged in.</title>

<?php scripts_css(); ?>

</head><body>

<div class="container">
  <header>
    <a href="?view=home"><img src="images/test.png" alt="Insert Logo Here" name="Insert_logo" width="1024" height="88" id="Insert_logo" style="display: block;" /> </a>
  </header>

  <div class="sidebar">
    <ul class="nav">

      <li><a href="#">

	 <form name="login" action="index.php?view=login" method="post">    
            <input type="text" name="username" style='width: 120px'>
            <input type="password" name="password" style='width: 120px'>
            <input type="submit" class='loginbutton' value="Click to login">   
  </form></a></li>

    </ul>

    <aside>
      <h4> <?php $t=time();  echo(date("F d Y",$t));  ?>  </h4>
      <h4><?php echo(date("G:i:s",$t));  ?>  </h4>
      
    	
    </aside>
	
  <!-- end .sidebar --></div>
  
  <article class="content">
  
<?php
// includes this page as root
include 'views/layout/'.$view.'.php' ;
 ?>

  <!-- end .content --></article>

  <footer>
    <p>Disclaimer: This site is constructed as a project at Oxford Brookes University. It is not a working website and is not connected with any site referenced. The views and opinions expressed within these pages are personal and should not be construed as reflecting the views and opnions of Oxford Brookes University.</pf>
    <address>
    </address>
  </footer>
  <!-- end .container --></div>
</body>
</html>