<!doctype html><html><head><meta charset="utf-8">
<title>SMS - Logged in.</title>
<?php  scripts_css();  
$type = $_SESSION['type']; ?>
</head>
<body>
<div class="container">

  <header>
    <a href="?view=home"><img src="images/test2.png" alt="SMS Logo" name="SMS Logo" width="1024" height="49" id="logoo" style="display: block;" /> </a>
  </header>

  <div class="sidebar">

    <ul class="nav">
      <li><a href='?view=trains'>Setup Trains and Scheduling</a></li>
      <li><a href='?view=reports'>View Data or Reports</a></li> 
  <?php if ($_SESSION['type'] == 'eng' || $_SESSION['type'] == 'admin') {
      echo"<li><a href='?view=eng'>Engineer Panel</a></li>"; }
        if ($_SESSION['type'] == 'admin') {
      echo"<li><a href='?view=users'>Setup Users</a></li>"; } ?>
      <li><a href='?view=settings'>Settings</a></li>
      <li><a href='?view=logout'>Logout</a></li>
  </ul>
          <aside>         
             <h4><?php $t=time();  echo(date("F d Y",$t));  ?>  </h4>
             <h4><?php echo(date("G:i:s",$t));  ?>  </h4>         
              <h4><?php  echo $_SESSION['name']; ?></h4>
          </aside>
  </div><!-- end .sidebar1 -->

    <article class="content">

        <?php include 'views/layout/'.$view.'.php'; // includes this page as root ?>

    </article><!-- end .content -->
	
  <footer>

      <p>Disclaimer: This site is constructed as a project at Oxford Brookes University. It is not a working website and is not connected with any site referenced. The views and opinions expressed within these pages are personal and should not be construed as reflecting the views and opnions of Oxford Brookes University.</p>
      
  </footer>

</div><!-- end .container -->

</body></html>
